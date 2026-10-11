<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Record logouts (for attendance exit time) and track when each user was last active. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_histories', function (Blueprint $t) {
            $t->string('event', 10)->default('login')->after('successful');   // login | logout
            $t->string('reason', 20)->nullable()->after('event');             // logout: manual | timeout
            $t->index(['event', 'created_at']);
        });

        Schema::table('users', function (Blueprint $t) {
            $t->timestamp('last_activity_at')->nullable();
            $t->string('last_activity_ip', 45)->nullable();
            $t->boolean('session_open')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['last_activity_at', 'last_activity_ip', 'session_open']);
        });
        Schema::table('login_histories', function (Blueprint $t) {
            $t->dropIndex(['event', 'created_at']);
            $t->dropColumn(['event', 'reason']);
        });
    }
};
