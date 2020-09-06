<?php

namespace App\Services;

use Exception;

class PokerAnalyzer
{
    /**
     * Analyze pocker hand and return result
     * 
     * @param array  $hand
     * @return array
     */
    public function analyze(array $hand)
    {
        for($i = 0; $i < 2; $i++)
        {
            $players[$i] = new PlayerHand($hand[$i]);
            $players[$i]->analyze();
        }        

        // comparing rank first
        if ($players[0]->getRank() > $players[1]->getRank())
        {
            $winner = 1;
        }
        else if ($players[0]->getRank() < $players[1]->getRank())
        {
            $winner = 2;
        }
        else
        {
            // if both players has the same rank than we need to check for highest card

            // comparing the rank cards array only to try to find a winner by high card
            $winner = $this->compare($players[0]->getRankCards(), $players[1]->getRankCards());

            // again if both players has the same rank high card than we need to check the
            // kicker cards to check if someone is winning
            if($winner == 0)
            {
                // comparing the kickers cards array
                $winner = $this->compare($players[0]->getKickers(), $players[1]->getKickers());

                // of course can happen that players has same result, than generating an exception.
                if($winner == 0)
                {
                    throw new Exception('Unprocessable hand');
                }
            }
        }        

        return [
            'p1_cards' => $players[0]->getCards(),
            'p1_rank'  => $players[0]->getRankName(),
            'p2_cards' => $players[1]->getCards(),
            'p2_rank'  => $players[1]->getRankName(),
            'winner'   => $winner ?? 0
        ];
    }

    /**
     * Comparing high card
     * 
     * @return integer
     */
    public function compare($x, $y)
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