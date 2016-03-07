<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$checkLogin = new checkLogin(); //this is confusing, but there is a module called checkLogin
$uname = strip_tags($_GET['uname']);
$pword = strip_tags($_GET['pword']);

$exist = $checkLogin->checkUser($dbCon, $uname, $pword);
  // print_r($checkLogin);
    //return $exist;
//echo $uname." ".$pword;

if($exist[0] >= 1){
    echo "<script>
        jQuery('#loginBlock').fadeOut();
        //set a cookie to look if the user has already logged in.
        setCookie('fashionUser', $exist[1], 365);
        setCookie('fashionPass', '$pword', 365);
        setCookie('fashionLev', $exist[0], 365);    
        jQuery('#mother').load('view/view_mainView.php?level=$exist[0]&userID=$exist[1]').fadeIn();
        
        </script>";
    


}
