<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->foreignId('creator_user_id')->nullable()->after('id')->comment('Usuário que criou o formulário (professor)')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['creator_user_id']);
            $table->dropColumn('creator_user_id');
        });
    }
};
