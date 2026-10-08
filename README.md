# JOPLC IT Service Desk (ITSM) – Phase 1

Laravel 11/12 + Blade + Bootstrap 5 + MySQL. This folder is an **overlay**: it contains only the project's own code and is applied on top of a fresh Laravel install.

## Install

```bash
./install.sh joplc-itsm-app        # needs PHP 8.2+, Composer, internet access to Packagist
cd joplc-itsm-app
# edit .env  (template: .env.itsm.example)
php artisan migrate --seed
php artisan serve
```

`php artisan migrate --seed` creates the lookups, the six roles, a few departments and **only** these seven accounts:

| Role | Email | Password |
|---|---|---|
| Department User | acct_user@joplc.com | 123456 |
| Department User | sales_user@joplc.com | 123456 |
| Department Head | acct_head@joplc.com | 123456 |
| IT Admin | it_admin@joplc.com | 123456 |
| IT Team Member | it_emp@joplc.com | 123456 |
| Management | sharif99452@gmail.com | 123456 |
| System Administrator | nayem.jocl@gmail.com | 12345678 |

These passwords are weak: change them after the first login (key icon in the top bar). To (re)create just the accounts on an existing database: `php artisan db:seed --class=UserSeeder` (resets those seven passwords and roles). Accounts created by earlier versions of the seeder are not removed automatically; delete them, or run `php artisan migrate:fresh --seed` on a database with no data you need.

Scheduler (SLA checks every 5 min, auto-close hourly): add to cron  
`* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1`

Audit log, Login history and System Settings are restricted to the System Administrator role. IT Admin can create and edit users, but System Administrator accounts and the System Administrator role are hidden from them. User records hold a WhatsApp number (not a phone number); all user fields are mandatory when creating a user.

Upgrading an existing install: run `php artisan migrate` (renames the user phone column to `whatsapp` and refreshes role names/permissions), then `php artisan optimize:clear`.

## Attachments

Maximum **5 MB per file** (ceiling `max_upload_kb` in `config/itsm.php`; the `upload.max_kb` setting can only lower it). PHP must allow it too: set `upload_max_filesize` and `post_max_size` in php.ini to at least 5 MB per file you expect in one submission (for example 40M), then restart the web server.

## Time zone

The system time zone is **GMT+6 (Asia/Dhaka)**, set in `config/itsm.php` (`ITSM_TIMEZONE`) and applied automatically, so ticket times, SLA due times, reports and scheduled jobs all use it. Timestamps already stored before this setting was applied were written in the old zone and will look 6 hours earlier if the old zone was UTC.

## Requests on behalf of others

System Administrator, IT Admin and IT Team Member can file a request for any user (e.g. when a problem is reported by phone); a Department Head can file for users in their own department. Pick the person under **Request for** on the New Request form. The ticket belongs to that person (they see it and are notified), and shows who filed it. Permissions: `ticket.create.behalf` and `ticket.create.behalf.dept` in `config/itsm.php`. After upgrading run `php artisan migrate` and `php artisan optimize:clear`.

## Multiple roles

A user can hold more than one role (e.g. IT Admin + IT Team Member, or Department Head + Department User). Tick the roles on the user form; permissions are combined. After upgrading an existing install run `php artisan migrate` – existing users keep their current role.

## UI

Blade + Bootstrap 5 with a custom design layer (`public/css/itsm.css`): left sidebar, sticky top bar with global ticket search, light/dark theme toggle (remembered per browser), soft status pills, avatars, stat cards and toast messages.
Vue 3 (loaded from `public/vendor`, no build step) powers two screens: the **New Request** form (dependent sub-categories, SLA hints on priorities, drag-and-drop attachments, searchable "Request for" picker) and the IT Admin's **drag-and-drop assignment board** on the dashboard (drop a ticket on an IT member, or press Auto for the member with the fewest open tickets).

## What is in Phase 1

- Login with lockout, login history, session timeout, role + permission authorization, audit log
- Request submission (type, category/sub-category, priority, attachments, preferred date), ticket numbers `IT-YYYY-000001`
- IT Admin: unassigned queue, assign / reassign / auto-assign (fewest open tickets), priority/category/due-date changes, escalate, close, reopen
- IT Member: own queue, work, wait-for-user, hold, resolve with resolution text
- Department: track own requests, comment, upload, confirm & close or reopen; Department Head sees the whole department
- Public conversation and IT-only internal notes (filtered server-side), private attachment storage with extension/size checks
- In-system notifications for the events listed in the requirements
- Dashboards (officer/management, IT member, department), team workload, charts, monthly report, CSV export
- Configurable categories, priorities/SLA values, departments, designations, locations, upload limits, auto-close days
- Search and filters (ticket no., subject, requester, employee ID, department, category, status, priority, assignee, type, dates)

## Not in Phase 1 (by design)

Asset module (and asset/IP search), approval workflows, knowledge base, email/SMS/WhatsApp delivery, LDAP/AD, ERP integration, working-hours SLA calendar, virus scanning (`scan_status` hook is in place for ClamAV).

## Before go-live

1. Serve over HTTPS; set `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`.
2. Bootstrap, Vue 3 and Chart.js are bundled in `public/vendor/`, so the app works on a network without internet access. No Node/npm build step is needed.
3. Back up the database and `storage/app/private` (attachments) on a schedule.
4. Run the tests against a MySQL test database: `php artisan test` (`tests/Feature/TicketWorkflowTest.php`).
5. Run UAT using the workflow table in `WORKFLOW.md`.
