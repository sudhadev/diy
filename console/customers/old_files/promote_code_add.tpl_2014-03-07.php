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

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset  id="page-middle-middle-content">
	  <legend>Add Promotional Code </legend>
	  <table class="admintable" width="470">
              <tbody>
	    <tr>
          <td class="key" align="right" valign="top">Listing Package</td>
	      <td>
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


	

