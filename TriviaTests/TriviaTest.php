<?php
use PHPUnit\Framework\TestCase;
use ApprovalTests\Approvals;
include_once __DIR__ . "/../Trivia/Player.php";
include_once __DIR__ . "/../Trivia/Game.php";



class TriviaTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_and_verify_golden_master()
    {
        $output='';
        for ($seed= 1;$seed < 20 ; $seed++) {
            $output .= $this->getOutput($seed);
        }
        Approvals::VerifyString($output);
    }

    /**
     * @test
     */
    public function should_list_contains_one_player()
    {
        $player = new \Trivia\Player('toto');
        $game = new Game();
        $game->add($player);
        $players = $game->getPlayers();
        $expected = [$player];
        $this->assertEquals($expected, $players);
    }

    /**
     * @return false|string
     */
    protected function getOutput($seed)
    {
        srand($seed);
        ob_start();

        require __DIR__ . "/../Trivia/GameRunner.php";
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
