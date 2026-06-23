<?php

namespace App\Jobs;

use App\Exceptions\ClaudeApiException;
use App\Mail\ContentIdeaMail;
use App\Models\ContentIdea;
use App\Models\User;
use App\Services\ClaudeContentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateAndSendContentIdea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(ClaudeContentService $claude): void
    {
        $profile = $this->user->contentProfile;

        if (!$profile) {
            Log::warning('GenerateAndSendContentIdea : aucun profil de contenu', [
                'user_id' => $this->user->id,
            ]);
            return;
        }

        try {
            $generatedContent = $claude->generateIdeas($profile);
        } catch (ClaudeApiException $e) {
            Log::error('GenerateAndSendContentIdea : échec génération Claude', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
            ]);
            $this->fail($e);
            return;
        }

        $idea = ContentIdea::create([
            'user_id' => $this->user->id,
            'content' => $generatedContent,
            'prompt_used' => $claude->buildPrompt($profile),
            'status' => 'generated',
        ]);

        try {
            Mail::to($this->user)->send(new ContentIdeaMail($idea));

            $idea->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('GenerateAndSendContentIdea : échec envoi email', [
                'user_id' => $this->user->id,
                'idea_id' => $idea->id,
                'error' => $e->getMessage(),
            ]);

            $idea->update(['status' => 'failed']);

            $this->fail($e);
        }
    }
}
