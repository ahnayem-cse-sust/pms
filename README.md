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

## IT Inventory: deleting

- **Receives and allocations** can be deleted only by the System Administrator (permission `inv.delete`), from the list or the entry page. The entry's stock effect is reversed and its records are removed. A delete is refused, with a red alert, when it would break the records: stock would go below zero, a returned unit or quantity depends on it, or a serial unit has later records.
- **Asset types, categories and sub categories** can be deleted (with `inv.update`) only when no equipment uses them and nothing sits under them; otherwise the Delete button is disabled and says why. Mark a row Inactive to hide it instead.
- The Categories page filters by asset type; the Sub categories page filters by asset type and category.

## Maintenance mode (under construction page)

`php artisan down` takes the application offline and every visitor sees the **under maintenance** page (`resources/views/errors/503.blade.php`, with the JOPLC logo and footer; it refreshes itself every minute). Bring the app back with `php artisan up`. Useful options: `php artisan down --retry=60` (tells browsers when to retry) and `php artisan down --secret="my-secret"` (the administrator can still open the app at `/my-secret` while it is down). The page is standalone (no login, session or database), so it works even during a database upgrade.

## Automatic sign-out

The session itself lives for 8 hours (`ITSM_SESSION_LIFETIME`, default 480) on purpose: a 15-minute session lifetime also expires the *login page*, so the first sign-in after an automatic logout fails with "419 Page Expired". The 15-minute rule is enforced separately for signed-in users. If a login page is left open for hours and a token still goes stale, the user is returned to the login screen with a message instead of a 419 error page.

A user is signed out after **15 minutes of inactivity** (`inactivity_minutes` in `config/itsm.php`, or `ITSM_INACTIVITY_MINUTES` in `.env`). It is enforced on the server (every request) and in the browser: a warning appears one minute before, activity in any open tab keeps the session alive, and the page returns to the login screen with a notice.

## IT attendance (Management)

**IT Attendance** in the sidebar (Management and System Administrator) lists each IT employee per day with entry time (first sign-in of the day), exit time (**last sign-out of the day**), total time and status (Present / Absent / Weekend / Not in yet). Only sign-ins and sign-outs from the office IP addresses count; the list is in `config/itsm.php` (`attendance.office_ips`, or `ITSM_OFFICE_IPS` in `.env`, comma-separated). Weekend days are Friday and Saturday (`attendance.weekend_days`). "IT employees" are users with the IT Team Member role (`attendance.roles`). Results are paginated (15 per page). The From/To dates must be in order and at most **6 months** apart (`attendance.max_months`). Management and System Administrator can download the current view as a **PDF** (same date range as the page; needs `composer require barryvdh/laravel-dompdf`, which `install.sh` does for new installs). Enable the PHP **GD** extension (`extension=gd` in php.ini, then restart the web server) to get the logo in the PDF; without GD the PDF is still produced, just without the logo. IT Team Members get **My Attendance** in their menu, showing only their own record (no PDF).
A sign-out is recorded when the user clicks Sign out, and also when the 15-minute inactivity timeout ends their session (then it is stamped with the time of their **last activity**, i.e. when they actually left). Closing the browser without signing out is therefore covered after 15 minutes, **but only if the scheduler is running** (`php artisan schedule:run` every minute – see Scheduler above; the job is `itsm:record-logouts`). A day with a sign-in but no recorded sign-out shows `—` as exit and total time. Days before this feature was installed have no sign-out records.
The IP comes from the login history, so if the app runs behind a reverse proxy or load balancer configure Laravel's trusted proxies; otherwise every sign-in is recorded with the proxy's address and nothing will match. After upgrading run `php artisan migrate` and `php artisan optimize:clear`.

## Attachments

Maximum **5 MB per file** (ceiling `max_upload_kb` in `config/itsm.php`; the `upload.max_kb` setting can only lower it). PHP must allow it too: set `upload_max_filesize` and `post_max_size` in php.ini to at least 5 MB per file you expect in one submission (for example 40M), then restart the web server.

## Time zone

The system time zone is **GMT+6 (Asia/Dhaka)**, set in `config/itsm.php` (`ITSM_TIMEZONE`) and applied automatically, so ticket times, SLA due times, reports and scheduled jobs all use it. Timestamps already stored before this setting was applied were written in the old zone and will look 6 hours earlier if the old zone was UTC.

