<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$uname = strip_tags($_GET['uname']);
$pword = strip_tags($_GET['pword']);

    echo "<script>jQuery('#username').val('$uname');"
            . "jQuery('#password').val('$pword');"
            . "</script>";

?>
<div class="login-block" id="loginBlock">
    <h1>Create User</h1>
<input type="text" value="" placeholder="E-Mail Address" id="username" />
<input type="text" value="" placeholder="Password" id="password" />
<input type="text" value="" placeholder="First Name" id="fname" />
<input type="text" value="" placeholder="Last Name" id="lname" />
<button id="submit" >Create User</button>
</div>
<div id="result"></div>
<script>
    jQuery('#submit').click(function(){
        var uname = jQuery('#username').val();
        var pword = jQuery('#password').val();
        var fname = jQuery('#fname').val();
        var lname = jQuery('#lname').val();
                            //alert("clicked uname = "+uname+" and password is "+pword);
        jQuery('#result').load("user/control/control_addUser.php?uname="+uname+"&pword="+pword+"&fname="+fname+"&lname="+lname);
    });
    </script>