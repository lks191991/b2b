<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
			$table->string('certificate_title', 255);
			$table->string('certificate_src', 255);
			$table->date('expiry_date');
			$table->text('notes');
			$table->tinyInteger('certificate_type');
			$table->integer('associate_id');
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
        Schema::dropIfExists('certificates');
    }
}
