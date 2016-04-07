<?php

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists
$id = strip_tags($_GET['id']);
//echo $id;
//echo "<script>var id='$id';</script>";
$stores = $addModel->getStores($dbCon);
$storeCount = count($stores)-1;
$modNum = '1';
$modNumZero = '0';
for ($z = 0; $z <= $storeCount; $z++) {
    $storeName[$z] = $stores[$z]['storeName'];
    
    $anchor[$z] = str_replace("&", "and", $storeName[$z]);
    $anchor[$z] = str_replace("1", "", $anchor[$z]);
    $anchor[$z] = str_replace(" ", "_", $anchor[$z]);
    echo '<div id="'.$anchor[$z].'"></div>';

    echo '<div class="storeLogo"><img src="' . $stores[$z]['storeImage'] . '" /><img src="' . $stores[$z]['salonImage'] . '" /></div>';
    $res = $addModel->getModel($dbCon, $storeName[$z]);
    $resCount = count($res)-1;

    $getUserLikes = $addModel->getUserLikes($dbCon, $id);

//print_r($getUserLikes);
    for ($i = 0; $i <= $resCount; $i++) {
        $modelNum = $i + 1;
        $store[$i] = $res[$i]['store'];
        $mrch[$i] = explode('|', $res[$i]['items']);
        $mrchPrice[$i] = explode('|', $res[$i]['price']);
        echo "<div class='modelEdit' data-model='$modNum' id='modelNum_$modNumZero' style=''>
    <!--<div class='storeNameEdit' style=''>MODEL $modelNum</div>-->";
        $mrchCount = count($mrch[$i]) - 1;
        for ($x = 0; $x <= $mrchCount; $x++) {
            $item[$x] = $mrch[$i][$x];
            $price[$x] = $mrchPrice[$i][$x];
            $price[$x] = str_replace('null', '', $price[$x]);
            $price[$x] = str_replace('$', '', $price[$x]);
            $currentModelCount = count($currentModelLikes[$i]);
            for ($y = 0; $y <= $currentModelCount; $y++) {
                echo "<div class='itemsEdit' data-liked='false' data-item='$x' id='item_$x' style='display:table-row'><div style='display:table-cell'><input id='itemSelect' type='checkbox'></div><div style='display:table-cell'>$item[$x]";

                if ($price[$x] != '') {
                    echo ", $$price[$x]";
                } else {
                    echo "$price[$x]";
                }
                echo "</div></div>";
            }
        }



        echo "</div><br/>";
        $modNum++;
        $modNumZero++;
    }
    
    if($stores[$z]['storeDesc'] !== ''){
        echo '<div class="storeDescription">'.$stores[$z]['storeDesc'].'</div>';
    }
    echo '<div class="blackImage" style="">
    <img style="width:100% " src="/img/Fashionation16_WebApp_BlackBar.png" />
</div>';
}

if ($getUserLikes != '') {
    //we are looking to see if you have liked anything, if you do we are seperating them
    //out, then running some jQuery to set those items to being liked.
    $getUserLikesCount = count($getUserLikes) - 1;
    for ($i = 0; $i <= $getUserLikesCount; $i++) {
        $myLikes[$i] = explode('|', $getUserLikes[$i]);
        //print_r($myLikes);
        for ($x = 0; $x <= count($myLikes[$i]) - 1; $x++) {
            $realNum = $x + 1;
            /* echo "model_$i, item_";
              echo $myLikes[$i][$x];
              echo "<br />"; */
            echo " <script>
      jQuery('#modelNum_$i').children('#item_" . $myLikes[$i][$x] . "').attr('data-liked', 'true');
      jQuery('#modelNum_$i').children('#item_" . $myLikes[$i][$x] . "').children('input').prop('checked', true);
          
</script>";
        }
    }
}
?>

<div class="welcomText bottomPad">
    Thanks for attending #417Fashionation! We’ve saved your likes, and you’ll get an email from us tonight. Now it’s time for the after party!
</div>

<script>
    jQuery(document).ready(function () {
        jQuery('input[id="itemSelect"]').each(function () {
            jQuery(this).hide();
            var amILiked = jQuery(this).parent().parent().attr('data-liked');
            if (amILiked === 'true') {
                jQuery(this).after('<img id="like" src="/img/Fashionation16_WebApp_GoldStar.png" style="padding-right:5px;" />');
                jQuery(this).after('<img id="unlike" src="/img/Fashionation16_WebApp_BlackStar2.png" style=" display:none; padding-right:5px;" />');
                jQuery(this).parent().parent().css({'color': '#DEB065'});
            } else {
                jQuery(this).after('<img id="unlike" src="/img/Fashionation16_WebApp_BlackStar2.png" style="padding-right:5px;" />');
                jQuery(this).after('<img id="like" src="/img/Fashionation16_WebApp_GoldStar.png" style="display:none; padding-right:5px;" />');
                jQuery(this).parent().parent().css({'color': '#000'});
            }
        });
    });
    jQuery('.itemsEdit').on('click touch',function () {
        var isChecked = jQuery(this).children('input').prop('checked');
        var liked = jQuery(this).attr('data-liked');
        //alert(liked);
        var myLikes = '';
        var parent = '';
        if (liked === 'true') {
            jQuery(this).children('div').children('#like').hide();
            jQuery(this).children('div').children('#unlike').show();
            jQuery(this).css({'color': '#000'});
            jQuery(this).children('input').prop('checked', false);
            jQuery(this).attr('data-liked', 'false');
            parent = jQuery(this).parent('.modelEdit').data('model');
            var parentID = jQuery(this).parent('.modelEdit').attr('id');
            //alert(parentID);
            jQuery('#' + parentID).children(".itemsEdit").each(function () {
                //alert('here');
                var findMyLikes = jQuery(this).attr('data-liked');
                //alert(findMyLikes);
                if (findMyLikes === 'true') {
                    var thisNumber = jQuery(this).attr('data-item');
                    if (myLikes === '') {
                        myLikes = thisNumber;
                    } else {
                        myLikes = myLikes + '|' + thisNumber;
                    }
                }
            });
        }
        if (liked === 'false') {
            jQuery(this).children('div').children('#like').show();
            jQuery(this).children('div').children('#unlike').hide();
            jQuery(this).css({'color': '#DEB065'});
            jQuery(this).children('input').prop('checked', true);
            jQuery(this).attr('data-liked', 'true');
            parent = jQuery(this).parent('.modelEdit').data('model');
            var parentID = jQuery(this).parent('.modelEdit').attr('id');
            //alert(parentID);
            jQuery('#' + parentID).children(".itemsEdit").each(function () {
                //alert('here');
                var findMyLikes = jQuery(this).attr('data-liked');
                //alert(findMyLikes);
                if (findMyLikes === 'true') {
                    var thisNumber = jQuery(this).attr('data-item');
                    if (myLikes === '') {
                        myLikes = thisNumber;
                    } else {
                        myLikes = myLikes + '|' + thisNumber;
                    }
                }
            });
        }
//alert('parent= '+parent+' likes= '+myLikes+' id='+id);
//jQuery.post('control/control_updateUserLikes.php?model='+parent+'likes='+myLikes+'id='+id);
        jQuery.post('control/control_updateUserLikes.php', {model: parent, likes: myLikes, id: userID});
    });
</script>  





