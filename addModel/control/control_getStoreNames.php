<?php

/* 
 * just returnes the store names in a select for add model
 */
function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model();

$res = $addModel->getStores($dbCon);
//print_r($res);
echo "<div>Select the store for this model, if the store you are looking for is not listed, please add the store.</div>";

echo "<select id='storeSelect'>";
$storeCount = count($res);
for ($k = 0; $k <= $storeCount - 1; $k++) {
    if ($res[$k]['storeName'] != '') {
        echo "<option value='" . $res[$k]['storeName'] . "'>" . $res[$k]['storeName'] . "</option>";
    }
}
echo "</select>";
