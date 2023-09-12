<?php

class Ingredient {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
     
    public function selectIngredient($recipe_id) {

        $sql = "SELECT * FROM ingredient WHERE recipe_id = $recipe_id";
        $ingrfetch = mysqli_query($this->connection, $sql);
        //$ingr = mysqli_fetch_array($ingrfetch, MYSQLI_ASSOC);

        return($this->resultToArray($ingrfetch));

    }

    private function selectArticle($ingr_id, $art_id) {
        $sql = "SELECT article_id FROM ingredient WHERE id = $ingr_id";
        
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

       if ($art_id == $ingredient[0]) { 
            $sql = "SELECT * FROM article WHERE id = art_id";
            $stepfetch = mysqli_query($this->connection, $sql);
            $article = mysqli_fetch_array($stepfetch, MYSQLI_ASSOC);

            return($article);
       } else {
            echo "article id does not match ingredient";
       }
        
    }
    private function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }


}
