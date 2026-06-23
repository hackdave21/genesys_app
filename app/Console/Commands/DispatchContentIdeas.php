<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAndSendContentIdea;
use App\Models\User;
use Illuminate\Console\Command;

class DispatchContentIdeas extends Command
{
    protected $signature = 'inspira:dispatch-ideas';
    protected $description = 'Dispatch GenerateAndSendContentIdea jobs for users with active subscriptions and matching frequency';

    public function handle(): int
    {
        $frequencies = now()->isMonday() ? ['daily', 'weekly'] : ['daily'];

        $users = User::whereHas('subscriptions', function ($q) {
            $q->where('status', 'active')
              ->where('expires_at', '>', now());
        })->whereHas('contentProfile', function ($q) use ($frequencies) {
            $q->whereIn('frequency', $frequencies);
        })->cursor();

        $count = 0;

        foreach ($users as $user) {
            GenerateAndSendContentIdea::dispatch($user);
            $count++;
        }

        $this->info("Dispatched {$count} GenerateAndSendContentIdea jobs.");

        return Command::SUCCESS;
    }
}
