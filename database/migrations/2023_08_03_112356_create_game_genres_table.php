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
        Schema::create('game_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();
            $table->index('game_id','game_genre_game_idx');
            $table->index('genre_id','game_genre_genre_idx');
            $table
                ->foreign('game_id', 'game_genre_game_fk')
                ->on('games')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('genre_id', 'game_genre_genre_fk')
                ->on('genres')
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
        Schema::dropIfExists('game_genres');
    }
};
