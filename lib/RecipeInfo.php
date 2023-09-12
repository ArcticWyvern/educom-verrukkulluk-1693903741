<?php

class RecipeInfo {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selectInfo($recipe_id, $record_type) {

        $sql = "SELECT id, record_type, recipe_id, user_id, date FROM recipeinfo WHERE recipe_id = $recipe_id";
        
        $result = mysqli_query($this->connection, $sql);
        $infoarr = $this->resultToArray($result);



        foreach ($infoarr as $recipeinfo) 
            {
                if($recipeinfo["record_type"] == $record_type) {
                    switch ($recipeinfo["record_type"]) {
                    case "O": //comment
                        $queryone = "SELECT commenter_id, comment FROM recipeinfo WHERE id = $recipeinfo[0]";
                        $commentfetch = mysqli_query($this->connection, $queryone);
                        $comment = mysqli_fetch_array($commentfetch, MYSQLI_ASSOC);
                        $querytwo = "SELECT * FROM user WHERE id = $comment[0]";
                        $user = mysqli_query($this->connection, $querytwo);
                        $append = mysqli_fetch_array($user, MYSQLI_ASSOC);

                        foreach ($append as $value) {
                            array_push($recipeinfo, $value);
                        }

                    case "F": //favourite
                        $queryone = "SELECT fav_id FROM recipeinfo WHERE id = $recipeinfo[0]";
                        $favfetch = mysqli_query($this->connection, $queryone);
                        $fav = mysqli_fetch_array($favfetch, MYSQLI_ASSOC);
                        $querytwo = "SELECT * FROM user WHERE id = $fav[0]";
                        $user = mysqli_query($this->connection, $querytwo);
                        $append = mysqli_fetch_array($user, MYSQLI_ASSOC);

                        foreach ($append as $value) {
                            array_push($recipeinfo, $value);
                        }

                    case "B": //recipe step
                        $queryone = "SELECT step, step_text FROM recipeinfo WHERE id = $recipeinfo[0]";
                        $stepfetch = mysqli_query($this->connection, $queryone);
                        $append = mysqli_fetch_array($stepfetch, MYSQLI_ASSOC);

                        foreach ($append as $value) {
                            array_push($recipeinfo, $value);
                        }

                    case "W": //rating
                        $queryone = "SELECT rating FROM recipeinfo WHERE id = $recipeinfo[0]";
                        $ratingfetch = mysqli_query($this->connection, $queryone);
                        $append = mysqli_fetch_array($ratingfetch, MYSQLI_ASSOC);
                    
                        foreach ($append as $value) {
                            array_push($recipeinfo, $value);
                        }
                }
            }
        }
        return($infoarr);

    }

    function addFavourite($info_id, $fav_id) {
        
        $sql = "UPDATE recipeinfo SET fav_id = $fav_id WHERE id = $info_id";
        try {
                $this->connection->exec($sql);
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        
    }

    function deleteFavourite($info_id, $fav_id) {
        $sql = "UPDATE recipeinfo SET fav_id = NULL WHERE id = $info_id";
        try {
                $this->connection->exec($sql);
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
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
