<?php

/* --------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>     	  '
  '    FILE            :  listing_add_edit.ajax.php          		  '
  '    PURPOSE         :  provide listings for any section of the system      '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

require_once("../../classes/core/core.class.php");
$objCore = new Core;

require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
$objListing = new Listing;

 // Content inclusion
    include("my_listing.content.php");

//Display the logged user.
$objCore->auth(1, true);

switch ($_REQUEST['val']) {
    case "checkValue": {
            $unitCost = addslashes(htmlspecialchars($_REQUEST['uc']));
            $bulkDiscount = $_REQUEST['bd'];
            $bulkPrice = addslashes(htmlspecialchars($_REQUEST['bp']));
            $delivery = addslashes(htmlspecialchars($_REQUEST['deliv']));
            $listingActive = $_REQUEST['la'];
            $elementId = $_REQUEST['rowId'];

            checkingData($elementId, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $objCore);
        } break;

    case "add_edit": {
            //echo $_REQUEST['rowValues'];
            $rowValues = explode('|**|,', $_REQUEST['rowValues']);

            //$lstCanAdd = $objListing->calculate_credit($objCore->sessCusId);// take the count of listings that can be add
            $str = "";

            $listingData = $objListing->calculate_credit($objCore->sessCusId); // take the count of listings that can be add
            $lstCanAdd = (int) $listingData['listCanAdd'];

            for ($i = 0; $i < count($rowValues); $i++) {

                $recordValue = explode('||', $rowValues[$i]);
                //print_r($recordValue);
                $unitCost = $recordValue[0];
                // echo "unit cost = ".$unitCost."<br />";
                $bulkDiscount = $recordValue[1];
                // echo "bulk discount = ".$bulkDiscount."<br />";
                $bulkPrice = $recordValue[2];
                // echo "bulk Price = ".$bulkPrice."<br />";
                $delivery = $recordValue[3];
                // echo "delivery = ".$delivery."<br />";
                $listingActive = $recordValue[4];
                // echo "listingActive= ".$listingActive."<br />";
                $ids = $recordValue[5];
                // echo "ids= ".$ids."<br />";

                $img = $recordValue[6];
                $desc = $recordValue[7];
                $curStatus = $recordValue[8];
                $supplier_code = $recordValue[9];
                $list_spec = $recordValue[10];
                $del = $recordValue[11];
                $del_rate = $recordValue[12];
                $header = $recordValue[13];
                $url = $recordValue[14];
                $img2 = $recordValue[15];
                $img3 = $recordValue[16];
                $img4 = $recordValue[17];

                //echo "***************<br />";
                //echo "values = ".$ids.",<br /> unit cost =  ".$unitCost.",".$bulkDiscount.",".$bulkPrice.",".$delivery.",".$listingActive;
                if ($unitCost == "" && $delivery == "" && ($bulkDiscount == "0" || $bulkDiscount == "") && $bulkPrice == "") {
                    continue;
                } else {
                    $val = explode('_', $ids);
                    $arrParentId = array(0 => $val[0], 1 => $val[1], 2 => $val[2], 3 => $val[3], 4 => $val[4], 5 => $val[5]);
                    $logId = $objCore->sessCusId;
                    //print_r($val);
                 //   echo __LINE__ . "=---->" . $lstCanAdd . "<br/>";
                    // Add if condition to check whether this add has exeeded $lstCanAdd
                    // if exeeded add all the values to an array

                    /*
                     * Changed by saliya - 24th Nov 2010
                     */
                    //echo $curStatus . $listingActive . "<br/>-----------------------------</br>";
                    $safeUpdate = false; // initially updation shuld be turned off
                    switch ($curStatus . $listingActive) {
                        case "NY":
                        case "*Y": {
                                // listing increased
                                $lstCanAdd--;
                           //     echo __LINE__ . " LINE | " . $lstCanAdd . " <br/>";
                            }
                            break;
                        case "YN": {
                                // listing decresed
                                $lstCanAdd++;
                           //     echo __LINE__ . " LINE | " . $lstCanAdd . " <br/>";
                            }
                            break;
                        default: {
                                // nothing to do
                                $safeUpdate = true;
                            }
                            break;
                    }

                    //echo __LINE__ . "=---->" . $lstCanAdd . "<br/>";
                    if ($safeUpdate || $lstCanAdd > -1) {
                        
                        $msg = $objListing->add_edit($arrParentId, $logId, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $img, $desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4);

                        if ($msg[0] == "ERR") {
                            break;
                        }
                    } else {

                        $str .= $unitCost . "||" . $bulkDiscount . "||" . $bulkPrice . "||" . $delivery . "||" . $listingActive . "||" . $ids . "-dlm-";
                    }



