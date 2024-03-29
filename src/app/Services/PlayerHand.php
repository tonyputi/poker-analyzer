<?php

namespace App\Services;

use Exception;

class PlayerHand
{
    /**
     * Constant representing high ace
     * 
     * @var integer
     */
    const HIGH_ACE = 14;

    /**
     * Available ranks with key representing the weight of the rank
     * 
     * @var array
     */
    const ranks = [
        9 => 'RoyalFlush',
        8 => 'StraightFlush',
        7 => 'FourOfAKind',
        6 => 'FullHouse',
        5 => 'Flush',
        4 => 'Straight',
        3 => 'ThreeOfAKind',
        2 => 'TwoPair',
        1 => 'OnePair',
        0 => 'HighCard'
    ];

    /**
     * The cards own by player
     * 
     * @var array
     */
    protected $cards;

    /**
     * The high ace is present or not
     * 
     * @var boolean
     */
    protected $highAce = false;

    /**
     * The rank of the player
     * 
     * @var integer
     */
    protected $rank = 0;

    /**
     * The rankCards used to compare high card when same result
     * occur on both players side
     * 
     * @var array
     */
    protected $rankCards = [];

    /**
     * The cards 
     * 
     * @var array
     */
    protected $kickers = [];

    /**
     * Class constructor
     * 
     * @param array  $cards
     */
    public function __construct(array $cards)
    {
        // checking if we have proper amount of cards
        if(count($cards) != 5)
        {
            throw new Exception('The player has invalid card number');
        }

        // populating cards array
        foreach($cards as $card)
        {
            $this->cards[] = new Card($card);
        }

        // always set the rankCards to highest card when instantiating
        $this->rankCards = $this->getValues();
    }

