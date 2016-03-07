<?php

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists
$id = strip_tags($_POST['id']);
$model = strip_tags($_POST['model']);
$items = strip_tags($_POST['likes']);
echo $id;

$res = $addModel->updateLikes($dbCon, $model, $items, $id);