<?php

class Recipe {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selectRecipe($recipe_id) {
        $sql = "SELECT * FROM recipe WHERE id = $recipe_id";

        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($recipe);
    }

    

    function selectUser($recipe_id, $user_id) {
        $sql = "SELECT user_id FROM recipe WHERE id = $recipe_id";
        
        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);

       if ($user_id == $recipe[0]) { 
            $sql = "SELECT * FROM user WHERE id = user_id";
            $userfetch = mysqli_query($this->connection, $sql);
            $user = mysqli_fetch_array($userfetch, MYSQLI_ASSOC);

            return($user);
       } else {
            echo "user id does not match recipe";
       }
    }
    public function selectIngredient($recipe_id) {

        $sql = "SELECT * FROM ingredient WHERE recipe_id = $recipe_id";
        $ingrfetch = mysqli_query($this->connection, $sql);
        //$ingr = mysqli_fetch_array($ingrfetch, MYSQLI_ASSOC);

        return($this->resultToArray($ingrfetch)); 
        //returns nested array with each entry of the array having an array with the ingredient data in it
    }
    private function calcCalories($recipe_id) {        
        $selection = $this->selectIngredient($recipe_id);
        $total = 0;
        foreach ($selection as $arr) {
            $art_id = $arr["article_id"];
            $amount = $arr["amount"];
            $sql = "SELECT calories FROM article WHERE id = $art_id";
            $calories = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);
            $result = $amount * $calories[0];
            $total += $result;
        }
        return $total;

    }
    private function calcPrice($recipe_id) {
        $selection = $this->selectIngredient($recipe_id);
        $total = 0;
        foreach ($selection as $arr) {
            $art_id = $arr["article_id"];
            $amount = $arr["amount"];
            $sql = "SELECT price FROM article WHERE id = $art_id";
            $price = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);
            $result = $amount * $price[0];
            $total += $result;
        }
        return $total;
    }
    function selectRating($recipe_id) {
        $sql = "SELECT id, date, rating FROM recipeinfo WHERE recipe_id = $recipe_id AND record_type = 'W'";
        $ratingfetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($ratingfetch);
    }
    function selectSteps($recipe_id) {
        $sql = "SELECT id, date, step, steptext FROM recipeinfo WHERE recipe_id = $recipe_id AND record_type = 'B'";
        $stepfetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($stepfetch);
    }
    function selectComments($recipe_id) {
        $sql = "SELECT id, date, commenter_id, comment FROM recipeinfo WHERE recipe_id = $recipe_id AND record_type = 'O'";
        $commentfetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($commentfetch);
    }
    function selectKitchen($recipe_id) {
        $sql = "SELECT kitchen_id FROM recipe WHERE id = $recipe_id";
        $kitchen_id = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);

        $sql = "SELECT * FROM kitchentype WHERE id = $kitchen_id[0] AND record_descriptor = 'K'";
        $kitchenfetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($kitchenfetch);

    }
    function selectType($recipe_id) {
        $sql = "SELECT type_id FROM recipe WHERE id = $recipe_id";
        $type_id = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);

        $sql = "SELECT * FROM kitchentype WHERE id = $type_id[0] AND record_descriptor = 'T'";
        $typefetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($typefetch);
    }
    function determineFavourite($recipe_id, $user_id) {
        $sql = "SELECT id, fav_id FROM recipeinfo WHERE recipe_id = $recipe_id AND record_type = 'F'";
        $favfetch = mysqli_query($this->connection, $sql);
        $arr = $this->resultToArray($favfetch);
        foreach ($arr as $row) {
            if($arr["fav_id"] == $user_id) {
                return true;
            } 
        }
    }
    function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    




}