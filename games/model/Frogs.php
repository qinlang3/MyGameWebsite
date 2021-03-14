<?php

class Frogs {
    public $board = array("red", "red", "red", "empty", "blue", "blue", "blue");
    public $length = 6;
    public $moves = 0;
    public $state = "play";
    public $winning = array();

    public function __construct()
    {
        for($x=0;$x<=$this->length;$x++){
            if($this->board[$x]=="red"){
                $this->winning[]="blue";
            }
            if($this->board[$x]=="empty"){
                $this->winning[]="empty";
            }
            if($this->board[$x]=="blue"){
                $this->winning[]="red";
            }    
        }    
    }
    public function play($frog)
    {
        $frog=$frog-1;
        if($this->board[$frog]=="empty"){ // empty slot
            return;
        }
        if($this->board[$frog]=="red"){ // can only move right
            if($frog+1<=$this->length&&$this->board[$frog+1]=="empty"){
                $this->board[$frog+1]="red";
                $this->board[$frog]="empty";
            }else if($frog+2<=$this->length&&$this->board[$frog+2]=="empty"){
                $this->board[$frog+2]="red";
                $this->board[$frog]="empty";
            }else{
                return;
            }
        }
        if($this->board[$frog]=="blue"){ // can only move left
            if($frog-1>=0&&$this->board[$frog-1]=="empty"){
                $this->board[$frog-1]="blue";
                $this->board[$frog]="empty";
            }else if($frog-2>=0&&$this->board[$frog-2]=="empty"){
                $this->board[$frog-2]="blue";
                $this->board[$frog]="empty";
            }else{
                return;
            }
        }
        $this->moves++;
        // check if won
        if($this->board==$this->winning){
            $this->state="won";
            return;
        }

        // check if stuck
        $stuck=1;
        for($x=0;$x<=$this->length;$x++){
            if($this->board[$x]=="red"){
                if($x<=$this->length-1&&$this->board[$x+1]=="empty"){
                    $stuck=0;
                    break;
                }
                if($x<=$this->length-2&&$this->board[$x+2]=="empty"){
                    $stuck=0;
                    break;
                }
            }
            if($this->board[$x]=="blue"){
                if($x>=1&&$this->board[$x-1]=="empty"){
                    $stuck=0;
                    break;
                }
                if($x>=2&&$this->board[$x-2]=="empty"){
                    $stuck=0;
                    break;
                }
            }
        }
        if($stuck==1){
            $this->state="stuck";
            return;
        }
    }

    public function getState()
    {
        return $this->state;
    }
}

?>