<?php

class RockPaperScissors {
	public $score = 0;
	public $computerScore = 0;
	public $result = "";
	public $state = "";
	public $array = array("rock", "paper", "scissors");
	public $opponent = "";

	public function play($guess){
		$this->opponent = $this->array[array_rand($this->array)];
		if($guess=="rock"){
			if($this->opponent=="rock"){
				$this->state="it's a tie!";
			}
			if($this->opponent=="paper"){
				$this->state="you lost!";
				$this->computerScore++;
			}
			if($this->opponent=="scissors"){
				$this->state="you won!";
				$this->score++;
			}
		} else if($guess=="paper"){
			if($this->opponent=="rock"){
				$this->state="you won!";
				$this->score++;
			}
			if($this->opponent=="paper"){
				$this->state="it's a tie!";
			}
			if($this->opponent=="scissors"){
				$this->state="you lost!";
				$this->computerScore++;
			}		
		} else{
			if($this->opponent=="rock"){
				$this->state="you lost!";
				$this->computerScore++;
			}
			if($this->opponent=="paper"){
				$this->state="you won!";
				$this->score++;
			}
			if($this->opponent=="scissors"){
				$this->state="it's a tie!";
			}
		}
		$this->result = "Your gave $guess and computer gave $this->opponent, $this->state";
	}
	public function getState()
    {
        return $this->state;
    }
}
?>
