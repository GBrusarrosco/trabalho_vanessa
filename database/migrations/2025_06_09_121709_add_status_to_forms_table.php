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
        Schema::table('forms', function (Blueprint $table) {

            $table->string('status')->default('pendente')->after('description');
            $table->text('rejection_reason')->nullable()->after('status');

            $table->dropColumn('is_validated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason']);
            $table->boolean('is_validated')->default(false);
        });
    }
};
