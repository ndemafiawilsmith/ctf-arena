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
        Schema::table('ctf_events', function (Blueprint $table) {
            $table->boolean('is_rewarded')->default(false);
            $table->string('first_prize')->nullable();
            $table->string('second_prize')->nullable();
            $table->string('third_prize')->nullable();
            $table->string('sponsor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ctf_events', function (Blueprint $table) {
            $table->dropColumn(['is_rewarded', 'first_prize', 'second_prize', 'third_prize', 'sponsor']);
        });
    }
};
