<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceMigrateExisting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:force-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark existing migrations as run';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for existing tables and marking migrations as run...');
        
        // Check if users table exists and mark the migration as run if it does
        if ($this->tableExists('users')) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1
            ]);
            $this->info('Marked users table migration as run.');
        }
        
        // Check if cache table exists and mark the migration as run if it does
        if ($this->tableExists('cache')) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1
            ]);
            $this->info('Marked cache table migration as run.');
        }
        
        // Check if jobs table exists and mark the migration as run if it does
        if ($this->tableExists('jobs')) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1
            ]);
            $this->info('Marked jobs table migration as run.');
        }
        
        $this->info('Migration marking process completed.');
    }
    
    /**
     * Check if a table exists in the database
     */
    private function tableExists($tableName)
    {
        try {
            DB::select("SELECT 1 FROM `$tableName` LIMIT 1");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}