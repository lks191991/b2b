<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
			$table->string('title', 255);
			$table->text('description');
			$table->decimal('price', 8, 2);
			$table->decimal('discount', 8, 2);
			$table->string('manual', 255);
			$table->string('serial_number', 255);
			$table->string('No', 255);
			$table->string('size', 255);
			$table->date('expiry_date');
			$table->integer('rental_duration');
			$table->date('rental_assigned_date');
			$table->tinyInteger('status')->default('1');		
            $table->timestamps();
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
        Schema::dropIfExists('products');
    }
}
