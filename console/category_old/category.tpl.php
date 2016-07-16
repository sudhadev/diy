<?php
  /*---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2004 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
  '    FILE            :  console/category/category.tpl.php     	  		   '
  '    PURPOSE         :  list specifications page of the specification section'
  '    PRE CONDITION   :  commented                                            '
  '    COMMENTS        :                                                       '
  '---------------------------------------------------------------------------*/
  
  	$module = "category";
	$function = "dataList";
	
  	if($objCore->isAllowed($module, $function))
	{
  
?>
<div id="divMessage">
									
</div>

<div id="div_Message">
	Click on the button to add a new Specification
	<a class="cateMsg" href="javascript:addSpecification('<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/specifications/?f=add');">Add Specification</a>
</div>

<div id="divAddBtn" style="display:none"> 
	<a class="cate_Msg" href="">Add Specification</a>
</div>

<div id="div_Mess">
	Click on the button to add a new Category
	<a class="cateMsg" href="j">Add Category</a>
</div>


<div id="all_list_spec"  style="<?php if($_REQUEST['f']=="plist"){?>width:97%;display:block;<?php }else{?>display:none; <?php };?>" >
<form id="frm" action="">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
        <tr align="center">
          <td height="23"> </td>
          <td><table cellspacing="0" cellpadding="0" border="0" align="right">
              <tbody>
                <tr>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="65" align="right">Filter&nbsp;By</td>
                          <td width="10">&nbsp;</td>


                            <td><?php

                            echo $objCategory->getTopcList("drop",'cmbTopCat','','',"OnChange=\"getPendingCategories(this.value,'category','1');\"");
//                            echo $objComponent->drop('category_status', $_REQUEST['category_status'], array(
//				"P"=>"Pending",
//                                "Y"=>"Active",
//				"D"=>"Deleted",
//				"R"=>"Rejected",
//			), '', 'onchange="setAllList();"');
							?>
                            </td>                        
                          <td width="10">&nbsp;</td>


                            <td><?php
                            echo $objComponent->drop('category_status', $_REQUEST['category_status'], array(
				"P"=>"Pending",
                                "Y"=>"Active",
				"D"=>"Deleted",
				"R"=>"Rejected",
			), '', 'onchange="getCategoryList();"');
							?>
                            </td>
                            
                        </tr>
                      </tbody>
                    </table>
                  </td>

                  
                  <td>

                      <div id="sort" style="display:none;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
                            <tr>
                                
                              <td width="30"> </td>
                              <td class="vertical-line"></td>

                              <td width="65" align="right">Sort&nbsp;By</td>
                              <td width="10">&nbsp;</td>
                                <td><?php
                                echo $objComponent->drop('sort_by', $_REQUEST['sort_by'], array(
                                    "category"=>"Category",
                                    "requested_by"=>"E-Mail",
                            ), '' , 'onchange="sortBy();"');
                                                            ?></td>
                              <td> </td>
                              <!--<td width="20"> </td>
                              <td width="20" class="vertical-line"></td> -->
                            </tr>
                          </tbody>
                        </table>
                      </div>
                  </td>
                 
                  <!--
                  <td>
                     <div id="all_list_active_add_spec_btn" style="display:none">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
                            <tr>
                                <td> </td>
                              <td align="right">
                                 <a class="cateMessage" href="javascript:checkLevel();">Add Specification</a>
                              </td>
                              <td> </td>
                            </tr>
                          </tbody>
                        </table>
                     </div>
                  </td>
                  -->
                  <td width="10"> </td>
                </tr>
              </tbody>
            </table></td>
          <td width="15"> </td>
        </tr>
      </tbody>
    </table>
  </form>
 <!-- </fieldset> -->

</div>


<div id="page_body" <?php if($_REQUEST['f']=="plist"){?>style="width:100%;"<?php }?>>
 <div id="page_body_deflt">
	 <!-- START CONTENT AREA -->  
	 
       <?php if($_REQUEST['f']=="plist"){?><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/ajax-loader.gif" alt="Loding"  /> &nbsp;&nbsp;Loading .... Please Wait.
       <?php }else{ ?> Please Select a Category
       <?php }?>
	 <!-- END CONTENT AREA -->   
 </div>
</div>
<?php  }  ?>