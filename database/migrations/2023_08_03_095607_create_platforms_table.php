<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation')->nullable();
            $table->string('name');
            $table->string('category')->nullable();
            $table->unsignedInteger('generation')->nullable();
            $table->string('slug');
            $table->integer('source_id')->nullable();
            $table->timestamps();
        });
        Artisan::call('app:modify-genres-platforms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
