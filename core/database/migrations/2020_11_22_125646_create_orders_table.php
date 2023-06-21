<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedInteger('user_id');
            $table->text('shipping_address');
            $table->unsignedInteger('shipping_method_id');
            $table->decimal('shipping_charge', 8,2)->default(0);
            $table->string('coupon_code', 20);
            $table->double('coupon_amount')->default(0);
            $table->decimal('total_amount', 8,2)->default(0);
            $table->tinyInteger('order_type');
            $table->boolean('payment_status')->default(false);
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = processing, 2=dispatched, 3=delivered, 4= canceled_by_admin');
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
        Schema::dropIfExists('orders');
    }
}
