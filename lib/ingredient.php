<?php

class User {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
     
    public function selectIngredient($ingr_id) {

        $sql = "SELECT * FROM ingredient WHERE id = $ingr_id";
        
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($ingredient);

    }

    private function selectArticle($ingr_id, $art_id) {
        $sql = "SELECT * FROM ingredient WHERE id = $ingr_id";
        
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

       if ($art_id == $ingredient[2]) { 
            $sql = "SELECT * FROM article WHERE id = art_id";
            $stepfetch = mysqli_query($this->connection, $sql);
            $article = mysqli_fetch_array($stepfetch, MYSQLI_ASSOC);

            return($article);
       } else {
            echo "article id does not match ingredient";
       }
        
    }


}
