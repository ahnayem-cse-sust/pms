<?php

/**
 * Role => permission map. Seeded into the `roles` table by RoleSeeder;
 * after seeding, the database copy is authoritative (editable later by an admin screen).
 */
return [
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
            'ticket.create', 'ticket.view.own', 'ticket.view.all', 'ticket.comment.public',
            'ticket.note.internal', 'attachment.upload', 'attachment.download.internal',
            'dashboard.officer', 'report.view', 'user.manage', 'lookup.manage',
            'settings.manage', 'audit.view',
        ],
        'it_officer' => [
            'ticket.create', 'ticket.view.own', 'ticket.view.all', 'ticket.acknowledge',
            'ticket.assign', 'ticket.edit', 'ticket.work', 'ticket.comment.public',
            'ticket.note.internal', 'ticket.close', 'ticket.reopen', 'ticket.escalate',
            'ticket.cancel', 'attachment.upload', 'attachment.download.internal',
            'dashboard.officer', 'report.view', 'lookup.manage', 'user.manage',
        ],
        'it_member' => [
            'ticket.create', 'ticket.view.own', 'ticket.view.assigned', 'ticket.work',
            'ticket.comment.public', 'ticket.note.internal', 'attachment.upload',
            'attachment.download.internal', 'dashboard.member',
        ],
        'dept_user' => [
            'ticket.create', 'ticket.view.own', 'ticket.comment.public', 'ticket.confirm',
            'ticket.reopen', 'ticket.cancel', 'attachment.upload', 'dashboard.department',
        ],
        'dept_head' => [
            'ticket.create', 'ticket.view.own', 'ticket.view.department', 'ticket.comment.public',
            'ticket.confirm', 'ticket.reopen', 'ticket.cancel', 'attachment.upload',
            'dashboard.department', 'report.view',
        ],
        'management' => [
            'ticket.view.all', 'dashboard.officer', 'report.view',
        ],
    ],
];
