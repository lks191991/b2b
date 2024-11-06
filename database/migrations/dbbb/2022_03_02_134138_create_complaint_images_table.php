<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_images', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
			$table->uuid('complaint_id')->index();
			$table->string('image', 255);
			$table->tinyInteger('status')->default('1');		
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_images');
    }
}
