<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class checkLogin{
    
    function checkUser($dbCon, $user, $password){
        $sql = "SELECT password, level,id FROM user WHERE email = '$user'";
        $res = $dbCon->select($sql);
        $userPass = $res[0]['password'];
        $userLevel = $res[0]['level'];
        $userId = $res[0]['id'];
        $userInfo[0] = $userLevel;
        $userInfo[1] = $userId;
       // print_r($dbCon);
        if(count($res)>0){
            if($password === $userPass){
                return $userInfo;
            }
            else{
                echo "There is a problem with your username or password.";
            }
        }
        if(count($res)<=0){
            echo "There is a problem with your username or password.";
        }
    }
}

