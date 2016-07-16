
<p class="main_text">Thank you for using Diy Price Check. <br/><br/>In the meantime, if you have any further queries please contact us. </p>
   <p> <a href="mailto:<?php echo $objCore->gConf['DIY_EMAIL']; ?>" title="mailto:<?php echo $objCore->gConf['DIY_EMAIL']; ?>"><span
    style='font-size:9.5pt;font-family:"Arial","sans-serif";color:#666666;
    text-decoration:none'><?php echo $objCore->gConf['DIY_EMAIL']; ?></span></a> </p>
    <p align="left"><span style='font-size:11px;font-family:"Arial","sans-serif";
    color:#727171'>
<!--            <strong>- DIY Team - </strong>-->
            <br>
    <div style="margin-left:6px;">
  <?php
      if($objCore->gConf['DIY_ADDRESS']) $diyDetails= ucwords($objCore->gConf['DIY_ADDRESS'])."<br />";
      if($objCore->gConf['DIY_STREET']) $diyDetails.= ucwords($objCore->gConf['DIY_STREET'])."<br />";
      if($objCore->gConf['DIY_CITY']) $diyDetails.= ucwords($objCore->gConf['DIY_CITY'])."<br />";
      if($objCore->gConf['DIY_COUNTRY']) $diyDetails.= ucwords($objCore->gConf['DIY_COUNTRY'])."<br />";
      if($objCore->gConf['DIY_POSTAL']) $diyDetails.= strtoupper ($objCore->gConf['DIY_POSTAL'])."<br />";


      echo $diyDetails;

  ?><br />
  <strong>
      <?php
          if($objCore->gConf['DIY_TELEPHONE']) $diyConDetails= $objCore->gConf['DIY_TELEPHONE']."(Tel) <br />";
          if($objCore->gConf['DIY_FAX']) $diyConDetails.= $objCore->gConf['DIY_FAX']." (Fax) <br />";
          //if($objCore->gConf['DIY_EMAIL']) $diyConDetails.= "<a href='mailto:".$objCore->gConf['DIY_EMAIL']."'>".$objCore->gConf['DIY_EMAIL']."</a><br />";
        echo $diyConDetails;
      ?>
  </strong></div>
