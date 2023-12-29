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
        Schema::table('candidates', function (Blueprint $table) {
            $table->foreignId('city_id')->after('gender')->constrained();
            $table->foreignId('province_id')->after('city_id')->constrained();

            $table->foreignId('last_educ')->after('province_id')->nullable()->constrained('education');
            $table->foreignId('last_experience')->after('last_educ')->nullable()->constrained('experiences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['last_educ']);
            $table->dropForeign(['last_experience']);
        });
    }
};
