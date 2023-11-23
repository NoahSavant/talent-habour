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
        Schema::create('company_informations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('image_url')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('address_main')->nullable();
            $table->string('scale')->nullable();
            $table->string('field')->nullable();
            $table->string('web')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('description')->nullable();
            $table->string('culture')->nullable();
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
        Schema::dropIfExists('company_informations');
    }
};
