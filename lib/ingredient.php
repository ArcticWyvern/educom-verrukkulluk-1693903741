<?php

require_once 'Article.php';

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

    private function selectArticle($article_id) {
        $article = new Article($this->connection);

        return($article->selectArticle($article_id));
       
        
    }
    private function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }


}
