<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('tracked_at');
            $table->timestamps();
            
            $table->index(['order_id', 'tracked_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_trackings');
    }
};