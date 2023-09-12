<?php

require_once("lib/database.php");
require_once("lib/article.php");

/// INIT
$db = new Database();
$art = new Article($db->getConnection());


/// VERWERK 
$data = $art->selectArticle(1);

/// RETURN
echo var_dump($data);