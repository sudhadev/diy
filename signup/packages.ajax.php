<?php

if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
require_once("../classes/core/core.class.php");$objCore=new Core; 
?>

<div class="option_form_sub_selections">
  <div class="option_form_sub_text_selections">
    <label>
    <input name="packages" type="radio" id="gold" value="G" />
    </label>
    Gold <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </div>
  <div class="option_form_sub_text_selections">
    <label>
    <input type="radio" name="packages" id="silver" value="S" />
    </label>
    Silver <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </div>
  <div class="option_form_sub_text_selections">
    <div class="option_form_sub_text_selections">
      <label>
      <input type="radio" name="packages" id="bronze" value="B" checked/>
      Bronze <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')"; onmouseout="hidePopup()" /> </label>
    </div>
  </div>
</div>
