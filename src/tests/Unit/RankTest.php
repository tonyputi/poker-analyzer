<?php

namespace Tests\Unit;

use App\Services\PlayerHand;
use PHPUnit\Framework\TestCase;

class RankTest extends TestCase
{
    /**
     * Test for valid royal flush
     *
     * @return void
     */
    public function testRoyalFlush()
    {
        $player = new PlayerHand(['TS', 'JS', 'QS', 'KS', 'AS']);

        $this->assertTrue($player->hasRoyalFlush());
    }

    /**
     * Test for valid straight flush
     *
     * @return void
     */
    public function testStraightFlush()
    {
        $player = new PlayerHand(['5H', '6H', '7H', '8H', '9H']);

        $this->assertTrue($player->hasStraightFlush());
    }

    /**
     * Test for valid four of a kind
     *
     * @return void
     */
    public function testFourOfAKind()
    {
        $player = new PlayerHand(['QS', 'QH', 'QC', 'QD', '5H']);

        $this->assertTrue($player->hasFourOfAKind());
    }

    /**
     * Test for valid full house
     *
     * @return void
     */
    public function testFullHouse()
    {
        $player = new PlayerHand(['TH', 'TC', 'TD', 'JC', 'JD']);

        $this->assertTrue($player->hasFullHouse());
    }

    /**
     * Test for valid flush
     *
     * @return void
     */
    public function testFlush()
    {
        $player = new PlayerHand(['2D', '5D', '7D', 'JD', 'KD']);

        $this->assertTrue($player->hasFlush());
    }

    /**
     * Test for valid straight
     *
     * @return void
     */
    public function testStraight()
    {
        $player = new PlayerHand(['7C', '8H', '9D', 'TC', 'JH']);

        $this->assertTrue($player->hasStraight());
    }

    /**
     * Test for valid three of a kind
     *
     * @return void
     */
    public function testThreeOfAKind()
    {
        $player = new PlayerHand(['6H', '6C', '6D', '4C', '5H']);

        $this->assertTrue($player->hasThreeOfAKind());
    }

    /**
     * Test for valid two pair
     *
     * @return void
     */
    public function testTwoPair()
    {
        $player = new PlayerHand(['5S', '5H', 'AC', 'AD', '8H']);

        $this->assertTrue($player->hasTwoPair());
    }

    /**
     * Test for valid one pair
     *
     * @return void
     */
    public function testOnePair()
    {
        $player = new PlayerHand(['KS', 'KH', 'AC', '2D', '8H']);

        $this->assertTrue($player->hasOnePair());
    }
}
