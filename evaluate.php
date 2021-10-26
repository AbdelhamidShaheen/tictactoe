<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json; charset=utf-8');

    $game = new game($_POST);
    if (!$game->status) {

        $player = new player($game);
        $game = $player->play();
    }
    echo json_encode($game);
}

class game
{
    public $status;
    //status 0=>incomplete 1=>winner 2=>loaser 3=>draw
    public $winner;
    public $empty_cells;
    public $full_cells;
    public $next;
    private $cells;

    public static $data_set = [
        ["cell1", "cell2", "cell3"],
        ["cell4", "cell5", "cell6"],
        ["cell7", "cell8", "cell9"],
        ["cell1", "cell4", "cell7"],
        ["cell2", "cell5", "cell8"],
        ["cell3", "cell6", "cell9"],
        ["cell3", "cell5", "cell7"],
        ["cell1", "cell5", "cell9"],
    ];
    public $resulted_set;

    public function __construct($cells)
    {
        $this->cells = $cells;
        $this->resulted_set = [];
        //sort full and empty cells
        $this->sortCells();
        // fill  data_set
        $this->fillDataSet();
        // check game status
        $this->checkGameStatus();

    }

    private function sortCells()
    {

        foreach ($this->cells as $key => $cell) {
            if (empty($cell)) {
                $this->empty_cells[$key] = $cell;
            } else {
                $this->full_cells[$key] = $cell;
            }
        }

    }

    public function checkGameStatus()
    {
        $this->status = 0;
        if ($value = $this->is_there_winner()) {
            $this->status = $value;
        } elseif (count($this->full_cells) == 9) {
            $this->status = 3;
        }

    }

    private function is_there_winner()
    {

        foreach ($this->resulted_set as $set) {

            $count = array_count_values($set);

            if (key_exists("x", $count) && $count["x"] == 3) {
                $this->winner = $set;
                return 1;
            } elseif (key_exists("o", $count) && $count["o"] == 3) {
                $this->winner = $set;
                return 2;
            }

        }

        return 0;

    }

    private function fillDataSet()
    {

        foreach (self::$data_set as $set) {
            $new_set = [];
            foreach ($set as $cell) {
                $new_set[$cell] = $this->cells[$cell];

            }
            array_push($this->resulted_set, $new_set);

        }

    }

}

class player
{
    public $game;
    public function __construct($game)
    {
        $this->game = $game;

        
        if($this->plan1()){
          $this->game->checkGameStatus();
        }elseif($this->plan2()){
          $this->game->checkGameStatus();
        }elseif($this->plan3()){
          $this->game->checkGameStatus();
        }else {
          $this->plan4();
        }

       
    }

  

    private function plan1()
    {

        foreach ($this->game->resulted_set as $key => $set) {

            $count = array_count_values($set);

            if (key_exists("o", $count) && $count["o"] == 2 && !key_exists("x", $count)) {
                $empty_cell = array_search("", $set);
                $this->game->resulted_set[$key][$empty_cell] = "o";
                $this->game->next = $empty_cell;
                return 1;
            }
            return 0;
        }

        return 0;
    }
    private function plan2()
    {

        foreach ($this->game->resulted_set as $key => $set) {

            $count = array_count_values($set);

            if (key_exists("x", $count) && $count["x"] == 2 && !key_exists("o", $count)) {
                $empty_cell = array_search("", $set);
                $this->game->resulted_set[$key][$empty_cell] = "o";
                $this->game->next = $empty_cell;
                return 1;
            }

        }

        return 0;
    }
    private function plan3()
    {

        foreach ($this->game->resulted_set as $key => $set) {

            $count = array_count_values($set);

            if (key_exists("o", $count) && $count["o"] == 1 && !key_exists("x", $count)) {
                $empty_cell = array_search("", $set);
                $this->game->resulted_set[$key][$empty_cell] = "o";
                $this->game->next = $empty_cell;
                return 1;
            }

        }

        return 0;

    }

    private function plan4()
    {

        $empty_cell = array_search("", $this->game->empty_cells);

        $this->game->next = $empty_cell;

    }

    public function play()
    {
        return $this->game;
    }

}