## Requests on behalf of others

System Administrator, IT Admin and IT Team Member can file a request for any user (e.g. when a problem is reported by phone); a Department Head can file for users in their own department. Pick the person under **Request for** on the New Request form. The ticket belongs to that person (they see it and are notified), and shows who filed it. Permissions: `ticket.create.behalf` and `ticket.create.behalf.dept` in `config/itsm.php`. After upgrading run `php artisan migrate` and `php artisan optimize:clear`.

## Escalation

The **Escalate** button in a request's Actions panel (red, with a mandatory comment) flags the request for the IT Admin. The IT Admin can escalate any open request; an IT employee can escalate a request where they are the primary responsible employee. It is available from New through Reopened. Escalating notifies the IT Admins, the requester and the primary employee. After upgrading run `php artisan migrate` (adds the New/Acknowledged transitions and the permission for IT employees).

## Request numbers and the request page

Requests are numbered **RQ-1, RQ-2, RQ-3 …** (one running counter, `ticket_prefix` in `config/itsm.php`). `php artisan migrate` renumbers existing requests in the order they were created and continues from the last one. Old numbers inside already-sent notifications are not rewritten.
The request page shows the number, status and a progress bar (New → Assigned → In progress → Resolved → Closed) on top, a panel with the request details and the assigned team, then the description and resolution and tabs for Conversation, Internal notes (IT staff only), Attachments and History. The details panel at the top has the requester (name, designation, employee ID, WhatsApp number), department and due date next to the assigned team; the side column has the actions available to you (including Escalate), work updates and team editing. The New Request form asks only for the requester's name, employee ID, designation and WhatsApp number (department is asked only if the person's profile has none).

## Team assignment: one primary + supporting employees

A request can have several IT employees, with **exactly one primary responsible employee** (accountable for coordination, follow-up and the final resolution) and any number of **supporting employees**.

- **IT Admin** sets the team on the ticket page (*Assign team* / *Change team*): choose the primary, tick the supporters, optional due date and instructions. The same screen changes the primary or the supporters later. Dragging a ticket onto an employee on the dashboard board changes only the primary; the supporters stay.
- **Primary** moves the request through the workflow (acknowledge, in progress, waiting, resolved) and records the final resolution. Supporting employees cannot change the request's status.
- **Every team member** records their own progress under *My work update* (To do / In progress / Waiting / Done plus a note). The primary is notified of supporters' updates. Work notes are visible to IT staff only; the requester sees the team's names and roles.
- When the primary resolves the request every member's part is marked Done; a reopened request resets everyone to To do.
- **My Tasks** lists requests where the employee is primary or supporting (with a *My role* column). Dashboard team workload shows primary and supporting counts, and auto-assign counts both.
- **History:** who was added or removed, role changes, and who assigned them and when are recorded on the ticket timeline and in the audit log.
- **Rule enforcement:** the application validates "exactly one primary" inside a transaction, and the database has a unique index (`ticket_assignments.ticket_id + primary_marker`) so a second primary can never be stored.

Upgrading an existing install: `php artisan migrate` (the old assignment trail is kept as `ticket_assignment_log`; each already-assigned request gets its assignee as the primary), then `php artisan optimize:clear`.

## My Requests and My Tasks (IT staff)

IT Team Members and IT Admins have two personal menus. **My Requests** lists only requests where they are the requester: ones they submitted for themselves, or ones someone submitted on their behalf. **My Tasks** lists every request they are on the team of, as primary or supporting (with a badge for the open ones). **All Requests** lists every request for IT Team Members too, but a request's details page opens only for the requester and the IT team assigned to it (other rows show a lock and are not clickable; a direct link redirects to the request list with a red "That page is not accessible to you." alert). IT Admins and Management can open any request. Requests an IT employee filed for other people appear under that person's own list.

## Who can be assigned tickets

IT Team Members **and IT Admins** can be assigned requests: both appear in the assign lists, the dashboard team-workload table, the drag-and-drop board and auto-assign (fewest open tickets), and in the monthly report's team summary. The list of roles is `assignable_roles` in `config/itsm.php`.

## Multiple roles

