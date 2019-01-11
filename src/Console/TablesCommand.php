<?php

namespace Bokt\Queue\Console;

use Flarum\Database\Migrator;
use Illuminate\Console\Command;

class TablesCommand extends Command
{
    protected $signature = 'queue:tables';
    protected $description = 'Migrates queue jobs and failed_jobs tables.';

    public function handle(Migrator $migrator)
    {
        $migrator->run(__DIR__ . '/../../migrations');
    }
}
