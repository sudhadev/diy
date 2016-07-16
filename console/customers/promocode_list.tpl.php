<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of Promo Code section of tekMAZ          '
  '    (C) Copyright 2011 www.tekmaz.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sudharshan Ramasubramaniam <sudharshan@tekmaz.com>          		'
  '    FILE            :  customer_list.tpl.php                     				'
  '    PURPOSE         :                   												'
  '    PRE CONDITION   :                                             			'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>
<?php
	//$objCore=new Core;
	
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();
        
        require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
        if(!is_object($objPromotion)) $objPromotion= new Promotion();
          
        
       
        if ($_REQUEST['status'])
	{
		$list=$objPromotion->get_dList($_REQUEST['status'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['sort_by'],$_REQUEST['page'],'');
                
		$pg_list=$objPromotion->get_dList($_REQUEST['status'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['sort_by'],$_REQUEST['page'],'pg');
                if ($list == null ) $msg = array('ERR', 'NO_MATCHES');
	}
	else
	{
		$list=$objPromotion->get_dList( 'Y', '', '', 'generated','1','');
                
                 if(count($list)<5){
                    $pg = 1;
                }
                else{
                    $pg = $_REQUEST['page'];
                }
                
	}       
        $pg_list=$objPromotion->get_dList( 'Y', '', '', 'generated','1','pg');
       if($msg)
	{
		echo $objCore->msgBox("CUSTOMER",$msg,'96%');
	}

        echo $where;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
?>


<fieldset  style="border:1px solid #CCCCCC"id="page-middle-middle-content">
<legend>Search</legend>
<form id="frm" action="<?php echo $editFormAction; ?>">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
        <tr align="center">
          <td height="23"> </td>
          <td><table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="10"> </td>
                          <td><input type="text" value="<?php echo $_REQUEST['search']; ?>" size="30" id="search" class="" name="search"/></td>
                          <td width="80" align="center">By</td>
									<td><?php
									echo $objComponent->drop('search_by', $_REQUEST['search_by'], array(
				
				"send_email_to"=>"E-mail",
                                "code"=>"Promo Code",
                                                                            
			), '', '');
							?></td>
                          <td> </td>
                          <td width="60" align="center"><input type="submit" value="Search" class="btn_common" name="button2"/>
                            <input type="hidden" value="1" id="pg" name="pg"/></td>
                          <input type="hidden" value="<?php echo $_REQUEST['page']; ?>" id="page_no" name="page_no"/></td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Filter&nbsp;By</td>
                          <td><?php
									echo $objComponent->drop('status', $_REQUEST['status'], array(
				//" "=>"----",
                                "Y"=>"Used",
				"N"=>"Not Used",
                                "E"=>"Expired",                                            
			), '', 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
                          <td></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Sort&nbsp;By</td>
									<td><?php
									echo $objComponent->drop('sort_by', $_REQUEST['sort_by'], array(
				//""=>"----",
                                "generated"=>"Sent Date",
				"promo_expire"=>"Expire Date",
			), '' , 'onchange="form.submit();"');
							?></td>
                                                                         
                          <td> </td>
                          <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <!--
                  <td>
  
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Page&nbsp;No</td>
									<td>
              <?php   
        $no_of_pages = count($pg_list)/30;
        echo count($list);
        echo 'sldfk';
        echo count($pg_list);
        echo 'fdgdg';
        echo $no_of_pages;
        $no_of_bal = count($pg_list)%30;
       
        if($no_of_pages>=1){
        if($no_of_bal>0){
            $limit = $no_of_pages+1;
        }
        else{
            $limit = $no_of_pages;
        }
        }
        else{
            $limit = 1;
        }   

            if($no_of_pages>1){
            $array = array();
            for($i=1;$i<=$limit;$i++){
                $array[$i] = $i;
            }
           echo $objComponent->drop('page', $pg, $array, '', 'onchange="form.submit();"');
            }
            ?>
        </td>
                        </tr>
                      </tbody>
                    </table>
                      <?php
            //}

        ?>
            </td>-->
                  <td width="10"> </td>
                </tr>
              </tbody>
            </table></td>
            <input type="hidden" name="f" value="prcd_list"/>
          <td width="15"> </td>
        </tr>
      </tbody>
    </table>
  </form>
  </fieldset>


<fieldset  id="page-middle-middle-content">
 <legend>Promotion Code List</legend>
<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="" height=""> # </th>
      <th width="" class="title"> <a href="javascript:tableOrdering('c.code','desc','');">Sent To</a> </th>
      <th width="" nowrap="nowrap"><a href="javascript:tableOrdering('c.code','desc','');">Promotional Code</a></th>
      <th width="" nowrap="nowrap"><a  href="javascript:tableOrdering('c.package','desc','');">Package</a></th>
      <th width="" align="center"><a  href="javascript:tableOrdering('c.grace_period','desc','');">Grace Period (Days)</a></th>
      <th width="" align="center"><a  href="javascript:tableOrdering('c.generated','desc','');">Sent Date/Time</a></th>
      <th width="" align="center"><a  href="javascript:tableOrdering('c.status','desc','');">Status</a></th>
      <th width="" align="center"><a  href="javascript:tableOrdering('c.expire','desc','');">Promo Code Expiry Date/Time</a></th>
      <th width="" align="center"><a  href="javascript:tableOrdering('c.expire','desc','');">Grace Period End Date/Time</a></th>
      
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
        $start = 0;
            if(!$_REQUEST['page']||$_REQUEST['page']=='1'){
                $start = 1;
            }
            else{
                $start = ($_REQUEST['page']-1)*5+1;
            }
		for($n=0;$n<count($list);$n++)
		{
			
	?>
    <tr class="row0">
      <td align="left"><?php echo $start; ?> </td>
      <td align="left"><?php echo $list[$n][8];?></td>
      <td align="left"><?php echo $list[$n][1];?></td>
      <?php
      $package = '';
      switch ($list[$n][4]){
          case 'G':
              $package = 'Gold';
              break;
          case 'S':
              $package = 'Silver';
              break;
          case 'B':
              $package = 'Bronze';
              break;
          default:
              $package = 'Silver';
      }
      
      ?>
      <td align="left"><?php echo $package;?></td>
      <td align="left"><?php echo $list[$n][5];?> </td>
      <td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$list[$n][2]);?></td>
      <?php 
      $status = '';
      if($list[$n][6]=='Y'){
          $status = 'Used';
      }
      else if($list[$n][9]<time()){
          $status = 'Expired';
      }
      else{
          $status = 'Not Used';
      }
      //$status = $list[$n][6]=='Y'?'Used':'Not Used';
      ?>
      <td align="left"><?php echo $status;?> </td>
      <td nowrap="nowrap" align="left"><?php echo $list[$n][9]?date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$list[$n][9]):'-';?></td>
      <td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$list[$n][3]);?></td>
    </tr>
    <?php $start++; }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="12"><del class="container">
        <div class="pagination"> 
       
        
        
        </div>
        </del> </td>
    </tr>
  </tfoot>
</table>
</fieldset>

