<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * One request, several IT employees, exactly one of them PRIMARY (accountable) and the rest SUPPORT.
 *
 * - the old per-change trail in `ticket_assignments` is kept as `ticket_assignment_log`
 * - `ticket_assignments` becomes the current team: one row per employee on a request
 * - `tickets.assigned_to` stays as a shortcut to the primary employee
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('ticket_assignments', 'ticket_assignment_log');

        Schema::create('ticket_assignments', function (Blueprint $t) {
            $t->id();
            // explicit constraint names: the renamed table above still owns the auto-generated ones
            $t->unsignedBigInteger('ticket_id');
            $t->unsignedBigInteger('employee_id');
            $t->unsignedBigInteger('assigned_by');
            $t->string('role', 10)->default('SUPPORT');            // PRIMARY | SUPPORT
            // 1 for the primary employee, NULL for supporters. With the unique index below the database itself
            // refuses a second primary on the same request (MySQL allows many NULLs in a unique index).
            $t->unsignedTinyInteger('primary_marker')->nullable();
            $t->timestamp('assigned_at')->useCurrent();
            $t->string('work_status', 15)->default('ASSIGNED');    // ASSIGNED | IN_PROGRESS | WAITING | DONE
            $t->text('remarks')->nullable();                        // the employee's latest work note
            $t->timestamps();

            $t->foreign('ticket_id', 'fk_tasg_ticket')->references('id')->on('tickets')->cascadeOnDelete();
            $t->foreign('employee_id', 'fk_tasg_employee')->references('id')->on('users');
            $t->foreign('assigned_by', 'fk_tasg_by')->references('id')->on('users');
            $t->unique(['ticket_id', 'employee_id'], 'uq_tasg_ticket_employee');
            $t->unique(['ticket_id', 'primary_marker'], 'uq_tasg_one_primary');
            $t->index('employee_id', 'ix_tasg_employee');
        });

        Schema::create('ticket_work_updates', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('ticket_id');
            $t->unsignedBigInteger('user_id');
            $t->string('work_status', 15);
            $t->text('note')->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->foreign('ticket_id', 'fk_twu_ticket')->references('id')->on('tickets')->cascadeOnDelete();
            $t->foreign('user_id', 'fk_twu_user')->references('id')->on('users');
            $t->index(['ticket_id', 'created_at'], 'ix_twu_ticket_time');
        });

        // Existing requests: whoever was assigned becomes the PRIMARY employee
        $statusCodes = DB::table('ticket_statuses')->pluck('code', 'id');
        $work = [
            'IN_PROGRESS' => 'IN_PROGRESS', 'WAITING_USER' => 'WAITING', 'ON_HOLD' => 'WAITING',
            'RESOLVED' => 'DONE', 'USER_CONFIRMATION' => 'DONE', 'CLOSED' => 'DONE',
        ];
        foreach (DB::table('tickets')->whereNotNull('assigned_to')->get(['id', 'assigned_to', 'assigned_at', 'created_by', 'status_id']) as $tk) {
            $by = DB::table('ticket_assignment_log')->where('ticket_id', $tk->id)->orderByDesc('id')->value('assigned_by') ?? $tk->created_by;
            DB::table('ticket_assignments')->insert([
                'ticket_id' => $tk->id,
                'employee_id' => $tk->assigned_to,
                'assigned_by' => $by,
                'role' => 'PRIMARY',
                'primary_marker' => 1,
                'assigned_at' => $tk->assigned_at ?? now(),
                'work_status' => $work[$statusCodes[$tk->status_id] ?? ''] ?? 'ASSIGNED',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_work_updates');
        Schema::dropIfExists('ticket_assignments');
        Schema::rename('ticket_assignment_log', 'ticket_assignments');
    }
};
