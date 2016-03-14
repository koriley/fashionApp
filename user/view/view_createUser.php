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
<div class="login-block createUser" id="loginBlock">
    <h1>Create User</h1>
    <input type="text" value="" placeholder="E-Mail Address" id="username" />
    <input type="text" value="" placeholder="Password" id="password" />
    <input type="text" value="" placeholder="First Name" id="fname" />
    <input type="text" value="" placeholder="Last Name" id="lname" />

    <!-- silverpop email stuff. -->
    
       

    <input type="hidden" name="formSourceName" value="StandardForm" />
    <!-- DO NOT REMOVE HIDDEN FIELD sp_exp -->
    <input type="hidden" name="sp_exp" value="yes" />
    <input type="hidden" name="fashionation" id="control_COLUMN55" value="Yes" />
    <input type="hidden" name="fashApp2016" id="control_COLUMN66" value="Yes" />

    <button id="submit" >Create User</button>

<div id="result"></div>
<script>
    jQuery('#submit').click(function () {
        var uname = jQuery('#username').val();
        var pword = jQuery('#password').val();
        var fname = jQuery('#fname').val();
        var lname = jQuery('#lname').val();
        var spHfashApp = 'yes';
        var spHspExp = 'yes';
        var spHFashionation = 'yes';
        var spFormSource = jQuery("input[name='formSourceName']").val();
        //alert("clicked uname = "+uname+" and password is "+pword);
        var spURL = 'http://417mag.mkt7054.com/Fashionation/fashWebApp2016';
        
        jQuery.post(spURL, {Email:uname, 'First Name':fname, 'Last Name':lname, formSourceName:spFormSource,sp_exp:spHspExp, fashionation:spHFashionation, fashApp2016:spHfashApp}, function(){
      
      }).fail(function(){
          jQuery('#result').load("user/control/control_addUser.php?uname=" + uname + "&pword=" + pword + "&fname=" + fname + "&lname=" + lname);
      });
    });
</script>