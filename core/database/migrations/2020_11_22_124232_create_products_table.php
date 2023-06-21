<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brand_id')->index();
            $table->string('sku', 100)->nullable();
            $table->string('name', 191);
            $table->string('model', 100)->nullable();

            $table->unsignedTinyInteger('has_variants')->default(0);
            $table->unsignedTinyInteger('track_inventory')->default(1);
            $table->unsignedTinyInteger('show_in_frontend')->default(1);

            $table->string('main_image', 191);
            $table->text('video_link')->nullable();
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->text('specification')->nullable();
            $table->json('extra_descriptions')->nullable();

            $table->double('base_price', 8, 2)->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_special')->default(0);

            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
