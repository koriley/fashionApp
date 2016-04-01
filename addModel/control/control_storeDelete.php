<?php

/* 
 * control to delete the store
 */

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model();

$storeDelete = $_POST['deleteStore'];
$image1 = $_POST['delImage1'];
$image2 = $_POST['delImage2'];
$name = $_POST['storeName'];

$res = $addModel->deleteStore($dbCon, $storeDelete, $image1, $image2, $name);
