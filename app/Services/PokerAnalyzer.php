<?php

namespace App\Services;

use Exception;

class PokerAnalyzer
{
    const PLAYER1 = 0;
    const PLAYER2 = 1;

    /**
     * Array of players
     * 
     * @var array
     */
    protected $players = [];

    /**
     * Class constructor
     * 
     */
    public function __construct($playersNumber = 2)
    {
        for($i = 0; $i < $playersNumber; $i++)
        {
            // $this->players[$i] = new PlayerHand(2);
        }
    }

    /**
     * Analyze pocker hand and return result
     * 
     * @param array  $hand
     * @return array
     */
    public function analyze(array $hand)
    {
        $players[static::PLAYER1] = new PlayerHand($hand[static::PLAYER1]);
        $players[static::PLAYER2] = new PlayerHand($hand[static::PLAYER2]);        

        foreach($players as $i => $player)
        {
            $player->analyze();
        }

        $hand = [
            'p1_cards' => $players[0]->getCards(),
            'p1_rank'  => $players[0]->getRankName(),
            'p2_cards' => $players[1]->getCards(),
            'p2_rank'  => $players[1]->getRankName(),
            'winner'   => 0
        ];

        // comparing rank first
        if ($players[0]->getRank() > $players[1]->getRank())
        {
            $hand['winner'] = 1;
        }
        else if ($players[0]->getRank() < $players[1]->getRank())
        {
            $hand['winner'] = 2;
        }
        else
        {
            // if both players has the same rank than we need to check for highest card

            // comparing the winning cards array
            $hand['winner'] = $this->compare($players[0]->getChecksum(), $players[1]->getChecksum());

            // again if both players has the same winning high card than we need to check the
            // kickers card to check if someone is winning
            if($hand['winner'] == 0)
            {
                // comparing the kickers cards array
                $hand['winner'] = $this->compare($players[0]->getKickers(), $players[1]->getKickers());

                // of course can happen that players has same result, than generating an exception.
                if($hand['winner'] == 0)
                {
                    throw new Exception('Unprocessable hand');
                }
            }
        }        

        return $hand;
    }

    /**
     * Comparing high card
     * 
     * @return integer
     */
    public static function compare($x, $y)
    {
        if(count($x) != count($y))
        {
            throw new Exception('Unable to compare array of different size');
        }

        for($i = 0; $i < count($x); $i++)
        {
            if($x[$i] > $y[$i])
            {
                return 1;
            }
            else if($x[$i] < $y[$i])
            {                        
                return 2;
            }
        }

        return 0;
    }
}