<?php

namespace TriviaTests;

include __DIR__ . "/../Trivia/Player.php";

use PHPUnit\Framework\TestCase;
use Trivia\Player;


class PlayerTest extends TestCase
{

    /**
     * @test
     */
    public function should_place_is_0_when_new_player()
    {

        $player = new Player();

        $place = $player->getPlace();

        $this->assertEquals(0, $place);

    }


    /**
     * @test
     */
    public function should_purse_is_0_when_new_player()
    {
        $player = new Player();
        $purse = $player->getPurse();
        $this->assertEquals(0, $purse);
    }

    /**
     * @test
     */
    public function should_be_out_of_penaltyBox_when_new_player()
    {
        $player = new Player();
        $isInPenaltyBox = $player->getIsInPenaltyBox();
        $this->assertFalse($isInPenaltyBox);
    }


}
