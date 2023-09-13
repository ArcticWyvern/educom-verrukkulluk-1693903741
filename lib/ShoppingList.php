<?php

class ShoppingList {

    private $connection;
    private $list = [];
    public function __construct($connection) {
        $this->connection = $connection;
    }

    private function selectUser($recipe_id) {
        $sql = "SELECT user_id FROM recipe WHERE id = $recipe_id";
        
        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user_id = $recipe[0]; 
        $user = new User($this->connection);

        return($user->selectUser($user_id));
    }

    private function selectIngredient($recipe_id) {
        $ingrfetch = new Ingredient($this->connection);
        //$ingr = mysqli_fetch_array($ingrfetch, MYSQLI_ASSOC);

        return($ingrfetch->selectIngredient($recipe_id)); 
        //returns nested array with each entry of the array having an array with the ingredient data in it
    }

    function addIngredients($recipe_id, $user_id) {
        $ingredients = $this->selectIngredient($recipe_id); 
        
        
        foreach ($ingredients as $ingredient) {
            if (is_array($this->articleOnList($ingredient["article_id"], $user_id))) {
                foreach ($list as &$entry){
                    $entry['amount'] += $ingredient['amount'];
                }
            } else {
                array_push($list, $ingredient);
            }
        }
    }



    private function articleOnList($article_id, $user_id) {
        $groceries = $this->retrieveGroceries($user_id); //placeholder

        foreach ($groceries as $art) {
            if ($art == $article_id){
                return $art;
            }
        }

        return false;

    }

    private function retrieveGroceries($user_id) {
        return []; //placeholder
    }

    private function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
}



















?>