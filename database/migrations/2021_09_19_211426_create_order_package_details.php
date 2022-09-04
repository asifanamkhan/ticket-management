<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_detail_id')->constrained('order_details');
            $table->foreignId('type_id')->constrained('package_types','id');
            $table->string('type_name');
            $table->string('type_arabic_name')->nullable();
            $table->string('day_code');
            $table->string('day_name');
            $table->string('day_arabic_name')->nullable();
            $table->string('day_from')->nullable();
            $table->string('day_to')->nullable();
            $table->string('name');
            $table->foreignId('package_id')->constrained('packages','id');
            $table->string('arabic_name')->nullable();
            $table->text('description')->nullable();
            $table->text('arabic_description')->nullable();
            $table->double('price');
            $table->integer('gate_access')->default(0);
            $table->integer('quantity');
            $table->integer('fixed_quantity')->default(0);
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
        // Drop foreign key
        Schema::table('order_package_details', function (Blueprint $table) {
            $table->dropForeign(['order_detail_id']);
            $table->dropForeign(['type_id']);
            $table->dropForeign(['package_id']);
        });

        Schema::dropIfExists('order_package_details');
    }
}
