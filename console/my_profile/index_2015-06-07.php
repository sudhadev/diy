<?php
/* --------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  index.php                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

require_once("../../classes/core/core.class.php");
$objCore = new Core;

$objCore->auth(0, true);
require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']); //Making a referance to Geo Class 
$formName = "address_details"; // Registration Form Name
$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 
$objGeo = new Geo(); // Creating an Object from Geo Class 
$objCustomer = new Customer(); // Creating an Object from Geo Class 
$map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl); // Calling the method getCoordinates()   

    $title = "";
    $email = "";
    $fname = "";
    $lname = "";
    $pass = "";
    
    $company = "";
    $address = "";
    $street = "";
    $city = "";
    $postcode = "";
    $country = "";
    
    $latitude = "";
    $longitude = "";
    $phone = "";
    $fax = "";
    
    $longitude = "";
    $phone = "";
    $fax = "";
    
    $mon = "";
    $sat = "";
    $sun = "";
    
    $cusType = "";
    
    $subscription = "";
    $package_type_extend = 1;
    
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $email = $_POST['email'];
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $pass = $_POST['password'];
    
    $company = $_POST['company'];
    $address = $_POST['address'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    
    $latitude = $_POST['confirmedLatitude'];
    $longitude = $_POST['confirmedLongitude'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    
    $mobile = $_POST['mobile'];
    $website = $_POST['website'];
    $fax = $_POST['fax'];
    
    $mon = $_POST['mon_open'].'_'.$_POST['mon_close'];
    $sat = $_POST['sat_open'].'_'.$_POST['sat_close'];
    $sun = $_POST['sun_open'].'_'.$_POST['sun_close'];
    
    $cusType = "S";
    
    $subscription = $_POST['type'];
    $package_type_extend = 6;


    if ($subscription == "M")
        $package = "S";
    else
        $package = "6";

    $objCustomer->setVariables($title, $fname, $lname, $email, $email, $pass, $pass, $company, $address, $street, $city, $postcode, $country, $phone, $fax, $mobile, $cusType, $latitude, $longitude, $subscription, $package,$package_type_extend);

    $msg = $objCustomer->addAdmin($cusType);
    if ($msg[0] == 'SUC') {
        //$_REQUEST['f'] = '';
        $title = "";
    $email = "";
    $fname = "";
    $lname = "";
    $pass = "";
    
    $company = "";
    $address = "";
    $street = "";
    $city = "";
    $postcode = "";
    $country = "";
    
    $latitude = "";
    $longitude = "";
    $phone = "";
    $fax = "";
    
    $longitude = "";
    $phone = "";
    $fax = "";
    
    $mon = "";
    $sat = "";
    $sun = "";
    
    $cusType = "";
    
    $subscription = "";
    $package_type_extend = 1;
    }
}
//print_r($_REQUEST);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/jquery.min.js"></script>

        <?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']); ?>
        <?php //require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']); ?>


        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE'] ?>/users.js">
        </script>
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE'] ?>/update.js"></script>

    </head>

    <body>
        <div align="left">
            <div id="main_outer">
                <div id="mainDiv">
                    <div id="top-bar">
                        <?php require_once($objCore->_SYS['PATH']['HEAD_CONSOLE']); ?>					
                    </div>
                    <!-- END PAGE HEADER -->

                    <!-- START MENU -->
                    <div id="page-menu">
                        <?php require_once($objCore->_SYS['PATH']['MENU_CONSOLE']); ?>			
                    </div>
                    <!-- END MENU -->

                    <!-- START PAGE MIDDLE -->
                    <div id="page-middle">
                        <div id="page-middle-middle">
                            <div id="page-middle-content">
                                <div>
                                    <!-- START CONTENT AREA-->
                                    <?php
                                    switch ($_REQUEST['f']) {
                                        default: {
                                                include("profile.tpl.php");
                                            }
                                    }
                                    ?>
                                    <!-- END CONTENT AREA-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE MIDDLE -->

                    <!-- START PAGE FOOTER -->
                    <div id="footer">
                        <?php
                        require_once($objCore->_SYS['PATH']['FOOT_CONSOLE']);
                        ?>
                    </div>
                    <!-- END PAGE FOOTER -->
                </div>
            </div>
        </div>
    </body>
</html>