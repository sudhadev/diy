<?php
/* print '<pre>';
print_r($_POST); */	
/* if (isset($_POST['comment'])){
	echo 'dmskdkskdl';
} */
if ( isset ( $_POST['comment'] )) {
	$client_id=$objCore->sessCusId;
 	$comment = $_POST ['comment'];
 	$post_id = $list [0] [0]; 	
 	$name=$cusData_forHeader[0][0].' '.$cusData_forHeader[0][1];
 	$msg = $objBlog->addComment ( $name, $comment, $post_id );
 	
 	 $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
 	$url= $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 	/* header("location:http://www.google.lk"); */ 
 	/* header("Location: success.html"); */
// 	$url = "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	/*
	 * echo $url;
	 * header("location:".$url);
	 */
	// redirect to this pahe again
	// echo $msg;
}

$comments = $objBlog->getComments ( $list [0] [0] );
?>
<div>
	<hr>
	<h3
		style="background: rgb(255, 221, 0) none repeat scroll 0% 0%; padding: 5px;">Comments
		for this post:</h3>
<?php if(count($comments)):?>		
		
<?php foreach ($comments as $acomment):?>		

	<div
		style="margin-bottom: 12px; background: #F9F9F9 none repeat scroll 0%; padding: 10px;">
		<div>
			<span><b><?php	echo $acomment[0];?></b></span><span
				style="float: right;">
				<?php echo date("jS F Y, h:i A", strtotime($acomment[2]));?></span>
		</div>
		<div>
			<br><?php echo $acomment[1];?>
		</div>
	</div>
<?php endforeach;?>
<?php else:?>
<span style="margin-left: 10px;">No comments to display</span>
<?php endif;?>	
	<?php
	/**
	 * Display the message.
	 */
	if ($msg) :		
		echo $objCore->msgBox ( "BLOG", $msg, '98.99%' );
	endif;
	?>
<?php if ($objCore->sessUId){?>	
	<form action="" method="post" name="blogCommentForm"
		id="blogCommentForm" enctype="multipart/form-data">
		<fieldset id="page-middle-middle-content"
			style="width: 620px; margin-bottom: 12px; margin-top: 12px;border: 3px solid #FFCE00;">
			<legend><b>Add Your Comment</b></legend>
			<div>
				<!-- Display the Page Name -->
				<div>
					<b style="">Comment :</b>
				</div>
				<div>
					<textarea name="comment" class="text_area" id="comment"
						style="width: 614px;" required></textarea>

				</div>
			</div>
			<div>
				<input type="submit" value="sumbmit">
			</div>
		</fieldset>
	</form>
	<?php }?>
</div>
