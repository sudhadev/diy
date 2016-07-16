<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv='X-UA-Compatible' content='IE=edge' />
        <?php
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        ini_set("max_execution_time", "6000");

        require_once("classes/core/core.class.php");
        $objCore = new Core;

        // Display the logged user.
        $objCore->auth(1, false);
        require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);
        ?>
        <!--[if IE]><script defer type="text/javascript" src="pngfix.js"></script><![endif]-->
        <?php
        require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
        $objCategory = new Category;
        require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
        $objComponent = new Component();
        require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
        $formName = "search"; // Registration Form Name
        $mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
        $apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 
        $objGeo = new Geo(); // Creating an Object from Geo Class 
        $map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl); // Calling the method getCoordinates() 
        ?>
    </head>
    <body <?php echo $jsBodyOnLoad; ?> >
        <!-- ashan -->

        <!-- ashan end -->
        <div id="bg" style="left: 0px; top: 0px; display: none; position: absolute;"></div>
        <div style="z-index: 0;">
            <div align="center">
                <div id="main_outer">
                    <div id="mainDiv">


                        <div id="top_bar">
                            <!-- START TOP HEADER-->
                            <?php $homePage = true;
                            require_once($objCore->_SYS['PATH']['HEAD_FRONT']); ?>
                            <!-- END TOP HEADER-->
                        </div>
                        <!-- START BODY AREA-->
                        <div id="middle_bar">
                            <div id="middle_left_bar">
                                <!-- START LEFT AREA-->
<?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']); ?>
                                <!-- END LEFT AREA-->
                            </div>

                            <div id="middle_right_bar">
                                <!-- START CONTENT AREA-->
                                <?php
                                switch ($_REQUEST['f']) {
                                    /* case "":
                                      {

                                      }break;

                                      case "":
                                      {

                                      }break; */

                                    default: {
                                            // default inclution
                                            include("bin/tpl/home.tpl.php");
                                        }
                                }
                                ?>
                                <!-- END CONTENT AREA-->
                            </div>
                            <!-- END BODY AREA-->
<?php
include("bin/tpl/latest_services.tpl.php");
?>
                            <!-- START FOOTER AREA-->
                            <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']); ?>
                            <!-- END FOOTER AREA-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">/* stLight.options({publisher: "fbf4ad8f-b47b-4123-bae1-3ca5b5100d59", doNotHash: false, doNotCopy: false, hashAddressBar: false}); */</script>
    <script>
        /* var options={ "publisher": "fbf4ad8f-b47b-4123-bae1-3ca5b5100d59", "position": "right", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ["facebook", "twitter", "linkedin", "pinterest", "email"]}};
         var st_hover_widget = new sharethis.widgets.hoverbuttons(options); */
    </script>
</html>