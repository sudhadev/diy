<?php

if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
require_once("../classes/core/core.class.php");$objCore=new Core; 
?>

<div class="option_form_sub_selections">
  <div class="option_form_sub_text_selections">
    <label>
    <input name="packages" type="radio" id="one_month" value="1" />
    </label>
    1 Month <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </div>
  <div class="option_form_sub_text_selections">
    <label>
    <input type="radio" name="packages" id="three_months" value="3" />
    </label>
    3 Month <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </div>
    <div class="option_form_sub_text_selections">
      <label>
      <input type="radio" name="packages" id="six_months" value="6" checked/>
      6 Month <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </label>
    </div>
      <div class="option_form_sub_text_selections">
      <label>
      <input type="radio" name="packages" id="one_year" value="12" checked/>
      1 Year <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </label>
    </div>
  </div>
</div>
