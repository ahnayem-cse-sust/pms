<?php

/**
 * Role => permission map. Seeded into the `roles` table by RoleSeeder;
 * after seeding, the database copy is authoritative (editable later by an admin screen).
 */
return [
    // System time zone: GMT+6 (Bangladesh Standard Time, no daylight saving). Overrides APP_TIMEZONE.
    // Hard ceiling for a single attachment (KB). 5120 KB = 5 MB. The upload.max_kb setting can only go lower.
    'max_upload_kb' => 5120,

    // IT attendance page (Management): entry = first login of the day, exit = last login of the day,
    // counting only successful logins from the office IP addresses below.
    'attendance' => [
        'roles' => ['it_member'],                    // role slugs treated as "IT employees"
        'office_ips' => array_values(array_filter(array_map('trim', explode(',', env(
            'ITSM_OFFICE_IPS',
            '103.16.73.139,103.16.73.137,103.16.73.138,103.16.73.140,103.16.73.141,103.4.67.236'
        ))))),
        'weekend_days' => [5, 6],                    // Carbon day numbers: 5 = Friday, 6 = Saturday
        'max_months' => 6,                           // longest date range (From..To) allowed on the page and PDF
    ],

    // Request numbers are RQ-1, RQ-2, RQ-3 ... (one running counter, no year, no zero padding).
    'ticket_prefix' => 'RQ',

    // Roles whose members can be assigned tickets (team workload, assignment board, assign lists, auto-assign).
    'assignable_roles' => ['it_member', 'it_officer'],

    // How long the session record/cookie lives. Deliberately long: the 15-minute inactivity rule below is enforced by the
    // app for signed-in users, while a short lifetime would also expire the login page itself (-> "419 Page Expired").
    'session_lifetime_minutes' => (int) env('ITSM_SESSION_LIFETIME', 480),

    // Automatic sign-out after this many minutes without activity (override with ITSM_INACTIVITY_MINUTES).
    'inactivity_minutes' => (int) env('ITSM_INACTIVITY_MINUTES', 15),

    'timezone' => env('ITSM_TIMEZONE', 'Asia/Dhaka'),

    'roles' => [
        'admin'      => 'System Administrator',
        'it_officer' => 'IT Admin',
        'it_member'  => 'IT Team Member',
        'dept_user'  => 'Department User',
        'dept_head'  => 'Department Head',
        'management' => 'Management',
    ],

    'permissions' => [
        'admin' => [
            'ticket.create', 'ticket.create.behalf', 'ticket.view.own', 'ticket.view.all', 'ticket.comment.public',
            'ticket.note.internal', 'attachment.upload', 'attachment.download.internal',
            'dashboard.officer', 'report.view', 'attendance.view', 'user.view', 'user.create', 'user.update',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'lookup.view', 'lookup.create', 'lookup.update',
            'settings.view', 'settings.update', 'audit.view',
            // IT Inventory
            'inv.view', 'inv.view.own', 'inv.create', 'inv.update',
        ],
        'it_officer' => [
            'ticket.create', 'ticket.create.behalf', 'ticket.view.own', 'ticket.view.all', 'ticket.acknowledge',
            'ticket.assign', 'ticket.edit', 'ticket.work', 'ticket.comment.public',
            'ticket.note.internal', 'ticket.close', 'ticket.reopen', 'ticket.escalate',
            'ticket.cancel', 'attachment.upload', 'attachment.download.internal',
            'dashboard.officer', 'report.view', 'lookup.view', 'lookup.create', 'lookup.update',
            'user.view', 'user.create', 'user.update',
            // IT Inventory
            'inv.view', 'inv.create', 'inv.update',
        ],
        'it_member' => [
            'ticket.create', 'ticket.create.behalf', 'ticket.view.own', 'ticket.view.assigned', 'ticket.work',
            'ticket.comment.public', 'ticket.note.internal', 'ticket.escalate', 'attachment.upload',
            'attachment.download.internal', 'dashboard.member', 'attendance.own',
            // IT Inventory
            'inv.view', 'inv.create',
        ],
        'dept_user' => [
            'ticket.create', 'ticket.view.own', 'ticket.comment.public', 'ticket.confirm',
            'ticket.reopen', 'ticket.cancel', 'attachment.upload', 'dashboard.department',
            // IT Inventory
            'inv.view.own',
        ],
        'dept_head' => [
            'ticket.create', 'ticket.create.behalf.dept', 'ticket.view.own', 'ticket.view.department', 'ticket.comment.public',
            'ticket.confirm', 'ticket.reopen', 'ticket.cancel', 'attachment.upload',
            'dashboard.department', 'report.view',
            // IT Inventory
            'inv.view.own',
        ],
        'management' => [
            'ticket.view.all', 'dashboard.officer', 'report.view', 'attendance.view',
            // IT Inventory
            'inv.view',
        ],
    ],

    // Permissions that only a System Administrator may hand out (to a user through a role).
    'privileged_permissions' => ['role.view', 'role.create', 'role.update', 'role.delete', 'settings.view', 'settings.update', 'audit.view'],

    // Picking a permission automatically adds the ones it cannot work without (applied in the role form and on save).
    'permission_requires' => [
        'ticket.create.behalf' => ['ticket.create'],
        'ticket.create.behalf.dept' => ['ticket.create'],
        'ticket.assign' => ['ticket.view.all'],
        'ticket.edit' => ['ticket.view.all'],
        'ticket.acknowledge' => ['ticket.view.all'],
        'ticket.close' => ['ticket.view.all'],
        'ticket.cancel' => ['ticket.view.own'],
        'ticket.reopen' => ['ticket.view.own'],
        'ticket.confirm' => ['ticket.view.own'],
        'ticket.work' => ['ticket.view.assigned'],
        'ticket.comment.public' => ['ticket.view.own'],
        'dashboard.officer' => ['ticket.view.all'],
        'attendance.view' => ['report.view'],
        'user.create' => ['user.view'], 'user.update' => ['user.view'],
        'role.create' => ['role.view'], 'role.update' => ['role.view'], 'role.delete' => ['role.view'],
        'lookup.create' => ['lookup.view'], 'lookup.update' => ['lookup.view'],
        'settings.update' => ['settings.view'],
        'inv.create' => ['inv.view'], 'inv.update' => ['inv.view'],
    ],

    // Module-wise access matrix on the role screen: one row per module, one checkbox per Read / Add / Update / Delete.
    // A null cell means the module has no such action. Permissions that are not in the matrix (workflow actions such as
    // assign, escalate, close, internal notes ...) are listed below the matrix, grouped as in permission_catalog.
    'permission_matrix' => [
        'Requests' => [
            ['label' => 'Own requests', 'note' => 'Delete = cancel a request', 'read' => 'ticket.view.own', 'add' => 'ticket.create', 'update' => null, 'delete' => 'ticket.cancel'],
            ['label' => 'Requests assigned to them', 'read' => 'ticket.view.assigned', 'add' => null, 'update' => null, 'delete' => null],
            ['label' => 'Own department requests', 'note' => 'Add = file a request for department users', 'read' => 'ticket.view.department', 'add' => 'ticket.create.behalf.dept', 'update' => null, 'delete' => null],
            ['label' => 'All requests', 'note' => 'Add = file for any user; Update = edit request details', 'read' => 'ticket.view.all', 'add' => 'ticket.create.behalf', 'update' => 'ticket.edit', 'delete' => null],
        ],
        'Files' => [
            ['label' => 'Attachments', 'note' => 'Read = download internal attachments; Add = upload', 'read' => 'attachment.download.internal', 'add' => 'attachment.upload', 'update' => null, 'delete' => null],
        ],
        'Dashboards' => [
            ['label' => 'Officer dashboard', 'note' => 'Assignment board and team workload', 'read' => 'dashboard.officer', 'add' => null, 'update' => null, 'delete' => null],
            ['label' => 'IT team member dashboard', 'read' => 'dashboard.member', 'add' => null, 'update' => null, 'delete' => null],
            ['label' => 'Department dashboard', 'read' => 'dashboard.department', 'add' => null, 'update' => null, 'delete' => null],
        ],
        'Reports & attendance' => [
            ['label' => 'Reports', 'read' => 'report.view', 'add' => null, 'update' => null, 'delete' => null],
            ['label' => 'Attendance of all IT employees', 'read' => 'attendance.view', 'add' => null, 'update' => null, 'delete' => null],
            ['label' => 'Own attendance', 'read' => 'attendance.own', 'add' => null, 'update' => null, 'delete' => null],
        ],
        'IT Inventory' => [
            ['label' => 'Equipment stock & allocations', 'note' => 'Add = receive item (new or returned), allocate; Update = equipment, asset types and categories', 'read' => 'inv.view', 'add' => 'inv.create', 'update' => 'inv.update', 'delete' => null],
            ['label' => 'Own allocated equipment', 'read' => 'inv.view.own', 'add' => null, 'update' => null, 'delete' => null],
        ],
        'Administration' => [
            ['label' => 'Users', 'read' => 'user.view', 'add' => 'user.create', 'update' => 'user.update', 'delete' => null],
            ['label' => 'Roles & permissions', 'note' => 'Update also covers users\' individual permissions', 'read' => 'role.view', 'add' => 'role.create', 'update' => 'role.update', 'delete' => 'role.delete'],
            ['label' => 'Configuration lists', 'note' => 'Categories, departments, designations, locations ...', 'read' => 'lookup.view', 'add' => 'lookup.create', 'update' => 'lookup.update', 'delete' => null],
            ['label' => 'System settings & SLA', 'read' => 'settings.view', 'add' => null, 'update' => 'settings.update', 'delete' => null],
            ['label' => 'Audit log & login history', 'read' => 'audit.view', 'add' => null, 'update' => null, 'delete' => null],
        ],
    ],

    // Every permission an administrator can tick on a role or on a single user, grouped for the screens.
    'permission_catalog' => [
        'Requests' => [
            'ticket.create' => 'Create requests',
            'ticket.create.behalf' => 'Create a request on behalf of any user',
            'ticket.create.behalf.dept' => 'Create a request on behalf of department users',
            'ticket.view.own' => 'View own requests',
            'ticket.view.assigned' => 'View requests assigned to them',
            'ticket.view.department' => 'View all requests of own department',
            'ticket.view.all' => 'View all requests',
        ],
        'Request handling' => [
            'ticket.acknowledge' => 'Acknowledge requests',
            'ticket.assign' => 'Assign requests to IT employees',
            'ticket.edit' => 'Edit request details',
            'ticket.work' => 'Work on requests (appears as an assignable IT employee)',
            'ticket.escalate' => 'Escalate requests',
            'ticket.close' => 'Close requests',
            'ticket.reopen' => 'Reopen requests',
            'ticket.cancel' => 'Cancel requests',
            'ticket.confirm' => 'Confirm resolution',
        ],
        'Comments & files' => [
            'ticket.comment.public' => 'Post public comments',
            'ticket.note.internal' => 'Write and read internal notes',
            'attachment.upload' => 'Upload attachments',
            'attachment.download.internal' => 'Download internal attachments',
        ],
        'Dashboards' => [
            'dashboard.officer' => 'Officer dashboard (assignment board, team workload)',
            'dashboard.member' => 'IT team member dashboard',
            'dashboard.department' => 'Department dashboard',
        ],
        'Reports & attendance' => [
            'report.view' => 'View reports',
            'attendance.view' => 'View attendance of all IT employees',
            'attendance.own' => 'View own attendance',
        ],
        'IT Inventory' => [
            'inv.view' => 'View equipment stock, allocations and records',
            'inv.view.own' => 'View equipment allocated to themselves / their department',
            'inv.create' => 'Receive items (new or returned) and allocate items',
            'inv.update' => 'Manage equipment, asset types and categories',
        ],
        'Administration' => [
            'user.view' => 'View users',
            'user.create' => 'Create users',
            'user.update' => 'Edit users',
            'role.view' => 'View roles and permissions',
            'role.create' => 'Create roles',
            'role.update' => 'Edit roles and users\' individual permissions',
            'role.delete' => 'Delete roles',
            'lookup.view' => 'View configuration lists',
            'lookup.create' => 'Add to configuration lists',
            'lookup.update' => 'Edit configuration lists',
            'settings.view' => 'View system settings and SLA',
            'settings.update' => 'Change system settings and SLA',
            'audit.view' => 'View audit log and login history',
        ],
    ],
];