//                        if($arrParentId[5] != ""  )
//                        {
//                            //echo "hi1";
//                            $msg=$objListing->add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc);
//
//                            if($msg[0] == "ERR")
//                            {
//                                break;
//                            }
//
//
//
//                        }elseif($lstCanAdd > 0)
//                        {
//                            //echo "hi2";
//                            $msg=$objListing->add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc);
//                           // print_r($msg);
//                            if($msg[0] == "ERR")
//                            {
//                                break;
//                            } /*elseif($msg[0] == "SUC")
//                            {
//                               $lstCanAdd--;
//                            }*/
//                        } else
//                        {
//                           // $str .= $ids."-spl-".$unitCost."-spl-".$bulkDiscount."-spl-".$bulkPrice."-spl-".$delivery."-spl-".$listingActive."-dlm-";
//                            $str .= $unitCost."||".$bulkDiscount."||".$bulkPrice."||".$delivery."||".$listingActive."||".$ids."-dlm-";
//                        }
                }
            }
            //echo "str = ".$str."<br />";
            // add the generated listing to the data
            if ($str != "") {
                $returnVal = $objCore->sysUpdate('Content', $str);
                //echo "returnVal = ".$returnVal."<br />";
                if ($returnVal) {
                    $payment = "yes";
                    // added by saliya to restrict auto redirection

                    $payment = "no";
                    //$msg[0] = "ERR";
                    $msg = array('ERR', 'QUOTA_EXCEED');
                } else {
                    $payment = "no";
                }
            } else {
                $payment = "no";
            }

            $listingData = $objListing->calculate_credit($objCore->sessCusId);
            $credit = $listingData['listCanAdd']; //$objListing->calculate_credit($objCore->sessCusId);
            //$credit = $objListing->calculate_credit($objCore->sessCusId);

            if ($credit > 0) {
                $credit = $credit . " More";
            } else {
                $credit = $credit;
            }

            if ($msg) {
                if ($listingData['listAvailable'] < 20) {
                    $infoBox = $objListing->infoBox('limitExeed',$pageContents['infoSubsAlert'],$listingData).'<input type="hidden" id="traceInfoBox" value="y"/>'

                    ;
                }
                else
                {
                    $infoBox ='<input type="hidden" id="traceInfoBox" value=""/>';
                }
                echo '  <style>.msgBox {width:95%;}</style>   ';
                echo '<div id="msgWrapper">'.$objCore->msgBox("LISTING", $msg, '99%') .'</div>'. $infoBox . "||" . $msg[0] . "||" . $credit . "||" . $msg[1] . "||" . $payment;
            } else {
                echo "" . "||" . "1" . "||" . $credit;
            }

            /* $val = explode('_',$_REQUEST['ids']);
              $arrParentId=array(0=>$val[0],1=>$val[1],2=>$val[2],3=>$val[3],4=>$val[4],5=>$val[5]);
              $logId = $objCore->sessCusId; //$objCore->sessUId
              //submitFields($objCore,$objListing, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $arrParentId, $logId);

              $msg=$objListing->add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive);

              if($msg)
              {
              echo $objCore->msgBox("LISTING",$msg,'96%')."||".$msg[0];
              } */
        } break;
}


