<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gameInFields = Field::all('id')->toArray();
        $games = Game::where('status', 'pending')->get();
        $game = $games[random_int(0, 2)];
        $players = [$game->player1_id, $game->player2_id];
        if (!in_array($game->id, $gameInFields)) {
            return [
                'game_id' => $game->id,
                'field11' => $players[random_int(0, 1)],
                'field12' => $players[random_int(0, 1)],
                'field13' => $players[random_int(0, 1)],
                'field21' => $players[random_int(0, 1)],
                'field22' => $players[random_int(0, 1)],
                'field23' => $players[random_int(0, 1)],
                'field31' => $players[random_int(0, 1)],
                'field32' => $players[random_int(0, 1)],
                'field33' => $players[random_int(0, 1)]
            ];
        }
    }
}
