<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * JOPLC IT Service Management - Phase 1 (Core Helpdesk)
 * Tables: lookups, org, users/roles, tickets, assignments, comments,
 * internal notes, attachments, history, ticket-number sequence, notifications, audit.
 *
 * Phase 2 hooks already present as nullable columns: asset_id, sla_*, approval_required.
 * Roles/permissions: install spatie/laravel-permission separately (see WORKFLOW.md).
 */
return new class extends Migration
{
    public function up(): void
    {
        // ---------- Organisation ----------
        Schema::create('departments', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('code', 20)->unique();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('designations', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('locations', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        // ---------- Users (extends default Laravel users table) ----------
        Schema::table('users', function (Blueprint $t) {
            $t->string('employee_id', 30)->nullable()->unique()->after('id');
            $t->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $t->string('phone', 30)->nullable();
            $t->boolean('is_active')->default(true);
            $t->boolean('is_department_head')->default(false);
            $t->unsignedTinyInteger('failed_logins')->default(0);
            $t->timestamp('locked_until')->nullable();
            $t->timestamp('last_login_at')->nullable();
            $t->string('last_login_ip', 45)->nullable();
            $t->timestamp('password_changed_at')->nullable();
        });

        Schema::create('login_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('email_tried')->nullable();
            $t->boolean('successful');
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->timestamp('created_at')->useCurrent();
        });

        // ---------- Configurable lookups ----------
        Schema::create('ticket_types', function (Blueprint $t) {   // Incident, Service Request, Change, Access, Asset Request
            $t->id();
            $t->string('name')->unique();
            $t->string('code', 10)->unique();
            $t->boolean('requires_approval')->default(false);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('ticket_categories', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('ticket_subcategories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained('ticket_categories')->cascadeOnDelete();
            $t->string('name');
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->unique(['category_id', 'name']);
        });

        Schema::create('ticket_priorities', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();             // Critical, High, Medium, Low
            $t->unsignedTinyInteger('level')->unique(); // 1 = highest
            $t->string('color', 20)->nullable();
            // SLA targets (minutes) - admin-editable now, enforced in Phase 2
            $t->unsignedInteger('response_minutes')->nullable();
            $t->unsignedInteger('resolution_minutes')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('ticket_statuses', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('code', 30)->unique();          // NEW, ACKNOWLEDGED, ...
            $t->boolean('is_open')->default(true);     // counts toward "open" workload
            $t->boolean('is_final')->default(false);
            $t->string('color', 20)->nullable();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });

        // Allowed transitions, editable data instead of hard-coded rules
        Schema::create('ticket_status_transitions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('from_status_id')->constrained('ticket_statuses')->cascadeOnDelete();
            $t->foreignId('to_status_id')->constrained('ticket_statuses')->cascadeOnDelete();
            $t->string('permission', 60);              // permission name required to perform it
            $t->boolean('requires_comment')->default(false);
            $t->unique(['from_status_id', 'to_status_id', 'permission'], 'uq_status_transition');
        });

        // ---------- Tickets ----------
        Schema::create('ticket_sequences', function (Blueprint $t) {  // IT-2026-000125 generation
            $t->unsignedSmallInteger('year')->primary();
            $t->unsignedInteger('last_number')->default(0);
        });

        Schema::create('tickets', function (Blueprint $t) {
            $t->id();
            $t->string('ticket_no', 20)->unique();     // IT-2026-000125
            $t->foreignId('ticket_type_id')->constrained('ticket_types');

            // requester snapshot (kept even if user record changes later)
            $t->foreignId('requester_id')->constrained('users');
            $t->foreignId('department_id')->constrained('departments');
            $t->string('requester_name');
            $t->string('requester_employee_id', 30)->nullable();
            $t->string('requester_designation')->nullable();
            $t->string('requester_phone', 30)->nullable();
            $t->string('requester_email')->nullable();
            $t->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();

            $t->foreignId('category_id')->constrained('ticket_categories');
            $t->foreignId('subcategory_id')->nullable()->constrained('ticket_subcategories')->nullOnDelete();
            $t->foreignId('priority_id')->constrained('ticket_priorities');
            $t->foreignId('status_id')->constrained('ticket_statuses');

            $t->string('subject', 200);
            $t->text('description');
            $t->date('preferred_completion_date')->nullable();

            $t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $t->date('due_date')->nullable();

            // Phase 2 hooks
            $t->unsignedBigInteger('asset_id')->nullable()->index();
            $t->boolean('approval_required')->default(false);
            $t->timestamp('sla_response_due_at')->nullable();
            $t->timestamp('sla_resolution_due_at')->nullable();
            $t->string('sla_status', 20)->nullable();  // on_track, warning, breached

            // lifecycle timestamps
            $t->timestamp('acknowledged_at')->nullable();
            $t->timestamp('assigned_at')->nullable();
            $t->timestamp('started_at')->nullable();
            $t->timestamp('resolved_at')->nullable();
            $t->timestamp('closed_at')->nullable();
            $t->timestamp('reopened_at')->nullable();
            $t->unsignedSmallInteger('reopen_count')->default(0);

            $t->text('resolution')->nullable();
            $t->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('created_by')->constrained('users');
            $t->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->softDeletes();

            // search / dashboard indexes
            $t->index(['status_id', 'assigned_to']);
            $t->index(['department_id', 'status_id']);
            $t->index(['category_id', 'created_at']);
            $t->index('priority_id');
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                $t->fullText(['subject', 'description']);
            }
        });

        Schema::create('ticket_assignments', function (Blueprint $t) {  // full assignment trail
            $t->id();
            $t->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $t->foreignId('assigned_to')->constrained('users');
            $t->foreignId('assigned_from')->nullable()->constrained('users')->nullOnDelete(); // previous owner
            $t->foreignId('assigned_by')->constrained('users');
            $t->text('instructions')->nullable();
            $t->timestamp('created_at')->useCurrent();
        });

        Schema::create('ticket_comments', function (Blueprint $t) {     // PUBLIC thread
            $t->id();
            $t->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users');
            $t->text('body');
            $t->timestamps();
            $t->index(['ticket_id', 'created_at']);
        });

        Schema::create('ticket_internal_notes', function (Blueprint $t) { // IT-only, never shown to requester
            $t->id();
            $t->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users');
            $t->text('body');
            $t->timestamps();
            $t->index(['ticket_id', 'created_at']);
        });

        Schema::create('ticket_attachments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $t->foreignId('comment_id')->nullable()->constrained('ticket_comments')->nullOnDelete();
            $t->foreignId('uploaded_by')->constrained('users');
            $t->string('original_name');
            $t->string('stored_path');                 // private disk, served via authorised controller
            $t->string('mime_type', 100);
            $t->string('extension', 10);
            $t->unsignedBigInteger('size_bytes');
            $t->string('sha256', 64)->nullable();
            $t->boolean('is_internal')->default(false); // hidden from requester
            $t->string('scan_status', 20)->default('pending'); // pending, clean, infected, skipped
            $t->timestamps();
        });

        Schema::create('ticket_history', function (Blueprint $t) {       // status/field timeline
            $t->id();
            $t->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('action', 40);                  // created, status_changed, assigned, priority_changed ...
            $t->string('field', 60)->nullable();
            $t->string('old_value')->nullable();
            $t->string('new_value')->nullable();
            $t->text('remark')->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->index(['ticket_id', 'created_at']);
        });

        // ---------- Notifications (in-system) ----------
        Schema::create('notifications', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('type');
            $t->morphs('notifiable');
            $t->text('data');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });

        // ---------- System settings & audit ----------
        Schema::create('system_settings', function (Blueprint $t) {
            $t->id();
            $t->string('key', 100)->unique();          // e.g. upload.max_kb, upload.allowed_ext, session.timeout
            $t->text('value')->nullable();
            $t->string('group', 40)->default('general');
            $t->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('event', 60);                   // created, updated, deleted, login, assigned ...
            $t->string('auditable_type')->nullable();
            $t->unsignedBigInteger('auditable_id')->nullable();
            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->index(['auditable_type', 'auditable_id']);
            $t->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        foreach ([
            'audit_logs', 'system_settings', 'notifications', 'ticket_history',
            'ticket_attachments', 'ticket_internal_notes', 'ticket_comments',
            'ticket_assignments', 'tickets', 'ticket_sequences',
            'ticket_status_transitions', 'ticket_statuses', 'ticket_priorities',
            'ticket_subcategories', 'ticket_categories', 'ticket_types',
            'login_histories',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('department_id');
            $t->dropConstrainedForeignId('designation_id');
            $t->dropConstrainedForeignId('location_id');
            $t->dropColumn([
                'employee_id', 'phone', 'is_active', 'is_department_head',
                'failed_logins', 'locked_until', 'last_login_at',
                'last_login_ip', 'password_changed_at',
            ]);
        });

        Schema::dropIfExists('locations');
        Schema::dropIfExists('designations');
        Schema::dropIfExists('departments');
    }
};
