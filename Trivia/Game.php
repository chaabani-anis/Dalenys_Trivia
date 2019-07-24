<?php

use Trivia\Player;

function echoln($string)
{
    echo $string . "\n";
}

class Game
{

    const QUESTION_NUMBER_BY_CATEGORY = 50;
    const CASE_COUNT = 12;
    const CATEGORY_POP = "Pop";
    const CATEGORY_SCIENCE = "Science";
    const CATEGORY_SPORTS = "Sports";
    const CATEGORY_ROCK = "Rock";
    private $_players;
    private $_places;
    private $_purses;
    private $_inPenaltyBox;

    private $_popQuestions;
    private $_scienceQuestions;
    private $_sportsQuestions;
    private $_rockQuestions;

    private $_currentPlayer = 0;
    private $_isGettingOutOfPenaltyBox;

    function __construct()
    {

        $this->_players = array();
        $this->_places = array(0);
        $this->_purses = array(0);
        $this->_inPenaltyBox = array(0);

        $this->_popQuestions = array();
        $this->_scienceQuestions = array();
        $this->_sportsQuestions = array();
        $this->_rockQuestions = array();

        for ($i = 0; $i < self::QUESTION_NUMBER_BY_CATEGORY; $i++) {
            array_push($this->_popQuestions, "Pop Question " . $i);
            array_push($this->_scienceQuestions, ("Science Question " . $i));
            array_push($this->_sportsQuestions, ("Sports Question " . $i));
            array_push($this->_rockQuestions, ("Rock Question " . $i));
        }
    }

    function add(Player $player)
    {
        $this->_players[] = $player;
        $this->_places[$this->howManyPlayers()] = 0;
        $this->_purses[$this->howManyPlayers()] = 0;
        $this->_inPenaltyBox[$this->howManyPlayers()] = false;
        echoln($player->getName() . " was added");
        echoln("They are player number " . count($this->_players));
        return true;
    }

    function howManyPlayers()
    {
        return count($this->_players);
    }

    function roll($roll)
    {
        echoln($this->_players[$this->_currentPlayer]->getName() . " is the current player");
        echoln("They have rolled a " . $roll);

        if ($this->_inPenaltyBox[$this->_currentPlayer]) {
            if ($this->isRollOdd($roll)) {
                echoln($this->_players[$this->_currentPlayer]->getName() . " is not getting out of the penalty box");
                $this->_isGettingOutOfPenaltyBox = false;
            } else {
                $this->_isGettingOutOfPenaltyBox = true;

                echoln($this->_players[$this->_currentPlayer]->getName() . " is getting out of the penalty box");
                $this->_movePiece($roll);
                $this->askQuestion();
            }

        } else {

            $this->_movePiece($roll);
            $this->askQuestion();
        }
    }

    function askQuestion()
    {
        if ($this->currentCategory() == self::CATEGORY_POP)
            echoln(array_shift($this->_popQuestions));
        if ($this->currentCategory() == self::CATEGORY_SCIENCE)
            echoln(array_shift($this->_scienceQuestions));
        if ($this->currentCategory() == self::CATEGORY_SPORTS)
            echoln(array_shift($this->_sportsQuestions));
        if ($this->currentCategory() == self::CATEGORY_ROCK)
            echoln(array_shift($this->_rockQuestions));
    }


    function currentCategory()
    {
        $playerPosition = $this->_places[$this->_currentPlayer];
        $caseMap = [
            0 => self::CATEGORY_POP,
            4 => self::CATEGORY_POP,
            8 => self::CATEGORY_POP,
            1 => self::CATEGORY_SCIENCE,
            5 => self::CATEGORY_SCIENCE,
            9 => self::CATEGORY_SCIENCE,
            2 => self::CATEGORY_SPORTS,
            6 => self::CATEGORY_SPORTS,
            10 => self::CATEGORY_SPORTS,
        ];

        return isset($caseMap[$playerPosition])? $caseMap[$playerPosition] : self::CATEGORY_ROCK;
    }

    function wasCorrectlyAnswered()
    {
        if ($this->_inPenaltyBox[$this->_currentPlayer]) {
            if ($this->_isGettingOutOfPenaltyBox) {
                $winner = $this->_wonOnePoint();
                $this->_setNextPlayer();

                return $winner;
            } else {
                $this->_setNextPlayer();
                return true;
            }


        } else {

            $winner = $this->_wonOnePoint();
            $this->_setNextPlayer();

            return $winner;
        }
    }

    function wrongAnswer()
    {
        echoln("Question was incorrectly answered");
        echoln($this->_players[$this->_currentPlayer]->getName() . " was sent to the penalty box");
        $this->_inPenaltyBox[$this->_currentPlayer] = true;

        $this->_setNextPlayer();
        return true;
    }


    function didPlayerWin()
    {
        return $this->_purses[$this->_currentPlayer] != 6;
    }

    /**
     * @param $roll
     */
    private function _movePiece($roll)
    {
        $this->_places[$this->_currentPlayer] = $this->_places[$this->_currentPlayer] + $roll;
        if ($this->_places[$this->_currentPlayer] >= self::CASE_COUNT) {
            $this->_places[$this->_currentPlayer] = $this->_places[$this->_currentPlayer] - self::CASE_COUNT;
        }

        echoln($this->_players[$this->_currentPlayer]->getName()
            . "'s new location is "
            . $this->_places[$this->_currentPlayer]);
        echoln("The category is " . $this->currentCategory());
    }

    /**
     * @param $roll
     * @return bool
     */
    private function isRollOdd($roll): bool
    {
        return $roll % 2 == 0;
    }

    private function _setNextPlayer()
    {
        $this->_currentPlayer++;
        if ($this->_currentPlayer == count($this->_players)) $this->_currentPlayer = 0;
    }

    /**
     * @return bool
     */
    private function _wonOnePoint(): bool
    {
        echoln("Answer was correct!!!!");
        $this->_purses[$this->_currentPlayer]++;
        echoln($this->_players[$this->_currentPlayer]->getName()
            . " now has "
            . $this->_purses[$this->_currentPlayer]
            . " Gold Coins.");

        $winner = $this->didPlayerWin();
        return $winner;
    }

    public function getPlayers()
    {
        return $this->_players;
    }
}
