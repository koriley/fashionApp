<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class model {

    function addModel($dbCon, $store, $modNum, $items, $price) {
        $sql = "INSERT INTO model (id, modelNum, items, price, store) VALUES (NULL, '$modNum', '$items', '$price', '$store')";
        $res = $dbCon->select($sql);
        $findRows = 'SELECT * FROM model'; //lets find out how many models we have
        $res1 = $dbCon->select($findRows);
        $myCount = count($res1);

        $updateUserTable = "ALTER TABLE user ADD model_$myCount TEXT NOT NULL"; //adding the new model we will need to be able to delete this later
        $res2 = $dbCon->select($updateUserTable);

        return $add = 'yes';
    }

    function addStore($dbCon, $storeName, $storeLink, $storeImage, $salonName, $salonLink, $salonImage, $order, $desc) {
        $sql = "INSERT INTO store(id, storeName, storeImage, storeLink, salonName, salonImage, salonLink, runwayOrder, storeDesc) VALUES (NULL,'$storeName', '$storeImage', '$storeLink', '$salonName', '$salonImage', '$salonLink', '$order', '$desc')";
        $res = $dbCon->select($sql);
        //echo $sql;
        return $add = 'yes';
    }

    function updatedStore($dbCon, $storeName, $storeLink, $storeImage, $salonName, $salonLink, $salonImage, $order, $id, $desc) {
        //first we need to get the old store name to update the models.
        $sql = 'SELECT storeName FROM store WHERE id="'.$id.'"';
        $storeRes = $dbCon->select($sql);
        if($storeName != $storeRes[0]['storeName']){
            //if the store names are different, we will update the models
            $sql='UPDATE model SET store="'.$storeName.'" WHERE store ="'.$storeRes[0]['storeName'].'"';
            $res = $dbCon->select($sql);
        }
        $sql = 'UPDATE store SET id="' . $id . '", storeName="' . $storeName . '",storeImage="' . $storeImage . '",storeLink="' . $storeLink . '"salonName="' . $salonName . '",salonImage="' . $salonImage . '",salonLink="' . $salonLink . '",runwayOrder="' . $order . '",storeDesc="' . $desc . '" WHERE id=$id';
        $res = $dbCon->select($sql);
        echo $sql;
        return $add = 'yes';
    }

    function getModel($dbCon) {
        $sql = "SELECT * FROM model ORDER BY modelNum ASC";
        $res = $dbCon->select($sql);
        // echo $sql;
        // var_dump($res);
        return $res;
    }

    function getStores($dbCon) {
        $sql = "SELECT * FROM store ORDER BY runwayOrder";
        $res = $dbCon->select($sql);
        return $res;
    }

    function deleteStore($dbCon, $deleteID, $image1, $image2, $name) {
        //first lets find the images and delete those.
        // $path = '../../';
        if ($image1 != '') {
            unlink('../..' . $image1);
        }
        if ($image2 != '') {
            unlink('../..' . $image2);
        }

        $modelSql = "SELECT id FROM model WHERE store='$name'";
        $modelRes = $dbCon->select($modelSql);
        $numOfModelsInStore = count($modelRes) - 1;
        for ($i = 0; $i <= $numOfModelsInStore; $i++) {
            self::deleteModel($dbCon, $modelRes[$i]['id']);
        }
        //$getStoreModels = 
        $sql = 'DELETE FROM store WHERE id="' . $deleteID . '"';
        $res = $dbCon->insert($sql);
    }

    function deleteModel($dbCon, $id) {
        //lets get the number of models so we can delete that last model
        $sql = 'SELECT * from model';
        $res = $dbCon->select($sql);
        $modelCount = count($res);
        //now we are going to remove the last model element from users
        $sql = "ALTER TABLE user DROP model_$modelCount";
        $res = $dbCon->select($sql);
        //now remove the model
        $sql = 'DELETE FROM model WHERE id="' . $id . '"';
        $res = $dbCon->insert($sql);
        //echo $sql;
        return 'yes';
    }

    function updateModelOrder($dbCon, $newOrder) {
        $count = 1;

        foreach ($newOrder as $id) {
            $sql = "UPDATE model SET modelNum = " . $count . " WHERE id = $id";

            $res = $dbCon->select($sql);
            $count++;
        }
        return;
    }

    function updateModel($dbCon, $store, $modNum, $items, $price, $id) {
        $sql = "UPDATE model SET modelNum='" . $modNum . "',items='" . $items . "',price='" . $price . "',store='" . $store . "' WHERE id = '" . $id . "'";

        $res = $dbCon->select($sql);

        //echo $sql;
        return $add = 'yes';
    }

}
