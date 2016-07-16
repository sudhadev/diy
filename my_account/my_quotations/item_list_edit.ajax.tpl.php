<?php 
	/*---------------------------------------------------------------------------\
	'    This file is part of shoping Cart in module library of FUSIS            '
	'    (C) Copyright 2004 www.fusis.com                                        '
	' .......................................................................... '
	'                                                                            '
	'    AUTHOR          :  Sadaruwan Hettiarachchi <sadaruwan@fusis.com>          '
	'    FILE            :  my_account/my_quotations/quotation_edit.ajax.tpl.php     	   '
	'    PURPOSE         :  list specifications page of the specification section'
	'    PRE CONDITION   :  commented                                            '
	'    COMMENTS        :                                                       '
	'---------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	$objCore->auth(1,true);
	require_once($objCore->_SYS['PATH']['CLASS_QUOTATION']);$objQuotation = new Quotation('',$objCore->gConf,$objCore->sessCusId);
    switch($_POST['action']){
		case"del":{
			$objQuotation->delItem($_POST['qid'],$_POST['id']);
            
		}break;
		case"edit":{
			$msg  = $objQuotation->editItem($_POST);
			if ($msg)
                        {
                            echo $objCore->msgBox("QUOTATIONS",$msg);
                        }
		}break;
		case"moveup":{
			$objQuotation->moveItemUp($_POST['qid'],$_POST['id']);
		}break;
		case"movedown":{
			$objQuotation->moveItemDown($_POST['qid'],$_POST['id']);
		}break;
       case"editgeninfo":{
		 	$msg  = $objQuotation->editGenInfo($_POST);
			if ($msg)
                        {
                            echo $objCore->msgBox("QUOTATIONS",$msg);
                        }
		}break;
		
	}
	
	$list = $objQuotation->getQuotationItems($_POST['qid']);
	$qdetails = $objQuotation->getQuotationDtails($_POST['qid']);
    $imageQuote=$objQuotation->image($qdetails[0]['himage']);

	
 switch($_POST['action']){
     case"del":
	 case"edit":
     case"moveup":
     case"movedown":{

 ?>

                  <table border="0" width="632" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td><form action="#" method="post" id="items" name="items"><table border="0" width="632" cellspacing="0" cellpadding="0">
                                          <tbody><tr>
                                            <td width="6" id="grid_left_end"></td>
                                            <td class="grid_middle chagrs_grid_heading">Item</td>
                                            <td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading">Description</td>
                                            <td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading">Actual Unit<br/> Price (£)</td>
                                            <td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading">Markup<br/>
                                            Price</td>
                                            <td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading">Quantity or<br/> hourly rate</td>
                                            <td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading">Total <br/>price</td>
											<td width="1" class="grid_break"></td>
                                            <td class="grid_middle chagrs_grid_heading" style="width:5px;">Delete | Move</td>
                                            <td width="6" id="grid_right_end"></td>
                                          </tr>
                                            <? $counter=0;for ($n=0; count($list)>$n; $n++ ){
/*
                                            	switch ($list[$n][0]['type']){
                                                    case"M":
                                                    {
                                                         $qlDesc=$list[$n][0][16].'<br/>'.$list[$n][0][10].'<br/>'.$list[$n][0][0].'&nbsp;'.$list[$n][0][1].'&nbsp;-&nbsp;'.$list[$n][0][2];
                                                    }break;
                                                    case "S":
                                                    {
                                                         $qlDesc=$list[$n][0][16].'<br/>'.$list[$n][0][0].'&nbsp;'.$list[$n][0][1].'&nbsp;-&nbsp;'.$list[$n][0][2];
                                                    }break;
                                                     case "C":
                                                    {
                                                         $qlDesc=$list[$n][0][8].'<br/>'.$list[$n][0][0].'&nbsp;'.$list[$n][0][1].'&nbsp;-&nbsp;'.$list[$n][0][2];

                                                    }

                                                }
                                                 $qlId= $list[$n][0]['id'];
                                                 $qlEmail=$list[$n][0][3];

                                               */

                                            switch ($list[$n][0]['type']){
                                                    case"M":
                                                    {
                                                    if($list[$n][0][16]){
													?>
                                          <tr style="vertical-align: top;"  class="<? echo ($counter%2)? 'cadd_descriptionrow_gray': '';?>">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$counter+1;//$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?php echo $list[$n][0][16].'<br/>'.$list[$n][0][10].'<br/>'.$list[$n][0][0].'&nbsp;'.$list[$n][0][1].'&nbsp;-&nbsp;'.$list[$n][0][2];?></div>
											<div class="requested_category_details_sub">
											<div class="description_subdesc_mailicon">&nbsp;</div>
											<div class="requested_category_details_mailad"><a href="mailto:<?=$list[$n][0][3];?>"><?=$list[$n][0][3];?></a></div>										</div>
											</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0][6],2);?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
                                            <input type="text" class="numeric_texts" maxlength="6" size="2" name="unitp[<?=$list[$n][0]['id'];?>]" id="unitp[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['cp'];?>"/></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
											<input type="text" class="numeric_texts" maxlength="6" size="2" name="qty[<?=$list[$n][0]['id'];?>]" id="qty[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['qty'];?>" />
											</td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><strong><?=number_format($list[$n][0]['totle'],2);?></strong></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
<!--                                                <div class="edit_colmn_div"><a href="javascript:delItem('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img width="15" height="15" alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0" /></a></div>
                                              <div class="edit_colmn_div">
                                                  <a href="javascript:moveUp('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Up" title="Move Up"src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_up.gif"/></a></div>
										    <div class="edit_colmn_div"><a href="javascript:moveDown('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Down" title="Move Down" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_down.gif"/></a></div>-->
                                                                                    
                                              <div class="edit_colmn_div" >
                                                  <a style="float:left;margin-top: -6px; width: 25px;" href="javascript:delItem('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img width="15" height="15" alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0" /></a>
                                              <div id="move_elem" style="width: 25px; float: left;">
                                              <div class="edit_colmn_div" ><a href="javascript:moveUp('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Up" title="Move Up" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_up.gif"/></a></div>
					      <div class="edit_colmn_div" ><a href="javascript:moveDown('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Down" title="Move Down" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_down.gif"/></a></div>
                                              </div>
                                                  </div>
                                            </td>
                                            <td width="6"></td>
                                          </tr>
                                          <? $counter++;}// end if

                                          } break; case"S":{?>
                                            		 <tr style="vertical-align: top;"  class="<? echo ($counter%2)? 'cadd_descriptionrow_gray': '';?>">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$counter+1;//$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?=$list[$n][0][15];?><br/>
											  <?=$list[$n][0][0];?>&nbsp;<?=$list[$n][0][1];?>&nbsp;-&nbsp;<?=$list[$n][0][2];?></div>
											<div class="requested_category_details_sub">
											<div class="description_subdesc_mailicon">&nbsp;</div>
											<div class="requested_category_details_mailad"><a href="mailto:<?=$list[$n][0][3];?>"><?=$list[$n][0][3];?></a></div>
										    </div>
											</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0][10],2);?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
                                            <input type="text" class="numeric_texts" maxlength="6" size="2" name="unitp[<?=$list[$n][0]['id'];?>]" id="unitp[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['cp'];?>"/></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
											<input type="text" class="numeric_texts" maxlength="6" size="2" name="qty[<?=$list[$n][0]['id'];?>]" id="qty[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['qty'];?>"/>
											</td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0]['totle'],2);?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
