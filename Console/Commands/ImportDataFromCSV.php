<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Database\QueryException;

class ImportDataFromCSV extends Command
{
    protected $signature = 'importDataFromCSV';
    protected $description = 'Data Inserted Successfully';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Enable query buffering
        DB::connection()->getPdo()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $table_name = 'csvdata'; // Name of your MySQL table
		for($i=1;$i<2;$i++){
        $file_path = asset('uploads/import/'.$i.'.csv');
		
                // Use DB::unprepared to execute raw SQL
				$query = "
            LOAD DATA LOCAL INFILE '{$file_path}'
            INTO TABLE {$table_name}
            CHARACTER SET latin1
            FIELDS TERMINATED BY ',' 
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n'
            IGNORE 0 ROWS
            (name, email, company, city, state, code, mobile,status);";
			
              try {
            DB::unprepared($query);
            $this->info("Data from {$i} imported successfully.");
        } catch (QueryException $e) {
            $this->error("Error importing data from {$i}: " . $e->getMessage());
        }
        
    }
	

       
}
}