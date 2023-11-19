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
        Schema::create('recruitment_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('role', 100)->nullable(); 
            $table->string('title', 100)->nullable(); 
            $table->string('address', 100)->nullable(); 
            $table->string('job_type', 100)->nullable(); 
            $table->string('salary', 100)->nullable(); 
            $table->text('description')->nullable(); 
            $table->text('job_requirements')->nullable(); 
            $table->string('educational_requirements', 100)->nullable(); 
            $table->string('experience_requirements', 100)->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_posts');
    }
};
