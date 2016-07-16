<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  right.inc.php                                       '
  '    PURPOSE         :  Right side Inclution                                '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/



   
?>

<?php 
	switch($objCore->curSection())
	{
?>
<?php
		case "--": 
		{ 
?>
<?php 
		}break;	
?>


<?php 
		default:
		{	
?>
          <div id="middle_end_bar">
            <div id="middle_end_bar_middle">
            <?php /* include($objCore->_SYS['PATH']['SEARCH_COM']); */?>
                        <div id="middle_end_banner2">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/<?php echo $objCore->sessCusId!=""? "my_account/":"login/";?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/sign-up-ad.gif" border="0" /></a>
                        </div>
            </div>
          </div>

<?php 
		}break;	// End Default Action
	} // End Switch
?>


