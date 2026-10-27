<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * IT Inventory (simple): products, serialized assets, stock balances and one movement record.
 * Own tables only (prefix inv_); nothing in the ticket tables is touched.
 * Any tables from the earlier, larger inventory draft are dropped first (that draft was never in use).
 */
return new class extends Migration
{
    protected array $old = ['inv_asset_ticket_links', 'inv_import_batches', 'inv_disposals', 'inv_stocktake_lines', 'inv_stocktakes', 'inv_maintenance', 'inv_adjustments',
        'inv_transfers', 'inv_issue_lines', 'inv_issues', 'inv_receipt_lines', 'inv_receipts', 'inv_documents', 'inv_stock_transactions', 'inv_stock_balances',
        'inv_assignments', 'inv_asset_events', 'inv_assets', 'inv_items', 'inv_lookups', 'inv_categories', 'inv_locations', 'inv_counters'];

    public function up(): void
    {
        foreach ($this->old as $t) Schema::dropIfExists($t);
        Schema::dropIfExists('inv_movements');
        Schema::dropIfExists('inv_stock');
        Schema::dropIfExists('inv_products');

        Schema::create('inv_counters', function (Blueprint $t) { $t->string('name', 20)->primary(); $t->unsignedBigInteger('value')->default(0); });
        Schema::create('inv_categories', function (Blueprint $t) { $t->id(); $t->string('name')->unique(); $t->boolean('is_active')->default(true); $t->timestamps(); });
        Schema::create('inv_locations', function (Blueprint $t) { $t->id(); $t->string('name')->unique(); $t->boolean('is_active')->default(true); $t->timestamps(); });
        Schema::create('inv_products', function (Blueprint $t) {
            $t->id(); $t->string('code', 40)->unique(); $t->string('name'); $t->foreignId('category_id')->nullable(); $t->string('type', 12);
            $t->string('brand')->nullable(); $t->string('model')->nullable(); $t->string('unit', 30)->nullable(); $t->decimal('min_stock', 12, 2)->default(0);
            $t->text('notes')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('inv_assets', function (Blueprint $t) {
            $t->id(); $t->string('asset_code', 40)->unique(); $t->foreignId('product_id'); $t->string('serial_no', 100)->nullable()->index();
            $t->date('purchase_date')->nullable(); $t->decimal('cost', 14, 2)->nullable(); $t->string('supplier')->nullable(); $t->date('warranty_end')->nullable();
            $t->string('status', 12)->default('AVAILABLE')->index(); $t->foreignId('location_id')->nullable();
            $t->string('holder_type', 12)->nullable(); $t->foreignId('holder_user_id')->nullable(); $t->foreignId('holder_department_id')->nullable();
            $t->dateTime('allocated_at')->nullable(); $t->text('notes')->nullable(); $t->timestamps();
        });
        Schema::create('inv_stock', function (Blueprint $t) {
            $t->id(); $t->foreignId('product_id'); $t->foreignId('location_id'); $t->decimal('qty', 14, 2)->default(0); $t->timestamps();
            $t->unique(['product_id', 'location_id']);
        });
        // The single record of everything that happens: stock in, allocation, return, adjustment, status change.
        Schema::create('inv_movements', function (Blueprint $t) {
            $t->id(); $t->string('ref', 30)->unique(); $t->date('moved_on'); $t->string('type', 10); $t->foreignId('product_id')->index(); $t->foreignId('asset_id')->nullable()->index();
            $t->foreignId('location_id')->nullable(); $t->decimal('qty', 14, 2)->default(0); $t->decimal('balance_after', 14, 2)->nullable();
            $t->string('holder_type', 12)->nullable(); $t->foreignId('holder_user_id')->nullable(); $t->foreignId('holder_department_id')->nullable();
            $t->string('reference_no')->nullable(); $t->string('party')->nullable(); $t->text('remarks')->nullable();
            $t->foreignId('created_by')->nullable(); $t->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        foreach (['inv_movements', 'inv_stock', 'inv_assets', 'inv_products', 'inv_locations', 'inv_categories', 'inv_counters'] as $t) Schema::dropIfExists($t);
    }
};
