<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendPackageActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activity', function (Blueprint $table) {
            $table->string('day_limit')->nullable();
            $table->string('limit_per_visitor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_activity', function (Blueprint $table) {
            $table->dropColumn(['day_limit', 'limit_per_visitor']);
        });
    }
}
