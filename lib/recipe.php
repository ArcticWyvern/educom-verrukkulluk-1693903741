<?php

require_once 'User.php';
require_once 'Ingredient.php';
require_once 'KitchenType.php';
require_once 'RecipeInfo.php';

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


    //takes an array of recipe id's to return multiple recipes. And returns a nested array of all the recipes corresponding to the id's
    public function selectMultiple(array $id_array = []) {
        $sql = "SELECT * FROM recipe WHERE id IN (" . implode(",", $id_array) . ")";
        //implode separates all elements in the array with a given string (in this case a comma) thus converting this array into a string 
        $result = mysqli_query($this->connection, $sql);
        return($this->resultToArray($result));
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
    private function selectRating($recipe_id) {
        $info = new RecipeInfo($this->connection);
        $info->selectInfo($recipe_id, "W"); 

        return $info->selectInfo($recipe_id, "W");
    }
    private function selectSteps($recipe_id) {
        $info = new RecipeInfo($this->connection);
        $info->selectInfo($recipe_id, "B"); 

        return $info->selectInfo($recipe_id, "B");
    }
    private function selectComments($recipe_id) {
        $info = new RecipeInfo($this->connection);
        $info->selectInfo($recipe_id, "O"); 

        return $info->selectInfo($recipe_id, "O");
    }
    private function selectKitchen($recipe_id) {
        $sql = "SELECT kitchen_id FROM recipe WHERE id = $recipe_id";
        $kitchen_id = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);

        $kitchenfetch = new KitchenType($this->connection); 
        $selected = $kitchenfetch->selectKitchenType($kitchen_id[0]);

        if ($selected["record_descriptor"] == "K") {
            return $selected;
        }
    }
    private function selectType($recipe_id) {
        $sql = "SELECT type_id FROM recipe WHERE id = $recipe_id";
        $type_id = mysqli_fetch_array(mysqli_query($this->connection, $sql), MYSQLI_ASSOC);

        $sql = "SELECT * FROM kitchentype WHERE id = $type_id[0] AND record_descriptor = 'T'";
        $typefetch = mysqli_query($this->connection, $sql);
        return $this->resultToArray($typefetch);
    }
    private function determineFavourite($recipe_id, $user_id) {
        $sql = "SELECT id, fav_id FROM recipeinfo WHERE recipe_id = $recipe_id AND record_type = 'F'";
        $favfetch = mysqli_query($this->connection, $sql);
        $arr = $this->resultToArray($favfetch);
        foreach ($arr as $row) {
            if($row["fav_id"] == $user_id) {
                return true;
            } 
        }
        return false;
    }


    private function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
}