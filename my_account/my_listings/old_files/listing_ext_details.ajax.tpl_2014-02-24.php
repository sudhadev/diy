<?php
/* --------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  listing_ext_detail.ajax.tpl.php                                           '
  '    PURPOSE         :  provide the template for listing extra information     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

require_once("../../classes/core/core.class.php");
$objCore = new Core;

/**
 * Display the logged user.
 */
$objCore->auth(1, true);

require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
if (!is_object($objListing)) {
    $objListing = new Listing;
}
//echo $_POST['id'];
$control = explode('_', $_POST['control']);
$spec_id = $control[0];
//echo $spec_id;

if ($_POST['id'] != '') {
    $listing = $objListing->dList("WHERE id=" . $_POST['id'] . "");
    
    $listing_spec_id = $objListing->dList_spec("WHERE id=" . $spec_id . "");

    $listing_spec[0][0] = $listing_spec_id[0][0];
    $listing_spec[0][1] = trim($listing_spec_id[0][1]);
    $listing_spec[0][2] = trim($listing_spec_id[0][2]);
} else {
    $listing = $objListing->dList_spec("WHERE id=" . $spec_id . "");

    //if($listing[0][0]){
    $listing_spec[0][0] = $listing[0][0];
    $listing_spec[0][1] = trim($listing[0][1]);
    $listing_spec[0][2] = trim($listing[0][2]);
//}
//else{
//    $listing_spec[0][0] = "";
//    $listing_spec[0][1] = "Specification doesn't have any description";
//    $listing_spec[0][2] = "Specification doesn't have any specification";
//} 
}

$image_array = explode('|*|', $_POST['image_list']);
//echo $_POST['image_list'];
?>
<!-- <div class="common_text" style="font-size:10px;"> <br/> <?php echo str_replace("{%MAX_SIZE%}", $objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'], $objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']); ?></div>-->

<div style="margin-top: -35px;">
<?php
$image_path_array = array(0 => 14, 1 => 22, 2 => 23, 3 => 24);
$image_issue=FALSE;

