<?php
function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}
include_once('../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model();

$stores = $addModel->getStoresAlpha($dbCon);
//print_r($stores);
$numStores = count($stores)-1;
echo "<nav id='menu'>
                <ul id='menuUL'>";
for($z=0;$z<=$numStores;$z++){
    $storeName[$z] = $stores[$z]['storeName'];
    
    $anchor[$z] = str_replace("&", "and", $storeName[$z]);
    $anchor[$z] = str_replace("1", "", $anchor[$z]);
    $anchor[$z] = str_replace(" ", "_", $anchor[$z]);
    echo '<a href="http://417fashionation.com/#'.$anchor[$z].'"><li class="menuItemLI">'.str_replace("1", "", $storeName[$z]).'</li></a>';
}

 echo "</ul>
            </nav>";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

