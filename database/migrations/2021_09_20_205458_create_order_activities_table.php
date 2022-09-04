<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_detail_id')->constrained('order_details');
            $table->foreignId('activity_id')->constrained('activities');
            $table->string('name');
            $table->string('arabic_name')->nullable();
            $table->text('description')->nullable();
            $table->text('arabic_description')->nullable();
            $table->float('price');
            $table->integer('qty');
            $table->text('images')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::table('order_activities', function (Blueprint $table) {
            $table->dropForeign(['order_detail_id']);
            $table->dropForeign(['activity_id']);
        });

        Schema::dropIfExists('order_activities');
    }
}