for ($i = 0; $i < 4; $i++) {

    if ($i == 0) {
        $n = '';
        $style = "padding-left:138px;";
    } else {
        $n = $i;
        $style = "";
    }
    ?>
        <div class="image_path<?php echo $n; ?>" style="display: inline;
             float: left;
             width: 80px;padding-left: 20px; padding-top: 5px;<?php echo $style; ?>">
            <!--
               Image is uploaded and display in this div.
            -->
            <div id="uploadingImg<?php echo $n; ?>" style="min-height: 85px;margin-top: 20px;">
    <?php
    $marker = 0;
    //echo $i;
    //print_r($image_array[$i]);
    //if($listing[0][14]==""||$listing[0][14]=="no_image.jpg"){
    
    
    if ($_POST['id'] == '') {

        if ($i == 0) {
            if ($image_array[0] != "") {
                $imgUrl = $objListing->image($image_array[0], $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], $objCore->sessCusId);
                $zoomImage = $image_array[$i];
            } else {
                $imgUrl = $objListing->image($listing[0][0], $objCore->_SYS['CONF']['FTP_SPECS'], $objCore->_SYS['CONF']['URL_IMAGES_SPECS'], '');
                $zoomImage = $listing[0][0];
                
                if(is_file($objCore->_SYS['CONF']['FTP_SPECS'].'/thumbs/'.$listing[0][0])){
                copy($objCore->_SYS['CONF']['FTP_SPECS'].'/thumbs/'.$listing[0][0], $objCore->_SYS['CONF']['FTP_LISTINGS'].'/'.$objCore->sessCusId.'/thumbs/'.$listing[0][0]);
                copy($objCore->_SYS['CONF']['FTP_SPECS'].'/large/'.$listing[0][0], $objCore->_SYS['CONF']['FTP_LISTINGS'].'/'.$objCore->sessCusId.'/large/'.$listing[0][0]);
                //echo '<script>$("#keyName_'.$_POST['control'].'").val('.$listing[0][0].');</script>';
                }
            }
        } else {
            $imgUrl = $objListing->image($image_array[$i], $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], $objCore->sessCusId);
            $zoomImage = $image_array[$i];
        }
    } else {
        if ($image_array[$i] == '' || $image_array[$i] == 'no_image.jpg') {
            if ($i == 0) {
                
                if ($listing[0][$image_path_array[$i]] == '' || $listing[0][$image_path_array[$i]] == "no_image.jpg") {
                    $imgUrl = $objListing->image($listing_spec[0][0], $objCore->_SYS['CONF']['FTP_SPECS'], $objCore->_SYS['CONF']['URL_IMAGES_SPECS'], '');
                    $zoomImage = $listing_spec[0][0];
               if(is_file($objCore->_SYS['CONF']['FTP_SPECS'].'/thumbs/'.$listing_spec[0][0])){     
                copy($objCore->_SYS['CONF']['FTP_SPECS'].'/thumbs/'.$listing_spec[0][0], $objCore->_SYS['CONF']['FTP_LISTINGS'].'/'.$objCore->sessCusId.'/thumbs/'.$listing[0][0]);
                copy($objCore->_SYS['CONF']['FTP_SPECS'].'/large/'.$listing_spec[0][0], $objCore->_SYS['CONF']['FTP_LISTINGS'].'/'.$objCore->sessCusId.'/large/'.$listing[0][0]);
               }
                } else {
                    $imgUrl = $objListing->image($listing[0][$image_path_array[$i]], $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], $listing[0][5]);
                    $zoomImage = $listing[0][$image_path_array[$i]];
                }
            } else {
                $imgUrl = $objListing->image('no_image.jpg', $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], '');
                $zoomImage = $listing[0][$image_path_array[$i]];
            }
        } else { 
			
            $imgUrl = $objListing->image($image_array[$i], $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], $listing[0][5]);
            $zoomImage = $image_array[$i];
        }
    }

    
    if($i == 0){
    	$image_issue=$imgUrl;
    }
    ?>
                <img width="65" border="0" src="<?php echo $imgUrl; ?>" />
                <br/>
                <?php
                if ($_POST['id'] == '') {
                    ?>
                    <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/zoom_prods.php','<?php echo $zoomImage . "_spl_" . $objCore->sessCusId; ?>','listing');"><img  border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT']; ?>/zoom.png" /></a>

                    <?php
                } else {
                    ?>
                    <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/zoom_prods.php','<?php echo $zoomImage . "_spl_" . $listing[0][5]; ?>','listing');"><img  border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT']; ?>/zoom.png" /></a>

                    <?php
                }
                ?>

            </div>
            <!--
               Display zoom icon in here.
            -->
            <div id="zooming<?php echo $n; ?>" style="display:none">
                <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/zoom_prods.php','listings');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT']; ?>/zoom.png" /></a>
            </div>

            <form id="extDat<?php echo $n; ?>" name="extDat<?php echo $n; ?>" action="">  
                <input type="hidden" name="maxSize" value="9999999999" />
                <input type="hidden" name="maxW" value="200" />
                <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>" />
                <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>" />
                <input type="hidden" name="colorR" value="255" />
                <input type="hidden" name="colorG" value="255" />
                <input type="hidden" name="colorB" value="255" />
                <input type="hidden" name="maxH" value="300" />
                <input type="hidden" name="filename" value="filename" />
                <input type="hidden" name="imgFolder" value="listings" id="imgFolder"/>
                <input type="hidden" name="logUser" value="<?php echo $objCore->sessCusId; ?>" id="logUser"/>
    <!--                    <input type="file" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName','extDat','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg','divProcess');  this.value='';return true;" />
                <input type="file" class="add_cladds_txtfield" name="filename2" onchange="clearMsg('error_msg');getFieldNames('keyName2','extDat','zooming2'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg2','divProcess');  this.value='';return true;" />
                <input type="file" class="add_cladds_txtfield" name="filename3" onchange="clearMsg('error_msg');getFieldNames('keyName3','extDat','zooming3'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg3','divProcess');  this.value='';return true;" />-->
                <div style="position: relative;overflow: hidden; width: 85px; float: left;margin-left: 10px">                           
                    <input type="file" style="position: relative;
                           text-align: right;
                           -moz-opacity:0 ;
                           filter:alpha(opacity:0);
                           opacity: 0;
                           z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName<?php echo $n; ?>_<?php echo $_POST['control']; ?>','frmListingED','zooming<?php echo $n; ?>'); ajaxUpload('extDat<?php echo $n; ?>','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg<?php echo $n; ?>','divProcess');  this.value='';return true;" />

                    <div class="fakefile" style="position: absolute;
                         top: 0px;
                         left: 0px;
                         z-index: 1;text-decoration: underline; cursor: pointer;">
                 <!--		<input />-->
    		Upload Image
                    </div>      
                </div>  

    <!--        <input type="hidden" name="keyName" value="<?php //echo $listing[0][14]; ?>" id="keyName"/>-->

                <input type="hidden" name="blankimagePath" value="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'] . "/thumbs/"; ?>" id="blankimagePath"/>
                <input type="hidden" name="imagePath" value="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'] . "/" . $objCore->sessCusId . "/thumbs/"; ?>" id="imagePath"/>

            </form>
        </div>

    <?php
}// echo $image_issue;


