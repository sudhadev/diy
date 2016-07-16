<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/cms/page_edit.tpl.php                       '
  '    PURPOSE         :  'edit pages' page of the cms section                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<?php

	/** 
	* Display the message.
	*/
	if($msg)
	{
		echo $objCore->msgBox("PAGE",$msg,'98.99%');
	}

	$list=$objCms->get_dList($_REQUEST['pid']);
?>

<div id="toolbar-box"><!-------------- END Top tool bar with functionality name----------->
            <div id="element-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<?php 
			if($list[0][1]=='')
			{
				$msg=array('ERR','SELECT_PAGE');
				echo $objCore->msgBox("PAGE",$msg,'96%');
				
			} else{			
	?>
			
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Page Details</legend>
	  <p>
	  	<!-- Display the Page Name -->
		<?php 
			echo " <b> Name of the Page : ".$list[0][1]." </b>" ;
		?>
	  </p>
	  <p>
	  	<!-- Display the fckeditor on the page -->
	  	<?php 
			//include_once($objCore->_SYS['CONF']['URL_FCKEDITOR_MODULE']."/fckeditor.php") ;
	  		include_once("../../modules/fckeditor/fckeditor.php") ;
			$oFCKeditor = new FCKeditor('FCKeditor') ;
			//$oFCKeditor->BasePath = '../../modules/fckeditor/' ;
			$oFCKeditor->BasePath = $objCore->_SYS['CONF']['URL_FCKEDITOR_MODULE']."/";
			$oFCKeditor->Value = $list[0][2];
			$oFCKeditor->Create() ;	
	 	?>
	  </p>
		 <input type="submit" value="Submit">
	   <input type="hidden" name="action" value="edit" />
	   <?php } ?>
	  </fieldset>
	</form>

<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>


	

