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
        return $add = 'yes';
    }

    function getModel($dbCon, $store) {
        $sql = 'SELECT * FROM model WHERE store="'.$store.'" ORDER BY modelNum ASC';
        $res = $dbCon->select($sql);
        // echo $sql;
        // var_dump($res);
        return $res;
    }

    function getStores($dbCon) {
        $sql = "SELECT * FROM store ORDER BY runWayOrder ASC";
        $res = $dbCon->select($sql);
        return $res;
    }
    function getStoresAlpha($dbCon) {
        $sql = "SELECT * FROM store ORDER BY storeName ASC";
        $res = $dbCon->select($sql);
        return $res;
    }

    function getUserLikes($dbCon, $id) {
        //getting the loged in users likes (well reall you are getting everything about this user).
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $res = $dbCon->select($sql);

        //Lets get the number of models we have
        $sql2 = "SELECT * FROM model ORDER BY modelNum ASC";
        $res2 = $dbCon->select($sql2);
        //This for statement is counting to the number of models
        $res2Count = count($res2) - 1;
        for ($i = 0; $i <= $res2Count; $i++) {
            $arrayLocation = $i + 1;
            $myLikes[$i] = $res[0]["model_$arrayLocation"];
            //echo "<br>".$myLikes[$i].' array='.$i.' ('.$res[0]["model_$arrayLocation"].' model_'.$arrayLocation.')'.'</br>';
        }


        // print_r($res);
        return $myLikes;
    }

    function updateLikes($dbCon, $model, $items, $id) {
        $sql = "UPDATE user SET model_$model = '$items' WHERE id = $id";
        $res = $dbCon->select($sql);
        echo $sql;
        return $res;
    }
    
    
                
   

}
