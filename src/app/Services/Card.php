<?php

namespace App\Services;

use Exception;

// TODO: don't forget to implement ArrayAccess maybe can be helpful
class Card
{
    const SUITS = [
        'C' => 'club',
        'D' => 'diamond',
        'S' => 'sword',
        'H' => 'heart'
    ];

    const VALUES = [
        '2' => 2, 
        '3' => 3, 
        '4' => 4, 
        '5' => 5, 
        '6' => 6, 
        '7' => 7, 
        '8' => 8, 
        '9' => 9, 
        'T' => 10, 
        'J' => 11, 
        'Q' => 12, 
        'K' => 13, 
        'A' => 14
    ];

    /**
     * The raw value of the card passed to the class
     * 
     * @var string
     */
    protected $card;

    /**
     * Analyze pocker hand and return result
     * 
     * @param array  $hand
     * @return array
     */
    public function __construct(string $card)
    {
        if(strlen($card) != 2)
        {
            throw new Exception('The card is not properly formatted');
        }

        if(!array_key_exists($card[0], static::VALUES))
        {
            throw new Exception('The card value is not matching any possible value');
        }

        if(!array_key_exists($card[1], static::SUITS))
        {
            throw new Exception('The card suit is not matching any possible suit');
        }

        $this->card = $card;
    }

    /**
     * Return the value of the card
     * 
     * @return integer
     */
    public function value()
    {              
        return static::VALUES[$this->card[0]];
    }

    /**
     * Return the value of the card
     * 
     * @return integer
     */
    public function symbol()
    {      
        return $this->card[0];          
    }

    /**
     * Return the suit of the card
     * 
     * @return string
     */
    public function suit()
    {
        return $this->card[1];        
    }

    /**
     * Return the card as string
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->card;
    }
}