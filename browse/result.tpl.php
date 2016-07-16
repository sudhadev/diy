<?php 
?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
             <?php if ($_REQUEST['categories']==2 || $_REQUEST['categories']==3) include($objCore->_SYS['PATH']['COM_GROUP_BY']); ?>
				<?php
				switch ($_REQUEST['categories'])
				{
					case 1:
					{
						include($objCore->_SYS['PATH']['MATERIAL_LIST']);
					}break;
                    case 2:
					{
						include($objCore->_SYS['PATH']['SERVICE_LIST']);
					}break;
					case 3:
					{
						include($objCore->_SYS['PATH']['CLASSIFIED_LIST']);
					}break;
				}
				?>
				                </div>
            </div>
				<div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>