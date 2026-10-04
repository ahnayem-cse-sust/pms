#!/usr/bin/env bash
# Creates a fresh Laravel app and overlays the JOPLC ITSM code on top of it.
# Requirements: PHP 8.2+, Composer, MySQL 8 (or MariaDB 10.6+), Node not required.
set -euo pipefail

TARGET="${1:-joplc-itsm-app}"
HERE="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

composer create-project laravel/laravel "$TARGET"
cd "$TARGET"

# Overlay our code (overwrites a few Laravel defaults on purpose: User model,
# Controller base, AppServiceProvider, DatabaseSeeder, routes, bootstrap/app.php)
for d in app bootstrap config database public resources routes tests; do
    cp -R "$HERE/$d/." "./$d/"
done
cp "$HERE/WORKFLOW.md" ./WORKFLOW.md

# Remove Laravel's default welcome view/route leftovers
rm -f resources/views/welcome.blade.php

echo
echo "Done. Next steps:"
echo "  1. Edit .env  (see $HERE/.env.itsm.example): DB credentials, APP_TIMEZONE, SESSION_LIFETIME"
echo "  2. php artisan migrate --seed        # tables + statuses/priorities/categories + roles + admin"
echo "     (non-production only: also seeds demo users, password ChangeMe@12345)"
echo "  3. php artisan serve                 # then open http://127.0.0.1:8000"
echo "  4. Add cron: * * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
