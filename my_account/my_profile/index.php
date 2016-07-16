<?php 
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  index.php                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  require_once("../../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,true);
  require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
  $formName = "address_details"; // Registration Form Name
  $mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
  $apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 
  $objGeo = new Geo(); // Creating an Object from Geo Class 
  $map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl); // Calling the method getCoordinates()   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/animatedcollapse.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/update.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.myprof_editdetails_txtfield_company').keyup(function(){ 
            var max=$(this).attr('maxlength');
            var valLen=$(this).val().length;
            if(valLen==max && max!=0){
                $('#myprof_editdetails_txtfield_text_block').html('<strong style="color: red">'+valLen+'/'+max+'</strong>');
            }else{
                $('#myprof_editdetails_txtfield_text_block').html('<strong>'+valLen+'/'+max+'</strong>');
            }
        });
    });
    
	animatedcollapse.addDiv('personal', 'fade=0,speed=400,group=edit_details') 
	animatedcollapse.addDiv('address', 'fade=0,speed=400,group=edit_details')
	animatedcollapse.addDiv('contact', 'fade=0,speed=400,group=edit_details')
	//fires each time a DIV is expanded/contracted
	animatedcollapse.ontoggle=function($, divobj, state)
	{ 
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}

	animatedcollapse.init()
</script> 
</head>
<body <?php echo $jsBodyOnLoad;?> >
<div id="bg" style="left: 0px; top: 0px; display: none; position: absolute;"></div>
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
          <?php 
	switch($_REQUEST['f'])
	{
		default:
		{
			include("profile.tpl.php");   
		}
	}
?>
          <!-- END CONTENT AREA-->
        </div>
        <!-- END BODY AREA-->
      </div>
      <!-- START FOOTER AREA-->
      <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
      <!-- END FOOTER AREA-->
    </div>
  </div>
</div>
</body>
</html>
