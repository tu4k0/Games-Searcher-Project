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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedFloat('rating');
            $table->text('summary');
            $table->date('first_release_date');
            $table->timestamps();
            $table->unsignedBigInteger('category_id');
            $table->index('category_id','game_category_idx');
            $table
                ->foreign('category_id', 'game_category_fk')
                ->on('categories')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
