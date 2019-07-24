<?php

namespace Trivia;

class Player
{

    private $_place;
    private $_purse;
    private $_inPenaltyBox;
    private $_playerName;


    /**
     * Player constructor.
     */
    public function __construct($playerName)
    {
        $this->_place = 0;
        $this->_purse = 0;
        $this->_inPenaltyBox = false;
        $this->_playerName = $playerName;
    }

    public function getPlace()
    {
        return $this->_place;
    }

    public function getPurse()
    {
        return $this->_purse;
    }

    public function getIsInPenaltyBox()
    {
        return $this->_inPenaltyBox;
    }

    public function getName()
    {
        return $this->_playerName;
    }


}