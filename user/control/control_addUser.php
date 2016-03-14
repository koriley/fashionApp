<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addUser = new addUser(); 
$uname = strip_tags($_GET['uname']);
$pword = strip_tags($_GET['pword']);
$fname = strip_tags($_GET['fname']);
$lname = strip_tags($_GET['lname']);



if(filter_var($uname, FILTER_VALIDATE_EMAIL)) {
      $add = $addUser->addLogin($dbCon, $uname, $pword, $fname, $lname);
  // print_r($checkLogin);
    //return $exist;
//echo $uname." ".$pword;

//getting the id of the new user incase we need it
$getUser = new checkLogin();
$id = $getUser->checkUser($dbCon, $uname, $pword);
    }
    else {
        echo "Invalid E-Mail Address";
    }


$myID = $id[1];
//echo $myID;
if($add === 'yes'){
    echo "<script>
        jQuery('#loginBlock').fadeOut();
         //set a cookie to look if the user has already logged in.
        setCookie('fashionUser', $id[1], 365);
        setCookie('fashionPass', '$pword', 365);
        setCookie('fashionLev', $id[0], 365);    
        jQuery('#mother').load('view/view_mainView.php?level=$exist[0]&userID=$exist[1]').fadeIn();
        
        </script>";
    


}
