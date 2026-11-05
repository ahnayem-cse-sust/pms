<?php

namespace App\Console\Commands;

use App\Models\Inventory\Movement;
use App\Services\Inventory\InventoryService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

/**
 * Remove every "Previous item" receive (type OPENING, entry RC-…) from the system.
 * Each entry goes through InventoryService::deleteEntry(), exactly like the Delete button on the Receives page:
 * its stock effect is reversed, running balances are rebuilt and an audit-log row is written.
 * An entry that cannot be removed safely (e.g. stock was already allocated out of it) is skipped and reported.
 *
 * Runs as a dry run unless --force is given.
 */
class DeletePreviousReceives extends Command
{
    protected $signature = 'inventory:delete-previous-receives {--force : Actually delete (without it, only lists what would be deleted)}';
    protected $description = 'Delete all previous-item receive entries (type OPENING) and reverse their stock effect';

    public function handle(InventoryService $svc): int
    {
        $entries = Movement::where('type', 'OPENING')->whereNotNull('entry_no')
            ->select('entry_no')->selectRaw('COUNT(*) as line_count, MAX(id) as last_id')->groupBy('entry_no')->orderByDesc('last_id')->get();

        if ($entries->isEmpty()) {
            $this->info('No previous-item receives found. Nothing to do.');
            return self::SUCCESS;
        }

        $this->info($entries->count().' previous-item receive entries ('.$entries->sum('line_count').' lines) found.');

        if (! $this->option('force')) {
            $this->table(['Entry', 'Lines'], $entries->map(fn ($e) => [$e->entry_no, $e->line_count])->all());
            $this->warn('Dry run only. Back up the database, then run again with --force to delete.');
            return self::SUCCESS;
        }

        if ($this->input->isInteractive() && ! $this->confirm('This permanently deletes these entries and reduces stock accordingly. Continue?')) {
            $this->line('Cancelled.');
            return self::FAILURE;
        }

        $done = 0; $failed = [];
        foreach ($entries as $e) {   // newest first
            try {
                $svc->deleteEntry($e->entry_no, ['OPENING']);
                $done++;
            } catch (ValidationException $ex) {
                $failed[] = [$e->entry_no, collect($ex->errors())->flatten()->first()];
            }
        }

        $this->info("Deleted {$done} of {$entries->count()} entries.");
        if ($failed) {
            $this->error(count($failed).' entries could not be deleted (nothing was changed for them):');
            $this->table(['Entry', 'Reason'], $failed);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
