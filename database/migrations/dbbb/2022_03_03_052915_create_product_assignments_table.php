<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_assignments', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
            $table->uuid('user_id')->index();
            $table->uuid('product_id')->index();
            $table->uuid('assigned_by')->index();
            $table->tinyInteger('is_acceptance')->default('0');
            $table->uuid('acceptance_by')->index();
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('assigned_by')->references('id')->on('users');
            $table->foreign('acceptance_by')->references('id')->on('users');
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
        Schema::dropIfExists('product_assignments');
    }
}
