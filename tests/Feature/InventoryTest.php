<?php

namespace Tests\Feature;

use App\Models\Inventory\{Category, Equipment, Movement};
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Simple inventory: equipment stock, allocation, records. Needs the same MySQL test database as the other tests. */
class InventoryTest extends TestCase
{
    use RefreshDatabase;

    protected $type; protected $cat; protected $sub; protected $toner;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->type = Category::create(['name' => 'Consumables', 'level' => 1]);
        $this->cat = Category::create(['name' => 'Printing', 'parent_id' => $this->type->id, 'level' => 2]);
        $this->sub = Category::create(['name' => 'Toner', 'parent_id' => $this->cat->id, 'level' => 3]);
        $this->toner = Equipment::create(['code' => 'TONER', 'name' => 'HP Toner', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id, 'subcategory_id' => $this->sub->id, 'min_stock' => 3]);
    }

    protected function officer(): User { return User::where('email', 'it_admin@joplc.com')->firstOrFail(); }
    protected function person(): User { return User::where('email', 'acct_user@joplc.com')->firstOrFail(); }
    protected function stock(): float { return (float) $this->toner->fresh()->stock_qty; }

    protected function receive(int $qty)
    {
        return $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'supplier' => 'ACME', 'reference_no' => 'INV-1',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => $qty]]]);
    }

    protected function allocate(int $qty, ?User $to = null)
    {
        return $this->actingAs($this->officer())->post(route('inv.allocations.store'), ['to_type' => 'EMPLOYEE', 'user_id' => ($to ?? $this->person())->id, 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => $qty]]]);
    }

    public function test_department_users_cannot_open_stock_screens(): void
    {
        $this->actingAs($this->person());
        $this->get(route('inv.dashboard'))->assertForbidden();
        $this->get(route('inv.equipment.index'))->assertForbidden();
        $this->get(route('inv.records'))->assertForbidden();
        $this->get(route('inv.receive'))->assertForbidden();
        $this->get(route('inv.mine'))->assertOk();
    }

    public function test_receiving_adds_stock_and_writes_a_record(): void
    {
        $this->receive(10)->assertSessionHasNoErrors();
        $this->assertSame(10.0, $this->stock());
        $m = Movement::firstOrFail();
        $this->assertSame('RECEIVE', $m->type);
        $this->assertSame(10.0, (float) $m->balance_after);
        $this->assertSame('ACME', $m->party);
    }

    public function test_cannot_allocate_more_than_in_stock(): void
    {
        $this->receive(5);
        $this->allocate(8)->assertSessionHasErrors('qty');
        $this->assertSame(5.0, $this->stock());
        $this->allocate(2)->assertSessionHasNoErrors();
        $this->assertSame(3.0, $this->stock());
        $this->assertSame(-2.0, (float) Movement::where('type', 'ALLOCATE')->value('qty'));
    }

    public function test_return_cannot_exceed_what_the_person_holds(): void
    {
        $this->receive(10);
        $this->allocate(4);
        $ret = fn ($q) => $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'reference_no' => 'RET-1', 'lines' => [['equipment_id' => $this->toner->id, 'qty' => $q]]]);
        $ret(5)->assertSessionHasErrors('qty');
        $ret(3)->assertSessionHasNoErrors();
        $this->assertSame(9.0, $this->stock());
        $this->assertSame(1.0, $this->svcHeld());
        $m = Movement::where('type', 'RETURN')->firstOrFail();
        $this->assertSame('RET-1', $m->reference_no);
        $this->assertSame($this->person()->id, (int) $m->holder_user_id);
    }

    public function test_same_item_twice_in_one_return_cannot_exceed_what_is_held(): void
    {
        $this->receive(10);
        $this->allocate(4);
        $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 3], ['equipment_id' => $this->toner->id, 'qty' => 3]]])->assertSessionHasErrors('qty');
        $this->assertSame(6.0, $this->stock());   // whole return rolled back
        $this->assertSame(4.0, $this->svcHeld());
    }

    public function test_return_needs_the_person_and_receive_screen_lists_what_they_hold(): void
    {
        $this->receive(10);
        $this->allocate(4);
        $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'EMPLOYEE', 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 1]]])->assertSessionHasErrors('user_id');
        $this->actingAs($this->officer())->get(route('inv.receive'))->assertOk()->assertSee('Receive Item')->assertSee('HP Toner');
    }

    protected function svcHeld(): float
    {
        return app(\App\Services\Inventory\InventoryService::class)->heldQty($this->toner->id, ['type' => 'EMPLOYEE', 'user_id' => $this->person()->id]);
    }

    public function test_people_see_only_their_own_equipment(): void
    {
        $this->receive(10);
        $this->allocate(2, $this->person());
        $this->allocate(3, User::where('email', 'sales_user@joplc.com')->firstOrFail());
        $this->actingAs($this->person())->get(route('inv.mine'))->assertOk()->assertSee('HP Toner')->assertDontSee('Sales');
    }

    public function test_stock_changes_only_through_receives_and_allocations(): void
    {
        $this->assertFalse(\Illuminate\Support\Facades\Route::has('inv.equipment.adjust'));      // no manual correction any more

        $this->receive(10);
        $this->actingAs($this->officer())->put(route('inv.equipment.update', $this->toner), ['name' => 'HP Toner', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id,
            'stock_qty' => 999, 'is_active' => 1])->assertSessionHasNoErrors();
        $this->assertSame(10.0, $this->stock());                                                    // a posted quantity is ignored

        $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['name' => 'Keyboard', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id, 'stock_qty' => 50]);
        $this->assertSame(0.0, (float) Equipment::where('name', 'Keyboard')->value('stock_qty'));   // new equipment starts at zero

        $this->allocate(3);
        $this->assertSame(7.0, $this->stock());
        $this->assertSame(0, Movement::where('type', 'ADJUST')->count());
    }

    public function test_classification_is_asset_type_then_category_then_sub_category(): void
    {
        $this->assertSame('Consumables › Printing › Toner', $this->toner->fresh()->load(['assetType', 'category', 'subcategory'])->classification);

        $otherType = Category::create(['name' => 'Networking', 'level' => 1]);
        $post = fn ($extra) => $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['name' => 'Switch'] + $extra);

        $post(['asset_type_id' => $otherType->id, 'category_id' => $this->cat->id])->assertSessionHasErrors('category_id');                 // category of another type
        $post(['asset_type_id' => $this->type->id, 'subcategory_id' => $this->sub->id])->assertSessionHasErrors('category_id');             // category is required
        $post(['asset_type_id' => $this->type->id, 'category_id' => $this->cat->id, 'subcategory_id' => $this->sub->id])->assertSessionHasNoErrors();
        $this->assertSame(2, Equipment::count());
    }

    public function test_setup_enforces_the_three_levels(): void
    {
        $this->actingAs($this->officer());
        $this->post(route('inv.setup.store', 'categories'), ['name' => 'Laptops', 'parent_id' => $this->sub->id])->assertSessionHasErrors('parent_id');   // a sub category is not an asset type
        $this->post(route('inv.setup.store', 'categories'), ['name' => 'Laptops', 'parent_id' => $this->type->id])->assertSessionHasNoErrors();
        $this->assertSame(2, Category::where('level', 2)->count());
    }

    public function test_equipment_code_is_generated_from_two_letters_of_type_and_category(): void
    {
        $post = fn ($name, $type, $cat) => $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['code' => 'HAND-TYPED', 'name' => $name, 'asset_type_id' => $type->id, 'category_id' => $cat->id]);

        $post('Laser printer', $this->type, $this->cat)->assertSessionHasNoErrors();      // Consumables + Printing → COPR
        $post('Inkjet printer', $this->type, $this->cat);
        $this->assertSame(['COPR0001', 'COPR0002'], Equipment::whereIn('name', ['Laser printer', 'Inkjet printer'])->orderBy('id')->pluck('code')->all());

        $net = Category::create(['name' => 'Networking', 'level' => 1]);
        $sw = Category::create(['name' => 'Switches', 'parent_id' => $net->id, 'level' => 2]);
        $post('Core switch', $net, $sw);
        $this->assertSame('NESW0001', Equipment::where('name', 'Core switch')->value('code'));   // each prefix has its own running number
        $this->assertNull(Equipment::where('code', 'HAND-TYPED')->first());                    // a typed code is ignored
    }

    public function test_code_skips_numbers_already_in_use_and_does_not_change_on_edit(): void
    {
        Equipment::create(['code' => 'COPR0007', 'name' => 'Old', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id]);
        $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['name' => 'New', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id]);
        $e = Equipment::where('name', 'New')->firstOrFail();
        $this->assertSame('COPR0008', $e->code);

        $other = Category::create(['name' => 'Accessories', 'parent_id' => $this->type->id, 'level' => 2]);
        $this->actingAs($this->officer())->put(route('inv.equipment.update', $e), ['code' => 'ZZ9999', 'name' => 'New', 'asset_type_id' => $this->type->id, 'category_id' => $other->id])->assertSessionHasNoErrors();
        $this->assertSame('COPR0008', $e->fresh()->code);
        $this->assertSame($other->id, $e->fresh()->category_id);
    }

    public function test_code_grows_past_four_digits_and_short_names_use_what_they_have(): void
    {
        $x = Category::create(['name' => 'X', 'level' => 1]);
        $y = Category::create(['name' => '99 Kits', 'parent_id' => $x->id, 'level' => 2]);      // digits are skipped → "KI"
        Equipment::create(['code' => 'XKI9999', 'name' => 'Old', 'asset_type_id' => $x->id, 'category_id' => $y->id]);
        $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['name' => 'New', 'asset_type_id' => $x->id, 'category_id' => $y->id])->assertSessionHasNoErrors();
        $this->assertSame('XKI10000', Equipment::where('name', 'New')->value('code'));
    }

    public function test_only_categories_carry_the_serial_mark(): void
    {
        $this->actingAs($this->officer());
        $this->post(route('inv.setup.store', 'categories'), ['name' => 'Laptops', 'parent_id' => $this->type->id, 'is_serialized' => 1])->assertSessionHasNoErrors();
        $this->post(route('inv.setup.store', 'categories'), ['name' => 'Cables', 'parent_id' => $this->type->id])->assertSessionHasNoErrors();
        $this->assertTrue(Category::where('name', 'Laptops')->firstOrFail()->is_serialized);
        $this->assertFalse(Category::where('name', 'Cables')->firstOrFail()->is_serialized);
        $this->post(route('inv.setup.store', 'types'), ['name' => 'Furniture', 'is_serialized' => 1]);
        $this->assertFalse(Category::where('name', 'Furniture')->firstOrFail()->is_serialized);

        $laptops = Category::where('name', 'Laptops')->firstOrFail();
        $this->put(route('inv.setup.update', ['categories', $laptops->id]), ['name' => 'Laptops', 'parent_id' => $this->type->id, 'is_active' => 1])->assertSessionHasNoErrors();
        $this->assertFalse($laptops->fresh()->is_serialized);                                   // unticked on edit = not serialisable
    }

    public function test_equipment_can_be_saved_with_optional_fields_left_empty(): void
    {
        $this->actingAs($this->officer())->post(route('inv.equipment.store'), ['name' => 'Bare item', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id,
            'subcategory_id' => '', 'brand' => '', 'model' => '', 'unit' => '', 'min_stock' => '', 'notes' => ''])->assertSessionHasNoErrors();
        $e = Equipment::where('name', 'Bare item')->firstOrFail();
        $this->assertSame(0.0, (float) $e->min_stock);

        $this->actingAs($this->officer())->put(route('inv.equipment.update', $e), ['name' => 'Bare item', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id, 'min_stock' => '', 'is_active' => 1])->assertSessionHasNoErrors();
        $this->assertSame(0.0, (float) $e->fresh()->min_stock);
    }

    public function test_receives_lists_supplier_receipts_and_returns(): void
    {
        $this->receive(10);
        $this->allocate(4);
        $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'reference_no' => 'RET-9', 'lines' => [['equipment_id' => $this->toner->id, 'qty' => 2]]])->assertRedirect(route('inv.receives'));

        $this->actingAs($this->officer())->get(route('inv.receives'))->assertOk()->assertSee('INV-1')->assertSee('ACME')->assertSee('RET-9')->assertSee('HP Toner');
        $this->actingAs($this->officer())->get(route('inv.receives', ['source' => 'EMPLOYEE']))->assertOk()->assertSee('RET-9')->assertDontSee('ACME');
        $this->actingAs($this->officer())->get(route('inv.receives', ['source' => 'SUPPLIER']))->assertOk()->assertSee('ACME')->assertDontSee('RET-9');
        $this->actingAs($this->person())->get(route('inv.receives'))->assertForbidden();
    }

    public function test_previous_items_can_be_added_with_a_past_date_in_store_or_with_a_holder(): void
    {
        $past = today()->subYear()->toDateString();
        $post = fn ($extra) => $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'PREVIOUS', 'date' => $past, 'reference_no' => 'OLD-7',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 5]]] + $extra);

        $post(['held_type' => 'NONE'])->assertSessionHasNoErrors();                          // already in the store
        $this->assertSame(5.0, $this->stock());
        $m = Movement::where('type', 'OPENING')->firstOrFail();
        $this->assertSame($past, $m->moved_on->toDateString());

        $post(['held_type' => 'EMPLOYEE'])->assertSessionHasErrors('held_user_id');          // holder is required when chosen
        $this->assertSame(5.0, $this->stock());

        $post(['held_type' => 'EMPLOYEE', 'held_user_id' => $this->person()->id])->assertSessionHasNoErrors();   // 5 more, already with the employee
        $this->assertSame(5.0, $this->stock());                                                // stock unchanged: added and handed out
        $this->assertSame(5.0, $this->svcHeld());

        $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 2]]])->assertSessionHasNoErrors();   // …and can be returned later
        $this->assertSame(7.0, $this->stock());

        $this->actingAs($this->officer())->post(route('inv.receive.store'), ['source' => 'PREVIOUS', 'date' => today()->addDay()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 1]]])->assertSessionHasErrors('date');   // not in the future
        $this->actingAs($this->officer())->get(route('inv.receives', ['source' => 'PREVIOUS']))->assertOk()->assertSee('OLD-7')->assertSee('Previous item');
    }

    protected function serialEquipment(): Equipment
    {
        $cat = Category::create(['name' => 'Laptops', 'parent_id' => $this->type->id, 'level' => 2, 'is_serialized' => true]);

        return Equipment::create(['code' => 'LAPT0001', 'name' => 'Dell Latitude', 'asset_type_id' => $this->type->id, 'category_id' => $cat->id]);
    }

    protected function postAs(string $route, array $data)
    {
        return $this->actingAs($this->officer())->post(route($route), $data);
    }

    public function test_serialisable_equipment_is_one_unit_per_line_with_an_automatic_serial(): void
    {
        $lap = $this->serialEquipment();
        $day = today()->toDateString();
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => $day, 'lines' => [['equipment_id' => $lap->id, 'qty' => 3]]]);
        $this->assertSame(3.0, (float) $lap->fresh()->stock_qty);

        // a posted quantity is ignored: one unit per line, serial generated, purpose kept per line
        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => $day,
            'lines' => [['equipment_id' => $lap->id, 'qty' => 9, 'purpose' => 'Field work'], ['equipment_id' => $lap->id, 'purpose' => 'Backup']]])->assertSessionHasNoErrors();
        $rows = Movement::where('type', 'ALLOCATE')->where('equipment_id', $lap->id)->orderBy('id')->get();
        $this->assertSame(['LAPT00010001', 'LAPT00010002'], $rows->pluck('serial_no')->all());
        $this->assertSame([-1.0, -1.0], $rows->map(fn ($m) => (float) $m->qty)->all());
        $this->assertSame(['Field work', 'Backup'], $rows->pluck('remarks')->all());
        $this->assertSame(1.0, (float) $lap->fresh()->stock_qty);

        // return one unit by its serial (no quantity needed); the same unit cannot be returned twice, nor one that is not held
        $ret = fn ($serial) => $this->postAs('inv.receive.store', ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => $day, 'lines' => [['equipment_id' => $lap->id, 'serial_no' => $serial]]]);
        $ret('LAPT00010001')->assertSessionHasNoErrors();
        $this->assertSame(2.0, (float) $lap->fresh()->stock_qty);
        $ret('LAPT00010001')->assertSessionHasErrors('qty');
        $ret('LAPT00010099')->assertSessionHasErrors('qty');
        $this->assertSame(2.0, (float) $lap->fresh()->stock_qty);

        // the returned unit goes out again under its own serial; only then is a new serial generated
        $alloc = fn () => $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => $day, 'lines' => [['equipment_id' => $lap->id]]])->assertSessionHasNoErrors();
        $alloc();
        $alloc();
        $this->assertSame(['LAPT00010001', 'LAPT00010002', 'LAPT00010001', 'LAPT00010003'], Movement::where('type', 'ALLOCATE')->orderBy('id')->pluck('serial_no')->all());
        $this->assertSame(0.0, (float) $lap->fresh()->stock_qty);
    }

    public function test_allocation_line_can_carry_an_optional_manufacturer_serial_number(): void
    {
        $lap = $this->serialEquipment();
        $day = today()->toDateString();
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => $day, 'lines' => [['equipment_id' => $lap->id, 'qty' => 2]]]);
        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => $day,
            'lines' => [['equipment_id' => $lap->id, 'device_serial_no' => 'SN-ABC-123'], ['equipment_id' => $lap->id]]])->assertSessionHasNoErrors();
        $rows = Movement::where('type', 'ALLOCATE')->where('equipment_id', $lap->id)->orderBy('id')->get();
        $this->assertSame(['SN-ABC-123', null], $rows->pluck('device_serial_no')->all());
    }

    public function test_other_equipment_needs_a_quantity_and_has_no_serial(): void
    {
        $this->receive(10);
        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'purpose' => 'Printer']]])->assertSessionHasErrors('lines.0.qty');
        $this->assertSame(10.0, $this->stock());

        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(),
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 4, 'purpose' => 'Printer']]])->assertSessionHasNoErrors();
        $m = Movement::where('type', 'ALLOCATE')->firstOrFail();
        $this->assertNull($m->serial_no);
        $this->assertSame(-4.0, (float) $m->qty);
        $this->assertSame('Printer', $m->remarks);
    }

    public function test_previous_serialisable_items_with_a_holder_get_one_serial_per_unit(): void
    {
        $lap = $this->serialEquipment();
        $post = fn ($qty) => $this->postAs('inv.receive.store', ['source' => 'PREVIOUS', 'date' => today()->subYear()->toDateString(), 'held_type' => 'EMPLOYEE', 'held_user_id' => $this->person()->id,
            'lines' => [['equipment_id' => $lap->id, 'qty' => $qty]]]);
        $post(1.5)->assertSessionHasErrors('qty');
        $post(2)->assertSessionHasNoErrors();
        $this->assertSame(0.0, (float) $lap->fresh()->stock_qty);
        $this->assertSame(['LAPT00010001', 'LAPT00010002'], Movement::where('type', 'ALLOCATE')->orderBy('id')->pluck('serial_no')->all());
    }

    public function test_allocation_form_knows_the_serials_it_will_show(): void
    {
        $lap = $this->serialEquipment();
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'lines' => [['equipment_id' => $lap->id, 'qty' => 2]]]);
        $this->assertSame(['code' => 'LAPT0001', 'pool' => [], 'next' => 1], app(\App\Services\Inventory\InventoryService::class)->serialInfo($lap));
        $this->actingAs($this->officer())->get(route('inv.allocations.create'))->assertOk()->assertSee('LAPT0001');

        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(), 'lines' => [['equipment_id' => $lap->id]]]);
        $this->postAs('inv.receive.store', ['source' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(), 'lines' => [['equipment_id' => $lap->id, 'serial_no' => 'LAPT00010001']]]);
        $this->assertSame(['code' => 'LAPT0001', 'pool' => ['LAPT00010001'], 'next' => 2], app(\App\Services\Inventory\InventoryService::class)->serialInfo($lap));
    }

    public function test_one_receive_is_one_entry_for_all_its_items_with_a_pdf(): void
    {
        $kb = Equipment::create(['code' => 'KEYB0001', 'name' => 'Keyboard', 'asset_type_id' => $this->type->id, 'category_id' => $this->cat->id]);
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'supplier' => 'ACME', 'reference_no' => 'INV-5',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 10], ['equipment_id' => $kb->id, 'qty' => 4]]])->assertSessionHasNoErrors();

        $this->assertSame(['RC-000001'], Movement::whereIn('type', ['RECEIVE'])->pluck('entry_no')->unique()->values()->all());   // one entry, two lines
        $this->assertSame(2, Movement::where('entry_no', 'RC-000001')->count());
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'lines' => [['equipment_id' => $kb->id, 'qty' => 1]]]);
        $this->assertSame('RC-000002', Movement::latest('id')->value('entry_no'));                                            // the next save is a new entry

        $this->actingAs($this->officer())->get(route('inv.receives'))->assertOk()->assertSee('RC-000001')->assertSee('2 lines')->assertSee('HP Toner')->assertSee('Keyboard');
        $pdf = $this->actingAs($this->officer())->get(route('inv.receives.pdf', 'RC-000001'));
        $pdf->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $pdf->getContent());
        $this->actingAs($this->officer())->get(route('inv.receives.pdf', 'RC-999999'))->assertNotFound();
        $this->actingAs($this->person())->get(route('inv.receives.pdf', 'RC-000001'))->assertForbidden();
    }

    public function test_one_allocation_is_one_entry_for_all_its_equipment_with_a_pdf(): void
    {
        $lap = $this->serialEquipment();
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'lines' => [['equipment_id' => $this->toner->id, 'qty' => 10], ['equipment_id' => $lap->id, 'qty' => 2]]]);
        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(), 'reference_no' => 'REQ-1',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 3, 'purpose' => 'Printer'], ['equipment_id' => $lap->id, 'purpose' => 'Field work']]])->assertRedirect(route('inv.allocations.entries'));

        $this->assertSame(2, Movement::where('entry_no', 'AL-000001')->where('type', 'ALLOCATE')->count());
        $this->actingAs($this->officer())->get(route('inv.allocations.entries'))->assertOk()->assertSee('AL-000001')->assertSee('2 lines')->assertSee('Field work')->assertSee('LAPT00010001');

        $pdf = $this->actingAs($this->officer())->get(route('inv.allocations.pdf', 'AL-000001'));
        $pdf->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $pdf->getContent());
        $this->actingAs($this->person())->get(route('inv.allocations.pdf', 'AL-000001'))->assertOk();    // the person it was handed to can download it
        $this->actingAs($this->officer())->get(route('inv.allocations.pdf', 'AL-999999'))->assertNotFound();
    }

    public function test_view_pages_for_receives_allocations_and_records(): void
    {
        $lap = $this->serialEquipment();
        $this->postAs('inv.receive.store', ['source' => 'SUPPLIER', 'date' => today()->toDateString(), 'supplier' => 'ACME', 'reference_no' => 'INV-8',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 10], ['equipment_id' => $lap->id, 'qty' => 2]]]);
        $this->postAs('inv.allocations.store', ['to_type' => 'EMPLOYEE', 'user_id' => $this->person()->id, 'date' => today()->toDateString(), 'reference_no' => 'REQ-2',
            'lines' => [['equipment_id' => $this->toner->id, 'qty' => 3, 'purpose' => 'Printer'], ['equipment_id' => $lap->id, 'purpose' => 'Field work']]]);

        // receive entry
        $this->actingAs($this->officer())->get(route('inv.receives.show', 'RC-000001'))->assertOk()->assertSee('ACME')->assertSee('INV-8')->assertSee('HP Toner')->assertSee('Dell Latitude')->assertSee('Download PDF');
        $this->actingAs($this->officer())->get(route('inv.receives.show', 'RC-999999'))->assertNotFound();
        $this->actingAs($this->person())->get(route('inv.receives.show', 'RC-000001'))->assertForbidden();

        // allocation entry: officers, and the person it was handed to
        $this->actingAs($this->officer())->get(route('inv.allocations.show', 'AL-000001'))->assertOk()->assertSee('REQ-2')->assertSee('Field work')->assertSee('LAPT00010001')->assertSee('Download PDF');
        $this->actingAs($this->person())->get(route('inv.allocations.show', 'AL-000001'))->assertOk()->assertSee('Printer');
        $this->actingAs($this->officer())->get(route('inv.allocations.show', 'AL-999999'))->assertNotFound();
    }

    public function test_record_view_page_shows_the_line_and_links_to_its_entry(): void
    {
        $this->receive(10);
        $m = Movement::where('type', 'RECEIVE')->firstOrFail();
        $this->actingAs($this->officer())->get(route('inv.records.show', $m))->assertOk()->assertSee($m->ref)->assertSee($m->entry_no)->assertSee('HP Toner')->assertSee('Download PDF');
        $this->actingAs($this->person())->get(route('inv.records.show', $m))->assertForbidden();
        $this->actingAs($this->officer())->get(route('inv.records'))->assertOk()->assertSee('View');
    }
}
