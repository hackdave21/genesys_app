<?php

namespace App\Console\Commands;

use App\Mail\RenewalReminderMail;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendRenewalReminders extends Command
{
    protected $signature = 'inspira:send-renewal-reminders {--days=3 : Nombre de jours avant expiration pour envoyer le rappel}';
    protected $description = 'Send renewal reminder emails to users whose subscription expires soon';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $subscriptions = Subscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->where('expires_at', '<=', now()->addDays($days))
            ->whereNull('reminder_sent_at')
            ->cursor();

        $count = 0;

        foreach ($subscriptions as $subscription) {
            try {
                Mail::to($subscription->user)->send(new RenewalReminderMail($subscription));

                $subscription->update(['reminder_sent_at' => now()]);

                $count++;
            } catch (\Throwable $e) {
                $this->error("Erreur envoi rappel #{$subscription->id} : {$e->getMessage()}");
            }
        }

        $this->info("Sent {$count} renewal reminder emails.");

        return Command::SUCCESS;
    }
}
