<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
			$table->string('name');
			$table->uuid('user_id')->index();
			$table->decimal('amount', 8, 2);
			$table->date('start_date');
			$table->date('end_date');
			$table->uuid('company_id')->index();
            $table->timestamps();
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('company_id')->references('id')->on('companies');
			$table->tinyInteger('status')->default('1');
			$table->softDeletes();			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
