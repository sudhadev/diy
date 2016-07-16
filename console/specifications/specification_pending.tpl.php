<?php
  /*---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2009 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara         '
  '    FILE            :  console/specification/specification.tpl.php     	   '
  '    PURPOSE         :  list specifications page of the specification section'
  '    PRE CONDITION   :  commented                                            '
  '    COMMENTS        :                                                       '
  '---------------------------------------------------------------------------*/
  
  	$module = "specification";
	$function = "dataList";
	
  	if($objCore->isAllowed($module, $function))
	{

?>
<script language="javascript">
    getId_Spec_pending('1','P','specification','1');

</script>
<div id="divMessage">
									
</div>


<div id="div_Message">
	Click on the button to add a new Specification
	<a class="cateMsg" href="javascript:checkLevel();">Add Specification</a>
</div>

<div id="divAddBtn" style="display:none">
	<a class="cate_Msg" href="javascript:checkLevel();">Add Specification</a>
</div>

<div id="div_Mess">
	Click on the button to add a new Category
	<a class="cateMsg" href="javascript:addCategory('<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/category/?f=add');">Add Category</a>
</div>


<div id="all_list_spec" style="display:block;width:97%">

<!--<fieldset  style="border:1px solid #CCCCCC" id="page-middle-middle-content">
<legend>bbb</legend>-->
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
                          <td width="65" align="right"></td>
                          <td width="10">&nbsp;</td>
                          
                          
                            <td>
                            <input type="hidden" value="P" name="specification_status" id="specification_status"/>

                            <?php //Filter&nbsp;By
                            //$objCategory->getTopcList('drop');
                          // echo  $objCategory->getTopcList('drop', 'categ', '', '1', " onClick=\"getPendingList(this.value)\"")
//                            echo $objComponent->drop('specification_status', $_REQUEST['specification_status'], array(
//				"P"=>"Pending",
//                                "Y"=>"Active",
//				"D"=>"Deleted",
//				"R"=>"Rejected",
//			), '', 'onchange="setAllList();"');
							?></td>
                         
                        </tr>
                      </tbody>
                    </table>
                  </td>

                  <td width="30"> </td>
                  <td class="vertical-line"></td>
                  <td>

                      <div id="sort">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
                            <tr>
                              <td width="65" align="right">Sort&nbsp;By</td>
                              <td width="10">&nbsp;</td>
                                <td><?php if(!$_REQUEST['sort_by']){$_REQUEST['sort_by']='added_time';}
                                echo $objComponent->drop('sort_by', $_REQUEST['sort_by'], array(
                                    "added_time"=>"Time",
                                    "specification"=>"Specification",
                                    "email"=>"E-Mail",
                                    
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


<div id="page_body" style="display:none">
 <div id="page_body_deflt">
	 <!-- START CONTENT AREA -->  
	  Please Select a Subcategory
	 <!-- END CONTENT AREA -->   
 </div>
</div>

										
<div id="specification_body" style="width:100%;">

</div>

<?php  }  ?>