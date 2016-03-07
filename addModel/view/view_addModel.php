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
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="addModel">Add Model</button>

<!-- the add model modal-->

<div class="modal fade reload" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add a Model</h4>
            </div>
            <div class="modal-body">
                <input type="text" value="" placeholder="Store Name" id="storeName" />
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
<div id="newResult"></div>

<script>
    jQuery('#newResult').load('addModel/control/control_getModel.php');
    
    jQuery('.reload').on('hidden.bs.modal', function (e) {
  jQuery('#newResult').load('addModel/control/control_getModel.php');
});
    
    
    $('.multi-field-wrapper_add').each(function() {
                var $wrapper = $('.multi-fields_add', this);
                $("#addItem_add", $(this)).click(function(e) {
                    $('.multi-field_add:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
                });
                $('.multi-field_add .remove-field', $wrapper).click(function() {
                    if ($('.multi-field_add', $wrapper).length > 1)
                        $(this).parent('.multi-field_add').remove();
                });
            });
            var items = '';
            var price = '';
            jQuery('#save').click(function() {
                var store = jQuery('#storeName').val();
                var modelNum = jQuery('#modelNum').val();
                jQuery('.multi-field_add .items').each(function() {
                    if (items === '') {
                        items = jQuery(this).val();
                    } else {
                        items = items + '|' + jQuery(this).val();
                    }

                });
                jQuery('.multi-field_add .itemsPrice').each(function() {
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
                
                jQuery("input[type=text]").each(function(){
                    jQuery(this).val("");
                });
               
                jQuery('.multi-field_add:not(:first)').remove();
                       
                    
                    //jQuery('#newResult').load('addModel/control/control_getModel.php');
                $('#myModal').modal('toggle');
            });
     
</script>