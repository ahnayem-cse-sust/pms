# JOPLC ITSM – Phase 1 Workflow & Permission Matrix

## 1. Status workflow

```
NEW ─► ACKNOWLEDGED ─► ASSIGNED ─► IN_PROGRESS ─► RESOLVED ─► USER_CONFIRMATION ─► CLOSED
 │          │             │          │   ▲                            │
 │          │             │          ▼   │                            └─► REOPENED
 │          │             │     WAITING_USER                               │
 │          │             │     ON_HOLD                         (back to ASSIGNED / IN_PROGRESS)
 └──────────┴─────────────┴──► CANCELLED
 Any working state ─► ESCALATED ─► ASSIGNED / IN_PROGRESS
 CLOSED ─► REOPENED (within reopen window)
```

Transitions live in the `ticket_status_transitions` table (seeded by `ItsmLookupSeeder`), so rules are data, not code. A status change is allowed only if a row exists for (from → to) **and** the user holds the row's `permission`.

| From | To | Permission | Comment required | Who (default) |
|---|---|---|---|---|
| NEW | ACKNOWLEDGED | ticket.acknowledge | No | IT Admin |
| NEW / ACKNOWLEDGED / REOPENED / ESCALATED | ASSIGNED | ticket.assign | No | IT Admin |
| ASSIGNED | IN_PROGRESS | ticket.work | No | Assignee |
| IN_PROGRESS | WAITING_USER | ticket.work | Yes | Assignee |
| WAITING_USER | IN_PROGRESS | ticket.work | No | Assignee, or **automatic** when requester replies |
| IN_PROGRESS | ON_HOLD / back | ticket.work | Yes / No | Assignee |
| IN_PROGRESS | RESOLVED | ticket.work | Yes (resolution text) | Assignee |
| RESOLVED | USER_CONFIRMATION | system | No | Automatic, on resolve |
| USER_CONFIRMATION | CLOSED | ticket.confirm | No | Requester / Dept Head |
| USER_CONFIRMATION | CLOSED | ticket.close | No | IT Admin, or auto-close job after `ticket.auto_close_days` |
| USER_CONFIRMATION | REOPENED | ticket.confirm | Yes | Requester ("problem still exists") |
| CLOSED | REOPENED | ticket.reopen | Yes | Requester within `ticket.reopen_window_days`; Officer anytime |
| ASSIGNED / IN_PROGRESS / WAITING_USER / ON_HOLD / REOPENED | ESCALATED | ticket.escalate | Yes | IT Admin (SLA job in Phase 2) |
| NEW / ACKNOWLEDGED / ASSIGNED | CANCELLED | ticket.cancel | Yes | Requester (own, while NEW) / IT Admin |

**Design note:** RESOLVED and USER_CONFIRMATION are effectively the same waiting state. Phase 1 keeps both to match your spec; if it feels redundant in UAT, merge them (resolve → "Resolved – Awaiting Confirmation").

## 2. Roles

| Role | Scope |
|---|---|
| System Administrator | Configuration, users, roles, lookups, settings. No ticket work by default. |
| IT Admin | All tickets; assign/reassign; priority/category/due date; escalate; close; reopen; team workload. |
| IT Team Member | Own assigned tickets only (+ read of Knowledge Base in Phase 2). |
| Department User | Own tickets only. |
| Department Head | All tickets of own department (view, comment, confirm/close). Approval step arrives in Phase 2. |
| Management | Dashboards and reports, read-only. |

## 3. Permission matrix

Legend: ● = yes, ◐ = limited (see note), blank = no.

