<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hand extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'p1_cards' => 'collection',
        'p2_cards' => 'collection'
    ];

    /**
     * Get the winner nice name.
     *
     * @param  string  $value
     * @return string
     */
    public function getWinnerAttribute($value)
    {
        return 'Player ' . $value;
    }

    /**
     * Get player 1 cards image.
     *
     * @param  string  $value
     * @return string
     */
    public function getP1CardsImagesAttribute($value)
    {
        return $this->p1_cards->map(fn ($card) => "{$card}.png");
    }

    /**
     * Get player 2 cards image.
     *
     * @param  string  $value
     * @return string
     */
    public function getP2CardsImagesAttribute($value)
    {
        return $this->p2_cards->map(fn ($card) => "{$card}.png");
    }    
}
