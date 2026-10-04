<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 40)->unique();
            $t->string('name');
            $t->json('permissions');
            $t->timestamps();
        });

        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('role_id');
        });
        Schema::dropIfExists('roles');
    }
};