?>
    <br/><br/>
    <div id="divProcess" style=" margin-left: 20px;
         margin-top: -140px;float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div>
     <!--<table width="80%" border="0" align="center">
                         <tr>
                             <td class="" style="padding-top:10px; ">
                                 
                             </td>
                         </tr>
     
                     </table>-->

    <!--
       Use this form to display file browse part.
    -->
    <div class="" style="width:500px;">
        <form id="frmListingED" name="frmListingED" action="" style="vertical-align:top">
<!--            <div class="contact_fieldBlock_left" style="margin-top:10px;">Image: <span class="required_fields"></span></div>-->
            <!--            <div class="contact_fieldBlock_right">-->

            <!--
             Display loading image.
            -->


            <div id="message_holder">
                <div id="error_msg" style="margin-left: -8px; width: 630px;">
<?php
/*
 * classified ads messages has been used here because
 * those are identically similar on image uploading as @ 2010-June
 * if the requirenments get changed in the future, pls add relavant
 * configurations in message.config.php
 */
if ($msg) {
    echo $objCore->msgBox("CLASSIFIED_ADS", $msg, '400px');
} elseif ($_REQUEST['msg1'] != "" && $_REQUEST['msg2'] != "") {
    $msg = array($_REQUEST['msg1'], $_REQUEST['msg2']);
    echo $objCore->msgBox("CLASSIFIED_ADS", $msg, '400px');
}
?>
                </div>

            </div>

<!--                    <input type="file" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName','extDat','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg','divProcess');  this.value='';return true;" />nput type="file" class="add_cladds_txtfield" name="filename4" onchange="clearMsg('error_msg');getFieldNames('keyName4','extDat','zooming4'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']; ?>/ajaxupload.php','uploadingImg4','divProcess');  this.value='';return true;" />-->


            </label>
            <!--            </div>-->

            <div class="contact_fieldBlock_left">Listing Header: <span class="required_fields"></span></div>
            <div class="contact_fieldBlock_right">

                <input type="text" id="listheader" name="listheader" value="<?php echo $listing[0][21]; ?>" style="width: 400px;"/>

            </div>

            <div class="contact_fieldBlock_left">Description: <span class="required_fields"></span></div>
            <div class="contact_fieldBlock_right">

<!--                 <script>
$(document).ready(function(){
if($('#select_delivery').val('0')){
$('#select_rate').attr('disabled','disabled');
}
});

