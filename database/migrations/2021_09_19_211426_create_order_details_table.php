<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('type_id')->constrained('package_types','id');
            $table->string('type_name');
            $table->string('type_arabic_name')->nullable();
            $table->string('day_code');
            $table->string('day_name');
            $table->string('day_arabic_name')->nullable();
            $table->string('day_from')->nullable();
            $table->string('day_to')->nullable();
            $table->foreignId('package_id')->constrained('packages','id');
            $table->string('name');
            $table->string('arabic_name')->nullable();
            $table->text('description')->nullable();
            $table->text('arabic_description')->nullable();
            $table->double('price');
            $table->integer('gate_access')->default(0);
            $table->integer('qty');
            $table->integer('fixed_quantity')->default(0);
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
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['type_id']);
            $table->dropForeign(['package_id']);
        });
        Schema::dropIfExists('order_details');
    }
}
