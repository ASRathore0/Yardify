<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('password');
            $table->string('phone', 20)->nullable()->after('avatar_path');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male','female','other'])->nullable()->after('date_of_birth');
            $table->string('address')->nullable()->after('gender');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('zip', 20)->nullable()->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_path','phone','date_of_birth','gender','address','city','state','zip']);
        });
    }
};
