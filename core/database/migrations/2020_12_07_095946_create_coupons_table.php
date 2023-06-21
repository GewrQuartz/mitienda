<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name', 50);
            $table->string('coupon_code', 20);
            $table->tinyInteger('discount_type')->comment('1=fixed, 2=percent');
            $table->double('coupon_amount')->default(0);
            $table->text('description', 400)->nullable();
            $table->double('minimum_spend', 8, 2)->nullable();
            $table->double('maximum_spend', 8, 2)->nullable();
            $table->integer('usage_limit_per_coupon')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->boolean('status')->default(1)->comment('0=disabled, 1=enabled');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
