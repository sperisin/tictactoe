<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id', 'field11', 'field12', 'field13', 'field21', 'field22', 'field23', 'field31', 'field32', 'field33'
    ];

    protected $with = ['fieldRelationForGame'];

    public function fieldRelationForGame()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
