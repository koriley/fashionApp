<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists


$store = strip_tags($_POST['store']);
$modelNum = strip_tags($_POST['modelNum']);
$items = strip_tags($_POST['items']);
$price = strip_tags($_POST['price']);
$id = strip_tags($_POST['id']);


$add = $addModel->updateModel($dbCon, $store, $modelNum, $items, $price, $id);
//echo count($sepItems);
//print_r($itemPricetogeter);
//echo $id;
if($add == 'yes'){
    echo "<script>jQuery('#newResult').load('addModel/control/control_getModel.php');</script>";
}



