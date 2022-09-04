<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id')->index();
            $table->unsignedBigInteger('activity_id')->index();
            $table->timestamps();


            $table->foreign('package_id')
                    ->references('id')
                    ->on('packages');
            $table->foreign('activity_id')
                    ->references('id')
                    ->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign keys
        Schema::table('package_activity', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropForeign(['activity_id']);
        });
        Schema::dropIfExists('package_activity');
    }
}
