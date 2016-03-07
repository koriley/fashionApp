<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class forgotPassword{
    
    function getPassword($dbCon, $user, $password){
        $sql = "SELECT password FROM user WHERE email = '$user'";
        $res = $dbCon->select($sql);
        $userPass = $res[0]['password'];
       // print_r($dbCon);
        if(count($res)>0){
            
$subject = 'Your fashionation password was requested';
$message = 'Your 417 fashionation password is '.$userPass;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From:admin@417mag.com";
  $from = 'admin@417mag.com';
mail($user,$subject,$message,$headers,'-f'.$from);
        }
    }
}

$headers = 'From: user@yourdomain.com' . " " .
'Reply-To: user@yourdomain.com' . " " .
'X-Mailer: PHP/' . phpversion();