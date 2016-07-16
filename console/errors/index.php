<?php 
      /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  green_ideas.php    				          		  '
	  '    PURPOSE         :  provide the about us section of the system          '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	//$objCore->auth(0,false);
	
// Set error message
   switch($_REQUEST['err'])
    {
        case 403:
        {
            $msgTitle='403 Error- Forbidden!';
            $msgText="You are not permitted to access the requested URL ";
        }break;


        default:
        {
            // default inclution

        }
    }
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>

	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/users.js">
	</script>
	</head>

	<body>
									 <!-- START CONTENT AREA -->
                                        <div id="specification_body" style="width:99%;float:left;">
 <div id="specification_body_deflt" style="height:300px; margin-left:20px;padding-top:100px;">
	 <!-- START CONTENT AREA -->
	  <?echo $msgText;?><br/><br/>
      <div><a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>" style="font-size:12px;color:black;"><< Go Back to the Console</a></div>
	 <!-- END CONTENT AREA -->
 </div>
</div>
									 <!-- END CONTENT AREA -->	</body>
</html>
