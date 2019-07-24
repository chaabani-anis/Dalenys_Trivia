<?php

use Trivia\Player;
include_once __DIR__ . '/Player.php';

$notAWinner;

  $aGame = new Game();
  
  $aGame->add(new Player("Chet"));
  $aGame->add(new Player("Pat"));
  $aGame->add(new Player("Sue"));
  
  
  do {
    
    $aGame->roll(rand(0,5) + 1);
    
    if (rand(0,9) == 7) {
      $notAWinner = $aGame->wrongAnswer();
    } else {
      $notAWinner = $aGame->wasCorrectlyAnswered();
    }
    
    
    
  } while ($notAWinner);
  
