<?php 
	
require_once("../../classes/core/core.class.php");
if(!is_object($objCore))
{
	$objCore=new Core();
}

$specification=$_REQUEST['specification'];


///print_r($_REQUEST['cus']);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" >
<p class="main_text">
	New Product Approval
</p>

				<table>
    				
					<tr>
						<td align='center'>
    						<table>
								<tr>
									<td>Product Name </td>
									<td> : </td>
									<td><?php echo $specification?></td>
								</tr>
							</table>
    					</td>
					</tr>
				</table>



<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>



				