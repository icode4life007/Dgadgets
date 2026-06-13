<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('admins', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('admins', 'job_title')) {
                $table->string('job_title')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('admins', 'bio')) {
                $table->text('bio')->nullable()->after('job_title');
            }
            // Rename profile_image to avatar if needed
            if (Schema::hasColumn('admins', 'profile_image') && !Schema::hasColumn('admins', 'avatar')) {
                $table->renameColumn('profile_image', 'avatar');
            } elseif (!Schema::hasColumn('admins', 'avatar')) {
                $table->string('avatar')->nullable()->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['phone', 'job_title', 'bio']);
            // Optionally revert avatar rename
            if (Schema::hasColumn('admins', 'avatar') && !Schema::hasColumn('admins', 'profile_image')) {
                $table->renameColumn('avatar', 'profile_image');
            }
        });
    }
};