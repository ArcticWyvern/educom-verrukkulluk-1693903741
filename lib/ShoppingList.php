<?php

class ShoppingList {

    private $connection;
    private $list = [];
    public function __construct($connection) {
        $this->connection = $connection;
    }

    function addIngredients($recipe_id, $user_id) {
        $fetch = new Ingredient($this->connection);

        $ingredients = $fetch->selectIngredient($recipe_id); //nested array of ingredients (in case there are multiple)
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