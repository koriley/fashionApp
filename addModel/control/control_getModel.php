<?php

function __autoload($class_name) {
    include '../modules/module_' . $class_name . '.php';
}

include_once('../../inc/dbl.login.inc.php');
$dbCon = new PDODatabase($dbAdmin, $dbName, $dbPass);
$addModel = new model(); //model is the name of the class that will add and update model lists

$res = $addModel->getModel($dbCon);
$resCount = count($res);
echo"<ul id='sortable'>";
for ($i = 0; $i <= $resCount - 1; $i++) {
    $store[$i] = $res[$i]['store'];
    $id[$i] = $res[$i]['id'];
    $modelNum[$i] = $res[$i]['modelNum'];
    $mrch[$i] = explode('|', $res[$i]['items']);
    $mrchPrice[$i] = explode('|', $res[$i]['price']);
    $realNum = $i+1;
    echo "<li id='order_$id[$i]'><div class='modelEdit' id='modelNum_$i' style=''>
    <div class='storeNameEdit' style=''>$store[$i] - model - $realNum</div>";
    $mrchCount = count($mrch[$i]) - 1;
    for ($x = 0; $x <= $mrchCount; $x++) {
        $item[$x] = $mrch[$i][$x];
        $price[$x] = $mrchPrice[$i][$x];
        $price[$x] = str_replace("null","",$price[$x]);
        $price[$x] = str_replace('$','',$price[$x]);
        echo "<div class='itemContainer'>";
        echo "<div class='itemsEdit' style=''>$item[$x]</div>";
        if($price[$x] != ''){
            echo "<div class='priceEdit' style=''>$$price[$x]</div>";
        }else{
            echo "<div class='priceEdit' style=''>$price[$x]</div>";
        }
        
        echo "</div>";
    }

    echo"<button class='btn btn-primary edit' data-toggle='modal' data-target='#myModal_$id[$i]' id='model_$id[$i]' data-id='$id[$i]' id='delete'>EDIT</button>";
    echo"<button class='btn btn-primary delete' data-id='$id[$i]' id='delete'>DELETE</button>";
    echo "</div>";

    echo '<div class="modal fade reload" id="myModal_' . $id[$i] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Model</h4>
            </div>
            <div class="modal-body">
                <input type="text" value="' . $store[$i] . '"  id="storeName_'.$id[$i].'" />
                <input type="text" value="' . $modelNum[$i] . '"  id="modelNum_'.$id[$i].'" />
                <div class="multi-field-wrapper_' . $id[$i] . '">
                    <div class="multi-fields_' . $id[$i] . '">';
                        

    
    for ($x = 0; $x <= $mrchCount; $x++) {
        $item[$x] = $mrch[$i][$x];
        $price[$x] = $mrchPrice[$i][$x];
echo '<div class="multi-field_' . $id[$i] . '">';
        echo '<input type="text" value="' . $item[$x] . '" class="items" name="stuff[]" >';
        echo '<input type="text" value="' . $price[$x] . '" class="itemsPrice" name="stuff[]" >';
        echo '<button type="button" class="remove-field">Remove</button><br/>';
        echo'    </div> ';
    }

     echo'
                    </div>
                    <button class="btn btn-primary btn-lg" id="addItem_'.$id[$i].'">Add Item</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="save_' . $id[$i] . '" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

        
           

       
    </div>
</div>';

    echo"</li>";
}



echo "</ul>";
echo "<script>";
for ($i = 0; $i <= $resCount - 1; $i++) {
    
    $id[$i] = $res[$i]['id'];
    echo '
        
jQuery("#myModal_' . $id[$i] . '").on("hidden.bs.modal", function (e) {
  jQuery("#newResult").load("addModel/control/control_getModel.php");
});

    $(".multi-field-wrapper_'.$id[$i].'").each(function() {
                var $wrapper = $(".multi-fields_'.$id[$i].'", this);
                $("#addItem_'.$id[$i].'", $(this)).click(function(e) {
                    $(".multi-field_'.$id[$i].'", $wrapper).first().clone(true).appendTo($wrapper).find("input").val("").focus();
                });
                $(".multi-field_'.$id[$i].' .remove-field", $wrapper).click(function() {
                    if ($(".multi-field_'.$id[$i].'", $wrapper).length > 1)
                        $(this).parent(".multi-field_'.$id[$i].'").remove();
                });
            });
            var items = "";
            var price = "";
            
            jQuery("#save_'.$id[$i].'").click(function() {
                var store = jQuery("#storeName_'.$id[$i].'").val();
                var modelNum = jQuery("#modelNum_'.$id[$i].'").val();
                jQuery(".multi-field_'.$id[$i].' .items").each(function() {
                    if (items === "") {
                        items = jQuery(this).val();
                    } else {
                        items = items + "|" + jQuery(this).val();
                    }

                });
                jQuery(".multi-field_'.$id[$i].' .itemsPrice").each(function() {
                    if (price === "") {
                        price = jQuery(this).val();
                        if(price === ""){
                    price = "null";
                }
                    } else {
                       var newPrice = jQuery(this).val();
                if(newPrice === ""){
                    newPrice = "null";
                }
                price = price + "|" + newPrice;
                    }

                });
                 var modelID = "'.$id[$i].'";
                jQuery.post("addModel/control/control_updateModel.php", {store: store, modelNum: modelNum, items: items, price: price, id:modelID});
                
              
                       //alert("store="+store+" modelNum="+modelNum+" items="+items+" price="+price+" id="+modelID);
                   
                        //jQuery("#newResult").html("");
                        
                   //jQuery("#newResult").load("addModel/control/control_getModel.php");
                   
                $("#myModal_'.$id[$i].'").modal("toggle");
            });';
}
echo "</script>";
 

?>








<script>
    jQuery(function() {
        jQuery('#sortable').sortable({opacity: 0.8, cursor: 'move', update: function() {
                var order = jQuery(this).sortable("serialize");
                jQuery.post("addModel/control/control_updateModelNumber.php", order);
                //alert(order);
            }
        });
        //jQuery( '#sortable' ).disableSelection();
    });

    jQuery('.delete').click(function() {
        var id = jQuery(this).data('id');
        // alert(id);
        jQuery('#newResult').load('addModel/control/control_deleteModel.php?id=' + id);
    });
    
</script>


