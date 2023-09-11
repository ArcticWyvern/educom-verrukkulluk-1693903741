<?php

require_once("lib/database.php");
require_once("lib/article.php");

/// INIT
$db = new database();
$art = new article($db->getConnection());


/// VERWERK 
$data = $art->selectArticle(1);

/// RETURN
echo var_dump($data);