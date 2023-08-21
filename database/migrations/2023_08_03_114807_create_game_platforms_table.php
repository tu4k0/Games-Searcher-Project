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
        Schema::create('game_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('platform_id');
            $table->timestamps();
            $table->index('game_id','game_platform_game_idx');
            $table->index('platform_id','game_platform_platform_idx');
            $table
                ->foreign('game_id', 'game_platform_game_fk')
                ->on('games')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('platform_id', 'game_platform_platform_fk')
                ->on('platforms')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_platforms');
    }
};
