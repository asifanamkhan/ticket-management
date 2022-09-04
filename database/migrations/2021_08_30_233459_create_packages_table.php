<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id')->index();
            $table->unsignedBigInteger('package_type_id')->index();
            $table->string('name');
            $table->string('arabic_name')->nullable();
            $table->text('description')->nullable();
            $table->text('arabic_description')->nullable();
            $table->double('price');
            $table->integer('gate_access')->default(0);
            $table->boolean('status')->default(false);
            $table->integer('quantity');
            $table->integer('fixed_quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('day_id')
                    ->references('id')
                    ->on('days');
            $table->foreign('package_type_id')
                    ->references('id')
                    ->on('package_types');
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
        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['day_id']);
            $table->dropForeign(['package_type_id']);
        });
        Schema::dropIfExists('packages');
    }
}
