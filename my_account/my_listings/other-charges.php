<?php
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  require_once("../../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,true);

   require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);

    if (!is_object($objSearch))
    {
        $objSearch = new Search($objCore->gConf);
    }

    //
    $categoryId=$_REQUEST['cid'];
    $specificationId=$_REQUEST['sid'];
    $manufacturerId=$_REQUEST['mid'];
    
    $objSearch->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
    $objSearch->pgBarStrNext='<span id="pgBarImgNext">Next </span>';
    $listSuppliers=$objSearch->getSuppliers($categoryId, $specificationId, $manufacturerId,$_REQUEST['pg'],5,"cid=$categoryId&sid=$specificationId&mid=$manufacturerId",5);
  
    $unitCostMinAndMax=$objSearch->getMinMaxUnitCost($categoryId, $specificationId, $manufacturerId);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
</head>

<body>
<div align="center">
<div id="outer_full">
<div id="mainDiv_full">

<!-- START PAGE HEADER -->
<div id="top-bar">
<div id="top-bar-left">
<div id="logo"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/small-logo.jpg" alt="logo" width="270" height="65" /></div>
</div>
<div id="top-bar-shade">
<div class="activate_header">What are the others charging?</div>
</div>
<!-- END PAGE HEADER -->

<!-- START PAGE MIDDLE -->
<div id="page-middle">
<div id="page-middle-middle">
<div id="page-middle-content">
<div id="page-middle-middle-content">
<table width="698" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="14" height="10"></td>
    <td width="670" height="10" ></td>
    <td width="14" height="10"></td>
  </tr>
  <tr>
    <td width="14"></td>
    <td width="670" align="center">
    <div id="charges_specification_bg">
    <div id="left"></div>
    <div id="middle">
    <!--<div class="description_text_big">Plasterboard 12.5 2400mm x 1200mm TE<br />
<span class="common_text_ash">Notes:</span> <span class="common_text">General use plasterboard for stud walls and ceilings</span> </div>-->
<div class="common_text">
<span class="common_text_ash" style="padding-right:50px;"><strong>Spefication:</strong></span> <span class="common_text"><?php echo $listSuppliers[0][10];?></span><br />
<br />
<span class="common_text_ash" style="padding-right:35px;"><strong>Manufacturer:</strong></span> <span class="common_text"><?php echo $listSuppliers[0][15];?></span><br />
<br />

<span class="common_text_ash" style="padding-right:25px;"><strong>Price Range (£):</strong></span> <span class="common_text"><?php echo $unitCostMinAndMax[0];?> - <?php echo $unitCostMinAndMax[1];?></span>
</div>
    </div>
    <div id="right"></div>
    </div>    </td>
    <td width="14"></td>
  </tr>

  <tr>
    <td></td>
    <td style="padding:10px 5px 6px 0px;">&nbsp;<?php echo $objSearch->pgBar;?></td>
    <td></td>
  </tr>
</table>

<table width="652" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr >
    <td width="6" id="grid_left_end">
    </td><td class="grid_middle chagrs_grid_heading">Supplier</td>
    <td width="1" class="grid_break">
    </td><td class="grid_middle chagrs_grid_heading" style="width:70px;">UnitCost (£)</td>
    <td width="1" class="grid_break">
    </td><td class="grid_middle chagrs_grid_heading" style="width:90px;">Bulk Discount (Km)</td>
    <td width="1" class="grid_break">
    </td><td class="grid_middle chagrs_grid_heading" style="width:70px;">Bulk Price (£)</td>
    <td width="1" class="grid_break">
    </td><td class="grid_middle chagrs_grid_heading" style="width:70px; ">Delivery (£)
    </td><td width="6" id="grid_right_end">
  </td></tr>

   <?php
    for($ls=0;$ls<count($listSuppliers);$ls++)
    {



    ?>
    <tr class="<? echo ($ls%2)? 'cadd_descriptionrow_gray': '';?>" style="vertical-align: top;">
    <td width="6">
    </td><td class="chagrs_grid_text"><strong><?php echo $listSuppliers[$ls][21];//$listSuppliers[$ls][0]." ".$listSuppliers[$ls][1] ;?></strong><br/><a href="mailto:<?php echo $listSuppliers[$ls][3];?>"><?php echo $listSuppliers[$ls][3];?></a></td>
    <td width="1">
    </td><td class="chagrs_grid_text" style="text-align:right;"><?php echo $listSuppliers[$ls][6];?></td>
    <td width="1">
    </td><td class="chagrs_grid_text numeric_texts" style="text-align:right;"><?php echo $listSuppliers[$ls][7];?></td>
    <td width="1">
    </td><td class="chagrs_grid_text" style="text-align:right;"><?php echo $listSuppliers[$ls][8];?></td>
    <td width="1">
    </td><td class="chagrs_grid_text" style="text-align:right;"><?php echo $listSuppliers[$ls][9];?></td>
    <td width="6">
  </td></tr>
  <?php }?>

                     </tbody></table>
</div>
</div>
</div>
</div>
<!-- ENDPAGE MIDDLE -->


</div>
</div>
</div>
</div><br/><br/><br/>
</body>
</html>
