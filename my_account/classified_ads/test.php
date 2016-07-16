<?php 
	require_once("../../classes/core/core.class.php");
	$objCore=new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
	$objClassifiedAd = new ClassifiedAd();
	$objClassifiedAd->addToTbl($_REQUEST['cusId'], $_REQUEST['category'], $_REQUEST['ad_title'], $_REQUEST['keywords'], $_REQUEST['notes'], $_REQUEST['price']);
	echo $objClassifiedAd->checkAmount($_REQUEST['cusId']); 
?>

<form id="frmClassifiedAds" name="frmClassifiedAds" action="" method="post" enctype="multipart/form-data">
<!--  <form action="" method="post" name="frmClassifiedAds" id="frmClassifiedAds" enctype="multipart/form-data">-->
    <table>
           <tr><td>cusId</td><td><input type="text" name="cusId" value="195atPFEoO87DplQYeRdfxyhFS9ukG252VPYLVDZkzs551dnIVQNtp1239160604" /><br/>	
               </td></tr>
                <tr><td>  category</td><td><select name="category">
		<option value="3_70_73">Wooden</option>
		<option value="3_70_74">Steel</option>
		<option value="3_70">Stairs</option>
		<option value="3_71">Fireplace</option>
		<option value="3_72">Radiator</option>
                </select><br/>
	<tr><td>ad_title</td><td><input type="text" name="ad_title" value="" /><br/></td></tr>
	<tr><td>keywords</td><td><input type="text" name="keywords" value="" /><br/></td></tr>
	<tr><td>notes</td><td><input type="text" name="notes" value="" /><br/></td></tr>
	<tr><td>price</td><td><input type="text" name="price" value="" /><br/></td></tr>
	
        
        <tr id="imgUpload">
            <td class="key" align="right">Image</td>
            <td>
                <div id="debug" name="debug"></div>

                <!--
                  Display loading image.
                -->
                <div id="divProcess" style="display:none">
                    Uploading Image...
                </div>

                <!--
                   Image is uploaded and display in this div.
                -->
                <div id="uploadingImg"></div>

                <!--
                   Display zoom icon in here.
                -->
                <div id="zooming" style="display:none">
                    <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                </div>

                <!--
                  Use this form to display file browse part.
                -->
                <form action="scripts/ajaxupload.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
                    <input type="hidden" name="maxSize" value="9999999999" />
                    <input type="hidden" name="maxW" value="200" />
                    <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                    <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                    <input type="hidden" name="colorR" value="255" />
                    <input type="hidden" name="colorG" value="255" />
                    <input type="hidden" name="colorB" value="255" />
                    <input type="hidden" name="maxH" value="300" />
                    <input type="hidden" name="filename" value="filename" />
                    <input type="hidden" name="imgFolder" value="clas_ads" id="imgFolder"/>
                    <input type="file" name="filename" onchange="getFieldNames('keyName','frmClassifiedAds','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess');  return true;" />
                </form>
            </td>
         </tr>
         <tr><td>
        <!--
          Use this hidden field to keep the image key.
        -->
        <input type="hidden" name="keyName" value="" id="keyName"/>
	<input type="button" name="Submit" value="Submit" />
             </td></tr>
        </table>
       
</form>