    /**
     * Analyze pocker hand
     * 
     * @return PlayerHand
     */
    public function analyze()
    {
        foreach(static::ranks as $j => $rank)
        {
            $method = "has{$rank}";

            if(method_exists($this, $method))
            {                
                if($this->$method())
                {
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * Check if player has royal flush in his hand
     * 
     * @return boolean
     */
    public function hasRoyalFlush()
    {
        // royal flush must be first a simple flush
        if(!$this->hasFlush())
        {
            return false;
        }

        $values = $this->getValues();

        // if last reverse sorted value on array is 10 or T this mean 
        // that the previous ones must be 14,13,12,11 or better A,K,Q,J
        if($values[4] != 10)
        {
            return false;
        }

        $this->rank = 9;
        $this->highAce = true;
        $this->rankCards = $values;
        $this->kickers = [];

        return true;
    }

    /**
     * Check if player has straight flush in his hand
     * 
     * @return boolean
     */
    public function hasStraightFlush()
    {
        // royal flush must be first a simple flush
        if(!$this->hasFlush())
        {
            return false;
        }

        $values = [];

        foreach($this->cards as $card)
        {
            // when checking straight flush ace is always lower
            $values[] = ($card->value() == static::HIGH_ACE) ? 1 : $card->value();
        }

        if(!$this->hasSequentialValues($values))
        {
            return false;
        }

        $this->rank = 8;
        $this->rankCards = $values;
        $this->kickers = [];

        return true;
    }

    /**
     * Check if player has four of a kind in his hand
     * 
     * @return boolean
     */
    public function hasFourOfAKind()
    {
        $values = $this->getValues();

        $occurrences = array_count_values($values);

        // when 4 occurrences of the same value happen than mean that
        // the player has four of a kind
        if(!in_array(4, $occurrences))
        {
            return false;
        }

        $this->rank = 7;

        // using the weight/value of the card with 4 occurrence as rankCards
        $this->rankCards = array_keys(array_filter($occurrences, fn ($value) => $value == 4));

        // getting kickers card
        $this->kickers = array_keys(array_filter($occurrences, fn ($value) => $value == 1));

        return true;
    }

    /**
     * Check if player has four of a kind in his hand
     * 
     * @return boolean
     */
    public function hasFullHouse()
    {
        $values = $this->getValues();

        $occurrences = array_count_values($values);

        // when occurrences length is 2 and there are 3 occurrences of same value than
        // mean that the player has full house
        if(!(count($occurrences) == 2 AND in_array(3, $occurrences)))
        {
            return false;
        }

        $this->rank = 6;

        // using the weight/value of the card with 3 occurrence as rankCards
        $this->rankCards = $values;
        $this->kickers = [];

        return true;
    }

    /**
     * Check if player has flush in his hand
     * 
     * @return boolean
     */
    public function hasFlush()
    {
        $occurrences = array_count_values($this->getSuits());

        if(!(count($occurrences) == 1))
        {
            return false;
        }

        $this->rank = 5;

        $this->rankCards = $this->getValues();
        $this->kickers = [];
        
        return true;
    }

    /**
     * Check if player has flush in his hand
     * 
     * @return boolean
     */
    public function hasStraight()
    {   
        $values = $this->getValues();

        // if first sorted value on array is 10 this mean that
        // the next ones must be 11,12,13,14 or better J,Q,K,A
        if($values[4] == 10)
        {
            $this->highAce = true;
            $this->rank = 4;
            $this->rankCards = $values;
            $this->kickers = [];            

            return true;
        }

        if(in_array(static::HIGH_ACE, $values))
        {
           $values[array_search(static::HIGH_ACE, $values)] = 1;
           sort($values);
        }

        if(!$this->hasSequentialValues($values))
        {
            return false;
        }

        $this->rank = 4;
        $this->rankCards = $values;
        $this->kickers = [];

        return true;
    }

    /**
     * Check if player has three of a kind in his hand
     * 
     * @return boolean
     */
    public function hasThreeOfAKind()
    {
        $values = $this->getValues();

        $occurrences = array_count_values($values);

        // when there are 3 occurrences of same value than mean that the player 
        // has three of a kind
        if(!in_array(3, $occurrences))
        {
            return false;
        }

        $this->rank = 3;

        // using the weight/value of the card with 3 occurrence as rankCards
        $this->rankCards = array_keys(array_filter($occurrences, fn ($value) => $value == 3));

        // getting kickers card
        $this->kickers = array_keys(array_filter($occurrences, fn ($value) => $value != 1));

        return true;
    }

    /**
     * Check if player has two pair in his hand
     * 
     * @return boolean
     */
    public function hasTwoPair()
    {
        $values = $this->getValues();

        $occurrences = array_count_values($values);
        
        // checking for the presence of two pairs filtering only occurrences
        // of 2 cards of the same value
        if(!(count(array_filter($occurrences, fn ($n) => $n == 2)) == 2))
        {
            return false;
        }

        $this->rank = 2;

        // getting the cards value for two pairs outcome
        $this->rankCards = array_keys(array_filter($occurrences, fn ($value) => $value == 2));

        // getting kickers card
        $this->kickers = array_keys(array_filter($occurrences, fn ($value) => $value == 1));

        return true;
    }

    /**
     * Check if player has two pair in his hand
     * 
     * @return boolean
     */
    public function hasOnePair()
    {
        $occurrences = array_count_values($this->getValues());
        
        // checking for the presence of one pairs filtering only occurrences
        // of 2 cards of the same value
        if(!(count(array_filter($occurrences, fn ($n) => $n == 2)) > 0))
        {
            return false;
        }

        $this->rank = 1;

        // getting the cards value for two pairs outcome
        $this->rankCards = array_keys(array_filter($occurrences, fn ($value) => $value == 2));

        // getting kickers card
        $this->kickers = array_keys(array_filter($occurrences, fn ($value) => $value != 2));

        return true;
    }

    /**
     * Returning the rank name for the hand
     * 
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Returning the rank value for the hand
     * 
     * @return integer
     */
    public function getRankName()
    {
        return static::ranks[$this->rank];
    }

    /**
     * Returning the value numbers as array
     * 
     * @return array
     */
    public function getRankCards()
    {
        return $this->rankCards;
    }

    /**
     * Returning the kickers cards/numbers
     * 
     * @return array
     */
    public function getKickers()
    {
        return $this->kickers;
    }

    /**
     * Return all sorted cards as array
     *      
     * @return array
     */
    public function getCards()
    {
        $values = $this->getValues();
        $cards  = [];

        foreach($values as $i => $value)
        {
            foreach($this->cards as $card)
            {
                if($card->value() == $value)
                {
                    $cards[] = (string)$card;
                    break;
                }
            }
        }

        return $cards;

        // return array_map(fn ($card) => (string)$card, $this->cards);
    }

    /**
     * Return all the suits only from the player hand
     * 
     * @return array
     */
    public function getSuits()
    {        
        return array_map(fn ($card) => $card->suit(), $this->cards);
    }

    /**
     * Return all the values only from the player hand
     * 
     * @return array
     */
    public function getValues()
    {
        $values = array_map(fn ($card) => $card->value(), $this->cards);
        
        rsort($values);
        
        return $values;
    }

    /**
     * Checking if values in array are sequentials returning a boolean
     * 
     * @return boolean
     */
    public function hasSequentialValues(array $values)
    {
        sort($values);

        for($i = 0; $i < count($values); $i++)
        {
            if($i > 0)
            {
                if($values[$i] - $values[$i - 1] != 1)
                {
                    return false;
                }
            }
        }

        return true;
    }
}