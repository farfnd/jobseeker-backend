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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('position');
            $table->text('job_desc');
            $table->year('start_year');
            $table->year('end_year')->nullable();
            $table->boolean('until_now');
            $table->string('flag');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
