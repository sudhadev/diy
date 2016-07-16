<?
/* ---------------------------------------------------------------------------
 * PLUGGIN - PAY PAL API
 *
 *
 * Written By Saliya Wijesinghe - Fusis IT
 * [saliya@ymail.com / 0773-505072]
 -----------------------------------------------------------------------------*/
//echo __FILE__."(".__LINE__.")";
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
if(!is_object($objCustomer))$objCustomer = new Customer();
require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);

if(!is_object($objPayment)) $objPayment = new Payment($objCore->gConf);

// Most of the time we need user IP
   $args['ip']              =$_SERVER['REMOTE_ADDR'];


// Select the exact logic
switch($_REQUEST['act'])
{ 
    case "direct":
        {
            // Prepare local variables To recalculate the hash for double check
            // * ip also should be included. and you should maintain the following order
            $args['cid']        =$_POST['cid'];
            $args['email']      =$_POST['email'];
            $args['invoice']    =$_POST['invoice'];
            $args['amount']     =$_POST['amount'];

         //echo __FILE__." ".__LINE__."<br/><br/>";

            // double check for validity of the parameters
            if($_POST['hash']==$objPayment->calculateHash($args))
            { 
                ////echo __FILE__." ".__LINE__."<br/><br/>";
                // Hash is valid ...............
                // prepare the values to pass to the payment.
                // we dont pass all values in $_POST due to security reasons
                   $args['rPayAmount'] =$_POST['recPay'];
                   $args['extProfile'] =$_POST['pfId'];
                   //print_r($args);
                   $paymentData=array
                        (
                            'Args'=>$args, // Payment class to get all the necessory information from the database using values in $args
                            'CCard'=>array
                                (
                                        'Type'    =>$_POST['CardType'],                    // Credit Card Type [Visa/ Master/ etc]
                                        'Number'  =>$_POST['CardNumber'],                // Credit Card Number
                                        'ExpMonth'=>$_POST['ExpiryDateMonth'],           // Expire Month in 2 digits
                                        'ExpYear' =>$_POST['ExpiryDateYear'],             // Expire Month in 2 digits
                                        'CVV2'    =>$_POST['CV2'],                     // This is the code in back side of the card 3/4 digits depending on the card type

                                ),

                            'Schedule'       => array
                            (
                                'Description'      => $_POST['Title'],
                                'BillingPeriod'    => $_POST['Period'],
                                'BillingFrequency' => $_POST['Frequency'],
                                'TotalCycles'      => $_POST['Cycles'],

                            ),

                            'Payer'          =>array
                                (
                                        'FirstName'=>$_POST['fName'],
                                        'LastName'=>$_POST['lName'],
                                        'Address'=>$_POST['address'],
                                        'Street'=>$_POST['street'],
                                        'CityName'=>$_POST['city'],
                                        'StateOrProvince'=>$_POST[''],
                                        'PostalCode'=>$_POST['postcode'],
                                        'CountryCode'=>$_POST['country'],
                                        'Phone'=>$_POST[''],
                                        'Email'=>$_POST[''],

                                )
                        );
//echo __FILE__." ".__LINE__."<br/><br/><pre>";print_r($paymentData);echo "</pre>";

                // Make the Payment
                if($_POST['Cycles']!=1)
                {
                    $response=$objPayment->paypalCreateRecurrentProflie($paymentData);
                }
                else
                {
                    $response=$objPayment->doDirectPayment($paymentData);
                }

                // If success we should update the database in my account/ paymentconfirm.tpl
                   $response['Payer']=$paymentData['Payer'];

            }
            else
            { // hash not valid - reject the payment
                $msg=msg('HASH-NOT-MATCH');
            }
        }
        break;
    case "express":
        {
            // Prepare local variables To recalculate the hash for double check
            // * ip also should be included. and you should maintain the following order
            $args['cid']        =$_POST['cid'];
            $args['email']      =$_POST['email'];
            $args['invoice']    =$_POST['invoice'];
            $args['amount']     =$_POST['amount'];


            // double check for validity of the parameters
            if($_POST['hash']==$objPayment->calculateHash($args))
            {
                // Hash is valid ...............
                    // Set the express checkout
                       $response=$objPayment->setExpressCheckout(array('Args'=>$args));
            }
            else
            { // hash not valid - reject the payment
                echo "ERR|spl|HASH-NOT-MATCH";exit;
                
            }
        }
        break;
        case 'express-return':
            {
                   $args['PaymentType']         =$_REQUEST['paymentType'];
                   $args['Token']               =$_REQUEST['token'];
                   $args['PaymentAmount']       =$_REQUEST['paymentAmount'];
                   $args['CurrencyCodeType']    =$_REQUEST['currencyCodeType'];

                   // If there isn't a Token, no point executing the code further
                      if(!$args['Token']) {
                           $expCheckoutResponse=msg('TOKEN-BLANK');
                           if(!$expCheckoutResponse) exit;
                      }
                      
                  // Confirm the payment
                     $expCheckoutResponse=$objPayment->confirmExpressCheckout($args);



            }
            break;
        case "IPN": // use only for Ajax requests
            {
                $hashString=calc($args);
                If($hashString)
                {
                    echo "SUC||".$hashString;
                }
                else
                {
                    echo "ERR||BLANK";
                }

            }
            break;
        case "calc": // use only for Ajax requests
            {
                $hashString=calc($args);
                If($hashString)
                {
                    echo "SUC||".$hashString;
                }
                else
                {
                    echo "ERR||BLANK";
                }

            }
            break;
        case "listen": 
            {
                /*
                 * following code yet to smooth in the online enviorenment and
                 * this is only for a unit test
                 *
                 */
                 if(is_array($vals))
                 {
                     $objPayment->diyRecurringPaymentListner($vals);
                 }
                 
 
            }
            break;
         case "ebcyc": // expand billing cycles
            {
               // $_REQUEST['Cycles']=5;
                //echo "====>".__FILE__.__LINE__."<br/>".$_REQUEST['pfid']." <-----> ". $_REQUEST['Cycles']."<br/>";
                /*
                 * expanding the billing cycles
                 *
                 */

                 $response= $objPayment->paypalRecurrentProflieExtendBillingCycles($_REQUEST['pfid'], $_REQUEST['Cycles']);

// echo "<pre>";print_r($response);echo "</pre>";
                     if($response['Ack']=="Success")
                     {
                        $pgProfile=$objPayment->diyRecurringProfileGetFromGateway($_REQUEST['pfid']);
                        // Prepare necessory details
                           $getNPDate=$objPayment->pharseDateTime($pgProfile['RecurringPaymentsSummary']['NextBillingDate']);
                           $nextPaymentDate=$getNPDate['Stamp'];

                           $getFPDate=$objPayment->pharseDateTime($pgProfile['FinalPaymentDueDate']);
                           $finalPaymentDate=$getFPDate['Stamp'];
                           
                           $numberCyclesCompleted = $pgProfile['RecurringPaymentsSummary']['NumberCyclesCompleted']+1;
                           $numberCyclesRemaining = $pgProfile['RecurringPaymentsSummary']['NumberCyclesRemaining'];
                           $totalBillingCycles    = $pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;
                            
                        
                        echo "SUC||".$objCore->msgBox('PAYMENT', array('SUC','DONE'), '100%');
                        echo "-spl-$numberCyclesCompleted-spl-$numberCyclesRemaining-spl-$totalBillingCycles-spl-".date($objCore->gConf['DATE_FORMAT'],$finalPaymentDate);
                     }
                     else
                     {  
                         // ERROR :: Profile is invalid
                         switch($response['ErrorCode'])
                         {

                             default:
                                 echo "ERR||".$objCore->msgBox('PAYMENT', array('ERR','ERROR'), '100%');
                         }
                            exit;
                     }

                

            }
            break;

        case "eccard": // Edit Credit card
            {
                // Prepare local variables To recalculate the hash for double check
                // * ip also should be included. and you should maintain the following order
                 $args['ip']         =$_SERVER['REMOTE_ADDR'];
                 $args['cid']        =$_POST['cid'];
                 $args['pfid']       =$_POST['pfid'];


                // double check for validity of the parameters
                if($_POST['hash']==$objPayment->calculateHash($args))
                {
                    // Hash is valid ...............
                    // prepare the values to pass to the payment.
                    // we dont pass all values in $_POST due to security reasons

                       $ccData=array
                            (
                                        'Type'    =>$_POST['CardType'],                    // Credit Card Type [Visa/ Master/ etc]
                                        'Number'  =>$_POST['CardNumber'],                // Credit Card Number
                                        'ExpMonth'=>$_POST['ExpiryDateMonth'],           // Expire Month in 2 digits
                                        'ExpYear' =>$_POST['ExpiryDateYear'],             // Expire Month in 2 digits
                                        'CVV2'    =>$_POST['CV2'],                             
                             );

                        $payer=array
                                (
                                        'FirstName'=>$_POST['fName'],
                                        'LastName'=>$_POST['lName'],
                                        'Address'=>$_POST['address'],
                                        'Street'=>$_POST['street'],
                                        'CityName'=>$_POST['city'],
                                        'StateOrProvince'=>$_POST[''],
                                        'PostalCode'=>$_POST['postcode'],
                                        'CountryCode'=>$_POST['country'],
                                        'Phone'=>$_POST[''],
                                        'Email'=>$_POST[''],

                                );

                     $response=$objPayment->paypalRecurrentProflieChangeCreditCard($_POST['pfid'], $ccData, $payer);

                     if($response['Ack']=="Success")
                     {
                        echo "SUC||".$objCore->msgBox('PAYMENT', array('SUC','DONE'), '100%');
                        echo "-spl-$numberCyclesCompleted-spl-$numberCyclesRemaining-spl-$totalBillingCycles-spl-".date($objCore->gConf['DATE_FORMAT'],$finalPaymentDate);

                     }
                     else
                     {  
                         // ERROR :: Profile is invalid
                         switch($response['ErrorCode'])
                         {

                             default:
                                 echo "ERR||".$objCore->msgBox('PAYMENT', array('ERR','ERROR'), '100%');//print_r($response);print_r($ccData);print_r($payer);
                         }
                            exit;
                     }

                     // update code in pyament confirmation tpl

                }
                else
                { // hash not valid - reject the payment
                    $msg=msg('HASH-NOT-MATCH');
                }
            }
            break;


            default:
            {
                $msg=msg('REQUEST-INVALID');
            }


        }


       // Generate message
          function msg($errCode,$type='ERR',$ajax=true)
          {
                if($ajax)
                {
                    echo "$type||$errCode";
                    return null;
                }
                else
                {
                    return array('$type',$errCode);
                }
          }


        // $inv_Number=$_REQUEST['fp_invoice'];


        // unset($args);
        ?>        
