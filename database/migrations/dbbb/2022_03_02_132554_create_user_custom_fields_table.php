<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_custom_fields', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
            $table->uuid('custom_field_id')->index();
			$table->string('custom_field_value');
			$table->uuid('user_id')->index();
			$table->tinyInteger('status')->default('1');
            $table->timestamps();
			$table->foreign('custom_field_id')->references('id')->on('custom_fields');
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
        Schema::dropIfExists('user_custom_fields');
    }
}
