<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$checkLogin = new forgotPassword(); 
$uname = strip_tags($_GET['user']);


$exist = $checkLogin->getPassword($dbCon, $uname);
  // print_r($checkLogin);
    //return $exist;
//echo $uname." ".$pword;


