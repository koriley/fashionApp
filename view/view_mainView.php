<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$level = strip_tags($_GET['level']);
$id = strip_tags($_GET['userID']);
//echo $id;
if ($level < 3) {
    echo "<script>jQuery('#edit').remove();</script>";
} else {
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
    <img  src="/img/Fashionation16_WebAppHeader8.png" />
</div>
<div class="menu" style="">
    <div id="menu"><img src="/img/menuIcon.png" /></div>
</div>
<div class="welcomText" style="">
    Follow along with the show and click to star the fashions you love below. We'll save everything as you go and email you what you liked at the end of the night!
</div>
<div class="headImage" >
    <img  src="/img/Fashionation16_WebAppSponsors.png" />
</div>

<div class="headImage" >
    <img  src="/img/Fashionation16_WebApp_BlackBar.png" />
</div>
<div id='userView' class="userView"></div>


<script type="text/javascript">

    jQuery('.menu').on('touch click', function () {
        //alert('click');
        jQuery('.greyOut').toggle();
        jQuery('.menuItems').toggle();
    });
    jQuery('.greyOut').on('touch click', function () {
        jQuery('.greyOut').toggle();
        jQuery('.menuItems').toggle();
    });
    jQuery('a').on('touch click', function(){
        jQuery('.greyOut').toggle();
        jQuery('.menuItems').toggle();
    });



    jQuery('#userView').load('control/control_getModelsMainView.php?id=' + userID);

</script>

