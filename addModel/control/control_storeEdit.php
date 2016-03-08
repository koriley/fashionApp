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
echo "<select id='storeSelect'>";

for ($k = 0; $k <= $storeCount - 1; $k++) {
    if ($res[$k]['storeName'] != '') {
        echo "<option value='" . $res[$k]['storeName'] . "'>" . $res[$k]['storeName'] . "</option>";
    }
}
echo "</select>";
for ($i = 0; $i <= $storeCount; $i++) {
    if ($res[$i]['storeName'] != '') {


        if ($i == 0) {
            echo "<div class='" . $res[$i]['storeName'] . " store'>";
        } else {
            echo "<div class='" . $res[$i]['storeName'] . " store' style='display:none;'>";
        }

        echo "<h1>" . $res[$i]['storeName'] . " Information</h1>";

        echo '<input type = "text" value = "' . $res[$i]['storeName'] . '" id = "myStoreName" />
<input type = "text" value = "' . $res[$i]['storeLink'] . '"  id = "storeLink" />
<img src="' . $res[$i]['storeImage'] . '"  />
    <input type = "file" value = "Change Store Image" placeholder = "Salon Image" id = "storeImage" />
<h1>Salon Information</h1>
<input type = "text" value = "' . $res[$i]['salonName'] . '" placeholder = "Salon Name" id = "salonName" />
<input type = "text" value = "' . $res[$i]['salonLink'] . '" placeholder = "Salon Link" id = "salonLink" />
<img src="' . $res[$i]['salonImage'] . '"  />
    <input type = "file" value = "Change Salon Image" placeholder = "Salon Image" id = "salonImage" />
<h1>Order in runway show</h1>
<input type = "test" value = "' . $res[$i]['runwayOrder'] . '" placeholder = "Order" id = "storeOrder" />';


        echo '<div class = "modal-footer">
<button type = "button" class = "btn btn-primary" id = "exitStore">Exit Edit Store</button>
<button type = "button" id = "deleteStore" data-delete="' . $res[$i]['id'] . '" data-storeImage="' . $res[$i]['storeImage'] . '" data-salonImage="' . $res[$i]['salonImage'] . '" class = "btn btn-danger">Delete Store</button>
<button type = "button" id = "saveStore" class = "btn btn-primary" data-id="' . $res[$i]['id'] . '" data-storeImage="' . $res[$i]['storeImage'] . '" data-salonImage="' . $res[$i]['salonImage'] . '">Edit Store</button>
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
    jQuery("#storeSelect").on('change', function () {
        var newStore = jQuery(this).val();
        jQuery('.store').each(function () {
            jQuery(this).hide();
        });
        jQuery('.' + newStore).show();
    });

    //exit the edit we will just reload the view_addModel.php
    jQuery('#exitStore').click(function () {
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });

    //delete a store and its images
    jQuery('#deleteStore').click(function () {
        var storeDelete = jQuery(this).attr('data-delete');
        var image1 = jQuery(this).attr('data-storeImage');
        var image2 = jQuery(this).attr('data-salonImage');
        jQuery.post('addModel/control/control_storeDelete.php', {deleteStore: storeDelete, delImage1: image1, delImage2: image2});
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });

    //edit the store and delete old images
    jQuery('#saveStore').click(function () {
        var storeName = jQuery('#myStoreName').val();
        var storeLink = jQuery('#storeLink').val();
        var oldStoreImage = jQuery(this).attr('data-storeImage');
        var storeID = jQuery(this).attr('data-id');
        var salonName = jQuery('#salonName').val();
        var salonLink = jQuery('#salonLink').val();
        var oldSalonImage = jQuery(this).attr('data-salonImage');
        var order = jQuery('#storeOrder').val();

        var formData = new FormData();
        if (document.getElementById("storeImage").files.length !== 0) {
            formData.append('file1', jQuery('#storeImage')[0].files[0]);

        } else {
            formData.append('file1', '');
        }
        if (document.getElementById("salonImage").files.length !== 0) {
            formData.append('file2', jQuery('#salonImage')[0].files[0]);

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
                console.log(data);
                // alert(data);
            }
        });
        jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);
    });
</script>