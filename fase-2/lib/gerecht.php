<?php


class gerecht {


    public function selectRecipe() {

        $recipes = [

            [   "id" => 1,
                "title" => "Spaghetti",
                "image" => "https://www.inspiredtaste.net/wp-content/uploads/2019/03/Spaghetti-with-Meat-Sauce-Recipe-1-1200.jpg",
                "ingredients" => [
                    ["id" => 1, "artikel_id" => 1, "recipe_id" => 1, "name" => "Pasta"],
                    ["id" => 2, "artikel_id" => 2, "recipe_id" => 1, "name" => "Saus"],
                    ["id" => 3, "artikel_id" => 3, "recipe_id" => 1, "name" => "Gehakt"],
                ]
            ],

            [   "id" => 2,
                "title" => "Bami",
                "image" => "https://www.leukerecepten.nl/wp-content/uploads/2019/03/bami_v.jpg",
                "ingredients" => [
                    ["id" => 4, "article_id" => 10, "recipe_id" => 1, "name" => "Mie nestjes"],
                    ["id" => 5, "article_id" => 12, "recipe_id" => 1, "name" => "Bami kruiden"],
                    ["id" => 6, "article_id" => 31, "recipe_id" => 1, "name" => "Hamblokjes"],
                ]
            ],
        ];


        return($recipes);


    }



}
