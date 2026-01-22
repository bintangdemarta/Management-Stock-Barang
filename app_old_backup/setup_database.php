#!/usr/bin/env php
<?php

// Simple script to check if the application is properly configured
// and to manually insert migration records for tables that already exist

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check if the migrations table exists and has the required entries
try {
    // Insert migration records for tables that already exist
    $existingMigrations = [
        ['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
        ['migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
        ['migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
    ];
    
    foreach ($existingMigrations as $migration) {
        try {
            DB::table('migrations')->insert($migration);
            echo "Inserted migration: " . $migration['migration'] . "\n";
        } catch (Exception $e) {
            // Record might already exist, which is fine
            echo "Skipped migration: " . $migration['migration'] . "\n";
        }
    }
    
    // Now try to run the remaining migrations
    echo "Attempting to run remaining migrations...\n";
    
    // Create the sessions table if it doesn't exist
    $result = DB::select("SHOW TABLES LIKE 'sessions'");
    if (empty($result)) {
        DB::statement("
            CREATE TABLE sessions (
                id varchar(255) NOT NULL PRIMARY KEY,
                user_id bigint(20) UNSIGNED NULL,
                ip_address varchar(45) NULL,
                user_agent text NULL,
                payload longtext NOT NULL,
                last_activity int(11) NOT NULL,
                INDEX sessions_user_id_index (user_id),
                INDEX sessions_last_activity_index (last_activity)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "Created sessions table\n";
    }
    
    // Insert the sessions table migration record
    try {
        DB::table('migrations')->insert([
            'migration' => '2026_01_22_134533_create_sessions_table',
            'batch' => 1
        ]);
        echo "Inserted sessions table migration\n";
    } catch (Exception $e) {
        echo "Skipped sessions table migration\n";
    }
    
    // Insert our custom migrations
    $customMigrations = [
        ['migration' => '2026_01_22_122243_create_categories_table', 'batch' => 2],
        ['migration' => '2026_01_22_131514_create_audits_table', 'batch' => 2],
    ];
    
    foreach ($customMigrations as $migration) {
        try {
            DB::table('migrations')->insert($migration);
            echo "Inserted migration: " . $migration['migration'] . "\n";
        } catch (Exception $e) {
            // Record might already exist, which is fine
            echo "Skipped migration: " . $migration['migration'] . "\n";
        }
    }
    
    echo "Setup completed successfully!\n";
} catch (Exception $e) {
    echo "Error during setup: " . $e->getMessage() . "\n";
}