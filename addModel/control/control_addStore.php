<?php
function __autoload($class_name) {
    include '../modules/module_'.$class_name . '.php';
    
        
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists

$imgDir = '../../images/'; //this is the path for where the image will go, outside the two dir we are in.
$storeName = strip_tags($_POST['storeName']);
$storeLink = $_POST['storeLink'];
$salonName = strip_tags($_POST['salonName']);
$salonLink = $_POST['salonLink'];
$file[0] =  $_FILES['file1']; //these two lines set the file to an array so we can capture both of them.
$file[1] =  $_FILES['file2'];
$order = $_POST['storeOrder'];



//this for only runs twice, it is uploading our two images and setting a array for the location
for ($i = 0; $i <= 1; $i++) {
    $imageFileType = pathinfo($imgDir.$file[$i],PATHINFO_EXTENSION);
    //we are only allowing certin types of images.
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $file[$i]["name"]);
    $extension = end($temp);
    if ((($file[$i]["type"] == "image/gif") || ($file[$i]["type"] == "image/jpeg") || ($file[$i]["type"] == "image/jpg") || ($file[$i]["type"] == "image/pjpeg") || ($file[$i]["type"] == "image/x-png") || ($file[$i]["type"] == "image/png")) && ($file[$i]["size"] < 200000) && in_array($extension, $allowedExts)) {
        if ($file[$i]["error"] > 0) {
            echo "Return Code: " . $file[$i]["error"] . "<br>";
        } else {
            $filename = $file[$i];
            //these echos are examples of other information we can get from the $_FILES var.
            //echo "Upload: " . $file[$i]["name"] . "<br>";
            //echo "Type: " . $file[$i]["type"] . "<br>";
            //echo "Size: " . ($file[$i]["size"] / 1024) . " kB<br>";
            //echo "Temp file: " . $file[$i]["tmp_name"] . "<br>";

            if (file_exists($imgDir . $filename)) {
                echo $filename . " already exists. ";
            } else {
                move_uploaded_file($file[$i]["tmp_name"], "../../images/".$file[$i]["name"]); //the move of the file to its location
                //echo "Stored in: " . "../../images/".$file[$i]["name"];
                $imagPath[$i] = "/images/".$file[$i]["name"];
            }
        }
    } else {
        echo "Invalid file";
    }
}

//echo "$storeName, $storeLink, $imagPath[0], $salonName, $salonLink, $imagPath[1], $order";

$add = $addModel->addStore($dbCon, $storeName, $storeLink, $imagPath[0], $salonName, $salonLink, $imagPath[1], $order);
//echo count($sepItems);
//print_r($itemPricetogeter);
if($add == 'yes'){
   // echo "<script>jQuery('#newResult').load('addModel/control/control_getModel.php');</script>";
}