A user can hold more than one role (e.g. IT Admin + IT Team Member, or Department Head + Department User). Tick the roles on the user form; permissions are combined. After upgrading an existing install run `php artisan migrate` – existing users keep their current role.

## UI

Blade + Bootstrap 5 with a custom design layer (`public/css/itsm.css`): left sidebar, sticky top bar with global ticket search, light/dark theme toggle (remembered per browser), soft status pills, avatars, stat cards and toast messages.
Vue 3 (loaded from `public/vendor`, no build step) powers two screens: the **New Request** form (dependent sub-categories, SLA hints on priorities, drag-and-drop attachments, searchable "Request for" picker) and the IT Admin's **drag-and-drop assignment board** on the dashboard (drop a ticket on an IT member, or press Auto for the member with the fewest open tickets).

## What is in Phase 1

- Login with lockout, login history, session timeout, role + permission authorization, audit log
- Request submission (type, category/sub-category, priority, attachments, preferred date), request numbers `RQ-1`, `RQ-2`, …
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

## Roles and permissions (System Administrator)

**Administration → Roles & Permissions** lists every role. **+ New role** creates a custom role: give it a name and tick the permissions (grouped, with an *All* switch per group). Built-in roles can be edited too, except System Administrator, which is fixed so administrators can never be locked out. A role can only be deleted when it is custom and no user holds it. Changes apply to users on their next page load, and every change is written to the audit log.

