<?php
/*
 * --------------------------------------------------------------------------\
 * ' This file is part of shoping Cart in module library of FUSIS '
 * ' (C) Copyright 2004 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Ashan Rupasinghe <ashanrupasinghe11@gmail.com> '
 * ' FILE : blog.php '
 * ' PURPOSE : provide the about us section of the system '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
error_reporting(1);
ini_set('display_errors',E_ALL);

require_once ("../classes/core/core.class.php");
$objCore = new Core ();

/**
 * Display the logged user.
 */
$objCore->auth ( 1, false );
//die()

include ($objCore->_SYS ['PATH'] ['CLASS_BLOG']);
if (! is_object ( $objBlog )) {
	$objBlog = new Blog ();
}
/* $paginationSize = $objCore->gConf ['RECS_IN_LIST_CONSOLE']; */
$paginationSize = 5;
$status = 1;
$list = $objBlog->get_dList ( '', $_REQUEST ['pg'], $paginationSize, $status );


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>

</head>
<body <?php echo $jsBodyOnLoad;?>>
	<div align="center">
		<div id="main_outer">
			<div id="mainDiv">


				<div id="top_bar">
					<!-- START TOP HEADER-->
<?php require_once($objCore->_SYS['PATH']['HEAD_FRONT']);?>
<!-- END TOP HEADER-->
				</div>
				<!-- START BODY AREA-->
				<div id="middle_bar">
					<div id="middle_left_bar">
						<!-- START LEFT AREA-->
<?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']);?>
<!-- END LEFT AREA-->
					</div>

					<div id="middle_right_bar">
						<!-- START CONTENT AREA-->
						<div id="right_bar_middle">
							<div id="main_form_bg">
								<div id="main_form_bg_middle">
									<div id="main_form_bg_topbar">
										<img
											src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" />
									</div>
									<div id="main_form_bg_middlebar">
										<div id="banner" class=""><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/blog/" class="blog-banner"><?php /* echo ($list[0][1]); */ echo 'Green Ideas';?></a></div>
										<div id="outer">
											<div id="outer_middle">

												<!-- Load the content from database. -->
												<div align="right"><?php //echo $objBlog->pgBar; ?></div>
												<div id="text_area" class="common_text">

<?php

$post = $_REQUEST ['post'];
if (! empty ( $post )) {
	include ("post.php");
} else {
	include ("post_list.php");
	?>
<div align="center">
														<br/><?php echo $objBlog->pgBar; ?>
													
													</div>	
	<?php
}
?>

  </div>

												<!-- yellow part<div id="form_bg"> -->
												<!-- <div id="form_outer">
													<div id="form_middle">
														<div class="form_middle_text">
															<br /> <br />
														</div>
													</div>
												</div> -->
											</div>

											<!-- <div id="signup_butten" align="left">
												<a href="#"></a>
											</div> -->
										</div>
									</div>
								</div>

								<div id="main_form_bg_bottombar">
									<img
										src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" />
								</div>

							</div>
						</div>
					</div>
					<!-- END CONTENT AREA-->
				</div>
				<!-- END BODY AREA-->
				<!-- START FOOTER AREA-->
<?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
<!-- END FOOTER AREA-->
			</div>
		</div>
	</div>
	</div>
</body>
</html>
