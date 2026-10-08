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
        'max_days' => 62,                            // longest date range the page will show
    ],

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
            'dashboard.officer', 'report.view', 'attendance.view', 'user.manage', 'lookup.manage',
            'settings.manage', 'audit.view',
        ],
        'it_officer' => [
            'ticket.create', 'ticket.create.behalf', 'ticket.view.own', 'ticket.view.all', 'ticket.acknowledge',
            'ticket.assign', 'ticket.edit', 'ticket.work', 'ticket.comment.public',
            'ticket.note.internal', 'ticket.close', 'ticket.reopen', 'ticket.escalate',
            'ticket.cancel', 'attachment.upload', 'attachment.download.internal',
            'dashboard.officer', 'report.view', 'lookup.manage', 'user.manage',
        ],
        'it_member' => [
            'ticket.create', 'ticket.create.behalf', 'ticket.view.own', 'ticket.view.assigned', 'ticket.work',
            'ticket.comment.public', 'ticket.note.internal', 'attachment.upload',
            'attachment.download.internal', 'dashboard.member',
        ],
        'dept_user' => [
            'ticket.create', 'ticket.view.own', 'ticket.comment.public', 'ticket.confirm',
            'ticket.reopen', 'ticket.cancel', 'attachment.upload', 'dashboard.department',
        ],
        'dept_head' => [
            'ticket.create', 'ticket.create.behalf.dept', 'ticket.view.own', 'ticket.view.department', 'ticket.comment.public',
            'ticket.confirm', 'ticket.reopen', 'ticket.cancel', 'attachment.upload',
            'dashboard.department', 'report.view',
        ],
        'management' => [
            'ticket.view.all', 'dashboard.officer', 'report.view', 'attendance.view',
        ],
    ],
];
