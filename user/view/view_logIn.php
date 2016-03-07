<?php

$uname = strip_tags($_GET['user']);
if($uname !=''){
    echo "<script>jQuery('#username').val('$uname');</script>";
}

?>

<div class="login-block" id="loginBlock">
                    <h1>Login</h1>
                    <input type="text" value="" placeholder="E-Mail Address" id="username" />
                    <input type="password" value="" placeholder="Password" id="password" />
                    <div  class=buttonContainer" style='width:100%;'><div class='buttonDiv'>
                    <button id='create' style='display:inline;'>Create Account</button></div>
                     <div class='buttonDiv'>
                    <button id="submit" style='display:inline;'>Submit</button></div>
                    </div>
                </div>
                
                <div id="result"></div>
                
                
                <script>
                    jQuery('#submit').click(function(){
                 var uname = jQuery('#username').val();
                 var pword = jQuery('#password').val();
                            //alert("clicked uname = "+uname+" and password is "+pword);
                            jQuery('#result').load("user/control/control_checkLogin.php?uname="+uname+"&pword="+pword);
                        });
                       
    //this checks if enterwas pushed.
                       jQuery('#password').keypress(function(e){
        if(e.which === 13){//Enter key pressed
            
            jQuery('#submit').click();//Trigger search button click event
        }
    });
                        
                    jQuery('#create').click(function(){
                        var uname = jQuery('#username').val();
                 var pword = jQuery('#password').val();
                        jQuery('#mother').load("user/view/view_createUser.php?uname="+uname+"&pword="+pword);
                    });    
                    </script>
