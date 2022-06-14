<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::all('id')->random(2);
        $possibleStatus = ['open', 'pending', 'finished'];
        $status = $possibleStatus[random_int(0, 2)];
        return [
            'player1_id' => $user[0],
            'player2_id' => ($status === 'open') ? 0 : $user[1],
            'status' => $status,
            'winner' => ($status === 'open') ? 0 : $user[random_int(0, 1)]
        ];
    }
}
