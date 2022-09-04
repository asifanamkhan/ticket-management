<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_detail_id')->constrained('order_details');
            $table->string('name');
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
        Schema::table('order_names', function (Blueprint $table) {
            $table->dropForeign(['order_detail_id']);
        });

        Schema::dropIfExists('order_names');
    }
}
