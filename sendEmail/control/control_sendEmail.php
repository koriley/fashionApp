<?php

/*
 * This control will ask the model for all of the users and their likes and will send them an email with those likes.
 */

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists
//for testing purposes, we are going to send the controller a email address to send to before we open it up to the database.
//$eAddress = $_GET['emailAD'];
//$id = 1;
//email headers and subject stuff
$subject = 'Thank You for attending 417 Fashionation';

$headers .= "From: admin@417fashionation.com \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$from = 'admin@417fashionation.com';


//get the users
$sql = "SELECT * FROM user ORDER BY id";
$user = $dbCon->select($sql);
$userCount = count($user) - 1;
$o = 0;
for ($aa = 0; $aa <= $userCount; $aa++) {
    $noLikes = 0;
    $store = 0;
    $message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>417 Magazine Fashionation</title>
	<style type="text/css">@import url(http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700);

            @media only screen and (max-width: 660px) {

                table.container { width: 100% !important; } 
                .imageDisplay td {display: block;}
                .emailImage{
                    height:auto !important;
                    max-width:600px !important;
                    width: 100% !important;
                    display: block;
                }

            }

            @media only screen and (max-width: 480px) {

                table.container { width:100% !important; }

                .imageDisplay td {display: block;}
                .emailImage{
                    height:auto !important;
                    max-width:600px !important;
                    width: 100% !important;
                    display: block;
                }

            }
	</style>
</head>
<body bgcolor="white">
<table class="container" style="margin: auto; font-family: Open Sans,sans-serif; background-color: #ffffff; color:#000000;" width="600">
	<tbody>
		<tr>
			<td>
			<table class="prehead" style="background-color: #000000; color: #000000;" width="100%">
				<tbody>
					<tr>
						<td style="width: 60%;"><font color="#ffffff" face="arial, helvetica, sans-serif"><span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;">Thank you for attending Fashionation!</span></span><span style="font-size: 12px;"><b><em></em></b></span></font></td>
						<td style="text-align: right; color: white; "><span style="font-family:arial,helvetica,sans-serif;"><span style="font-size:12px;"><font color="#000000"></font></span></span></td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr style="text-align: center;">
			<td><span style="color:#FFFFFF;"></span></a><a href="http://www.417mag.com/spa-and-salon-week/" name="header_2" target="_blank" xt="SPCLICK"><span style="color:#FFFFFF;"><font face="Times"><img contentid="52851b4e-1533d95ee63-943e27de0c8b91cc3fcf1475c3e5d726" name="Fashionation_eblastheader1.png" spname="Fashionation_eblastheader1.png" src="http://www.417fashionation.com/imgs/Fashionation_eblastheader3.png" style="width: 100%; " xt="SPIMAGE" /></font></span></td>
		</tr>
		<tr>
			<td style="margin-bottom: 5px;">
			<div style="text-align: center;"><span style="font-size:24px;"><span style="font-family:arial,helvetica,sans-serif;"><b>Thank you for attending #417Fashionation presented by Swann Dermatology &amp; Esthetics!</b></span></span></div>

			<div style="text-align: center;"><a href="http://www.417mag.com/spa-and-salon-week/" name="Hyperlink_20160223_134614444" target="_blank" xt="SPCLICK"><span style="color:#545454;"></span></a><span style="font-size:16px;"><span style="font-family:arial,helvetica,sans-serif;"><br />
			<span style="color:#545454;"></span><span style="text-decoration: none; color: rgb(0, 0, 0);"><strong><span style="color:#545454;"></span></strong></span>As promised, the fashions you loved from the show are listed below.<br />
			Use the&nbsp;Spring Fling Shopping Pass you got tonight to receive 25%<br />
			off at participating retailers through April16!<br />
			<br />
			<img border="0" contentid="52851b4e-1533e6f2b23-943e27de0c8b91cc3fcf1475c3e5d726" height="37" name="Fashionation16_YourLikesFromShow.png" spname="Fashionation16_YourLikesFromShow.png" src="http://www.417fashionation.com/imgs/Fashionation16_YourLikesFromShow.jpg" width="231.044" xt="SPIMAGE" /><br />';


    $myName = $user[$aa]['email'];
    // echo $myName . "<br/>";
//get all the stores
    $stores = $addModel->getStores($dbCon);
    $storeCount = count($stores);



    $v = 0; //this is the real model number
//get each model associated with that store
    for ($k = 0; $k <= $storeCount - 1; $k++) {
        // echo $stores[$k]['storeName']."<br/>";
        $sql = "SELECT * FROM model WHERE store = '" . $stores[$k]['storeName'] . "' ORDER BY modelNum ASC";


        $model = $dbCon->select($sql);
        //print_r($model);
        //echo"<br/>";
        $first = $model[0]['modelNum'];

        $modelCount = count($model);
        //echo $modelCount;
        //echo $stores[$k]['storeName']."<br/>";
        for ($e = 0; $e <= $modelCount - 1; $e++) {
            //get user likes associated with model
            //echo "model_$v = " . $user[$aa]["model_$v"];
            $v++;

            //echo "<br/>";
            if ($user[$aa]["model_$v"] != '') {
if($store == 0){
    $message .= "<strong><a href='" . $stores[$k]['storeLink'] . "'><img src='http://www.417fashionation.com/" . $stores[$k]['storeImage'] . "' /></a><a href='" . $stores[$k]['salonLink'] . "'><img src='http://417fashionation.com" . $stores[$k]['salonImage'] . "' /></a></strong><br/>";
        $store = 1;
}
                $whatILike = explode('|', $user[$aa]["model_$v"]);
                $whatThisModelisWearing = explode('|', $model[$e]['items']);
                $itemPrice = explode('|', $model[$e]['price']);
                $priceCount = count($itemPrice);
                for($ke=0;$ke<=$priceCount-1;$ke++){
                    $itemPrice[$ke] = str_replace('$', '', $itemPrice[$ke]);
                }
                $wearingCount = count($whatILike);
                if ($whatILike != '') {
                    
                    for ($x = 0; $x <= $wearingCount; $x++) {
                        if ($whatThisModelisWearing[$whatILike[$x]] != '') {
                            //echo $whatThisModelisWearing[$whatILike[$x]]."<br/>";
                            $noLikes = 1;
                            if($itemPrice[$whatILike[$x]] == ''){
                            $message .= $whatThisModelisWearing[$whatILike[$x]] . "<br/>";
                            }else{
                            $message .= $whatThisModelisWearing[$whatILike[$x]] . ", $".$itemPrice[$whatILike[$x]]."<br/>";    
                            }
                        }
                    }
                }
               
                //echo $whatThisModelisWearing[$whatILike];
                //echo "------------------------------<br/>";
                //echo " you have items for model $v ";
                // print_r($whatILike);
                // echo "<br/>";
                // echo "these are the items the model $v was wearing<br/>";
                //  print_r($whatThisModelisWearing);
                // echo "<br/>";
            }

        }
        $message .= "<br/>";
        $store = 0;
    }



$message .= '<font face="Times"></font></td>
		</tr>
		<tr>
			<td>
			<div style="text-align:center; margin-top:10px;"><span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;"><strong><a href="https://www.facebook.com/acaciaspaspringfield/?fref=ts" name="www_facebook_com_acaciaspaspringfie" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533e65f1ad-943e27de0c8b91cc3fcf1475c3e5d726" name="Fashionation16_WebApp_BlackBar6004.png" spname="Fashionation16_WebApp_BlackBar6004.png" src="http://www.417fashionation.com/imgs/Fashionation16_WebApp_BlackBar600.jpg" xt="SPIMAGE" /><br />
			<br />
			<img border="0" contentid="52851b4e-1533e30f62b-943e27de0c8b91cc3fcf1475c3e5d726" height="35.644" name="Fashionation16_Participants.png" spname="Fashionation16_Participants.png" src="http://www.417fashionation.com/imgs/Fashionation16_Participants.png" width="99.803" xt="SPIMAGE" /><br />
			ACACIA SPA</a></strong><strong>&nbsp;</strong><a href="https://www.facebook.com/AmeliaMaddenBras/?fref=ts" name="www_facebook_com_AmeliaMaddenBras__" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">AMELIA MADDEN BRA SHOPPE</a>&nbsp;<strong><a href="https://www.facebook.com/BlueRavenEmporium/?fref=ts" name="www_facebook_com_BlueRavenEmporium_" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">BLUE RAVEN EMPORIUM</a></strong>&nbsp;<br />
			<a href="https://www.facebook.com/browneyedgirlsgifts/?fref=ts" name="www_facebook_com_browneyedgirlsgift" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">BROWN EYED GIRLS</a><strong>&nbsp;</strong><strong><a href="https://www.facebook.com/springfieldcuttingedge/?fref=ts" name="www_facebook_com_springfieldcutting" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">THE CUTTING EDGE SALON</a></strong>&nbsp;<a href="https://www.facebook.com/DowntownDapper/?fref=ts" name="www_facebook_com_DowntownDapper__fr" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">DAPPER</a><br />
			&nbsp;<strong><a href="https://www.facebook.com/Emerald-Salon-and-Spa-589943254389783/?fref=ts" name="www_facebook_com_Emerald_Salon_and_" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">EMERALD SALON &amp; SPA</a></strong>&nbsp;<a href="https://www.facebook.com/Fashion-House-188098224535758/?fref=ts" name="www_facebook_com_Fashion_House_1880" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">FASHION HOUSE</a>&nbsp;<strong><a href="https://www.facebook.com/GroveSpa/?fref=ts" name="www_facebook_com_GroveSpa__fref_ts" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">GROVE SPA</a></strong>&nbsp;<br />
			<a href="https://www.facebook.com/ShopHaremCo/?fref=ts" name="www_facebook_com_ShopHaremCo__fref_" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">HAREM &amp; COMPANY</a>&nbsp;<strong><a href="https://www.facebook.com/HoneyHive-Salon-Original-In-Haircare-312765758884009/?fref=ts" name="www_facebook_com_HoneyHive_Salon_Or" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">HONEY + HIVE</a></strong>&nbsp;<a href="https://www.facebook.com/Inviktus-Paul-Mitchell-Focus-Salon-143695495644153/?fref=ts" name="www_facebook_com_Inviktus_Paul_Mitc" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">INVIKTUS&nbsp;SALON</a>&nbsp;<strong><a href="https://www.facebook.com/Kaleidoscope-85481318771/?fref=ts" name="www_facebook_com_Kaleidoscope_85481" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">KALEIDOSCOPE</a></strong>&nbsp;<br />
			<a href="https://www.facebook.com/KarmaSalonSpringfield/?fref=ts" name="www_facebook_com_KarmaSalonSpringfi" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">KARMA SALON</a>&nbsp;<strong><a href="https://www.facebook.com/themarketspringfield/?fref=ts" name="www_facebook_com_themarketspringfie" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">THE MARKET</a></strong><strong style="text-align: center;">&nbsp;</strong><a href="https://www.facebook.com/maxonsdiamondmerchants/?fref=ts" name="www_facebook_com_maxonsdiamondmerch" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">MAXON&#39;S DIAMOND MERCHANTS</a>&nbsp;<br />
			<strong><a href="https://www.facebook.com/mitchumjewelers/?fref=ts" name="www_facebook_com_mitchumjewelers__f" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">MITCHUM JEWELERS</a></strong><strong>&nbsp;</strong><a href="https://www.facebook.com/PinUpSalonCo/?fref=ts" name="www_facebook_com_PinUpSalonCo__fref" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">PIN UP SALON CO.</a>&nbsp;<strong>QC MOTO</strong>&nbsp;<br />
			<a href="https://www.facebook.com/TheReviewShoppe/?fref=ts&ref=br_tf" name="www_facebook_com_TheReviewShoppe__f" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">THE REVIEW SHOPPE</a>&nbsp;<strong><a href="https://www.facebook.com/shailasboutique/?fref=ts" name="www_facebook_com_shailasboutique__f" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">SHAILA&#39;S</a></strong><strong><strong>&nbsp;</strong></strong><a href="https://www.facebook.com/sophieshoe/?fref=ts" name="www_facebook_com_sophieshoe__fref_t" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK"> SOPHIE BOUTIQUE</a>&nbsp;<strong><a href="https://www.facebook.com/shopstaxx/?fref=ts" name="www_facebook_com_shopstaxx__fref_ts" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">STAXX</a></strong><strong>&nbsp;</strong><a href="https://www.facebook.com/ShopTownAndCounty/" name="www_facebook_com_ShopTownAndCounty_" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">TOWN &amp; COUNTY</a><strong>&nbsp;</strong><br />
			<strong><a href="https://www.facebook.com/shoptheuptown/?fref=ts" name="www_facebook_com_shoptheuptown__fre" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">THE UPTOWN BOUTIQUE</a></strong>&nbsp;<a href="https://www.facebook.com/Weezies-199375920089433/?fref=ts" name="www_facebook_com_Weezies_1993759200" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">WEEZIE&#39;S UPSCALE RESALE</a>&nbsp;<br />
			<strong><a href="http://www.wbyworth.com" name="www_wbyworth_com" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">W BY WORTH COLLECTION</a></strong>&nbsp;&nbsp;<a href="https://www.facebook.com/ViVo-modern-hair-design-129932740413250/?fref=ts" name="www_facebook_com_ViVo_modern_hair_d" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">VIVO MODERN HAIR DESIGN</a><br />
			<em>LEXUS LOUNGE AND VIP DECOR BY </em><em><a href="https://www.facebook.com/Ellecordesignandgifts/?fref=ts" name="www_facebook_com_Ellecordesignandgi" style="text-decoration:none;color:#000000;" target="_blank" xt="SPCLICK">ELLECOR DESIGN &amp; GIFTS</a></em></span></span><em></em><br />
			<br />
			<br />
			<img border="0" contentid="52851b4e-1533e30f61e-943e27de0c8b91cc3fcf1475c3e5d726" height="35.644" name="Fashionation16_Sponsors.png" spname="Fashionation16_Sponsors.png" src="http://www.417fashionation.com/imgs/Fashionation16_Sponsors.png" width="80" xt="SPIMAGE" /></div>

			<table align="center" border="0" cellpadding="1" cellspacing="1" style="width: 300px;">
				<tbody>
					<tr>
						<td><span style="font-size:11px;"><span style="font-family:arial,helvetica,sans-serif;">PRESENTED BY</span></span></td>
						<td><a href="http://www.swanndermatology.com/" name="swann logo" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab4316-943e27de0c8b91cc3fcf1475c3e5d726" height="64.32" name="SwannLogoNEW.png" spname="SwannLogoNEW.png" src="http://www.417fashionation.com/imgs/SwannLogoNEW.png" width="160" xt="SPIMAGE" /></a></td>
					</tr>
				</tbody>
			</table>

			<table align="center" border="0" cellpadding="1" cellspacing="1" style="width: 550px;">
				<tbody>
					<tr>
						<td>
						<div style="text-align: center;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="http://www.417mag.com/417-Magazine/417-Fashionation/" name="vip party" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab42f2-943e27de0c8b91cc3fcf1475c3e5d726" height="80" name="Fashionation16_VIP22.png" spname="Fashionation16_VIP22.png" src="http://www.417fashionation.com/imgs/Fashionation16_VIP.png" width="112.821" xt="SPIMAGE" /></a>&nbsp;&nbsp;</div>
						</td>
						<td><br />
						<a href="http://missouriwine.org/" name="mo wines" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab4347-943e27de0c8b91cc3fcf1475c3e5d726" height="58.252" name="MOWineLogo_black2.png" spname="MOWineLogo_black2.png" src="http://www.417fashionation.com/imgs/MOWineLogo_black.png" width="60" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="http://phenixbrands.com/" name="stiletto" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab4303-943e27de0c8b91cc3fcf1475c3e5d726" name="stiletto_black2.png" spname="stiletto_black2.png" src="http://www.417fashionation.com/imgs/stiletto_black.png" width="60" xt="SPIMAGE" /></a></td>
					</tr>
					<tr>
						<td style="text-align: center;">&nbsp; &nbsp; &nbsp; &nbsp;<a href="http://www.417mag.com/417-Magazine/417-Fashionation/" name="main event" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab4321-943e27de0c8b91cc3fcf1475c3e5d726" height="80" name="Fashionation16_MainEvent22.png" spname="Fashionation16_MainEvent22.png" src="http://www.417fashionation.com/imgs/Fashionation16_MainEvent.png" width="114.38" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="http://alice955.iheart.com/" name="alice" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab42c3-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="AliceLogo_black2.png" spname="AliceLogo_black2.png" src="http://www.417fashionation.com/imgs/AliceLogo_black.png" width="60" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="http://www.millerlite.com/AV" name="miller" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533db99592-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="LavishlyTan_black.png" spname="LavishlyTan_black.png" src="http://www.417fashionation.com/imgs/LavishlyTan_black.jpg" width="60" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="http://www.millerlite.com/AV" name="miller" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab42cd-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="ML_black2.png" spname="ML_black2.png" src="http://www.417fashionation.com/imgs/ML_black.png" width="60" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="https://www.facebook.com/reliablelexus/?fref=ts" name="lexus" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533db99587-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="QCMoto_black.png" spname="QCMoto_black.png" src="http://www.417fashionation.com/imgs/QCMoto_black.jpg" width="60" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="https://www.facebook.com/reliablelexus/?fref=ts" name="lexus" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab4335-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="lexus_logo_fashination2_blk2.png" spname="lexus_logo_fashination2_blk2.png" src="http://www.417fashionation.com/imgs/lexus_logo_fashination2_blk.png" width="60" xt="SPIMAGE" /></a></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;<a href="http://www.417mag.com/417-Magazine/417-Fashionation/" name="after party" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab42b8-943e27de0c8b91cc3fcf1475c3e5d726" height="80" name="Fashionation16_AfterParty22.png" spname="Fashionation16_AfterParty22.png" src="http://www.417fashionation.com/imgs/Fashionation16_AfterParty.png" width="157.025" xt="SPIMAGE" /></a></td>
						<td><br />
						<a href="https://www.facebook.com/GroveSpa/?fref=ts" name="grove" target="_blank" xt="SPCLICK"><img border="0" contentid="52851b4e-1533dab42e0-943e27de0c8b91cc3fcf1475c3e5d726" height="60" name="GroveSpa_black2.png" spname="GroveSpa_black2.png" src="http://www.417fashionation.com/imgs/GroveSpa_black.png" width="60" xt="SPIMAGE" /></a></td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>

			<div style="text-align: center;">&nbsp;</div>

			<table style="background-color: #000000;">
				<tbody>
					<tr>
						<td style=" width: 100%; text-align: center;   background-color: #000000;">
						<p><span style="font-size:16px;"><span style="font-family:arial,helvetica,sans-serif;"><span style="font-weight: normal; color:#ffffff;"><strong>FOLLOW US!</strong></span></span></span></p>
						<span style="font-family:arial,helvetica,sans-serif;"><font color="#000000"><a href="https://www.facebook.com/417mag?fref=ts" name="Facebook" target="_blank" xt="SPCLICK"><img contentid="52851b4e-1533d7ab781-943e27de0c8b91cc3fcf1475c3e5d726" name="fbRound2.png" spname="fbRound2.png" src="http://www.417fashionation.com/imgs/fbRound.png" style="max-width: 30px;" xt="SPIMAGE" /></a> <a href="https://instagram.com/417mag/" name="Instagram" target="_blank" xt="SPCLICK"><img contentid="52851b4e-1533e36f590-943e27de0c8b91cc3fcf1475c3e5d726" name="instaRound.png" spname="instaRound2.png" src="http://www.417fashionation.com/imgs/instaRound.png" style="max-width: 30px;" xt="SPIMAGE" /></a> <a href="https://www.pinterest.com/417magazine/" name="Pinterest" target="_blank" xt="SPCLICK"><img contentid="52851b4e-1533e36f576-943e27de0c8b91cc3fcf1475c3e5d726" name="pinRound2.png" spname="pinRound2.png" src="http://www.417fashionation.com/imgs/pinRound.png" style="max-width: 30px;" xt="SPIMAGE" /></a> <a href="https://twitter.com/417mag" name="Twitter" target="_blank" xt="SPCLICK"><img contentid="52851b4e-1533e36f5ac-943e27de0c8b91cc3fcf1475c3e5d726" name="twitterRound2.png" spname="twitterRound2.png" src="http://www.417fashionation.com/imgs/twitterRound.png" style="max-width: 30px;" xt="SPIMAGE" /></a></font></span></td>
					</tr>
					<tr>
						<td style=" width: 100%; text-align: center;   background-color: #000000;"><span style="font-size:14px;"><font color="#000000"><a href="http://www.417mag.com/417-Magazine/Newsletter-Signup/" name="newsletterSignup" style="color:#ffffff;" target="_blank" xt="SPCLICK">Click here to sign up for our other newsletters!</a></font></span></td>
					</tr>
					<tr>
						<td style=" width: 600px; text-align: center; background-color: #000000; color:#ffffff;"><span style="font-size:14px;"><em>417 Magazine</em> | 2111 S. Eastgate Ave. | Springfield, MO 65809</span></td>
					</tr>
					<tr>
						<td style=" width: 600px; text-align: center; background-color: #000000;"><span style="font-size:14px;"><a href="http://www.417mag.com/Newsletter-Opt-Out/" name="manage sub" target="_blank" xt="SPCLICK"><font color="#ffffff">Manage Your Subscription</font></a></span></td>
					</tr>
					<tr>
						<td style=" width: 600px; text-align: center; background-color: #000000;">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>';






//this is what we are sending.
//mail($myName, $subject, $message, $headers, '-f' . $from);
if($noLikes > 0){
    echo $myName."<br/>";
    echo $message."<br/><br/>";
}

}

            