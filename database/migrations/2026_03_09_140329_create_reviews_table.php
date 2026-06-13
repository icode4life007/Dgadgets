<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment');
            $table->string('user_name');
            $table->string('email');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['product_id', 'is_approved']);
            $table->index('email');
            $table->index('rating');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};