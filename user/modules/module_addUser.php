<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class addUser{
    
    function addLogin($dbCon, $user, $password, $fname, $lname){
       $sql = "SELECT email FROM user WHERE email = '$user'";
        $res = $dbCon->select($sql);
        $userPass = $res[0]['email'];
        
        if(count($res)>0){
            echo "<div id='passwordClick'>You already have a log in, click here and we will email this address the password.</div>";
            echo "<script>
    jQuery('#passwordClick').click(function(){
        jQuery('#result').load('user/control/control_forgotPassword.php?user=$user');
                  jQuery('#loginBlock').fadeOut();
        jQuery('#mother').load('user/view/view_logIn.php?user=$user').fadeIn();
    });
    
    </script>";
                    
        }
        
        if(count($res)<=0){
            $sql = "INSERT INTO gocoupon_fashionation.user (id, email, password, firstName, lastName) VALUES (NULL, '$user', '$password', '$fname', '$lname');";
       //echo $sql;
        $res = $dbCon->select($sql);
        return $add = 'yes';
        }
        
        
        
        
        
       
        
     
    }
}


