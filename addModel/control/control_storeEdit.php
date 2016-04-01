<?php
/*
 * This is a controle to get all the stores, output them in the model body, and update any changes to the database.
 */

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model();

$res = $addModel->getStores($dbCon);

//print_r($res);

/*
 * Array ( [0] => Array ( [id] => 1 [storeName] => test [storeImage] => http://www.something.com [storeLink] => ../../images/417Logo.png [salonName] => testSalon [salonImage] => www.something.com [salonLink] => ../../images/fallout-guy-psd-457127.png [runwayOrder] => 1 ) )
 */
$storeCount = count($res);
echo "<select id='storeSelectEdit'>";

for ($k = 0; $k <= $storeCount - 1; $k++) {
    if ($res[$k]['storeName'] != '') {
        echo "<option value='" . $res[$k]['storeName'] . "'>" . $res[$k]['storeName'] . "</option>";
    }
}
echo "</select>";
for ($i = 0; $i <= $storeCount; $i++) {
    if ($res[$i]['storeName'] != '') {


        if ($i == 0) {
            echo "<div class='" . str_replace(" ","_",$res[$i]['storeName']) . " store store_".$res[$i]['id']."'>";
        } else {
            echo "<div class='" . str_replace(" ","_",$res[$i]['storeName']) . " store store_".$res[$i]['id']."' style='display:none;'>";
        }

        echo "<h1>" . $res[$i]['storeName'] . " Information</h1>";

        echo '<input type = "text" value = "' . $res[$i]['storeName'] . '" id = "myStoreName_'.$res[$i]['id'].'"  />
<input type = "text" value = "' . $res[$i]['storeLink'] . '"  id = "storeLink_'.$res[$i]['id'].'" />
<img src="' . $res[$i]['storeImage'] . '"  />
    <input type = "file" value = "Change Store Image" placeholder = "Salon Image" id = "storeImage_'.$res[$i]['id'].'" />
<h1>Salon Information</h1>
<input type = "text" value = "' . $res[$i]['salonName'] . '" placeholder = "Salon Name" id = "salonName_'.$res[$i]['id'].'" />
<input type = "text" value = "' . $res[$i]['salonLink'] . '" placeholder = "Salon Link" id = "salonLink_'.$res[$i]['id'].'" />
<img src="' . $res[$i]['salonImage'] . '"  />
    <input type = "file" value = "Change Salon Image" placeholder = "Salon Image" id = "salonImage_'.$res[$i]['id'].'" />
<h1>Order in runway show</h1>
<input type = "test" value = "' . $res[$i]['runwayOrder'] . '" placeholder = "Order" id = "storeOrder_'.$res[$i]['id'].'" />';


        echo '<div class = "modal-footer">
<button type = "button" class = "btn btn-primary exitStore" id = "exitStore">Exit Edit Store</button>
<button type = "button" id = "deleteStore" data-delete="' . $res[$i]['id'] . '" data-storeName="' . $res[$i]['storeName'] . '" data-storeImage="' . $res[$i]['storeImage'] . '" data-salonImage="' . $res[$i]['salonImage'] . '" class = "btn btn-danger deleteStore">Delete Store</button>
<button type = "button" id = "editStore" class = "btn btn-primary editStore" data-id="' . $res[$i]['id'] . '" data-storeImage="' . $res[$i]['storeImage'] . '" data-salonImage="' . $res[$i]['salonImage'] . '">Save Store Updates</button>
</div>';
        echo "</div>";
    }
}





/*
  <input type = "file" value = "'.$res[$i]['storeName'].'"  id = "storeImage" />
 * <input type = "file" value = "" placeholder = "Salon Image" id = "salonImage" />
 */
?>
<script>

    //this will change the div depending on what store you have selected.
    jQuery("#storeSelectEdit").on('change', function () {
        var newStore = jQuery(this).val();
        newStore = newStore.replace(/\s/g, "_");
        //alert(newStore);
        jQuery('.store').each(function () {
            jQuery(this).hide();
        });
        jQuery('.' + newStore).show();
    });

    //exit the edit we will just reload the view_addModel.php
    jQuery('.exitStore').click(function () {
       
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });

    //delete a store and its images
    jQuery('.deleteStore').click(function () {
        var storeDelete = jQuery(this).attr('data-delete');
        var image1 = jQuery(this).attr('data-storeImage');
        var image2 = jQuery(this).attr('data-salonImage');
        var name = jQuery(this).attr('data-storeName');
        //alert(name);
        jQuery.post('addModel/control/control_storeDelete.php', {deleteStore: storeDelete, delImage1: image1, delImage2: image2, storeName:name});
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });

    //edit the store and delete old images
    jQuery('.editStore').click(function () {
        var storeID = jQuery(this).attr('data-id');
        var storeName = jQuery('#myStoreName_'+storeID).val();
        var storeLink = jQuery('#storeLink_'+storeID).val();
        var oldStoreImage = jQuery(this).attr('data-storeImage');
        var storeID = jQuery(this).attr('data-id');
        var salonName = jQuery('#salonName_'+storeID).val();
        var salonLink = jQuery('#salonLink_'+storeID).val();
        var oldSalonImage = jQuery(this).attr('data-salonImage');
        var order = jQuery('#storeOrder_'+storeID).val();

        var formData = new FormData();
        if (document.getElementById('storeImage_'+storeID).files.length !== 0) {
            formData.append('file1', jQuery('#storeImage_'+storeID)[0].files[0]);

        } else {
            formData.append('file1', '');
        }
        if (document.getElementById('salonImage_'+storeID).files.length !== 0) {
            formData.append('file2', jQuery('#salonImage_'+storeID)[0].files[0]);

        } else {
            formData.append('file2', '');
        }
        formData.append('storeName', storeName);
        formData.append('storeLink', storeLink);
        formData.append('salonName', salonName);
        formData.append('salonLink', salonLink);
        formData.append('storeOrder', order);
        formData.append('oldStore', oldStoreImage);
        formData.append('oldSalon', oldSalonImage);
        formData.append('id', storeID);

        jQuery.ajax({
            url: 'addModel/control/control_editStore.php', //yes this is confusing, we are on storeEdit, but editStore does the editing.
            type: 'POST',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
               // console.log(data);
                // alert(data);
            }
        });
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });
</script>