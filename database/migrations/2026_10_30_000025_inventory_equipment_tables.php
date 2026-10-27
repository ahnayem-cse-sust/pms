<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * IT Inventory (simple): equipment, asset types / sub-categories, stock quantity and one movement record.
 * Own tables only (prefix inv_); nothing in the ticket tables is touched.
 * Tables from earlier inventory drafts are dropped first (those drafts were never in use).
 */
return new class extends Migration
{
    protected array $old = ['inv_asset_ticket_links', 'inv_import_batches', 'inv_disposals', 'inv_stocktake_lines', 'inv_stocktakes', 'inv_maintenance', 'inv_adjustments',
        'inv_transfers', 'inv_issue_lines', 'inv_issues', 'inv_receipt_lines', 'inv_receipts', 'inv_documents', 'inv_stock_transactions', 'inv_stock_balances',
        'inv_assignments', 'inv_asset_events', 'inv_movements', 'inv_stock', 'inv_assets', 'inv_products', 'inv_items', 'inv_lookups', 'inv_locations', 'inv_categories', 'inv_counters', 'inv_equipment'];

    public function up(): void
    {
        foreach ($this->old as $t) Schema::dropIfExists($t);

        Schema::create('inv_counters', function (Blueprint $t) { $t->string('name', 20)->primary(); $t->unsignedBigInteger('value')->default(0); });
        // parent_id null = Asset Type; parent_id set = Sub-category of that type
        Schema::create('inv_categories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->foreignId('parent_id')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('inv_equipment', function (Blueprint $t) {
            $t->id(); $t->string('code', 40)->unique(); $t->string('name'); $t->foreignId('category_id')->nullable(); $t->foreignId('subcategory_id')->nullable();
            $t->string('brand')->nullable(); $t->string('model')->nullable(); $t->string('unit', 30)->nullable();
            $t->decimal('stock_qty', 14, 2)->default(0); $t->decimal('min_stock', 12, 2)->default(0);
            $t->text('notes')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        // The single record of everything that happens: stock in, allocation, return, correction.
        Schema::create('inv_movements', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->date('moved_on'); $t->string('type', 10); $t->foreignId('equipment_id')->index();
            $t->decimal('qty', 14, 2); $t->decimal('balance_after', 14, 2)->nullable();
            $t->string('holder_type', 12)->nullable(); $t->foreignId('holder_user_id')->nullable(); $t->foreignId('holder_department_id')->nullable();
            $t->string('reference_no')->nullable(); $t->string('party')->nullable(); $t->text('remarks')->nullable();
            $t->foreignId('created_by')->nullable(); $t->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        foreach (['inv_movements', 'inv_equipment', 'inv_categories', 'inv_counters'] as $t) Schema::dropIfExists($t);
    }
};
