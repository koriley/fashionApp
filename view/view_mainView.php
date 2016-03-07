<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$level = strip_tags($_GET['level']);
$id = strip_tags($_GET['userID']);
//echo $id;
if($level < 3){
    echo "<script>jQuery('#edit').remove();</script>";
}
else{
    echo "<script>
    jQuery('#edit').click(function(){
        jQuery('#mother').load('addModel/view/view_addModel.php?level=$level&userID=$id');
    });
    </script>";
}
echo "<script> var userID='$id'; </script>";
?>
<div id="edit" class="adminEdit"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>edit</div>
<!-- this is the ads above the form-->
<div class="headImage top" >
    <img  src="/img/Fashionation16_WebAppHeader2.png" />
</div>
<div class="welcomText" style="text-align: center; max-width:400px; margin:auto;">
    <span style='font-weight:bold'>WELCOME TO THE #417FASHIONATION STYLE GUIDE!</span><br/>
    Follow along with the runway show and click to star the fashions you love below. We'll email you everything you liked at the end of the night!
</div>
<div class="headImage" >
    <img  src="/img/Fashionation16_WebAppSponsors.png" />
</div>
<div class="headImage" >
    <img  src="/img/Fashionation16_WebApp_BlackBar.png" />
</div>
<div id='userView' class="userView"></div>
<script>
    jQuery('#userView').load('control/control_getModelsMainView.php?id='+userID);
</script>

