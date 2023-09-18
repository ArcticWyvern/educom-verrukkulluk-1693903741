<?php

class ShoppingList {

    private $connection;
    private $list = [];
    public function __construct($connection) {
        $this->connection = $connection;
    }

    
    public function selectShoppingList($user_id) {
        $sql = "SELECT * FROM shoppinglist WHERE user_id = $user_id";
        $listFetch = mysqli_query($this->connection, $sql);

        return $this->resultToArray($listFetch);
    }


    public function addIngredients($recipe_id, $user_id) {
        $ingredients = $this->selectIngredient($recipe_id); 
        
        foreach ($ingredients as $ingredient) {
            if (is_array($this->articleOnList($ingredient["article_id"], $user_id))) {
                $listItem = $this->articleOnList($ingredient["article_id"], $user_id);
                $amountTotal = $ingredient["amount"] + $listItem["amount"];
                $item_id = $listItem["id"];

                $updateQuery = "UPDATE shoppinglist SET amount = $amountTotal WHERE id = $item_id";

                mysqli_query($this->connection, $updateQuery);
            } else {

                $ingr_id = $ingredient["id"];
                $amount = $ingredient["amount"];
                $addIngrToList = "INSERT INTO shoppinglist (ingredient_id, user_id, amount) VALUES ($ingr_id, $user_id, $amount)";
                mysqli_query($this->connection, $addIngrToList);
            }
        } 
    }



    private function articleOnList($article_id, $user_id) {
        $sql = "SELECT * FROM shoppinglist WHERE user_id = $user_id";
        $listfetch = mysqli_query($this->connection, $sql);
        $articlesonlist = $this->resultToArray($listfetch);

        foreach ($articlesonlist as $article) {
            $ingr_id = $article ["ingredient_id"];

            $ingrQuery = "SELECT article_id FROM ingredients WHERE id = $ingr_id";
            
            $ingrFetch = mysqli_query($this->connection, $ingrQuery);
            $ingr = mysqli_fetch_array($ingrFetch, MYSQLI_ASSOC);

            $article_id = $ingr["article_id"];

            $artQuery = "SELECT * FROM article WHERE id = $article_id";
        
            $artFetch = mysqli_query($this->connection, $artQuery);
            $art = mysqli_fetch_array($artFetch, MYSQLI_ASSOC);

            if ($art["id"] == $article_id) {
                return $article;
            }
        }   //room for improvement

        return false;

    }

    private function selectUser($list_id) {
        $sql = "SELECT user_id FROM shoppinglist WHERE id = $list_id";
        
        $result = mysqli_query($this->connection, $sql);

        $list = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user_id = $list[0]; 
        $user = new User($this->connection);

        return($user->selectUser($user_id));
    }

    private function selectIngredient($recipe_id) {
        $ingrFetch = new Ingredient($this->connection);
        //$ingr = mysqli_fetch_array($ingrfetch, MYSQLI_ASSOC);

        return($ingrFetch->selectIngredient($recipe_id)); 
        //returns nested array with each entry of the array having an array with the ingredient data in it
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