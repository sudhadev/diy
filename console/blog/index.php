<?php
/*
 * --------------------------------------------------------------------------\
 * ' This file is part module library of FUSIS '
 * ' (C) Copyright 2002-2015 '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Ashan Rupasinghe <ashanrupasinghe11@gmail.com> '
 * ' FILE : index.php '
 * ' PURPOSE : provide the frame for any section of the system '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
require_once ("../../classes/core/core.class.php");
$objCore = new Core ();

/**
 * Display the logged user.
 */
$objCore->auth ( 0, true );

/**
 * Create an object to the User class.
 */
require_once ($objCore->_SYS ['PATH'] ['CLASS_BLOG']);
if (! is_object ( $objBlog )) {
	$objBlog = new Blog ();
}

/**
 * Check the request with the hidden field.
 */
$action = $_REQUEST ['action'];

switch ($action) {
	case "add" :
		{
			/**
			 * Call to the add function in the User class.
			 */
			
			include ("addsampleposteddata.php");
			
			/*
			 * echo 'content: '.$content.'<br>title: '.$title.'author: '.$author;
			 * die();
			 */
			$logId = $objCore->sessUId;
			
			$msg = $objBlog->add ( $title, $content, $logId,$status );
			
			/**
			 * If message is successfull message, call to the default php file.
			 */
			if ($msg [0] == 'SUC') {
				$_REQUEST ['f'] = '';
			}
		}
		break;
	
	case "edit" :
		{
			/**
			 * Call to the edit function in the User class.
			 */
			/* die(); */
			include ("sampleposteddata.php");
			// $msg=$objBlog->edit($_POST['mname'],$objCore->sessUId,$_REQUEST['id']);
			
			// echo $title;
			// die();
			$logId = $objCore->sessUId;
			$msg = $objBlog->edit ( $newContent, $title, $logId, $reqPId,$status );
			
			/**
			 * If message is successfull message, call to the default php file.
			 */
			if ($msg [0] == 'SUC') {
				$_REQUEST ['f'] = '';
			}
		}
		break;
	
	case "delete" :
		{
			/**
			 * Call to the edit function in the User class.
			 */
			$msg = $objBlog->delete ( $_REQUEST ['id'] );
			
			/**
			 * If message is successfull message, call to the default php file.
			 */
			if ($msg [0] == 'SUC') {
				$_REQUEST ['f'] = '';
			}
		}
		break;
	
	case "publish" :
		{
			/**
			 * Call to the edit function in the User class.
			 */
			$logId = $objCore->sessUId;
			$msg = $objBlog->editStatus ( $logId, $_REQUEST ['id'], $_REQUEST ['stat'] );
			
			/**
			 * If message is successfull message, call to the default php file.
			 */
			if ($msg [0] == 'SUC') {
				$_REQUEST ['f'] = '';
			}
		}
		break;
	
	default :
		{
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
		
	<script type="text/javascript" language="javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/blog.js">
	</script>

</head>

<body>
	<div align="left">
		<div id="main_outer">
			<div id="mainDiv">
				<!-- START PAGE HEADER -->
				<div id="top-bar">
						<?php require_once($objCore->_SYS['PATH']['HEAD_CONSOLE']);?>					
					</div>
				<!-- END PAGE HEADER -->

				<!-- START MENU -->
				<div id="page-menu">
					<?php require_once($objCore->_SYS['PATH']['MENU_CONSOLE']);?>			
					</div>
				<!-- END MENU -->

				<!-- START PAGE MIDDLE -->
				<div id="page-middle">
					<div id="page-middle-middle">
						<div id="page-middle-content">
							<div>
								<!-- START CONTENT AREA -->  
									  	<?php
												switch ($_REQUEST ['f']) {
													case "add" :
														{
															include ("blog_post_add.tpl.php");
														}
														break;
													
													case "edit" :
														{
															include ("blog_post_edit.tpl.php");
														}
														break;
													
													default :
														{
															include ("blog_post_list.tpl.php");
														}
												}
												?>
									 <!-- END CONTENT AREA -->
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE MIDDLE -->

				<!-- START PAGE FOOTER -->
				<div id="footer">
						<?php
						require_once ($objCore->_SYS ['PATH'] ['FOOT_CONSOLE']);
						?>
					</div>
				<!-- END PAGE FOOTER -->
			</div>
		</div>
	</div>
</body>
</html>
