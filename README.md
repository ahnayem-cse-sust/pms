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

Production seeding creates the lookups, six roles and one administrator (`admin@joplc.local`, password from `ITSM_ADMIN_PASSWORD`; change it after first login). In any non-production environment it also creates demo users, all with password `ChangeMe@12345`:

| Email | Role |
|---|---|
| admin@joplc.local | System Administrator |
| officer@joplc.local | IT Admin |
| member1…5@joplc.local | IT Team Members |
| accounts.user@ / sales.user@joplc.local | Department Users |
| accounts.head@joplc.local | Department Head (Accounts) |
| mgmt@joplc.local | Management |

Scheduler (SLA checks every 5 min, auto-close hourly): add to cron  
`* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1`

Audit log, Login history and System Settings are restricted to the System Administrator role. IT Admin can create and edit users, but System Administrator accounts and the System Administrator role are hidden from them. User records hold a WhatsApp number (not a phone number); all user fields are mandatory when creating a user.

Upgrading an existing install: run `php artisan migrate` (renames the user phone column to `whatsapp` and refreshes role names/permissions), then `php artisan optimize:clear`.

## Multiple roles

A user can hold more than one role (e.g. IT Admin + IT Team Member, or Department Head + Department User). Tick the roles on the user form; permissions are combined. After upgrading an existing install run `php artisan migrate` – existing users keep their current role.

## UI

Blade + Bootstrap 5 with a custom design layer (`public/css/itsm.css`): left sidebar, sticky top bar with global ticket search, light/dark theme toggle (remembered per browser), soft status pills, avatars, stat cards and toast messages.
Vue 3 (loaded from `public/vendor`, no build step) powers two screens: the **New Request** form (dependent sub-categories, SLA hints on priorities, drag-and-drop attachments) and the IT Admin's **drag-and-drop assignment board** on the dashboard (drop a ticket on an IT member, or press Auto for the member with the fewest open tickets).

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
