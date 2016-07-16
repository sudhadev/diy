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
										
<div id="page_body">
 <div id="page_body_deflt">
	 <!-- START CONTENT AREA -->  
	  Please Select a Category
	 <!-- END CONTENT AREA -->   
 </div>
</div>
<?php  }  ?>