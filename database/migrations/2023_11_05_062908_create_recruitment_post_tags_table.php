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
        Schema::create('recruitment_post_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id')->nullable();
            $table->bigInteger('recruitment_post_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('recruitment_post_id')->references('id')->on('recruitment_posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_post_tags');
    }
};
