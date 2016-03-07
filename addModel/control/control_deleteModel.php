<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$deleteModel = new model(); //model is the name of the class that will add and update model lists


$id = strip_tags($_GET['id']); //this is the model ID



$res = $deleteModel->deleteModel($dbCon, $id);
//echo count($sepItems);
//print_r($itemPricetogeter);
//print_r($res);
if($res == 'yes'){
    echo "<script> jQuery('#mother').load('addModel/view/view_addModel.php?level='+level+'&userID='+userID);";
}


