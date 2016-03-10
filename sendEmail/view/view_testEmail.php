<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<input type="text" id="emailAddress" placeholder="email" />
<button class="btn" id="sendEmail">Send Email </button>
<div id="response"></div>
<script>
    jQuery('#sendEmail').click(function(){
        var eAddress = jQuery('#emailAddress').val();
        //console.log("sendEmail/control/control_sendEmail.php?emailAD="+eAddress);
        jQuery('#response').load("sendEmail/control/control_sendEmail.php?emailAD="+eAddress);
        
    });
</script>