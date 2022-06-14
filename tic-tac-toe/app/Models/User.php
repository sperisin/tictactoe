<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'password', 'gamesplayed'
    ];

    protected $hidden = [
        'password'
    ];

    // protected $with = ['player1Relation', 'player2Relation', 'winnerRelation'];

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = Hash::make($password);
    // }

    // public function player1Relation()
    // {
    //     return $this->hasMa(Game::class, 'player1_id', 'id');
    // }

    // public function player2Relation()
    // {
    //     return $this->hasOne(Game::class, 'player2_id', 'id');
    // }

    // public function winnerRelation()
    // {
    //     return $this->hasOne(Game::class, 'winner', 'id');
    // }
}
