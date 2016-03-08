<?php

/* 
 * Capture the editied store information
 */

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model();

$imgDir = '../../images/'; //this is the path for where the image will go, outside the two dir we are in.
$storeName = strip_tags($_POST['storeName']);
$storeLink = $_POST['storeLink'];
$salonName = strip_tags($_POST['salonName']);
$salonLink = $_POST['salonLink'];
$file[0] =  $_FILES['file1']; //these two lines set the file to an array so we can capture both of them.
$file[1] =  $_FILES['file2'];
$order = $_POST['storeOrder'];
$oldStoreImage[0] = $_POST['oldStore'];
$oldStoreImage[1] = $_POST['oldSalon'];
$id = $_POST['id'];

//echo "$storeName, $storeLink, $salonName, $salonLink, ".$file[0]['name'].",". $file[1]['name'].", $order, $oldStoreImage, $oldSalonImage";


if($file[0]!=''){
    uploadImage(0);
}

if($file[1]!=''){
    uploadImage(1);
}
//print_r($oldStoreImage);
$res = $addModel->updatedStore($dbCon, $storeName, $storeLink, $oldStoreImage[0], $salonName, $salonLink, $oldStoreImage[1], $order, $id);

//make the upload file a function and add the ability to delete the old image.
function uploadImage($i){
    global $oldStoreImage;
    global $file;
    //we will start be deleting the old image
    //echo "creating".$file[$i]['name'];
    
    unlink('../..'.$oldStoreImage[$i]);
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
                $oldStoreImage[$i] = "/images/".$file[$i]["name"];
            }
        }
    } else {
        echo "Invalid file";
    }
}


