<?
  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  current_user.inc.php                                '
  '    PURPOSE         :  Footer for Admin console                            '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

 $url=$base->_SW['URL_LOGIN_SHOP']."/process.php?logout=y&cusr=0" ;
    function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
   }

  require_once($base->_LINK['CLASS_ENCRYPT']);
  if(!is_object($obj_encrypt)){$obj_encrypt=new encryption;}
  $obj_encrypt->inText=curPageURL();
  $url_enc=$obj_encrypt->url_encrypt();
  $thisPageUrl=$obj_encrypt->outText;
 
 ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--Drop down menu begins here-->
		  <tr>
			<td>
				<div class="drop_down_menu" id="Dropmenu">
			
				<ul>
				<? if($U_ID){?>
				<li><a href="#" rel="dropmenu8">Categories</a></li>
				<li><a href="#" rel="dropmenu1">Brands</a></li>
				<li><a href="#" rel="dropmenu2">Products</a></li>
				<li><a href="#" rel="dropmenu3">Configuration</a></li>	
				<li><a href="#" rel="dropmenu4">Orders</a></li>	
				<li><a href="#" rel="dropmenu5">Customers</a></li>	
				<li><a href="#" rel="dropmenu6">Help</a></li>
				<? }else{ ?><li>&nbsp;</li>
				<? }?>
				</ul>
			
				</div>
				
				<!--1st drop down menu -->                                                   
				<div id="dropmenu8" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/categories/?f=cadd">Add Categories</a>
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/categories/">Category List</a>
				</div>
				
				<!--2nd drop down menu -->                                                   
				<div id="dropmenu1" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/brands/?f=badd">Add Brand</a>
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/brands/">Brand List</a>
				</div>
				
				
				<!--3rd drop down menu -->                                                
				<div id="dropmenu2" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/products/?f=padd">Add Products</a>
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/products/">Products List</a>
				</div>
				
				<!--4th drop down menu -->                                                   
				<div id="dropmenu3" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/configure/">Global Settings</a>
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/users/">Change Password</a>
				</div>
				
				<!--5th drop down menu -->                                                   
				<div id="dropmenu4" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/orders/">Order List</a>
				</div>
				
				<!--6th drop down menu -->                                                   
				<div id="dropmenu5" class="dropmenudiv" style="width: 150px;">
				<a href="<? echo $base->_SW['URL_CONSOLE'];?>/customers/">Customers List</a>
				</div>
				
				<!--7th drop down menu -->                                                   
				<div id="dropmenu6" class="dropmenudiv" style="width: 150px;">
				<a href="javascript: pop_help();">Index</a>
				</div>

				<? if($U_ID) { ?>
				<script type="text/javascript">
				cssdropdown.startchrome("Dropmenu")
				</script>	 
				<? } ?>
		  </tr>
		  <!--Drop down menu ends here-->
</table>						
						
