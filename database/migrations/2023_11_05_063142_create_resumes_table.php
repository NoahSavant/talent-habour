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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_url')->nullable();
            $table->string('content')->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('resume_form_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resume_form_id')->references('id')->on('resume_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
