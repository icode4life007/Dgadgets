<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make shipping_address nullable since we're using customer_address
            $table->text('shipping_address')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert back to NOT NULL (you might want to set a default)
            $table->text('shipping_address')->nullable(false)->change();
        });
    }
};