<?php

namespace Tests\Unit;

use App\Services\PokerAnalyzer;
use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    /**
     * Test player one winning with royal flush.
     *
     * @return void
     */
    public function testPlayerOneRoyalFlush()
    {
        $hand = [
            ['TS', 'JS', 'QS', 'KS', 'AS'], 
            ['4C', '5C', '6C', '7C', '8C']
        ];

        $analyzer = new PokerAnalyzer;
        $result = $analyzer->analyze($hand);
        
        $this->assertTrue($result['p1_rank'] == 'RoyalFlush');
        $this->assertTrue($result['winner'] == 1);        
    }

    /**
     * Test player one winning with straight flush.
     *
     * @return void
     */
    public function testPlayerOneStraightFlush()
    {
        $hand = [
            ['5H', '6H', '7H', '8H', '9H'], 
            ['4C', '5C', '6C', '7C', '8C']
        ];

        $analyzer = new PokerAnalyzer;
        $result = $analyzer->analyze($hand);        
        
        $this->assertTrue($result['p1_rank'] == 'StraightFlush');
        $this->assertTrue($result['winner'] == 1);
    }
    
    /**
     * Test player one winning with four of a kind.
     *
     * @return void
     */
    public function testPlayerOneFourOfAKind()
    {
        $hands = [
            [
                ['QS', 'QH', 'QC', 'QD', '9H'], 
                ['2C', '5H', '6C', '9S', '8D']
            ],
            [
                ['QS', 'QH', 'QC', 'QD', '9H'], 
                ['JS', 'JH', 'JC', 'JD', 'TH']
            ]
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);
            $this->assertTrue($result['p1_rank'] == 'FourOfAKind');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with full house.
     *
     * @return void
     */
    public function testPlayerOneFullHouse()
    {
        $hands = [
            [
                ['TH', 'TC', 'TD', 'JC', 'JD'],
                ['2C', '5H', '6C', '9S', '8D']
            ],
            [
                ['TH', 'TC', 'TD', 'JC', 'JD'],
                ['7H', '7C', '7D', '8C', '8D']
            ]
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);
            $this->assertTrue($result['p1_rank'] == 'FullHouse');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with flush.
     *
     * @return void
     */
    public function testPlayerOneFlush()
    {
        $hands = [
            [
                ['2D', '5D', '7D', 'JD', 'KD'],
                ['2C', '5H', '6C', '9S', '8D']
            ],
            [
                ['2D', '5D', '7D', 'JD', 'KD'],
                ['2C', '5C', '7C', 'JC', 'QC'],
            ]
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);
            $this->assertTrue($result['p1_rank'] == 'Flush');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with straight.
     *
     * @return void
     */
    public function testPlayerOneStraight()
    {
        $hands = [
            [
                ['7S', '8H', '9D', 'TC', 'JH'],
                ['2C', '5H', '6C', '9S', '8D']
            ],
            [
                ['7S', '8H', '9D', 'TC', 'JH'],
                ['6S', '7H', '8D', '9C', 'TH'],
            ]
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);
            $this->assertTrue($result['p1_rank'] == 'Straight');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with straight.
     *
     * @return void
     */
    public function testPlayerOneThreeOfAKind()
    {
        $hands = [
            [
                ['6H', '6C', '6D', 'TC', 'JH'],
                ['2C', '5H', '6C', '9S', '8D']
            ],
            [
                ['6H', '6C', '6D', 'TC', 'JH'],
                ['5C', '5H', '5D', '9S', '8D'],
            ]
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);            
            $this->assertTrue($result['p1_rank'] == 'ThreeOfAKind');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with straight.
     *
     * @return void
     */
    public function testPlayerOneTwoPair()
    {
        $hands = [
            [
                ['5S', '5H', 'AC', 'AD', '6D'], 
                ['4C', '4D', 'JS', 'JH', '5C']
            ],
            [
                ['5S', '5H', 'AC', 'AD', '6D'], 
                ['4C', '4D', 'AS', 'AH', '5C']
            ],
            [
                ['5S', '5H', 'AC', 'AD', '6D'], 
                ['5C', '5D', 'AS', 'AH', '4C']
            ],
            // [
            //     ['5S', '5H', 'AC', 'AD', '6D'], 
            //     ['5C', '5D', 'AS', 'AH', '6C']
            // ],
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);            
            $this->assertTrue($result['p1_rank'] == 'TwoPair');
            $this->assertTrue($result['winner'] == 1);
        }
    }

    /**
     * Test player one winning with straight.
     *
     * @return void
     */
    public function testPlayerOneOnePair()
    {
        $hands = [
            [
                ['5S', '5H', 'AC', 'KD', '6D'], 
                ['4C', '3D', 'KS', 'JH', '5C']
            ],
            [
                ['5S', '5H', 'AC', 'KD', '6D'], 
                ['4C', '4D', 'KS', 'AH', '5C']
            ],
            [
                ['5S', '5H', 'AC', 'KD', '6D'], 
                ['5C', '5D', 'KS', 'QH', '3C']
            ],
        ];        

        $analyzer = new PokerAnalyzer;

        foreach($hands as $hand)
        {
            $result = $analyzer->analyze($hand);
            // dd($result);
            $this->assertTrue($result['p1_rank'] == 'OnePair');
            $this->assertTrue($result['winner'] == 1);
        }
    }
}
