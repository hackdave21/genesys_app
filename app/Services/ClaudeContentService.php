<?php

namespace App\Services;

use App\Exceptions\ClaudeApiException;
use App\Models\ContentProfile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeContentService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.api_key') ?? env('ANTHROPIC_API_KEY');
        $this->model = config('services.anthropic.model') ?? env('ANTHROPIC_MODEL', 'claude-sonnet-4-6');
    }

    /**
     * Génère des idées de contenu via l'API Claude.
     */
    public function generateIdeas(ContentProfile $profile): string
    {
        $prompt = $this->buildPrompt($profile);

        $response = Http::timeout(60)
            ->withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => $this->model,
                'max_tokens' => 1024,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ]);

        if ($response->status() === 401) {
            Log::error('Claude API : clé API invalide');
            throw new ClaudeApiException('Clé API Anthropic invalide.', 401);
        }

        if ($response->status() === 429) {
            Log::warning('Claude API : rate limit atteint');
            throw new ClaudeApiException('Rate limit Anthropic dépassé. Réessaie plus tard.', 429);
        }

        if (!$response->successful()) {
            Log::error('Claude API : erreur', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new ClaudeApiException(
                'Erreur API Anthropic (HTTP ' . $response->status() . ').',
                $response->status()
            );
        }

        $body = $response->json();
        $text = $body['content'][0]['text'] ?? null;

        if (!$text) {
            Log::error('Claude API : réponse sans contenu textuel', ['response' => $body]);
            throw new ClaudeApiException('Réponse inattendue de l\'API Claude.');
        }

        return $text;
    }

    /**
     * Construit le prompt structuré à partir du profil de contenu.
     */
    public function buildPrompt(ContentProfile $profile): string
    {
        $niche = $profile->niche;
        $audience = $profile->target_audience ?? 'un public large';
        $tone = $profile->tone;
        $platform = $profile->platform;

        return <<<PROMPT
Tu es un expert en stratégie de contenu. Génère 3 idées de contenu originales et actionnables pour un créateur dans la niche "{$niche}", qui s'adresse à "{$audience}", avec un ton "{$tone}", destinées à la plateforme "{$platform}".

Pour chaque idée, donne : un titre accrocheur, une brève description (2-3 phrases), et un angle ou hook suggéré.

Réponds uniquement avec les idées, sans préambule.
PROMPT;
    }
}
