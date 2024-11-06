<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
			$table->string('address');
			$table->string('zip_code', 50);
			$table->uuid('user_id')->index();
			$table->tinyInteger('status')->default('1');
            $table->timestamps();
			$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('locations');
    }
}
