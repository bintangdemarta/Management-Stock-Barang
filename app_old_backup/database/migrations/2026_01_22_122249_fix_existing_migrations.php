<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the tables already exist and mark migrations as run if they do
        $existingTables = DB::select("SHOW TABLES LIKE 'users'");
        if (!empty($existingTables)) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1
            ]);
        }
        
        $existingCacheTable = DB::select("SHOW TABLES LIKE 'cache'");
        if (!empty($existingCacheTable)) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1
            ]);
        }
        
        $existingJobsTable = DB::select("SHOW TABLES LIKE 'jobs'");
        if (!empty($existingJobsTable)) {
            DB::table('migrations')->insert([
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};