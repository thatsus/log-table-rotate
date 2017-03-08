<?php

namespace LotVantage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RotateLogTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:rotate {table_name | The table to rename and replace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move existing table to a holding place and create a new empty version';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table_name = $this->argument('table_name');
        $old = "old_{$table_name}";
        $new = "new_{$table_name}";
        $this->info("Rotating {$table_name} tables...");
        DB::statement("DROP TABLE IF EXISTS `{$old}`;");
        DB::statement("CREATE TABLE `{$new}` LIKE `{$table_name}`;");
        DB::statement("RENAME TABLE `{$table_name}` TO `{$old}`, `{$new}` TO `{$table_name}`;");
        $this->info("Rotation complete.");
    }
}