| Permission | Admin | IT Admin | IT Member | Dept User | Dept Head | Mgmt |
|---|:-:|:-:|:-:|:-:|:-:|:-:|
| ticket.create | ● | ● | ● | ● | ● | |
| ticket.view.own | ● | ● | ● | ● | ● | |
| ticket.view.department | | | | | ● | |
| ticket.view.assigned | | | ● | | | |
| ticket.view.all | ● | ● | | | | ● |
| ticket.acknowledge | | ● | | | | |
| ticket.assign (assign/reassign) | | ● | | | | |
| ticket.edit.priority / category / due | | ● | ◐ | | | |
| ticket.work (progress, wait, resolve) | | ● | ◐ | | | |
| ticket.comment.public | ● | ● | ● | ● | ● | |
| ticket.note.internal (add + view) | ● | ● | ● | | | |
| ticket.confirm | | | | ◐ | ◐ | |
| ticket.close | | ● | | | | |
| ticket.reopen | | ● | | ◐ | ◐ | |
| ticket.escalate | | ● | | | | |
| ticket.cancel | | ● | | ◐ | ◐ | |
| attachment.upload | ● | ● | ● | ● | ● | |
| attachment.download.internal | ● | ● | ● | | | |
| dashboard.officer (team workload) | | ● | | | | ● |
| dashboard.member | | | ● | | | |
| dashboard.department | | | | ● | ● | |
| report.view | ● | ● | | | ◐ | ● |
| user.manage (create/edit users) | ● | ◐ | | | | |
| lookup.manage (categories, priorities, statuses) | ● | ◐ | | | | |
| settings.manage | ● | | | | | |
| audit.view / loginhistory.view | ● | | | | | |

Notes on ◐:
- **IT Member** can change priority/category only if the Officer enables it; `ticket.work` applies only to tickets where `assigned_to` = self.
- **IT Admin user.manage**: can create and edit users and assign any role except System Administrator. System Administrator accounts and that role are hidden from them, and the server rejects attempts to edit such an account or grant the role.
- **Dept User / Dept Head** `confirm`, `reopen`, `cancel` apply only to their own (Head: own department's) tickets and only from the valid states above.
- **Dept Head report.view** is limited to own department.
- **IT Admin lookup.manage** is limited to categories/sub-categories; priorities and SLA values stay Admin-only.
- **Audit log and login history** are visible to the System Administrator role only.

## 4. Business rules enforced in code (not just UI)

1. **Ticket number:** `IT-{year}-{000000}`, generated inside a DB transaction with a row lock on `ticket_sequences` (no duplicates under concurrent submits); counter resets each year.
2. **Assignment:** assignee must hold `ticket.work` and be active. Every assign/reassign writes `ticket_assignments` + `ticket_history`, and notifies the new assignee (and the old one on reassign).
3. **Internal notes and internal attachments** are filtered at the query level for any user without `ticket.note.internal` (never hidden by CSS only).
4. **Requester snapshot:** name, employee ID, designation, phone and email are copied onto the ticket at submit time.
5. **Resolve** requires resolution text; sets `resolved_at`. **Close** sets `closed_at` and `closed_by`. **Reopen** clears `closed_at`, increments `reopen_count`, notifies the Officer.
6. **Auto-close:** a scheduled job closes tickets sitting in USER_CONFIRMATION longer than `ticket.auto_close_days`.
7. **Every change** to a ticket writes `ticket_history` (user-visible timeline) and `audit_logs` (who / what / old / new / IP).
8. **Uploads:** extension whitelist and max size from `system_settings`; stored on a private disk with a random file name; downloads go through a policy-checked controller; `scan_status` is ready for ClamAV.
9. **Security:** lockout after `security.max_failed_logins`, session timeout from settings, all attempts recorded in `login_histories`.

## 5. Implementation notes

- **Roles and permissions** are stored in the `roles` table (permissions as JSON), seeded from `config/itsm.php`. A user can hold **several roles** (`role_user` pivot); effective permissions are the union of all their roles. Each permission name is registered as a Laravel Gate, so `@can('ticket.assign')` and `middleware('can:ticket.assign')` work everywhere. No third-party package is needed.
- **Status rules** come from `ticket_status_transitions`; `TicketService::changeStatus()` is the only code path that moves a ticket, and it also enforces ownership (assignee, requester, department head) and the reopen window.
- **Setup:** see README.md (`install.sh` builds a fresh Laravel app and overlays this code).
- `asset_id`, `sla_*` and `approval_required` are Phase 2 columns. SLA due times are already calculated at submit time and the `itsm:sla-check` command already updates warning/breached status (calendar minutes, not working hours).
