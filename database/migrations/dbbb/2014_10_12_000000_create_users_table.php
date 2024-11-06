<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
			$table->primary('id');
            $table->string('name');
			$table->string('lname');
            $table->date('date_of_birth');
            $table->string('position');
			$table->uuid('company_id')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
			$table->tinyInteger('is_active')->default('0');
			$table->uuid('role_id')->index();
			$table->tinyInteger('is_notification')->default('0');
            $table->timestamps();
			$table->foreign('company_id')->references('id')->on('companies');
			$table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
