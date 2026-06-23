<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionExpiredMail;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'inspira:check-expired';
    protected $description = 'Mark expired subscriptions as expired and send notification';

    public function handle(): int
    {
        $expired = Subscription::where('status', 'active')
            ->where('expires_at', '<', now())
            ->cursor();

        $count = 0;

        foreach ($expired as $subscription) {
            $subscription->update(['status' => 'expired']);

            try {
                Mail::to($subscription->user)->send(new SubscriptionExpiredMail($subscription));
            } catch (\Throwable $e) {
                $this->error("Erreur envoi email expiration #{$subscription->id} : {$e->getMessage()}");
            }

            $count++;
        }

        $this->info("Expired {$count} subscriptions and sent notifications.");

        return Command::SUCCESS;
    }
}
