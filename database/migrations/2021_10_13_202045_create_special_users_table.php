<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_users', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->string('full_name');
            $table->string('company_name');
            $table->string('type');
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->unsignedBigInteger('country_id')->index()->nullable();
            $table->string('city');
            $table->text('message')->nullable();
            $table->string('document')->nullable();
            $table->string('password');
            $table->timestamps();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
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
        Schema::table('special_users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });

        Schema::dropIfExists('special_users');
    }
}
