<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_add.tpl.php                      '
  '    PURPOSE         :  add users page of the user section                  '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<!-- Display the error messages  -->

<?php 
	if($msg)
	{
		echo $objCore->msgBox("CUSTOMER",$msg,'98.99%');
	}             	
?>

<div id="toolbar-box">
<div class="t"></div>
			<div class="m">

<!-------------- Function form----------->
<script type="text/javascript">
    function change_cus_type(val){
        if(val.value==1){
                document.getElementById('select_cus_Type_supplies').setAttribute('style', 'display: block');
                document.getElementById('select_cus_Type_services').setAttribute('style', 'display: none');
            }else if(val.value==2){
                document.getElementById('select_cus_Type_supplies').setAttribute('style', 'display: none');
                document.getElementById('select_cus_Type_services').setAttribute('style', 'display: block');
            }else {
                document.getElementById('select_cus_Type_supplies').setAttribute('style', 'display: none');
                document.getElementById('select_cus_Type_services').setAttribute('style', 'display: none');
            }
    }
    function check_promo_code(val){
        var Type = document.getElementById("select_cus_Type").value;
        var returnValues = true;
        var rate_value = false;
        if(Type==1){
                var rates = document.getElementsByName('package');
                for(var i = 0; i < rates.length; i++){
                    if(rates[i].checked){
                        rate_value = rates[i].value;
                    }
                } 
                if(rate_value){
                }else{ 
                    alert('Select a Package');
                    returnValues = false;
                }
        }else if(Type==2){
                var rates = document.getElementsByName('packages2');
                for(var i = 0; i < rates.length; i++){
                    if(rates[i].checked){
                        rate_value = rates[i].value;
                    }
                }  
                if(rate_value){
                }else{ 
                    alert('Select a Package');
                    returnValues = false;
                }
        }else{
            alert('Select Customer Type');
            returnValues = false;
        }
        return returnValues;
    }
</script>
<style type="text/css">
    #select_cus_Type_services .services_light,
    #select_cus_Type_services .services_dark
    {
        padding: 0;
    }
</style>
	<form action="" onsubmit="return check_promo_code(this);" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset  id="page-middle-middle-content">
	  <legend>Add Promotional Code </legend>
	  <table class="admintable" width="470">
              <tbody>
	    <tr>
                      <td class="key" align="right">Customer Type</td>
                          <td>
                              <select id="select_cus_Type" name="select_cus_Type" onchange="change_cus_type(this);">
                                  <option value="0" selected="selected">-----------------</option>
                                  <option value="1">Supplies</option>
                                  <option value="2">Services</option>
                              </select>
                          </td>
                    </tr>
	    <tr>
          <td class="key" align="right" valign="top">Listing Package</td>
	      <td>
                  <div id="select_cus_Type_supplies" style="display: none;">
            <?php
            $arrSubscription=$objCore->_SYS['CONF']['SUBCRIPTIONS']["M"];
            foreach($arrSubscription as $key=>$value)
            {
                if($key!="OPTION")
                {
                    if(!isset($_POST['package'])){
                        if($key=='B'){
                            echo '<input name="package" id="M'.$key.'" value="'.$key.'"  type="radio" checked=true>'. $value."<br/>\n";  
                        }
                        else{   
                        echo '<input name="package" id="M'.$key.'" value="'.$key.'"  type="radio">'. $value."<br/>\n";
                }
                    }
                    else if($key==$_POST['package']){    
                        echo '<input name="package" id="M'.$key.'" value="'.$key.'"  type="radio" checked=true>'. $value."<br/>\n";  
                    }
                    else{   
                        echo '<input name="package" id="M'.$key.'" value="'.$key.'"  type="radio">'. $value."<br/>\n";
                }
            }
            }
            ?>
                  </div>
            
                   <table  id="select_cus_Type_services" style="display: none;" border="0" cellpadding="0" cellspacing="2" width="200">
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td class="services_light">
                                                            <label>
                                                                <input name="packages2" type="radio" id="one_month" value="1" <?php if ($_REQUEST['packages'] == '1') ?> checked="true" />
                                                           1 Month</label></td>

        </tr>
                                                    <tr class="data">
                                                        <td class="services_dark">
                                                            <label>
                                                                <input type="radio" name="packages2" id="three_months" value="3" />
                                                            3 Months</label></td>

                                                    </tr>
        <tr>
                                                        <td class="services_light">
                                                            <label>
                                                                <input type="radio" name="packages2" id="six_months" value="6" />
                                                                6 Months</label></td>

                                                    </tr>
                                                    <tr class="data_bg">
                                                        <td class="services_dark"><label>
                                                                <input type="radio" name="packages2" id="one_year" value="12" />
                                                                12 Months</label></td>
                                                    </tr>
                                                </tbody>
                                              </table>
            
        </tr>
        <tr>
          <td class="key" align="right">Email Address</td>
	      <td><input name="email" class="text_area" id="email" size="30" type="text" value="<?php echo $_POST['email'];?>"/></td>
        </tr>
	    
                
                <tr>
          <td class="key" align="right">Grace Period</td>
	      <td>
                  <select name="grace_period" id="grace_period">
                      <?php
                      for($i=1;$i<13;$i++){
                          if($i==$_POST['grace_period']){
                              echo "<option value='$i' selected>$i</option>";
                          }
                          else{
                              echo "<option value='$i'>$i</option>";
                          }
                          
                      }
                      
                      ?>
                      </select>
              &nbsp; months</td>
        </tr>
        
         <tr>
          <td class="key" align="right">Use Before</td>
	      <td>
                  <select name="ex_period" id="ex_period">
                      <?php
                      $i = 5;
                      while($i<=60){
                          if($i==$_POST['ex_period']){
                              echo "<option value='$i' selected>$i</option>";
                          }
                          else{
                              if(($i=='10')){
                                  echo "<option value='$i' selected>$i</option>";
                              }
                              else{
                                  echo "<option value='$i'>$i</option>";
                              }
                              
                          }
                          $i += 5;;
                      }
                      
                      ?>
                      </select>
              &nbsp; days</td>
        </tr>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
	        <input type="submit" name="Submit" value="Add"/>
	        <input type="hidden" name="action"  value="addprom"/>
	      </label></td>
	    </tr>
            
            
	  </tbody></table>
	  </fieldset>
	</form>

<!--------------END Function form----------->

<div class="clr"></div>
</div>
<div class="b">
	<div class="b">
		<div class="b"></div>
	</div>
</div>


	

