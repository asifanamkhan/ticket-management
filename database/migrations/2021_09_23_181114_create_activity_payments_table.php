<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_activity_id')->constrained();
            $table->string('cart_id')->unique();
            $table->string('tran_ref')->nullable();
            $table->string('status')->default('pending');
            $table->string('resp_message')->nullable();
            $table->string('resp_code')->nullable();
            $table->integer('qty')->nullable();
            $table->float('adon_price')->nullable();
            $table->float('payment_price')->nullable();
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
        Schema::table('activity_payments', function (Blueprint $table) {
            $table->dropForeign(['order_activity_id']);
        });
        Schema::dropIfExists('activity_payments');
    }
}
