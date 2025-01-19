<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateSlugsForTables extends Command
{
    protected $signature = 'generate:slugs';
    protected $description = 'Generate slugs for all records in all tables based on the first primary key';

    public function handle()
    {
		$possibleFields = ['name', 'title'];


        // Get all table names from the current database
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
    // Check if the 'slug' column exists in the table
    if (Schema::hasColumn($table, 'slug')) {
        // Safely fetch table details using try-catch to avoid enum issues
        try {
            $tableDetails = DB::connection()->getDoctrineSchemaManager()->listTableDetails($table);
            $primaryKey = $tableDetails->getPrimaryKey();
        } catch (\Exception $e) {
            $this->warn("Skipping table due to error: $table (Error: " . $e->getMessage() . ")");
            continue;
        }

        if ($primaryKey) {
            $primaryKeyName = $primaryKey->getColumns()[0]; // Get the first primary key column
        } else {
            $this->warn("No primary key found for table: $table");
            continue;
        }

        // Fetch all records where slug is null
        $records = DB::table($table)->whereNull('slug')->get();

        foreach ($records as $record) {
            $slugField = collect($possibleFields)->first(fn($field) => isset($record->$field));

            // Ensure the primary key exists in the record
            if (isset($record->$primaryKeyName) && $slugField) {
                // Generate slug
                $slug = Str::slug($record->$slugField . '-' . $record->$primaryKeyName);

                // Update the slug column for the record
                DB::table($table)
                    ->where($primaryKeyName, $record->$primaryKeyName)
                    ->update(['slug' => $slug]);
            }
        }
    }
}


        $this->info('Slugs generated for all tables based on the first primary key!');
    }
}
