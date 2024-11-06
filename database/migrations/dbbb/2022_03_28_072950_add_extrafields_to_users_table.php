<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtrafieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('phone');
            $table->text('delivery_address')->nullable()->after('job_title');
            $table->string('postcode', 50)->nullable()->after('delivery_address');
			$table->text('delivery_address2')->nullable()->after('delivery_address');
			$table->text('city')->nullable()->after('delivery_address2');
			$table->text('country')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
