<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$level = strip_tags($_GET['level']);
$userID = strip_tags($_GET['userID']);
if ($level < 3) {
    echo "<script>jQuery('#mother').load('view/view_mainView.php?level=$level').fadeIn();</script>";
} else {
    echo "<script>
    jQuery('#edit').click(function(){
        jQuery('#mother').load('view/view_mainView.php?level=$level&userID=$userID').fadeIn();
    });
    </script>";
}
echo "<script> var level=$level;"
 . "var userID=$userID; </script>"
?>

<div id="edit" class="adminEdit"><span aria-hidden="true">&times;</span>EXIT</div>
<div class="adminButtons">
    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="addModel">Add Model</button>
    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#storeModal" id="addStore">Add Store</button>
    <button class="btn btn-danger btn-lg"   id="sendEmail">Send Email</button>
</div>

<!-- the add model modal-->

<div class="modal fade reload" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add a Model</h4>
            </div>
            <div class="modal-body addModel">
                <div id="storeNames"></div>
                <input type="text" value="" placeholder="Model Order Number" id="modelNum" />
                <div class="multi-field-wrapper_add">
                    <div class="multi-fields_add">
                        <div class="multi-field_add">
                            <input type="text" class="items" name="stuff[]" placeholder="Item">
                            <input type="text" class="itemsPrice" name="stuff[]" placeholder="price">
                            <button type="button" class="remove-field">Remove</button>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg" id="addItem_add">Add Item</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="save" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

        <script>



        </script>
    </div>
</div>
<!-- end modal -->

<!-- the add store modal-->

<div class="modal fade reload addStore"  id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add a Store/Salon Combo</h4>
            </div>
            <div class="modal-body editStoreBody">
                <h1>Store Information</h1>
                <input type="text" value="" placeholder="Store Name" id="myStoreName" />
                <input type="text" value="" placeholder="Store Link" id="storeLink" />
                <input type="file" value="" placeholder="Store Image" id="storeImage" />
                <h1>Salon Information</h1>
                <input type="text" value="" placeholder="Salon Name" id="salonName" />
                <input type="text" value="" placeholder="Salon Link" id="salonLink" />
                <input type="file" value="" placeholder="Salon Image" id="salonImage" />
                <h1>Order in runway show</h1>
                <input type="test" value="" placeholder="Order" id="storeOrder" />

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editStore">Edit Store</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="saveStore" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

        <script>



        </script>
    </div>
</div>
<!-- end modal -->

<div id="newResult"></div>

<script>
    jQuery('#newResult').load('addModel/control/control_getModel.php');

    jQuery('.reload').on('hidden.bs.modal', function (e) {
        jQuery('#newResult').load('addModel/control/control_getModel.php');
    });

//creating the send email button and sending the user to the send email functionality
jQuery('#sendEmail').click(function(){
    jQuery('#mother').load('/sendEmail/view/view_testEmail.php');
});
jQuery('#storeNames').load('addModel/control/control_getStoreNames.php');

    $('.multi-field-wrapper_add').each(function () {
        var $wrapper = $('.multi-fields_add', this);
        $("#addItem_add", $(this)).click(function (e) {
            $('.multi-field_add:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
        });
        $('.multi-field_add .remove-field', $wrapper).click(function () {
            if ($('.multi-field_add', $wrapper).length > 1)
                $(this).parent('.multi-field_add').remove();
        });
    });
    var items = '';
    var price = '';
    jQuery('#save').click(function () {
        var store = jQuery('#storeSelect').val();
        var modelNum = jQuery('#modelNum').val();
        jQuery('.multi-field_add .items').each(function () {
            if (items === '') {
                items = jQuery(this).val();
            } else {
                items = items + '|' + jQuery(this).val();
            }

        });
        jQuery('.multi-field_add .itemsPrice').each(function () {
            if (price === '') {
                price = jQuery(this).val();
            } else {
                price = price + '|' + jQuery(this).val();
            }

        });
        // alert(items+' - '+price);
        //jQuery('#newResult').load('addModel/control/control_addModel.php?store='+store+'&modelNum='+modelNum+'&items="'+items+'"&price="'+price+'"');
        jQuery.post('addModel/control/control_addModel.php', {store: store, modelNum: modelNum, items: items, price: price});
        //jQuery('#mother').html('');
        //jQuery('#mother').load('addModel/view/view_addModel.php?level=' + level + '&userID=' + userID);

        jQuery("input[type=text]").each(function () {
            jQuery(this).val("");
        });

        jQuery('.multi-field_add:not(:first)').remove();


        //jQuery('#newResult').load('addModel/control/control_getModel.php');
        jQuery('#myModal').modal('toggle');
    });

    /** 
     * This is the add store jQuery
     * after user fill in input, we will need to send the info to php to 
     * save the image / update the db with store, info salon info, and image file location. 
     **/
    jQuery('#saveStore').click(function () {
        var storeName = jQuery('#myStoreName').val();
        var storeLink = jQuery('#storeLink').val();
        //file = jQuery('#storeImage')[0].files[0];

        var salonName = jQuery('#salonName').val();
        var salonLink = jQuery('#salonLink').val();
        var order = jQuery('#storeOrder').val();
        //file2 = jQuery('#salonImage')[0].files[0];
        // jQuery.post('addModel/control/control_addStore.php',{storeName:storeName, storeLink:storeLink, storeImage:file});
        //alert(file);
//alert(storeName);
        var formData = new FormData();
        formData.append('file1', jQuery('#storeImage')[0].files[0]);
        formData.append('file2', jQuery('#salonImage')[0].files[0]);
        formData.append('storeName', storeName);
        formData.append('storeLink', storeLink);
        formData.append('salonName', salonName);
        formData.append('salonLink', salonLink);
        formData.append('storeOrder', order);

        jQuery.ajax({
            url: 'addModel/control/control_addStore.php',
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
        jQuery('#storeModal').modal('toggle');
    });
    
    jQuery('#editStore').click(function(){
        jQuery('.editStoreBody').load('addModel/control/control_storeEdit.php');
    });

</script>