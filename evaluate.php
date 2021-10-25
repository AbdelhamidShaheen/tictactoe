<?php



if($_SERVER["REQUEST_METHOD"] == "POST"){
    header('Content-Type: application/json; charset=utf-8');

   echo json_encode($_POST);
}






class game{
 public $staus;
 public $winner;
 public $empty_cells;
 public $full_cells;
}

class player{

function attack(){

}

function defind(){

}

}


?>