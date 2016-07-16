
<?php
$list = $objBlog->get_dList ( '', '', '', '',$post );
//$_SESSION['commentpage']=$objCore->_SYS['CONF']['URL_SYSTEM'].'/blog/?post='.$list[0][9];
?>
<div id="title">
<a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/blog/?post=<?php echo $list[0][9];?>"><?php echo $list [0][1];?></a>
<span id="postdate" class="postdate"><?php echo date("jS F Y, h:i A", strtotime($list [0][6]));?></span>
</div>
<div id="content">

    <div id="content-text"><?php echo stripslashes($list [0][2]);?></div>
<div class="next-priv">
<span class='st_facebook_hcount' displayText='Facebook'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_linkedin_hcount' displayText='LinkedIn'></span>
<span class='st_pinterest_hcount' displayText='Pinterest'></span>
<span class='st_email_hcount' displayText='Email'></span>
<!-- <span><a href="">PREVIOUS</a></span><span><a href="">NEXT</a></span> -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "8ea3b097-f585-47f9-9dd3-daec5f1af74b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</div>
<div>

<?php include 'comments.php';?>
</div>
</div>
