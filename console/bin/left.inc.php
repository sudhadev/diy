<?php 

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  left.inc.php                                        '
  '    PURPOSE         :  left panel                                          '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	if(!is_object($objCategory))
        {
        $objCategory = new Category();
        }
        $cArray = array_values($objCategory->getTopcList());
        //print_r($cArray);
		
?>

<div id="categoryList_body">
	<fieldset id="categoryList">
		  <legend align="center">Browse Categories </legend>	

    <?php
        switch($objCore->curSection())
        {
            case "specifications":
            {
                //echo "specification ***************";
           
    ?>
                <ul id="dhtmlgoodies_tree" class="dhtmlgoodies_tree">

                    
                    <?php 
                    //print_r($cArray);
                    //for ($s=0;$s<count($cArray);$s++)
                              //{
                    ?>
                    <li><a href="#" cpath="<?php echo $cArray[0]['id'];?>"><?php echo $cArray[0]['category'];?></a>
                            <ul>
                                    <li parentId="<?php echo $cArray[0]['id'];?>"><a href="#" >Loading...</a></li>
                            </ul>
                    </li>

                    <?php //} ?>
                </ul>

    <?php
            }break;


            case "listing":
            {
    ?>
                <ul id="dhtmlgoodies_tree" class="dhtmlgoodies_tree">
                    <?php for ($s=0;$s<count($cArray);$s++)
                              {
                    ?>
                    <li><a href="#" cpath="<?php echo $cArray[$s]['id'];?>"><?php echo $cArray[$s]['category'];?></a>
                            <ul>
                                    <?php 
                                        
                                    ?>
                                    <li parentId="<?php echo $cArray[$s]['id'];?>"><a href="#" >Loading...</a></li>
                            </ul>
                    </li>

                    <?php } ?>
                </ul>

    <?php
            }break;

            
            default:
            {
	?>
                 <ul id="dhtmlgoodies_tree" class="dhtmlgoodies_tree">
                    <?php for ($s=0;$s<count($cArray);$s++)
                              {
                    ?>
                    <li><a href="#" cpath="<?php echo $cArray[$s]['id'];?>"><?php echo $cArray[$s]['category'];?></a>
                            <ul>
                                    <li parentId="<?php echo $cArray[$s]['id'];?>"><a href="#" >Loading...</a></li>
                            </ul>
                    </li>

                    <?php } ?>
		</ul>


        <div style="padding:4px 0px 0px 34px; width:219px;height:18px; background-color:#EEEEEE;background-image:url('../images/icons/arrow_refresh.png');background-repeat:no-repeat;background-position:12px;"><a href="javascript:location.reload(true)" style="text-decoration:none;font-size:11px;font-family:Arial, Helvetica, sans-serif;color:black;">Reload the Category Tree</a></div>
    <?php
            }
        }
    ?>
				<script type="text/javascript">
					initTree("3","<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/");
				</script>
		
	</fieldset>
</div>