<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('tax', 5, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->string('main_image');
            $table->json('gallery_images')->nullable();
            $table->json('specifications')->nullable();
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};