</script>-->
                <script>
                    
                    

                    if(document.getElementById('list_des_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('listED').innerHTML = document.getElementById('list_des_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_spec_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('listSPEC').innerHTML = document.getElementById('list_spec_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_head_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('listheader').value = document.getElementById('list_head_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_sup_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('supplier_code').value = document.getElementById('list_sup_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_url_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('product_url').value = document.getElementById('list_url_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_del_<?php echo $_POST['control']; ?>').value!=""){
                        setSelectedIndex('select_del',document.getElementById('list_del_<?php echo $_POST['control']; ?>').value);
                        //document.getElementById('select_del').value = document.getElementById('list_del_<?php echo $_POST['control']; ?>').value;
                    }
                    if(document.getElementById('list_rate_<?php echo $_POST['control']; ?>').value!=""){
                        document.getElementById('select_rate').value = document.getElementById('list_rate_<?php echo $_POST['control']; ?>').value;
                    }
                    
                    
                </script>
<?php
$post_values = explode('-dlm-', $_POST['pass_details']);

if ($post_values[4] != '') {
    ?>
                    <textarea id="listED" name="listED" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $post_values[4])); ?></textarea> 
    <?php
} elseif ($listing[0][15] == "") {
    ?>
                    <textarea id="listED" name="listED" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $listing_spec[0][1])); ?></textarea> 
    <?php
} else {
    ?>
                    <textarea id="listED" name="listED" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $listing[0][15])); ?></textarea> 

                    <?php
                }
                ?>

                <input type="hidden" name="specdesc" id="specdesc" value="<?php echo trim(str_replace('-amp;', '&', $listing_spec[0][1])); ?>">
                <!--                <div class="common_text" style="font-size:10px;">* Keep your description in less than 255 Characters  </div>-->
            </div>

            <div class="contact_fieldBlock_left">Specification: <span class="required_fields"></span></div>
            <div class="contact_fieldBlock_right">
                <?php
                if ($post_values[5]) {
                    ?>
                    <textarea id="listSPEC" name="listSPEC" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $post_values[5])); ?></textarea> 

                    <?php
                } elseif ($listing[0][20] == "") {
                    ?>
                    <textarea id="listSPEC" name="listSPEC" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $listing_spec[0][2])); ?></textarea> 
                    <?php
                } else {
                    ?>
                    <textarea id="listSPEC" name="listSPEC" style="width:578px;height: 100px;border:default;"><?php echo trim(str_replace('-amp;', '&', $listing[0][15])); ?></textarea> 

    <?php
}
?>


                <!--                <div class="common_text" style="font-size:10px;">* Keep your description in less than 255 Characters  </div>-->
            </div>
            <?php //echo $post_values[8]; ?>
            <div class="contact_fieldBlock_left">Delivery: <span class="required_fields"></span></div>
            <div class="contact_fieldBlock_right"> 
                <select name="select_delivery" id="select_delivery" class="mng_mylistings_short" style="width:140px;" onchange="toggleselection('select_delivery','select_rate');">
                <?php
                if ($post_values[8] > 0) {
                   // $bdOptionList = '<option value="-" >-----------</option>' . "\n";
                    $bdOptionList = ' ' . "\n";
                    $bdOptionList .= '<option value="0" >Pickup only</option>' . "\n";
                    $bdOptionList .= '<option value="1" selected>Yes</option>' . "\n";
                }
                elseif ($post_values[8] == "-" || $post_values[8] == "") {
                    //$bdOptionList  = '<option value="-" selected>-----------</option>' . "\n";
                    $bdOptionList = ' ' . "\n";
                    $bdOptionList  .= '<option value="0" selected>Pickup only</option>' . "\n";
                    $bdOptionList .= '<option value="1">Yes</option>' . "\n";
                }
                else {
                   //$bdOptionList  = '<option value="-" >-----------</option>' . "\n";
                   $bdOptionList = ' ' . "\n";
                    $bdOptionList  .= '<option value="0" selected>Pickup only</option>' . "\n";
                    $bdOptionList .= '<option value="1">Yes</option>' . "\n";
                }

                echo $bdOptionList;
                ?>
                </select>
                
                <!--select name="select_delivery" id="select_delivery" class="mng_mylistings_short" style="width:140px;" >
                	<option value="0">Free UK</option>
                	<option value="1">RING</option>
                	<option value="2">Input Amount</option>
                </select-->
                <span style="margin-left: 15px;"><strong>If Yes:</strong>  