On **Users → (open a user) → Edit permissions** (its own screen, not part of the user edit form), a System Administrator sets **Individual permissions** (the *Inherit* button itself shows what the roles give: *Inherit · Allowed* in green or *Inherit · Denied* in red): for each permission choose *Inherit* (follow the user's roles), *Allow* (add it for this user) or *Deny* (remove it for this user only). Users with individual permissions show a "+ custom" tag on the user's details page. Administrators cannot edit their own individual permissions, and individual denies never apply to System Administrators.

Notes:
- Run `php artisan migrate` to add the new columns and the `role.manage` permission. Re-running the seeder no longer resets permissions you edited.
- Only a System Administrator can see or assign roles that carry `role.manage`, `settings.manage` or `audit.view` (configurable as `privileged_permissions` in `config/itsm.php`); IT Admin cannot hand them out or edit users who hold them.
- Any role that has the **Work on requests** permission (`ticket.work`) appears in the assignable-employee lists, team workload and assignment board.
- Some screens still depend on the built-in role names (the attendance list uses `itsm.attendance.roles`); permissions of a custom role control menus, pages and actions.

## Assignment board

The board has its own menu item, **Assignment Board** (shown to everyone who can see the officer dashboard; only users with the assign permission can drag). Each IT employee's column lists the requests they are primarily responsible for, followed by the requests where they are a **supporting** team member (teal cards tagged *Support*, naming the primary employee). Support cards cannot be dragged: change the team on the request page, or drag the primary card of that request.

## v36 changes

- **Assignment board:** cards where the employee is the primary now carry a blue **Primary** tag and blue accent (supporting cards stay teal with the **Support** tag); the column header count for primary work is blue too.
- **Role create/edit screen:** a module-wise matrix with **Read / Add / Update / Delete** checkboxes per module (requests by scope, attachments, dashboards, reports & attendance, users, roles, configuration lists, system settings, audit). Row and column "select all", search, live counter, and a *Duplicate* shortcut on the role list. Workflow actions that are not CRUD (acknowledge, assign, work, escalate, close, reopen, confirm, public comments, internal notes) are listed under the matrix. Add / Update / Delete automatically switch on Read for the same module; other dependencies are in `permission_requires` and the matrix rows in `permission_matrix` (`config/itsm.php`).
- **Granular admin permissions (real enforcement):** the old `user.manage`, `role.manage`, `lookup.manage` and `settings.manage` are replaced by `user.view/create/update`, `role.view/create/update/delete`, `lookup.view/create/update` and `settings.view/update`. Routes, menus, buttons and controllers check them individually (e.g. a user with only *Read* on Users sees the list without Edit/New buttons). Run `php artisan migrate`: migration `000020` converts existing roles and users' individual Allow/Deny entries (a former `*.manage` becomes the full set), and is reversible. Configuration lists have no delete action in the app, so their Delete cell is shown as "–". Users can be deleted only by a System Administrator (see *Users* below).
- **Users:** the list shows name, employee ID, email, department and status (role and last login are on the details page). Every user has a **details page** (all fields, roles, last login and the full **Permissions** list laid out like the edit-permissions screen, every permission shown as *Allowed* or *Denied* – inherited ones too – with individual allows/denies highlighted; searchable) with the **Edit** button; saving an edit returns to it. **Edit permissions** on that page opens a separate screen (needs `role.update`; not available for yourself or a System Administrator), so saving the user form never changes permissions. A **System Administrator** can **Delete** a user from the details page (permission `user.delete`, migration `000038`). Delete is refused for your own account and for anyone who already has records (requests, assignments, work updates, comments, attachments, inventory records) – disable the account instead (untick *Active*). Login history, the audit log and request history keep their rows, and a `user.deleted` entry is written to the audit log.
- Only a System Administrator can see or grant the role, settings and audit permissions (also for individual user overrides). Built-in role names are locked. The user form's individual permissions have a search box and an overrides counter. The role list no longer shows an access-by-area column.

## IT Inventory (simple)

Purpose: keep **equipment stock**, track **who has what**, and keep **records**. A separate module with its own tables (`inv_*`), routes (`routes/inventory.php`), controllers, models and views. The request/ticket module is not modified; shared files only received additive edits (sidebar group, permission catalogue, one icon, one `require` line in `routes/web.php`).

Run `php artisan migrate` (`000025` creates the tables, `000026` adds the permissions to existing roles, `000027` adds the three-level classification and carries over existing equipment; both also clean up earlier inventory drafts if they had been installed).

There are no stores and no individual asset records: each equipment item has one stock quantity, classified by **Asset type → Category → Sub category** (for example Computing › Laptop › Business laptop).

Screens (sidebar → *IT Inventory*):
- **Dashboard** – counts, low / out-of-stock equipment, latest records.
- **Equipment & Stock** – code, name, asset type, sub category, brand / model, unit, minimum stock, quantity in stock; CSV. The quantity is read-only here: stock only changes through **Receives** (+, from a supplier or a return) and **Allocations** (−). There is no manual correction; an entry made by mistake is fixed with another receive / allocation / return.
- **Allocations** – allocate equipment to an employee or a department and see who holds what; PDF handover form per entry. The **Return** button opens Receives for that person. **Purpose is entered per equipment line**, not once per allocation. **Serialisable** equipment (category tick) is one unit per line: no quantity, and the system generates the serial number (equipment code + running number, e.g. `LAPT00010001`); a unit that was returned is handed out again under its own serial. **Other** equipment needs only a quantity. Returning a serialisable unit (Receives → Employee / Department) is done per serial, one unit at a time. **One allocation = one entry** (`AL-000001`) for any number of equipment lines. *Allocations → Allocation records* lists the entries (one row each, with filters and CSV) and every entry has a **View** page and a **PDF** handover form to download; the person it was handed to can also download it. Records shows the entry number of every line, with a **View** page per record (all its details, linking to its entry) and a PDF link.
- **My Equipment** – people with "own" access see what is allocated to them or their department.
- **Serial mark** – each *category* (Types & Categories → Categories) has a *Serialisable* tick: ticked = each unit of that category's equipment carries a serial number. It is shown in the category list, as a `serial` tag on the equipment list and in the equipment CSV.
- **Equipment code** – generated by the system, never typed: first 2 letters of the asset type + first 2 letters of the category + a running number per prefix, at least 4 digits and growing after 9999 (e.g. `COPR0001`, `COPR0002`). The length is therefore not fixed. Category is required. The code never changes after creation, even if the classification is edited. Older hand-typed codes are left as they are.
- **Receives** (sidebar) – **one save = one entry** (`RC-000001`) holding all the items entered together; the list shows one row per entry with its items, filters (received from, equipment, dates, search) and CSV. Every entry has a **View** page (header + all items) and a **PDF** download (receipt). The **+ Receive item** button opens the entry form (Receive Item):
- **Previous items** – on Receive Item choose *Received from → Previous item* for equipment that existed before this system: enter the original (past) date and, optionally, who has it now. In store → stock is added. With an employee / department → stock is added and handed out on the same date (stock unchanged), so it appears under Allocations and can be returned later. Shown in Receives as *Previous item*.
- **Receive Item** – every item that comes in is entered here. *Received from* = Supplier (supplier, invoice / PO no., items, quantities) or Employee / Department (a return: pick who is returning, then only the items they hold are offered, up to the quantity they hold). Returns are no longer entered anywhere else.
- **Records** – every received item, allocation and return (plus any old corrections made before manual correction was removed), filterable, CSV.
- **Types & Categories** – three tabs: Asset types, Categories (under a type) and Sub categories (under a category).

Rules: no approvals; stock can never go negative; a return cannot exceed what the person / department holds; the category must belong to the asset type and the sub category to the category; every change leaves a record line and runs in one database transaction.

Permissions (Roles → *IT Inventory*): `inv.view` (see everything), `inv.view.own` (only their own equipment), `inv.create` (receive items incl. returns, allocate), `inv.update` (equipment, types, categories). Defaults: System Admin and IT Admin all; IT Employee view + create; Department users / heads own equipment; Management view.

Tests: `tests/Feature/InventoryTest.php` (not run in the build environment; run `php artisan test`).

## Inventory classification upgrade

If an inventory page fails with `Unknown column 'level' in 'where clause'`, run `php artisan migrate` and `php artisan optimize:clear`. Migration `000028` adds the missing `inv_categories.level` / `inv_equipment.asset_type_id` columns if they are absent and does nothing otherwise. Do not run `migrate:fresh` or `migrate:refresh` on a database with data you need (migration `000025` drops the `inv_*` tables).

## Inventory UI upgrade (v69)
Presentation only: no routes, permissions, database or form-field changes.
- **Dashboard**: icon stat cards, quick actions, "Needs attention" with stock meters, a latest-activity feed (each row opens its record) and stock by asset type.
- **Equipment & Stock**: one classification column (Asset type › Category › Sub category), stock meter with the minimum level marked, Out of stock / Low stock / In stock status, a result summary, a History shortcut per item, and filter switches.
- **Receives, Allocation records, Records**: whole row opens the entry, movement-type icons, +/- coloured quantities, long entries show the first three items with "+N more", PDF and CSV actions as labelled buttons, active-filter count on Reset, proper empty states.
- **Who has what / My Equipment**: avatars and department icons; My Equipment is now a card view that works well on phones.
- **Receive Item / Allocate Equipment / Equipment form**: sectioned cards, numbered item lines with live item count and available-quantity hints, sticky save bar.
- **Equipment form (asset type / category / sub category):** every asset type, category and sub category is always in its list (nothing is hidden by the selection above). Choosing a **sub category** fills in its category and asset type; choosing a **category** fills in its asset type; changing the asset type clears a category (and sub category) that belongs to another one. **Category** and **Sub category** have a search box (type part of the name, or of its parent's name; arrow keys + Enter work) and show the parent next to each name. The server still checks that the three levels belong together.
- **Detail pages** (entry and record): header card with type icon, status and a tidy details grid.
- **Types & Categories**: tabs with counts, the Asset type › Category › Sub category path, switches, highlighted row while editing.
- All light/dark theme aware. Shared styles are in the `inv-*` block at the end of `public/css/itsm.css`; small partials live in `resources/views/inventory/` (`_crumb`, `_meter`, `_empty`, `_rowlink`).


## Desktop notification pop-ups over plain http

Browsers only allow operating-system pop-ups (the Notification API) on `https://` pages or `localhost`; a web page cannot override that.
When the system is opened over `http://server`, the top-bar button reads **Enable sound alerts** and gives a chime plus a flashing tab title for every new notification.

To get real desktop pop-ups on the office PCs without HTTPS, allow the site in the browser (one-time, per PC or via Group Policy):

- **Chrome / Edge, single PC:** open `chrome://flags/#unsafe-treat-insecure-origin-as-secure` (Edge: `edge://flags/...`), add `http://your-server-address`, set it to *Enabled* and relaunch the browser.
- **Chrome / Edge, all PCs (Group Policy):** policy `OverrideSecurityRestrictionsOnInsecureOrigin` (Chrome) / `OverrideSecurityRestrictionsOnInsecureOrigin` (Edge) with the value `http://your-server-address`.
- After that the button reads **Enable desktop alerts** and the pop-ups work.
