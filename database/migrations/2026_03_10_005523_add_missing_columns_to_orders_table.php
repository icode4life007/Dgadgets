<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('orders', 'customer_address')) {
                $table->text('customer_address')->after('customer_email');
            }
            
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('customer_address');
            }
            
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('notes');
            }
            
            if (!Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2)->after('subtotal');
            }
            
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('total');
            }
            
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('orders', 'courier_service')) {
                $table->string('courier_service')->nullable()->after('tracking_number');
            }
            
            if (!Schema::hasColumn('orders', 'estimated_delivery')) {
                $table->date('estimated_delivery')->nullable()->after('courier_service');
            }
            
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('estimated_delivery');
            }
            
            if (!Schema::hasColumn('orders', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('delivered_at');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_address',
                'notes',
                'subtotal',
                'total',
                'status',
                'payment_status',
                'tracking_number',
                'courier_service',
                'estimated_delivery',
                'delivered_at',
                'admin_notes'
            ]);
        });
    }
};