<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
            $table->uuid('user_id')->index();
            $table->uuid('contract_id')->index();
            $table->string('no');
            $table->text('notes');
            $table->decimal('sub_total', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('total', 8, 2);
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
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
        Schema::dropIfExists('orders');
    }
}
