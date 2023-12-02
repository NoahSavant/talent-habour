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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('content', 1000)->nullable();
            $table->string('file_url')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('recruitment_post_id')->nullable();
            $table->string('status')->nullable();
            $table->string('feedback', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recruitment_post_id')->references('id')->on('recruitment_posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
