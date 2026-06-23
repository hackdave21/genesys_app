<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('inspira:dispatch-ideas')->dailyAt('08:00');
Schedule::command('inspira:check-expired')->dailyAt('00:30');
Schedule::command('inspira:send-renewal-reminders')->dailyAt('09:00');