<!--                                                <div class="edit_colmn_div"><a href="javascript:delItem('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img width="15" height="15" alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0" /></a></div>
                                              <div class="edit_colmn_div"><a href="javascript:moveUp('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Up" title="Move Up" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_up.gif"/></a></div>
										    <div class="edit_colmn_div"><a href="javascript:moveDown('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Down" title="Move Down" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_down.gif"/></a></div>-->
                                           
                                            <div class="edit_colmn_div" >
                                                  <a style="float:left;margin-top: -6px; width: 25px;" href="javascript:delItem('<?=$list[$n][0]['id'];?>','<?=$_GET['qid'];?>');"><img width="15" height="15" alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0" /></a>
                                              <div id="move_elem" style="width: 25px; float: left;">
                                              <div class="edit_colmn_div" ><a href="javascript:moveUp('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Up" title="Move Up" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_up.gif"/></a></div>
					      <div class="edit_colmn_div" ><a href="javascript:moveDown('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Down" title="Move Down" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_down.gif"/></a></div>
                                              </div>
                                                  </div>
                                            </td>
                                            <td width="6"></td>
                                          </tr>
											<? $counter++;} break; case"C":{?>
                                            		 <tr style="vertical-align: top;"  class="<? echo ($counter%2)? 'cadd_descriptionrow_gray': '';?>">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$counter+1;//$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?=$list[$n][0][8];?><br/>
											  <?=$list[$n][0][0];?>&nbsp;<?=$list[$n][0][1];?>&nbsp;-&nbsp;<?=$list[$n][0][2];?></div>
											<div class="requested_category_details_sub">
											<div class="description_subdesc_mailicon">&nbsp;</div>
											<div class="requested_category_details_mailad"><a href="mailto:<?=$list[$n][0][3];?>"><?=$list[$n][0][3];?></a></div>
										    </div>
											</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0][10],2);?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
                                            <input type="text" class="numeric_texts" maxlength="6" size="2" name="unitp[<?=$list[$n][0]['id'];?>]" id="unitp[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['cp'];?>" /></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
											<input type="text" class="numeric_texts" maxlength="6" size="2" name="qty[<?=$list[$n][0]['id'];?>]" id="qty[<?=$list[$n][0]['id'];?>]" value="<?=$list[$n][0]['qty'];?>"/>
											</td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0]['totle'],2);?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text">
                                                <div class="edit_colmn_div">
                                                    <a href="javascript:delItem('<?=$list[$n][0]['id'];?>','<?=$_GET['qid'];?>');"><img width="15" height="15" alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0"/></a>
                                             <div id="move_elem" style="width: 25px; float: right;">
                                              <div class="edit_colmn_div"><a href="javascript:moveUp('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Up" title="Move Up" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_up.gif"/></a></div>
                                            <div class="edit_colmn_div"><a href="javascript:moveDown('<?=$list[$n][0]['id'];?>','<?=$_POST['qid'];?>');"><img border="0" width="15" height="15" alt="Move Down" title="Move Down" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/move_down.gif"/></a></div>
                                                </div>
                                                    </div>
                                                </td>
                                            
                                                <td width="6"></td>
                                          </tr>
											<? $counter++;}
                                    }?>
                                          <? } ?>
                                        </tbody></table>
                                          
                                          <input type="hidden" name="quote_id" id="quote_id" value="<?php if($_POST['qid']) echo $_POST['qid'];?>"/>
                                          </form></td>
                                    </tr>
                                    <tr>
                                      <td> </td>
                                    </tr>
                                    <tr>
                                      <td><label id="submit_contact_details">
                                   <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/my_quotations/";?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
                                   <a href="javascript:editItems(document.forms['items'],'<?=$_POST['qid'];?>');"><img alt="Submit" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0"></a></label></td>
                                    </tr>
                                  </tbody></table>
                              <? }break;
                          case"editgeninfo":{?>
                        
                    <form enctype="multipart/form-data" action="" method="post" name="details" id="details">
                              <!--
                                                      Display loading image.
                                                    -->
                                                    <div id="message_holder">
                                                            <div style="width: 630px; margin-left: -8px;" id="error_msg">                                                      </div>
                                                            <table border="0" align="center" width="98%">
                                                                    <tbody><tr>
                                                                        <td style="padding-top: 10px;" class=""><div id="divProcess"><? print_r($msg);?></div></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td/>
                                                                    </tr>
                                                            </tbody></table>
                                                    </div>

                                                <div class="contact_fieldBlock_left">Title:</div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input type="text" style="width: 250px;" id="title" name="title" value="<?=$qdetails[0]['title'];?>"/>
                                                    </label>
                                                </div>
                                                <div class="contact_fieldBlock_left">Quotation:</div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input type="text" style="width: 250px;" id="quotationid" name="quotationid" value="<?=$qdetails[0]['quotationid'];?>"/>
                                                    </label>
                                                </div>

                                                <div class="contact_fieldBlock_left">Header Image:</div>
                                                <div class="contact_fieldBlock_right">
												   <div class="image_path">
                                                        <!--
                                                           Image is uploaded and display in this div.
                                                        -->
                                                        <div id="uploadingImg"><?php if($imageQuote){?><img src="<?php echo $imageQuote ?>" border="0"/><?php }?></div>
                                                        <!--
                                                           Display zoom icon in here.
                                                        -->
                                                        <div id="zooming" style="display:<?php if($imageQuote){echo "block";}else{echo "none";}?>;">
                                                            <a href="javascript:zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $qdetails[0]['himage'];?>','quotations');"><img alt="Zoom" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                                <!-- Dlete Image -->
                                                                <?php
                                                                  $pos = strrpos($imageQuote, "no_image.jpg");
                                                                  if ($pos === false) { // note: three equal signs
                                                                 ?>
                                                                 <a href="javascript:delImage('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/delete.ajax.php','quotations','<?php echo $qdetails[0]['himage'];?>','<?php echo $objCore->sessCusId;?>');" title="Delete Image" style="text-decoration:none"><img alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/delete_img_str.png" border="0"  /> </a>
                                                                  <?php  }// end of $pos
                                                                ?>
                                                                <!-- / Delete Image -->                                                        </div>
                                                        <!--
                                                            Use this form to display file browse part.
                                                        -->
                                                        <form id="frmQuotationImage" name="frmQuotationImage" action="" style="vertical-align:top">
                                                            <input type="hidden" name="filename" value="filename" />
                                                            <input type="hidden" name="imgFolder" value="quotations" id="imgFolder"/>

                                                            <input type="file" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName','details','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess'); this.value='';return true;" />
                                                            <span style="font-size:10px;padding-top:5px;font-family:Arial,Helvetica,sans-serif"><br/>* Recommended image width is 650 pixels</span>
                                                        </form>

                                                        <input type="hidden" name="keyName" value="<?=$qdetails[0]['himage'];?>" id="keyName"/>
                                               </div>
										</div>
                                                <div class="contact_fieldBlock_left">Customer Details:</div>
                                                <div class="contact_fieldBlock_right">
                                                    <textarea  name="cusdetails" id="cusdetails" class="gen_info_textareas" style="width:300px;height:75px;" ><?=$qdetails[0]['cdetails'];?></textarea>
                                                </div>
												<div class="contact_fieldBlock_left">Valid From:</div>
                                                <div class="Category contact_fieldBlock_right">
                                               <input name="vfrom" id="vfrom" size="12" value="<? if($qdetails[0]['vfrom']){echo date("d/m/Y",$qdetails[0]['vfrom']);}else{echo "dd/mm/yyyy";}?>" onfocus="showCalendar(this,'','','',0,20)" type="text" />
													</div>
												<div class="contact_fieldBlock_left">Valid To:</div>
                                                <div class="Category contact_fieldBlock_right">
                 <input name="vto" id="vto" size="12" value="<? if($qdetails[0]['vto']){echo date("d/m/Y",$qdetails[0]['vto']);}else{echo "dd/mm/yyyy";}?>" onfocus="showCalendar(this, $('#vfrom').val() ,'','',0,20)" type="text" />
												</div>
                                                <div class="contact_fieldBlock_left">Other Texts:</div>
                                                <div class="contact_fieldBlock_right">
                                                   <textarea name="othertext"  class="gen_info_textareas" id="othertext" style="width:300px;height:75px;"><?=$qdetails[0]['othertxt'];?></textarea>
                                                </div>
      												<div class="contact_fieldBlock_left">Terms of Payment:</div>
                                              <div class="Category contact_fieldBlock_right">
                                                    <label>
                                                    <select class="" name="payMethod" id="payMethod">
                                                      <option <?=($qdetails[0]['pay_method']=="Cash")? "selected=\"selected\"" : "" ;?> value="Cash">Cash</option>
                                                       <option <?=($qdetails[0]['pay_method']=="Cheque")? "selected=\"selected\"" : "" ;?> value="Cheque">Cheque</option>
                                                        <option <?=($qdetails[0]['pay_method']=="BAC")? "selected=\"selected\"" : "" ;?> value="BAC">BAC</option>
                                                   </select>
                                                    </label>
                                              </div>

												<div class="contact_fieldBlock_left">Status:</div>
                                              <div class="Category contact_fieldBlock_right">
                                                    <label>
                                                    <select class="" name="status" id="status">
                                                      <option <?=($qdetails[0]['status']=="open")? "selected=\"selected\"" : "" ;?> value="open">Open</option>
                                                       <option <?=($qdetails[0]['status']=="closed")? "selected=\"selected\"" : "" ;?> value="closed">Closed</option>
                                                        <option <?=($qdetails[0]['status']=="sent")? "selected=\"selected\"" : "" ;?> value="sent">Sent</option>
                                                   </select>
                                                    </label>
                                              </div>


                                                    <!--
                                                      Use this hidden field to keep the image key.
                                                    -->

                                           </form>

                                          
                                        
                                         <div class="contact_fieldBlock_left"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/my_quotations/";?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
<label><a href="javascript:editGenInfo('<?=$_REQUEST['qid'];T?>');"><img alt="Submit" onclick="editGenInfo('<?=$_REQUEST['qid'];?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0"></a></label>
                                          </div>
                                       

<? } } ?>