/* if($_REQUEST['rowId'] != "")
  {




  } elseif($_REQUEST['del'] != "")
  {
  $clearItems= $_REQUEST['del'];
  $logId = 4; //$objCore->sessUId
  clearData($objCore, $objListing, $clearItems, $logId);

  } else
  {
  $listingActive=$_REQUEST['la'];

  $val = explode('_',$_REQUEST['ids']);

  $arrParentId=array(0=>$val[0],1=>$val[1],2=>$val[2],3=>$val[3],4=>$val[4]);

  $logId = 4; //$objCore->sessUId

  submitFields($objCore,$objListing, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $arrParentId, $logId);
  } */

//check the server side validation and send the appropriate success or error message to the javascript code.
/* function submitFields($objCore,$objListing, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $arrParentId, $logId)
  {
  $msg=$objListing->add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive);

  if($msg)
  {
  echo $objCore->msgBox("LISTING",$msg,'96%')."||".$msg[0];
  }

  return $msg;
  } */

//Send the appropriate error message to the javascript code.
function checkingData($elementId, $unitCost, $bulkDiscount, $bulkPrice, $delivery, $listingActive, $objCore) {
    $fieldName1 = "";
    $fieldName2 = "";

    if ($bulkPrice == "0") {
        $bulkPrice = "";
    }

    if ($unitCost != "") {
        if (!is_numeric($unitCost)) {
            $msg = array('ERR', 'NOT_NUMERIC');
            $fieldName1 = "unit_cost_" . $elementId;
        } elseif ($bulkPrice != "") {
            if (!is_numeric($bulkPrice)) {
                $msg = array('ERR', 'NOT_NUMERIC');
                $fieldName1 = "bulk_price_" . $elementId;
            } elseif ((int) $unitCost < (int) $bulkPrice) {
                $msg = array('ERR', 'NOT_GREATER');
                $fieldName1 = "unit_cost_" . $elementId;
                $fieldName2 = "bulk_price_" . $elementId;
            }
        }
    } else {
        if ($bulkPrice != "") {
            if (!is_numeric($bulkPrice)) {
                $msg = array('ERR', 'NOT_NUMERIC');
                $fieldName1 = "bulk_price_" . $elementId;
            } elseif ((int) $unitCost < (int) $bulkPrice) {
                $msg = array('ERR', 'NOT_GREATER');
                $fieldName1 = "unit_cost_" . $elementId;
                $fieldName2 = "bulk_price_" . $elementId;
            }
        }
    }

    if ($bulkPrice != "") {
        if (!is_numeric($bulkPrice)) {
            $msg = array('ERR', 'NOT_NUMERIC');
            $fieldName1 = "bulk_price_" . $elementId;
        } elseif ($unitCost != "") {
            if (!is_numeric($unitCost)) {
                $msg = array('ERR', 'NOT_NUMERIC');
                $fieldName1 = "unit_cost_" . $elementId;
            } elseif ((int) $unitCost < (int) $bulkPrice) {
                $msg = array('ERR', 'NOT_GREATER');
                $fieldName1 = "unit_cost_" . $elementId;
                $fieldName2 = "bulk_price_" . $elementId;
            } elseif ($bulkDiscount == 0) {
                $msg = array('ERR', 'FILL_BULKDISCOUNT');
                $fieldName1 = "select_bulk_discount_" . $elementId;
                $fieldName2 = "bulk_price_" . $elementId;
            }
        }
    }

    if ($delivery != "") {
        if (!is_numeric($delivery)) {
            $msg = array('ERR', 'NOT_NUMERIC');
            $fieldName1 = "delivery_" . $elementId;
        }
    }

    if ($msg) {
        echo $objCore->msgBox("LISTING", $msg, '96%') . "||" . $msg[0] . "||" . $fieldName1 . "||" . $fieldName2;
    } else {
        echo "" . "||" . "no_SUC_ERR" . "||" . $fieldName1 . "||" . $fieldName2;
    }
}

/* function clearData($objCore,$objListing, $clearItems)
  {
  $msg=$objListing->delete($clearItems, $logId);

  if($msg)
  {
  echo $objCore->msgBox("LISTING",$msg,'96%')."||".$msg[0];
  }

  return $msg;
  } */