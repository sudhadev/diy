<?php
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();	 
?>

<div id="sortby_div">
	<div class="sortby_text common_text"><strong>Sort by</strong></div>
	<div class="sortby_box">
	<?php
		if ($_REQUEST['categories'] == 2)
		{
			$orderByArray = array("0"=>"-----------", "1"=>"Nearest", "2"=>"Price");
		}
		elseif ($_REQUEST['categories'] == 3)
		{
			$orderByArray = array("0"=>"-----------", "1"=>"Nearest", "2"=>"Price");
		}
     ?>
     <form>
     <?php
		echo $objComponent->drop('order_by', $_REQUEST['order_by'], $orderByArray, 'cat_sortby_dropdown', 'onchange=form.submit()');
        if ($objCore->curSection() == 'search')
							{
							$strSearch = explode("|DLM|", $strSearch);
							?>
								<input type="hidden" id="categories" name="categories" value="<?php echo $strSearch[0];?>">
								<input type="hidden" id="keyword" name="keyword" value="<?php echo $strSearch[1];?>">
								<input type="hidden" id="address" name="address" value="<?php echo $strSearch[2];?>">
								<input type="hidden" id="radius" name="radius" value="<?php echo $strSearch[3];?>">
								<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strSearch[5];?>">
								<input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strSearch[6];?>">
								<input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strSearch[7];?>">
								<input type="hidden" id="latitude" name="latitude" value="<?php echo $strSearch[8];?>">
								<input type="hidden" id="longitude" name="longitude" value="<?php echo $strSearch[9];?>">
								<input type="hidden" id="pg" name="pg" value="<?php echo $strSearch[10];?>">
								<?php }
								elseif ($objCore->curSection() == 'browse')
								{
								$strBrowse = explode("|DLM|", $strBrowse);
								?>
								<input type="hidden" id="f" name="f" value="<?php echo $strBrowse[0];?>">
								<input type="hidden" id="tcid" name="tcid" value="<?php echo $strBrowse[1];?>">
                                <input type="hidden" id="pcid" name="pcid" value="<?php echo $strBrowse[8];?>">
								<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strBrowse[2];?>">
								<input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strBrowse[3];?>">
								<input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strBrowse[4];?>">
								<input type="hidden" id="pg" name="pg" value="<?php echo $strBrowse[6];?>">
								<input type="hidden" id="categories" name="categories" value="<?php echo $strBrowse[7];?>">
								<?php }?>
    </form> 
	</div>
</div>