<?php
// Script to manually insert migration records for existing tables

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Insert migration records for tables that already exist
$migrations = [
    ['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
    ['migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
    ['migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
];

foreach ($migrations as $migration) {
    try {
        DB::table('migrations')->insert($migration);
        echo "Inserted migration: " . $migration['migration'] . "\n";
    } catch (Exception $e) {
        // Ignore if already exists
        echo "Skipped migration: " . $migration['migration'] . " - " . $e->getMessage() . "\n";
    }
}

echo "Migration records insertion completed.\n";