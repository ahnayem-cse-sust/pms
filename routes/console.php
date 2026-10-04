<?php

use Illuminate\Support\Facades\Schedule;

// Requires a cron entry: * * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
Schedule::command('itsm:sla-check')->everyFiveMinutes();
Schedule::command('itsm:auto-close')->hourly();