<?php
if ($post_values[8] == '0' || $post_values[8] == '' || $post_values[8] == '-') {
    ?>
      <select name="select_rate" id="select_rate" class="mng_mylistings_short" style="width:140px;" disabled>
    <?php
    //if($post_values[8] == '-' || $post_values[8]==" "){
        $bdOptionListRate = '<option value="0" selected>Ring for details</option>' . "\n";
   // }
    //else{
      //  $bdOptionListRate = '<option value="-" selected>-----------------</option>' . "\n";
    //}
    
} else {
    ?>
                      <select name="select_rate" id="select_rate" class="mng_mylistings_short" style="width:140px;">
                        <?php
                        $bdOptionListRate = '<option value="0" >Ring for details</option>' . "\n";
                    }

                    $i = 5;
                    while ($i < 55) {
                        $bdOptionListRate .= '<option value="' . $i . '" >£' . $i . '</option>' . "\n";
                        $i = $i + 5;
                    }

                    if ($post_values[9] != "") {
                        echo str_replace('value="' . $post_values[9] . '"', 'value="' . $post_values[9] . '" selected ', $bdOptionListRate);
                    } else {
                        echo str_replace('value="' . $listing[0][18] . '"', 'value="' . $listing[0][18] . '" selected ', $bdOptionListRate);
                    }
                    ?>
                        </select>
                        </div>

                        <div class="contact_fieldBlock_left">Supplier Code: <span class="required_fields"></span></div>
                        <div class="contact_fieldBlock_right">

                            <input type="text" id="supplier_code" value="<?php if ($post_values[5])
                            echo $post_values[5]; echo $listing[0][16]; ?>" style="width: 135px;"/>
                            <span style="margin-left: 15px;"><strong>URL&nbsp;&nbsp;:</strong> <input type="text" id="product_url" value="<?php if ($post_values[10])
                                echo $post_values[10]; echo $listing[0][19]; ?>" style="width: 135px;"/></span>
                        </div>

                        <div class="contact_fieldBlock_left"></div>
                        <div class="contact_fieldBlock_right">
                            <a href="javascript: cancelExtraDetails();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/cancel.jpg" border="" ></a>
                            <label id="submit_contact_details">

                                <a href="javascript:commitExtraDetails('<?php echo $_POST['control']; ?>');"><img alt="Edit" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/edit.jpg"/></a>
                            </label>
                        </div>
                        <?php
                        
                        
                        
                        
                        if($image_array[0]==""){
                        	$image_hid_one = $listing[0][0];
                        /*	$image_array_ex = explode('/', $image_issue);
                        	
                        	$image_hid_one =$image_array_ex[count($image_array_ex)-1];*/
                        }
                        else{
                        	$image_hid_one =  $image_array[0];
                        }
                        
                       
                        ?>
                        
                        <input type="hidden" name="keyName_<?php echo $_POST['control']; ?>" id="keyName_<?php echo $_POST['control']; ?>" value="<?php echo $image_hid_one; ?>"/>
                        <input type="hidden" name="keyName1_<?php echo $_POST['control']; ?>" value="<?php echo $image_array[1]; ?>" id="keyName1_<?php echo $_POST['control']; ?>"/>
                        <input type="hidden" name="keyName2_<?php echo $_POST['control']; ?>" value="<?php echo $image_array[2]; ?>" id="keyName2_<?php echo $_POST['control']; ?>"/>
                        <input type="hidden" name="keyName3_<?php echo $_POST['control']; ?>" value="<?php echo $image_array[3]; ?>" id="keyName3_<?php echo $_POST['control']; ?>"/>


<?php
//        $where = " WHERE `customer_id`='".$objCore->sessCusId."'";
//        $cus_list = $objCustomer->dList($where);
//        $cus_tbl_id = $cus_list[0][6];
?>

                        </form>

                        </div>
                        </div>