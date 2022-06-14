<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player1_id', 'player2_id', 'winner', 'status'
    ];

    protected $with = ['userRelationForPlayer1', 'userRelationForPlayer2', 'userRelationForWinner'];

    public function userRelationForPlayer1()
    {
        return $this->hasOne(User::class, 'id', 'player1_id');
    }

    public function userRelationForPlayer2()
    {
        return $this->hasOne(User::class, 'id', 'player2_id');
    }

    public function userRelationForWinner()
    {
        return $this->hasOne(User::class, 'id', 'winner');
    }
}
