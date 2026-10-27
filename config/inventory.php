<?php

/** IT Inventory (simple): equipment stock, allocation tracking and records. Permissions live in config/itsm.php. */
return [
    // Kept empty on purpose: the older migration 2026_10_28_000022_inventory_roles_settings reads this key on a fresh database
    // (migrate:fresh / the test database). The simple inventory has no settings, so there is nothing to insert.
    'settings' => [],
    'movement_types' => ['RECEIVE' => 'Received', 'OPENING' => 'Previous item', 'ALLOCATE' => 'Allocated', 'RETURN' => 'Returned', 'ADJUST' => 'Correction (old)'],
    'pills' => ['RECEIVE' => 'success', 'OPENING' => 'secondary', 'ALLOCATE' => 'primary', 'RETURN' => 'info', 'ADJUST' => 'warning'],
];
