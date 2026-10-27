<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** IT Inventory module: own tables only (prefix inv_). Nothing in the ticket tables is touched. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inv_counters', function (Blueprint $t) { $t->string('name', 20)->primary(); $t->unsignedBigInteger('value')->default(0); });

        Schema::create('inv_locations', function (Blueprint $t) {
            $t->id(); $t->string('code', 30)->unique(); $t->string('name'); $t->foreignId('parent_id')->nullable();
            $t->boolean('is_store')->default(false); $t->string('description')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('inv_categories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->foreignId('parent_id')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
            $t->unique(['name', 'parent_id']);
        });
        Schema::create('inv_lookups', function (Blueprint $t) {
            $t->id(); $t->string('type', 20); $t->string('name'); $t->boolean('is_active')->default(true); $t->timestamps();
            $t->unique(['type', 'name']);
        });
        Schema::create('inv_items', function (Blueprint $t) {
            $t->id(); $t->string('code', 40)->unique(); $t->string('name'); $t->text('description')->nullable();
            $t->string('type', 12); $t->foreignId('category_id'); $t->foreignId('subcategory_id')->nullable();
            $t->foreignId('unit_id')->nullable(); $t->foreignId('brand_id')->nullable(); $t->string('model')->nullable(); $t->text('specs')->nullable();
            $t->decimal('min_stock', 12, 2)->default(0); $t->decimal('reorder_level', 12, 2)->default(0);
            $t->boolean('is_active')->default(true); $t->foreignId('created_by')->nullable(); $t->timestamps();
        });
        Schema::create('inv_assets', function (Blueprint $t) {
            $t->id(); $t->string('asset_code', 40)->unique(); $t->foreignId('item_id'); $t->string('serial_no', 100)->nullable()->index(); $t->text('specs')->nullable();
            $t->date('acquisition_date')->nullable(); $t->decimal('cost', 14, 2)->nullable(); $t->foreignId('supplier_id')->nullable();
            $t->date('warranty_start')->nullable(); $t->date('warranty_end')->nullable(); $t->foreignId('condition_id')->nullable();
            $t->string('status', 20)->default('AVAILABLE')->index(); $t->foreignId('location_id')->nullable();
            $t->string('custodian_type', 12)->nullable(); $t->foreignId('custodian_user_id')->nullable(); $t->foreignId('custodian_department_id')->nullable();
            $t->boolean('is_shared')->default(false); $t->foreignId('receipt_id')->nullable(); $t->foreignId('import_batch_id')->nullable();
            $t->text('remarks')->nullable(); $t->foreignId('created_by')->nullable(); $t->timestamps();
        });
        Schema::create('inv_asset_events', function (Blueprint $t) {
            $t->id(); $t->foreignId('asset_id')->index(); $t->string('event', 30); $t->string('from_status', 20)->nullable(); $t->string('to_status', 20)->nullable();
            $t->string('ref', 30)->nullable(); $t->text('details')->nullable(); $t->foreignId('user_id')->nullable(); $t->timestamp('created_at')->useCurrent();
        });
        Schema::create('inv_assignments', function (Blueprint $t) {
            $t->id(); $t->foreignId('asset_id')->index(); $t->string('custodian_type', 12); $t->foreignId('custodian_user_id')->nullable(); $t->foreignId('custodian_department_id')->nullable();
            $t->foreignId('location_id')->nullable(); $t->dateTime('assigned_at'); $t->dateTime('returned_at')->nullable();
            $t->foreignId('condition_id')->nullable(); $t->text('accessories')->nullable(); $t->text('remarks')->nullable();
            $t->foreignId('released_by')->nullable(); $t->boolean('ack_required')->default(false); $t->dateTime('acknowledged_at')->nullable(); $t->foreignId('acknowledged_by')->nullable();
            $t->foreignId('return_condition_id')->nullable(); $t->text('return_remarks')->nullable(); $t->foreignId('received_by')->nullable();
            $t->string('source', 12)->nullable(); $t->string('source_ref', 30)->nullable(); $t->timestamps();
        });
        Schema::create('inv_stock_balances', function (Blueprint $t) {
            $t->id(); $t->foreignId('item_id'); $t->foreignId('location_id'); $t->decimal('qty', 14, 2)->default(0); $t->timestamps();
            $t->unique(['item_id', 'location_id']);
        });
        Schema::create('inv_stock_transactions', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->string('type', 16); $t->foreignId('item_id')->index(); $t->foreignId('location_id')->index();
            $t->decimal('qty_in', 14, 2)->default(0); $t->decimal('qty_out', 14, 2)->default(0); $t->decimal('balance_after', 14, 2)->default(0);
            $t->date('posting_date'); $t->text('reason')->nullable(); $t->string('source_ref', 30)->nullable(); $t->foreignId('reverses_id')->nullable();
            $t->foreignId('created_by')->nullable(); $t->foreignId('approved_by')->nullable(); $t->timestamp('created_at')->useCurrent();
        });
        Schema::create('inv_documents', function (Blueprint $t) {
            $t->id(); $t->string('owner_type', 20); $t->unsignedBigInteger('owner_id'); $t->string('original_name'); $t->string('stored_path');
            $t->string('mime_type', 100)->nullable(); $t->unsignedBigInteger('size_bytes')->default(0); $t->string('doc_type', 30)->nullable();
            $t->foreignId('uploaded_by')->nullable(); $t->timestamp('created_at')->useCurrent(); $t->index(['owner_type', 'owner_id']);
        });
        Schema::create('inv_receipts', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->date('receipt_date'); $t->foreignId('supplier_id')->nullable(); $t->string('procurement_ref')->nullable();
            $t->string('invoice_no')->nullable(); $t->foreignId('location_id'); $t->foreignId('received_by')->nullable(); $t->text('remarks')->nullable();
            $t->string('status', 12)->default('DRAFT'); $t->foreignId('prepared_by'); $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable();
            $t->foreignId('posted_by')->nullable(); $t->dateTime('posted_at')->nullable(); $t->text('reason')->nullable(); $t->timestamps();
        });
        Schema::create('inv_receipt_lines', function (Blueprint $t) {
            $t->id(); $t->foreignId('receipt_id')->index(); $t->foreignId('item_id'); $t->decimal('qty_received', 12, 2); $t->decimal('qty_rejected', 12, 2)->default(0);
            $t->decimal('unit_cost', 14, 2)->nullable(); $t->text('serials')->nullable();
        });
        Schema::create('inv_issues', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->foreignId('requested_by'); $t->foreignId('recipient_user_id')->nullable(); $t->foreignId('department_id')->nullable();
            $t->foreignId('location_id')->nullable(); $t->text('purpose'); $t->date('required_date')->nullable(); $t->string('ticket_no', 30)->nullable();
            $t->string('status', 12)->default('SUBMITTED'); $t->foreignId('created_by'); $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable();
            $t->foreignId('issued_by')->nullable(); $t->text('reason')->nullable(); $t->timestamps();
        });
        Schema::create('inv_issue_lines', function (Blueprint $t) {
            $t->id(); $t->foreignId('issue_id')->index(); $t->foreignId('item_id'); $t->foreignId('asset_id')->nullable();
            $t->decimal('qty_requested', 12, 2)->default(1); $t->decimal('qty_issued', 12, 2)->default(0); $t->string('remarks')->nullable();
        });
        Schema::create('inv_transfers', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->string('kind', 10); $t->foreignId('asset_id')->nullable(); $t->foreignId('item_id')->nullable(); $t->decimal('qty', 12, 2)->nullable();
            $t->string('from_type', 12)->nullable(); $t->foreignId('from_user_id')->nullable(); $t->foreignId('from_department_id')->nullable(); $t->foreignId('from_location_id')->nullable();
            $t->string('to_type', 12)->nullable(); $t->foreignId('to_user_id')->nullable(); $t->foreignId('to_department_id')->nullable(); $t->foreignId('to_location_id')->nullable();
            $t->foreignId('condition_id')->nullable(); $t->text('accessories')->nullable(); $t->text('remarks')->nullable(); $t->date('effective_date')->nullable();
            $t->string('status', 12)->default('REQUESTED'); $t->foreignId('requested_by'); $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable();
            $t->foreignId('posted_by')->nullable(); $t->dateTime('posted_at')->nullable(); $t->string('prev_status', 20)->nullable(); $t->text('reason')->nullable();
            $t->dateTime('acknowledged_at')->nullable(); $t->timestamps();
        });
        Schema::create('inv_adjustments', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->foreignId('item_id'); $t->foreignId('location_id'); $t->decimal('qty_delta', 12, 2);
            $t->string('reason_code', 12); $t->text('notes')->nullable(); $t->string('status', 12)->default('PENDING'); $t->foreignId('prepared_by');
            $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable(); $t->date('posting_date')->nullable(); $t->foreignId('stocktake_id')->nullable(); $t->timestamps();
        });
        Schema::create('inv_maintenance', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->foreignId('asset_id')->index(); $t->string('ticket_no', 30)->nullable(); $t->text('fault'); $t->date('reported_date');
            $t->string('status', 20)->default('REPORTED'); $t->string('vendor')->nullable(); $t->boolean('warranty_claim')->default(false); $t->decimal('cost', 14, 2)->nullable();
            $t->text('action_taken')->nullable(); $t->text('parts_replaced')->nullable(); $t->text('outcome')->nullable(); $t->date('completed_date')->nullable();
            $t->string('status_before', 20)->nullable(); $t->foreignId('created_by'); $t->timestamps();
        });
        Schema::create('inv_stocktakes', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->string('title'); $t->date('count_date'); $t->foreignId('location_id')->nullable(); $t->foreignId('category_id')->nullable();
            $t->string('status', 12)->default('OPEN'); $t->foreignId('created_by'); $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable(); $t->text('notes')->nullable(); $t->timestamps();
        });
        Schema::create('inv_stocktake_lines', function (Blueprint $t) {
            $t->id(); $t->foreignId('stocktake_id')->index(); $t->foreignId('item_id')->nullable(); $t->foreignId('asset_id')->nullable(); $t->foreignId('location_id')->nullable();
            $t->decimal('system_qty', 14, 2)->default(0); $t->decimal('physical_qty', 14, 2)->nullable(); $t->string('system_status', 20)->nullable(); $t->string('physical_status', 12)->nullable();
            $t->foreignId('condition_id')->nullable(); $t->string('remarks')->nullable(); $t->string('unrecorded_desc')->nullable();
            $t->foreignId('verified_by')->nullable(); $t->dateTime('verified_at')->nullable(); $t->foreignId('adjustment_id')->nullable();
        });
        Schema::create('inv_disposals', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->foreignId('asset_id')->index(); $t->string('reason', 12); $t->foreignId('condition_id')->nullable(); $t->string('proposed_action')->nullable();
            $t->date('proposed_date')->nullable(); $t->string('status', 12)->default('PROPOSED'); $t->foreignId('proposed_by'); $t->foreignId('approved_by')->nullable(); $t->dateTime('approved_at')->nullable();
            $t->string('method')->nullable(); $t->date('disposal_date')->nullable(); $t->string('recipient')->nullable(); $t->decimal('proceeds', 14, 2)->nullable(); $t->text('remarks')->nullable();
            $t->text('reject_reason')->nullable(); $t->timestamps();
        });
        Schema::create('inv_import_batches', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->string('kind', 14); $t->string('file_name'); $t->string('stored_path'); $t->string('source_ref')->nullable();
            $t->unsignedInteger('total_rows')->default(0); $t->unsignedInteger('error_rows')->default(0); $t->string('status', 12)->default('PREVIEW');
            $t->foreignId('uploaded_by'); $t->foreignId('posted_by')->nullable(); $t->dateTime('posted_at')->nullable(); $t->text('notes')->nullable(); $t->timestamps();
        });
        // Links an inventory asset to a ticket. Owned by the inventory module; the ticket tables are only read.
        Schema::create('inv_asset_ticket_links', function (Blueprint $t) {
            $t->id(); $t->foreignId('asset_id'); $t->foreignId('ticket_id'); $t->foreignId('linked_by')->nullable(); $t->string('note')->nullable();
            $t->timestamp('created_at')->useCurrent(); $t->unique(['asset_id', 'ticket_id']);
        });
    }

    public function down(): void
    {
        foreach (['inv_asset_ticket_links', 'inv_import_batches', 'inv_disposals', 'inv_stocktake_lines', 'inv_stocktakes', 'inv_maintenance', 'inv_adjustments', 'inv_transfers',
                  'inv_issue_lines', 'inv_issues', 'inv_receipt_lines', 'inv_receipts', 'inv_documents', 'inv_stock_transactions', 'inv_stock_balances', 'inv_assignments',
                  'inv_asset_events', 'inv_assets', 'inv_items', 'inv_lookups', 'inv_categories', 'inv_locations', 'inv_counters'] as $tbl) {
            Schema::dropIfExists($tbl);
        }
    }
};
