<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAreaRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_area_relation', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
            $table->uuid('user_id')->index();
			$table->uuid('area_id')->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
			$table->foreign('area_id')->references('id')->on('areas');
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
        Schema::dropIfExists('user_area_relation');
    }
}
