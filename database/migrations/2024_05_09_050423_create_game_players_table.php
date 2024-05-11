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
        Schema::create('game_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('game_id');
            $table->boolean('confirmed')->default(false);
            $table->smallInteger('goals')->default(0);
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('game_players', function(Blueprint $table){
            $table->dropForeign('game_players_player_id_foreign');
            $table->dropForeign('game_players_team_id_foreign');
            $table->dropForeign('game_players_game_id_foreign');
        });
        Schema::dropIfExists('game_players');
    }
};
