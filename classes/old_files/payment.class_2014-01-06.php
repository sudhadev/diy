<?php
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
          ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  paymet.class.php                                    '
  '    PURPOSE         :  provide the order and customer details for payment  '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
require_once($objCore->_SYS['PATH']['CLASS_PAYPAL_WRAPPER']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);

class Payment
    extends Order
{

    private $oData;
    private $diyCountries;
    Private $objWrapper;
    private $tblPrefix; 
    private $gConf;
    private $paginationConsole;
    private $paginationFront;
    private $vatStatus;
    private $vat;

    /**
     * Get Order
     * ------------------------------------------------------------
     * Get the order & change the country code where necessory.
     *
     * @param string $invoiceID  - Invoice Id
     *
     *
     */
        private function getOrder($invoiceID)
        {
            $this->oData=$this->getOrderInfo($invoiceID, true);
            if($this->oData[0]['ip']=="::1") $this->oData[0]['ip']='127.0.0.1';
            // change the country code
            // to add more code refer the construct
            if($this->diyCountries[$this->oData[0]['country']])$this->oData[0]['country']=$this->diyCountries[$this->oData[0]['country']];

            if($this->objWrapper->getAPIEnviornment()=='sandbox') $this->oData[0]['email']='diy_1291771486_biz_api1@tekmaz.com';
            
        }


    /**
     * Do Direct Payment
     * ------------------------------------------------------------
     * Call the Wrapper API
     *
     * @param array $arrData  - Data for the payment
     *
     * @return array $response - response from the API
     *
     */
        public function doDirectPayment($arrData)
        {
             $arrOrderData=$this->getOrderForPayPalDirect($this->oData[0]['customer_id'], $arrData['Args']['invoice']);
             if($this->oData[0]['paid']=='N')
             {
                $arrOrderData['CCard']=$arrData['CCard'];
                $response=$this->objWrapper->callAPI('DoDirectPayment',$arrOrderData);

                // We got the response from the API
                   switch($response['Ack'])
                   {
                       case 'Success':
                       case 'Sucess':
                           {
                               // Payment Success
                                  // Update the Order
                                  $this->updateOrderInfo($this->oData[0]['invoice_no'],'PP-DRT');
                                  return array(
                                      'Ack'=>'Sucess',
                                      'Actor'=>__FUNCTION__,
                                      'TransactionID'=>$response['TransactionID'],
                                      'MessageStack'=>$response,
                                      'InvoiceID'=>$this->oData[0]['invoice_no']

                                  );


                           }
                           break;
                       case 'Error':
                           {
                               return array('ERR'=>$response['ErrorCode']);
                           }break;
                       case 'Failure':
                           {

                                  return array(
                                      'Ack'=>'Failure',
                                      'Actor'=>__FUNCTION__,
                                      'MessageStack'=>$response

                                  );  


                           
                           }
                       default:
                           {
                                return array('ERR'=>'ACK-UNKNOWN');
                           }
                   }

                return $response;
             }
             else
             {
                 // Already paid for this invoice
                    return array('ERR'=>'ALREADY_PAID');
             }
             
        }



    /**
     * Get Order For PayPal Direct
     * ------------------------------------------------------------
     * Get the order details from the database using provided method and
     * prepare the data array to pass in to the wrapper
     *
     * @param string $customerID  - DIY customer Id
     * @param string $invoiceID  - DIY invoice Id
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        public function getOrderForPayPalDirect($customerID,$invoiceID)
        {
            // We have necessory values and can get the order values
                if(!$this->oData) $this->getOrder($invoiceID);
                if($this->oData[0]['ip']=="::1") $this->oData[0]['ip']='127.0.0.1';
                
                //echo __FILE__.__LINE__;print_r($this->oData);
                $vals = array
                            (
                                'Action'                    =>'Sale',                       // [Sale/Authroization] *-Required
                                'IPAddress'                 =>$this->oData[0]['ip'],        // IP address of the shopper *-Optional
                                'SessionID'                 =>'',                           // Merchant session Id *-Optional

                                'Order'=> array
                                    (
                                        'SubTotal'          =>$this->oData[0]['cost_contents'],               // Sub Total
                                        'Tax'               =>$this->oData[0]['cost_vat'],                     // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                                        'Total'             =>($this->oData[0]['cost_contents']+$this->oData[0]['cost_vat']),                    // Total of the Order [=SubTotal + Tax] *-Required
                                        'Currency'          =>'',                                               // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
                                    ),

                                'Payer'=> array
                                    (
                                      // You can easially understand the each parameter to be passed
                                        'FirstName'         =>$this->oData[0]['f_name'],
                                        'LastName'          =>$this->oData[0]['l_name'],
                                        'Address'           =>$this->oData[0]['address'],
                                        'Street'            =>$this->oData[0]['street'],
                                        'CityName'          =>$this->oData[0]['city'],
                                        'StateOrProvince'   =>$this->oData[0]['state'],
                                        'PostalCode'        =>$this->oData[0]['postal'],
                                        'CountryCode'       =>$this->oData[0]['country'],
                                        'Phone'             =>$this->oData[0]['telephone'],
                                        'Email'             =>$this->oData[0]['email'],
                                    ),

                            );

                 return $vals;

        }




    /**
     * Set Express Checkout
     * ------------------------------------------------------------
     * Call the Wrapper API
     *
     * @param array $arrData  - Data for the payment
     *
     * @return array $response - response from the API
     *
     */
        public function setExpressCheckout($arrData)
        {
             $arrOrderData=$this->getOrderForExpressCheckout($this->oData[0]['customer_id'], $arrData['Args']['invoice']);
             if($this->oData[0]['paid']=='N')
             {
                $arrOrderData['invoiceID']=$this->oData[0]['invoice_no'];
                $response=$this->objWrapper->callAPI('SetExpressCheckout',$arrOrderData); 

                // we have to write a situation only for faliures bellow



             } // End If - check for already paid orders
        } // End Function - setExpressCheckout





    /**
     * Confirm Express Checkout
     * ------------------------------------------------------------
     * Call the Wrapper API
     *
     * @param array $arrData  - Data for the payment
     *
     * @return array $response - response from the API
     *
     */
        public function confirmExpressCheckout($arrData)
        {

           // We got a value for a token. we should get all relative data from paypal
              $transactionData=$this->objWrapper->callAPI('GetExpressCheckoutDetails',array('Token'=>$arrData['Token']));
             
           // Now we can check the validity of the token
              if($transactionData['PaymentDetails']['OrderTotal']!=number_format($arrData['PaymentAmount'],2).$arrData['CurrencyCodeType'])
              {
                   return 'TOKEN-INVALID';             
              }
              else
              { 
                   // Prepare necessory values to confirm the order
                      $vals=array
                      (
                            'Token'         =>$arrData['Token'],
                            'Action'        =>$arrData['PaymentType'],
                            'OrderTotal'    =>$arrData['PaymentAmount'],
                            'Currency'      =>$arrData['CurrencyCodeType'],
                            'Payer'         => array
                                               (
                                                    'ID' =>$transactionData['PayerInfo']['PayerID'],
                                               ),

                      );     
                    
                // confirm the payment
                 $confirmedPayment=$this->objWrapper->callAPI('DoExpressCheckout',$vals);


                // We got the response from the API
                   switch($confirmedPayment['Ack'])
                   {
                       case 'Success':
                           {
                               // Payment Success
                                  // Update the Order
                                  $this->updateOrderInfo($transactionData['InvoiceID'],'PP-EXP');
                                  return array(
                                      'Ack'=>'Sucess',
                                      'CorrelationID'=>$confirmedPayment['CorrelationID'],
                                      'InvoiceID'=>$transactionData['InvoiceID']

                                  );
//GET EXPRESS CHECKOUT DETAILS [For Token: EC-6RD98553J3316271R]
//-----------------------------------------------------------Array
//(
//    [Token] => EC-6RD98553J3316271R
//    [PayerInfo] => Array
//        (
//            [Payer] => saliya_1264063573_per@gmail.com
//            [PayerID] => R6VBW4FCX5MMY
//            [PayerStatus] => verified
//            [PayerName] => Array
//                (
//                    [FirstName] => Test
//                    [LastName] => User
//                )
//
//            [PayerCountry] => US
//            [Address] => Array
//                (
//                    [Name] => Test User
//                    [Street1] => 1 Main St
//                    [CityName] => San Jose
//                    [StateOrProvince] => CA
//                    [Country] => US
//                    [CountryName] => United States
//                    [PostalCode] => 95131
//                    [AddressOwner] => PayPal
//                    [AddressStatus] => Confirmed
//                )
//
//        )
//
//    [CheckoutStatus] => PaymentActionNotInitiated
//    [PaymentDetails] => Array
//        (
//            [OrderTotal] => 211.50USD
//            [ItemTotal] => 180.00USD
//            [ShippingTotal] => 0.00USD
//            [HandlingTotal] => 0.00USD
//            [TaxTotal] => 31.50USD
//            [ShipToAddress] => Array
//                (
//                    [Name] => Test User
//                    [Street1] => 1 Main St
//                    [CityName] => San Jose
//                    [StateOrProvince] => CA
//                    [Country] => US
//                    [CountryName] => United States
//                    [PostalCode] => 95131
//                    [AddressOwner] => PayPal
//                    [AddressStatus] => Confirmed
//                )
//
//            [PaymentDetailsItem] => Array
//                (
//                    [Name] => Classified Ads
//                    [Quantity] => 1
//                    [Tax] => 0.00USD
//                    [Amount] => 180.00USD
//                    [EbayItemPaymentDetailsItem] =>
//                )
//
//            [InsuranceTotal] => 0.00USD
//            [ShippingDiscount] => 0.00USD
//        )
//
//    [Timestamp] => 2010-03-03T09:18:40Z
//    [Ack] => Success
//    [CorrelationID] => d82fd2c6cadb1
//    [Version] => 60
//    [Build] => 1212010
//)


                           }
                           break;
                       case 'Failure':
                           {
                                // Error Found
                                return array('ERR'=>'Error Occured','MessageStack' =>$confirmedPayment);

                           }break;
                       default:
                           {
                                return array('ERR'=>'ACK-UNKNOWN','MessageStack' =>$confirmedPayment);
                           }
                   }

                return $confirmedPayment;

                      
              } // End If - valid token




//             $arrOrderData=$this->getOrderForExpressCheckout($this->core->sessCusId, $arrData['Args']['invoice']);
//             if($this->oData[0]['paid']=='N')
//             {
//                $arrOrderData['invoiceID']=$this->oData[0]['invoice_no'];
//                $response=$this->objWrapper->callAPI('SetExpressCheckout',$arrOrderData);
//
//             }
//             else
//             {
//                 // Already paid for this invoice
//                    return array('ERR'=>'ALREADY_PAID');
//             }

        }






    /**
     * Get Order For Express Checkout
     * ------------------------------------------------------------
     * Get the order details from the database using provided method and
     * prepare the data array to pass in to the wrapper
     *
     * @param string $customerID  - DIY customer Id
     * @param string $invoiceID  - DIY invoice Id
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        private function getOrderForExpressCheckout($customerID,$invoiceID)
        {
            // We have necessory values and can get the order values
                $this->getOrder($invoiceID);

                $vals = array
                (
                    'Action'=>'Sale',                       // [Sale/Authroization] *-Required

                    'Order'=> array
                        (
                            'SubTotal'          =>$this->oData[0]['cost_contents'],               // Sub Total
                            'Tax'               =>$this->oData[0]['cost_vat'],                     // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                            'Total'             =>($this->oData[0]['cost_contents']+$this->oData[0]['cost_vat']),                    // Total of the Order [=SubTotal + Tax] *-Required
                            'Currency'          =>'',                                               // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
                        ),

                    'Payer'=> array                         // You can easially understand the each parameter to be passed - *-Required
                        (
                            'FirstName'=>$this->oData[0]['f_name'],
                            'LastName'=>$this->oData[0]['l_name'],
                            'Email'=>$this->oData[0]['email'],

                        ),

                        'Items'=> array
                        (
                            // Item 1
                            array
                            (
                                'Item'  =>'Classified Ads', // Try to add meanful content here
                                'Qty'   =>1, // keep Qty as 1.
                                'Amount'=>$this->oData[0]['cost_contents'],
                            )

                            // NOTE: PPWrapper v0.1 supports one item
                            // If you need to use more than one item enhance the wrapper class
                         ),

                );

                 return $vals;

        } // End Function - getOrderForExpressCheckout



    /**
     * Create Paypal Recurring Payment Profile
     * ------------------------------------------------------------
     * Pass necessory details to the wrapper to create recurrent profile
     * in the paypal system and then create record in diy database
     *
     * @param array  $arrData  - prepared array with all the relavent data
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        public function paypalCreateRecurrentProflie($arrData)
        { 
            // In here, we pay the initlal payment directly and then we create the
            // Recurring profile for the rest of the cycles
            // we do this as it will take up to 24 hrs to activate the profile

               $directResponse=$this->doDirectPayment($arrData);
               /* we can see a spelling issue in the word in the if block, but this is what returns the paypal
                * because of that we added another condition with the correct word,
                * in order to avoid any issue in the future
                */
               if($directResponse['Ack']=='Sucess' || $directResponse['Ack']=='Success')
               {
                // We have necessory values and can get the order values
                   $arrOrderData=$this->paypalGetOrderForCreateRecurrentProflie($this->oData[0]['customer_id'], $arrData['Args']['invoice']);
                   $arrOrderData['CCard']       =$arrData['CCard']; // add credit card details to the array
                   //-----------------------------

                   if($arrData['Args']['rPayAmount'])
                   {
                       $arrOrderData['Order']['SubTotal']=$arrData['Args']['rPayAmount'];
                       $vat=$this->calcVat($arrData['rPayAmount']);
                       $arrOrderData['Order']['Tax']=$vat;
                   }
                   // ---------------------------
                   // however we should set the start date manually as the first payment has been already done
                    $billingStart=$this->calcNextBillingDateTime($arrData['Schedule']['BillingPeriod'],$arrData['Schedule']['BillingFrequency']);
                    $arrData['Schedule']['StartDateDay']   =date("d",$billingStart);
                    $arrData['Schedule']['StartDateMonth'] =date("m",$billingStart);
                    $arrData['Schedule']['StartDateYear']  =date("Y",$billingStart);
                    
                 // we have charged the first payment and number of cycles should be reduced by one
                    $arrData['Schedule']['TotalCycles']--;
                 // add schedule deails to the array
                    $arrOrderData['Schedule']    =$arrData['Schedule']; 

                // Call the API through Wrapper
                   $reResponse=$this->objWrapper->callAPI('CreateRecurringProfile',$arrOrderData);
                    // We got the response from the API
                       switch($reResponse['Ack'])
                       {
                           case 'Success':
                           case 'Sucess':
                               {
                                   // Payment Success
                                      // create the recurring record in diy system
                                         $recArray=array
                                         (
                                             'Gate'             =>'PP',
                                             'OrderId'          =>$this->oData[0]['id'],
                                             'RCProfileId'      =>$reResponse['ProfileID'],
                                             'RCProfileStatus'  =>$reResponse['ProfileStatus'],
                                             'Amount'           =>$this->oData[0]['cost_contents'],
                                             'TaxAmount'        =>$this->oData[0]['cost_vat'],
                                             'TaxPrecentage'    =>$this->vatPercentage,
                                             'NextPayDate'      =>$billingStart,
                                             'CCExpire'         =>mktime(0, 0, 0, $arrData['CCard']['ExpiryDateMonth'], 1,$arrData['CCard']['ExpiryDateYear']),
                                             
                                             // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
                                         );


                                      $this->diyRecurringProfileCreate($recArray);
                                      
                                      // We store the 1st payment in the recurring payment table
                                      $arrayRPC=array(
                                                'PaymentCycle'=>'1',
                                                'Amount'=>($this->oData[0]['cost_contents']+$this->oData[0]['cost_vat']),
                                                'PaymentStatus'=>$directResponse['Ack'],
                                                'TxnId'=>$directResponse['TransactionID'],
                                                );
                                      $this->diyRecurringPaymentCreate($reResponse['ProfileID'], $this->oData[0]['id'], $arrayRPC, 'Y');
                                  
                                      return array(
                                          'Ack'              =>'Success',
                                          'TransactionID'    =>$reResponse['TransactionID'],
                                          'MessageStack'     =>$reResponse,
                                          'InvoiceID'        =>$this->oData[0]['invoice_no']
                                      );
                               } // End Case - Success
                               break;
                           case 'Error':
                               {
                                   return array('ERR'=>$response['ErrorCode'],'MessageStack' =>$reResponse);
                               }break;
                           default:
                               {
                                    return array('ERR'=>'ACK-UNKNOWN','MessageStack' =>$reResponse);
                               }
                       } // End Switch - $response['Ack']
               }
               else
               {
                   // Error Found
                   return array('ERR'=>'Error Occured','MessageStack' =>$directResponse);
               } // End - if($directResponse['Ack']=='Success')

        } // End Function - getOrderForExpressCheckout


    /**
     * Get Data for Create Paypal Recurring Payment Profile
     * ------------------------------------------------------------
     * Get necessory data from the database and prepare the array to
     * pass to the Pay Pal API
     *
     * @param string $customerID  - DIY customer Id
     * @param string $invoiceID  - DIY invoice Id
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        private function paypalGetOrderForCreateRecurrentProflie($customerID,$invoiceID)
        {
            // We have necessory values and can get the order values
                 if(!$this->oData) $this->getOrder($invoiceID);

                $vals = array
                (
                    'Action'=>'Sale',                       // [Sale/Authroization] *-Required

                    'Order'=> array
                        (
                            'SubTotal'          =>$this->oData[0]['cost_contents'],               // Sub Total
                            'Tax'               =>$this->oData[0]['cost_vat'],                     // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                            'Currency'          =>'',                                               // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
                        ),

                    'Payer'=> array                         // You can easially understand the each parameter to be passed - *-Required
                        (
                            'FirstName'         =>$this->oData[0]['f_name'],
                            'LastName'          =>$this->oData[0]['l_name'],
                            'Email'             =>$this->oData[0]['email'],
                            'Address'           =>$this->oData[0]['address'],
                            'Street'            =>$this->oData[0]['street'],
                            'CityName'          =>$this->oData[0]['city'],
                            'StateOrProvince'   =>$this->oData[0]['state'],
                            'PostalCode'        =>$this->oData[0]['postal'],
                            'CountryCode'       =>$this->oData[0]['country'],
                            'Phone'             =>$this->oData[0]['telephone'],

                        ),

                );

                 return $vals;

        } // End Function - getOrderForExpressCheckout



    /**
     * Update Paypal Recurring Payment Profile - Number of billing cycles
     * ------------------------------------------------------------
     * Pass necessory details to the wrapper to create recurrent profile
     * in the paypal system and then create record in diy database
     *
     * @param string $customerID  - DIY customer Id
     * @param string $invoiceID  - DIY invoice Id
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        public function paypalRecurrentProflieExtendBillingCycles($profile,$cycles)
        {

            $vals = array
                    (
                        'Action'=>'AdditionalBillingCycles',
                        'ProfileID'=>$profile,
                        'Schedule' => array
                            (
                                'TotalCycles' => $cycles,
                            )
                    );
            $result=$this->objWrapper->callAPI('UpdateRecurringProfile',$vals);
            return $result;

        }


    /**
     * Update Paypal Recurring Payment Profile - Credit card information
     * ------------------------------------------------------------
     * Pass necessory details to the wrapper to update recurrent profile
     * in the paypal system and then create record in diy database
     *
     * @param string $customerID  - DIY customer Id
     * @param string $invoiceID  - DIY invoice Id
     *
     * @return array $vals - Prepared array for the wrapper.
     *
     */
        public function paypalRecurrentProflieChangeCreditCard($profile,$ccData,$payer)
        {

            $vals = array
                    (
                        'Action'=>'ChangeCreditCard',
                        'ProfileID'=>$profile,
                        'CCard'=>array
                            (
                                'Type'    =>$ccData['CardType'],                    // Credit Card Type [Visa/ Master/ etc]
                                'Number'  =>$ccData['CardNumber'],                // Credit Card Number
                                'ExpMonth'=>$ccData['ExpiryDateMonth'],           // Expire Month in 2 digits
                                'ExpYear' =>$ccData['ExpiryDateYear'],             // Expire Month in 2 digits
                                'CVV2'    =>$ccData['CV2'],                     // This is the code in back side of the card 3/4 digits depending on the card type

                            ),

                        'Payer'=> array                          // You can easially understand the each parameter to be passed
                            (
                                'FirstName'         =>$payer['fName'],
                                'LastName'          =>$payer['lName'],
                                'Address'           =>$payer['address'],
                                'Street'            =>$payer['street'],
                                'CityName'          =>$payer['city'],
                                'StateOrProvince'   =>$payer[''],
                                'PostalCode'        =>$payer['postcode'],
                                'CountryCode'       =>$payer['country'],
                                'Phone'             =>$payer[''],
                                'Email'             =>$payer[''],

                            ),
                    );
            $result=$this->objWrapper->callAPI('UpdateRecurringProfile',$vals);
            return $result;

        }




        
    /**
     * Calculate the Hash
     * ------------------------------------------------------------
     * you can change the encryption in to any preferable algorithm from here
     */
        public function calculateHash($arrArgs)
        {
            $sth=''; //string to hash
            $amp="";

            foreach($arrArgs as $key=>$values)
            {
                $sth.= $amp.$key.'='.$values."";// add a default key
                $amp="&";
            }

            $hs=md5($sth); // calculate the hash
            return $hs;
        }



    /**
     * Constructor
     * ------------------------------------------------------------
     * call parent construct
     * prepare alternative country array
     * create wrapper and assign main values for execution
     */
    function __construct($gConf='')
    {
        parent::__construct($gConf);
        // We should pass the Paypal compatible country codes
        // here we arrange the possible changes to the country codes
        $this->diyCountries=array(
            'UK'=>'GB',
        );

        if(!is_object($this->objWrapper)) $this->objWrapper=new PPWrapper();

        require_once($this->core->_SYS['CONF']['DIR_MODULES'].'/payments/PP-API/config.php');

            // Common values - required
               $this->objWrapper->setAPIEnviornment($ppapi['Enviorenment']);
               $this->objWrapper->setPathSDK($ppapi['PathSDK']);
               $this->objWrapper->setDefaultCurrency($ppapi['DefaultCurrency']);

            // API Credentials - Most important values for API integration
               $this->objWrapper->setAPIUser($ppapi['APIUser']);
               $this->objWrapper->setAPIPassword($ppapi['APIPassword']);
               $this->objWrapper->setAPISignature($ppapi['APISignature']);

            // Specially needs in Instant Notification section (listner of the site)
               $this->objWrapper->setAPIUserId($ppapi['APIUserId']);
               $this->objWrapper->setAPIUserEmail($ppapi['APIUserEmail']);

            // Specially needs in Express checkout seciton
               $this->objWrapper->setAPIExpressCheckoutReturnURL($ppapi['ECRetrunURL']);
               $this->objWrapper->setAPIExpressCheckoutCancelURL($ppapi['ECCancelURL']);


           // Prepare configuration values
              $confVals=$this->getConfigValues();
              $this->tblPrefix            = $confVals['tblPrefix'];
              $this->gConf                = $confVals['gConf'];
              $this->paginationConsole    = $confVals['paginationConsole'];
              $this->paginationFront      = $confVals['paginationFront'];
              $this->vatStatus            = $confVals['vatStatus'];
              $this->vatPercentage        = $confVals['vatPercentage'];

           // Prepare array for payment periods
//              $this->paymentPeriods=array(
//                  'Month'=>array(
//                            1=> 'Monthly',
//                            3=> '',
//                            9=> '',
//                            12=> '',
//
//                            ),
//                  'Year'=>array(
//
//                  )
//              );

    } // End - Constructer



    /**
     * Destructor
     * ------------------------------------------------------------
     */
    function __destruct()
    {
        unset($this->oData);
        unset($this->objWrapper);
        unset($this->diyCountries);

    }



    /**
     * DIY- Recurring profile creation
     * ------------------------------------------------------------
     * DIY System specific class for creating necessory records to
     * keep minimum information about recurring profiles
     * within the system.
     *
     * @param string $var  -
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     private function diyRecurringProfileCreate($var)
     {
                                                                                        
   		$sql = "INSERT INTO `".$this->tblPrefix."recurring_profiles` (`gate`, `order_id`, `client_id`, `profile_id`, `profile_status`, `amount`, `tax_amount`, `tax_percentage`,`cc_expire`,`next_payment`)
                VALUES ('".$var['Gate']."', '".$var['OrderId']."', '".$this->oData[0]['customer_id']."', '".$var['RCProfileId']."', '".$var['RCProfileStatus']."', '".$var['Amount']."',
                '".$var['TaxAmount']."', '".$var['TaxPrecentage']."', '".$var['CCExpire']."', '".$var['NextPayDate']."')";
   		
   		$this->query($sql);
   		return $invoiceNo; 


     }


    /**
     * DIY- Recurring profile creation
     * ------------------------------------------------------------
     * DIY System specific class for creating necessory records to
     * keep minimum information about recurring profiles
     * within the system.
     *
     * @param string $var  -
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     public function diyRecurringProfileGet($profileId)
     {
         $rpList=$this->diyRecurringProfiles('ByProfile',array($profileId));
         return $rpList;
     }


    /**
     * DIY- Recurring profile creation
     * ------------------------------------------------------------
     * DIY System specific class for creating necessory records to
     * keep minimum information about recurring profiles
     * within the system.
     *
     * @param string $gate  - payment gateway
     *
     * @return array $rpList - array containing profile details
     *
     */
     public function diyRecurringProfileListFutureShedules($gate='PP')
     {
         /*
          * NOTE: in current development I have considered only the paypal gateway
          * if you ever need to add another, please add the $gate to the array bellow
          * and make necessory amendment to the method.
          */
         $rpList=$this->diyRecurringProfiles('ByFutureShedules',array());
         return $rpList;
     }


    /**
     * DIY- Recurring profile List
     * ------------------------------------------------------------
     * DIY System specific class for get recurring profile list by
     * a specific customer
     *
     * @param string $customerId  - customer id
     * @param string $status  - profile status
     * @param string $gate  - payment gateway
     *
     * @return array $rpList - array containing profile details
     *
     */
     public function diyRecurringProfileListByCustomer($customerId,$status='',$gate='PP')
     {
         /*
          * NOTE: in current development I have considered only the paypal gateway
          * if you ever need to add another, please add the $gate to the array bellow
          * and make necessory amendment to the method.
          */
         $rpList=$this->diyRecurringProfiles('ByCustomer',array($customerId,$status));
         return $rpList;
     }


    /**
     * DIY- Recurring profile List
     * ------------------------------------------------------------
     * DIY System specific class for get recurring profile list by
     * a specific customer
     *
     * @param string $customerId  - customer id
     * @param string $status  - profile status
     * @param string $gate  - payment gateway
     *
     * @return array $rpList - array containing profile details
     *
     */
     public function diyRecurringProfileListByCustomerFutureShedules($customerId,$pg=1,$status='',$gate='PP')
     {
         /*
          * NOTE: in current development I have considered only the paypal gateway
          * if you ever need to add another, please add the $gate to the array bellow
          * and make necessory amendment to the method.
          */
         $rpList=$this->diyRecurringProfiles('ByCustomerFutureShedules',array($customerId,$pg,$status));
         return $rpList;
     }


    /**
     * DIY- Recurring profile get from specified gateway
     * ------------------------------------------------------------
     * DIY System specific class for get the recurring profiles
     * from respective payment gateways.

     *
     * @param string $profileId  - profile Id for the gateway
     * @param string $gate - Gateway identifier (PP for paypal)
     *
     * @return array $response - contain profile details as in the format that we need to use in the diy
     *
     */
     public function diyRecurringProfileGetFromGateway($profileId,$gate='PP')
     {
         /*
          * NOTE: in current development I have considered only the paypal gateway
          * if you ever need to add another, please add the $gate to the array bellow
          * and make necessory amendment to the method.
          */
         $profile=$this->objWrapper->callAPI('GetRecurringProfileDetails', array('ProfileID'=>$profileId));

         // adjust amount
//         $alphabet=range("A","Z");
//         if(str_replace($alphabet,'',$profile['RegularAmountPaid'])=='0.00')
//         {
//             $profile['RegularAmountPaid']=$this->pharseAmount($profile['CurrentRecurringPaymentsPeriod']['Amount']) +$this->pharseAmount($profile['CurrentRecurringPaymentsPeriod']['TaxAmount']) ;
//         }


         return $profile;
     }


    /**
     * DIY- Recurring profile List
     * ------------------------------------------------------------
     * DIY System specific class for get available recurring profiles
     *
     * @param string $type  - the query type (ByCustomer,ByProfile, etc)
     * @param array $args - contain all the arguments depend on the type
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     private function diyRecurringProfiles($type,$args)
     {

         switch ($type)
         {
             case "ByCustomer":
                 {
                    $on="rp.client_id='".$args[0]."' ";
                    $orderBy=' ORDER BY rp.next_payment';
                 }
                 break;
             case "ByProfile":
                 {
                    $on="rp.profile_id='".$args[0]."' ";
                 }
                 break;
             case "ByFutureShedules":
                 {
                    
                    $on="rp.next_payment >".time()." ";
                 }
                 break;
             case "ByCustomerFutureShedules":
                 {
                    $on="rp.client_id='".$args[0]."' AND rp.next_payment >".time();

                    $orderBy=' ORDER BY rp.next_payment';
                 }
                 break;
             default:
                 {
                    return false;
                    exit;
                 }

         }


         if($on)
         {
            // Execute the Query
            $result=$this->queryPg("SELECT rp.id as rp_id,rp.gate,rp.order_id,rp.client_id,rp.profile_id,rp.profile_status,
                                   rp.amount,rp.tax_amount,rp.tax_percentage,rp.next_payment,rp.cc_expire,ord.id as ord_id,ord.invoice_no,
                                   ord.title,ord.f_name,ord.l_name,ord.email
                                   FROM `".$this->tblPrefix."recurring_profiles` rp
                                   JOIN `".$this->tblPrefix."orders` ord ON $on  AND rp.order_id=ord.id $orderBy ",$args[1],$this->paginationFront);

                for($i=0;$i<count($result);$i++)
                {
                    $list[$i][]=$result[$i]['rp_id'];//0
                    $list[$i][]=$result[$i]['gate'];//1
                    $list[$i][]=$result[$i]['order_id'];//2
                    $list[$i][]=$result[$i]['client_id'];//3
                    $list[$i][]=$result[$i]['profile_id'];//4
                    $list[$i][]=$result[$i]['profile_status'];//5
                    $list[$i][]=$result[$i]['amount'];//6
                    $list[$i][]=$result[$i]['tax_amount'];//7
                    $list[$i][]=$result[$i]['tax_percentage'];//8
                    $list[$i][]=$result[$i]['next_payment'];//9
                    $list[$i][]=$result[$i]['cc_expire'];//10
                    $list[$i][]=$result[$i]['ord_id'];//11
                    $list[$i][]=$result[$i]['invoice_no'];//12
                    $list[$i][]=$result[$i]['title'];//13
                    $list[$i][]=trim($result[$i]['f_name']." ".$result[$i]['l_name']);//14
                    $list[$i][]=$result[$i]['email'];//15
                } // End - loop
         } // End -if

	return $list;
     }


    /**
     * DIY- Recurring profile creation
     * ------------------------------------------------------------
     * DIY System specific class for creating necessory records to
     * keep minimum information about recurring profiles
     * within the system.
     *
     * @param string $var  -
     * @param string $update [NextPayment| ]
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     private function diyRecurringProfileUpdate($var,$update='')
     {
         
        switch($update)
        {
            case "NextPayment":
                {
                    $nextPayment=$this->objWrapper->pharseDateTime($var['NextPaymentDate']);

                    $this->query("UPDATE `".$this->tblPrefix."recurring_profiles` SET `next_payment`='".$nextPayment['Stamp']."'
                                  WHERE `profile_id`='".$var['RecurringPaymentId']."'");
                     return true;
                }
                break;
            default:
                {
                    return false;
                }
            
        } // End Switch

     } // End Function -diyRecurringProfileUpdate




    /**
     * DIY- Recurring payment creation
     * ------------------------------------------------------------
     * DIY System specific class for creating necessory records to
     * keep minimum information about recurring payment
     * within the system.
     *
     * @param string $var  -
     *
     * @return bool $response - indicate whether the process was sucess or fail
     *
     */
     private function diyRecurringPaymentCreate($profId,$orderId,$var,$status='N')
     {
         if($profId && $orderId && is_array($var))
         {
            if(!$status) $status='N';
           
            $this->query("INSERT INTO `".$this->tblPrefix."recurring_payments` (`profile_id`, `order_id`, `cycle_id`, `amount_charged`, `gateway_status`, `gateway_trans_id`, `time`, `locked`)
                VALUES ('".$profId."', '".$orderId."', '".$var['PaymentCycle']."', '".$var['Amount']."', '".$var['PaymentStatus']."', '".$var['TxnId']."',
                '".time()."', '".$status."')");
            return true;

         }
         else
         {
             return false;
         }
         
     }

    /**
     * DIY- Recurring PaymentListner
     * ------------------------------------------------------------
     * DIY System specific class for work with API listner in the wrapper
     * class in order to creating necessory updates to the diy system
     * when a automatic transaction/ update has happend at the PayPal end
     *
     * @param array $var  ->

        *   Following is the complete variable list as @ Feb 2010
        *   -----------------------------------------------------
        *   McGross,OutstandingBalance,PeriodType,NextPaymentDate,ProtectionEligibility
        *   PaymentCycle,Tax,PayerId,PaymentDate,PaymentStatus,ProductName,Charset
        *   RecurringPaymentId,firstName,McFee,NotifyVversion,AmountPerCycle,PayerStatus
        *   CurrencyCode,Business,VerifySign,InitialPaymentAmount,ProfileStatus,Amount
        *   TxnId,PaymentType,LastName,ReceiverEmail,PaymentFee,ReceiverId,TxnType
        *   McCurrency,ResidenceCountry,TestIpn,ReceiptId,TransactionSubject
        *   PaymentGross,Shipping,ProductType,TimeCreated
        *
     * 
     *
     */
     public function diyRecurringPaymentListner($ipnDataArray)
     {

    
        switch($ipnDataArray['TxnType'])
        {
            case "recurring_payment":
                {

                   /* Now we need to check whether this order is valid and has been already paid
                    *    1) Is there exact recurring profile? should be YES
                    *    2) Recurring payment record crated?  should be NO
                    *    3) Related order is there in the order table? should be NO
                    */
                     $firstCheck=$this->query("SELECT rp.profile_id,ord.id,pay.gateway_trans_id
                                    FROM `".$this->tblPrefix."recurring_profiles` rp
                                    JOIN `".$this->tblPrefix."orders` ord
                                    JOIN `".$this->tblPrefix."recurring_payments` pay
                                    ON    rp.profile_id='".$ipnDataArray['RecurringPaymentId']."'
                                    AND pay.order_id=ord.id
          
                                    AND pay.gateway_trans_id='".$ipnDataArray['TxnId']."'
                                    ");

                   /* Same time we can double check the profile
                    */
                     $rProfile=$this->objWrapper->callAPI('GetRecurringProfileDetails',array( 'ProfileID'=>$ipnDataArray['RecurringPaymentId']));


                     if(count($firstCheck)>0 || $rProfile['Ack']=='Failure')
                     {
                         // Error - as this is automated process which hasnt human intaraction,
                         // better way is maintain a log system
                         //
                     }
                     else
                     {
                        // Ok to proceed -----------------------> 

                        // We should get the recurring proile details from the database
                             $rProfileDb=$this->query("SELECT rp.id,rp.gate,rp.order_id,rp.client_id,rp.profile_id,rp.profile_status,
                                                        rp.amount,rp.tax_amount,rp.tax_percentage,rp.next_payment,rp.cc_expire,ord.id,ord.invoice_no
                                                        FROM `".$this->tblPrefix."recurring_profiles` rp
                                                        JOIN `".$this->tblPrefix."orders` ord ON rp.profile_id='".$ipnDataArray['RecurringPaymentId']."'
                                                        AND rp.order_id=ord.id");

//

                        // We should create new order
                           if($rProfileDb[0]['invoice_no']&&$rProfileDb[0]['client_id'])
                           {

                           // First we take the specific order data
                              $initOrder=$this->getOrderDetails($rProfileDb[0]['client_id'], '', $rProfileDb[0]['invoice_no']);

                           // Now we create a new order
                              $orderContents=explode("||",$initOrder[0][25]);
                              $subscription=$orderContents[0]; // this should be on of from  M,S or C
                              $orderContents[0]=''; // empty the fist ele
                              if(trim($orderContents[1])) $package=implode("||",$orderContents);

                              $newInvoice=$this->setOrder($rProfileDb[0]['client_id'], $subscription, $package, $rProfileDb[0]['amount'], 'PP-RCR',$initOrder[0][26]);

                           // Now we should mark the new order as paid
                              $this->updateOrderInfo($newInvoice, 'PP-RCR');
                           // And we need the new order id
                           $newOrder=$this->getOrderInfoByCus($rProfileDb[0]['client_id'], $newInvoice);
              
                        // We should create new recurring payment record
                           $this->diyRecurringPaymentCreate($ipnDataArray['RecurringPaymentId'], $newOrder[0]['id'], $ipnDataArray, 'Y');


                            return true;
                           }
                           else
                           {
                               // Second check has been failed
                               return false;
                           }
                     
                     } // End if
                    
                }
                break;
            default:
                {
                    // Not a valid transaction for diy system
                    // make a log
                    foreach($ipnDataArray as $key=>$value)
                    {
                        $log.=$key."=".$value."\n";
                    }
                    $this->query("INSERT INTO `"."@diy_____logs` (log,time) VALUES ('".$log."','".time()."')" );
                    return false;

                }
        }  // End switch - $ipnDataArray['TxnType']


     } // End function - diyRecurringPaymentListner



    /**
     * calculate the next payment day depending on the current time stamp
     * ------------------------------------------------------------
     * @param string $var  -
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     public function calcNextBillingDateTime($period='Year',$frequency=1,$timeStamp='')
     {
         switch($period)
         {

             case "Month":
                 {
                     if($frequency<1||$frequency>12)
                     {
                        return false;
                     }
                     else
                     { 
                         if($timeStamp)
                              return mktime(date("H",$timeStamp), date("i",$timeStamp), date("s",$timeStamp), (date("m",$timeStamp)+$frequency), date("d",$timeStamp),   date("Y",$timeStamp));
                         else
                              return mktime(23, 59, 59, date("m")+$frequency, date("d"),   date("Y"));

                     }
                 }
                 break;
             case "Year":
                 {
                     if($frequency<1||$frequency>52)
                     {
                        return false;
                     }
                     else
                     {
                         if($timeStamp)
                              return mktime(date("H",$timeStamp), date("i",$timeStamp), date("s",$timeStamp), date("m,$timeStamp"), date("d",$timeStamp),   date("Y",$timeStamp)+$frequency);
                         else
                              return mktime(23, 59, 59, date("m"), date("d"),   date("Y")+$frequency);
                     }
                     
                 }
                 break;
             case "Day":
                 {
                     if($frequency<1||$frequency>30)
                     {
                        return false;
                     }
                     else
                     {
                         if($timeStamp)
                              return mktime(date("H",$timeStamp), date("i",$timeStamp), date("s",$timeStamp), date("m",$timeStamp), date("d",$timeStamp)+$frequency,   date("Y",$timeStamp));
                         else
                              return mktime(23, 59, 59, date("m"), date("d")+$frequency,   date("Y"));

                     }
                 }
                 break;

              default:
                 {
                    return false;
                 }
             
         } // End Switch
       
       
     } // End Function - calcNextBillingDateTime



    /**
     * Get recurring payment details from the diy system
     * ------------------------------------------------------------
     * @param string $profileId  - Payment gateway profile id
     *
     * @return $payments - all the payment data retrieved from the database
     *
     */
     public function diyRecurringPaymentGetByProfile($Id)
     {
         $result=$this->query("SELECT `id`, `profile_id`, `order_id`, `cycle_id`, `amount_charged`, 
                               `gateway_status`, `gateway_trans_id`, `time`, `locked` 
                               FROM `".$this->tblPrefix."recurring_payments`
                               WHERE `profile_id`='".$Id."' ORDER BY `time`");

            for($i=0;$i<count($result);$i++)
            {
                $list[$i][]=$result[$i]['id'];              //0
                $list[$i][]=$result[$i]['profile_id'];      //1
                $list[$i][]=$result[$i]['order_id'];        //2
                $list[$i][]=$result[$i]['cycle_id'];        //3
                $list[$i][]=$result[$i]['amount_charged'];  //4
                $list[$i][]=$result[$i]['gateway_status'];  //5
                $list[$i][]=$result[$i]['gateway_trans_id'];//6
                $list[$i][]=$result[$i]['time'];            //7
                $list[$i][]=$result[$i]['locked'];          //8

            } // End - loop

            return $list;
     }


     
    /**
     * calculate the next payment day depending on the current time stamp
     * ------------------------------------------------------------
     * @param string $var  -
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     public function diyRecurringPaymentForceCreate($txnId)
     {
        // we should get transaction values again before do the update
        // this create an extra load to the server, but we should take this precaution as the security should be high
           $transData=$this->objWrapper->callAPI('GetTransactionDetails',array('TransactionID'=>$txnId));

        // if the response is positive, now we should prepare the array

           if($transData['Ack']=='Success')
           {
                $dataArray=array(
                    'McGross'=>'',
                    'OutstandingBalance'=>'',
                    'PeriodType'=>'',
                    'NextPaymentDate'=>'',
                    'ProtectionEligibility'=>'',
                    'PaymentCycle'=>'',
                    'Tax'=>'',
                    'PayerId'=>'',
                    'PaymentDate'=>'',
                    'PaymentStatus'=>'',
                    'ProductName'=>'',
                    'Charset'=>'',
                    'RecurringPaymentId'=>'',
                    'firstName'=>'',
                    'McFee'=>'',
                    'NotifyVersion'=>'',
                    'AmountPerCycle'=>'',
                    'PayerStatus'=>'',
                    'CurrencyCode'=>'',
                    'Business'=>'',
                    'VerifySign'=>'',
                    'InitialPaymentAmount'=>'',
                    'ProfileStatus'=>'',
                    'Amount'=>'',
                    'TxnId'=>'',
                    'PaymentType'=>'',
                    'LastName'=>'',
                    'ReceiverEmail'=>'',
                    'PaymentFee'=>'',
                    'ReceiverId'=>'',
                    'TxnType'=>'recurring_payment',
                    'McCurrency'=>'',
                    'ResidenceCountry'=>'',
                    'TestIpn'=>'',
                    'ReceiptId'=>'',
                    'TransactionSubject'=>'',
                    'PaymentGross'=>'',
                    'Shipping'=>'',
                    'ProductType'=>'',
                    'TimeCreated'=>'',
                );


             // Now we can execute the payment listner function in order to create the payment
                return $this->diyRecurringPaymentListner($dataArray);
           }
           else{
               return $transData;
           }


     } // End Function - calcNextBillingDateTime


    /**
     * get transactio data via diy specific class
     * ------------------------------------------------------------
     * @param string $txnId  - transaction id issued by the gateway
     * @param string gateway  - payment gateway identifier
     *
     * @return bool $response - indicate wheter the process sucess or fail
     *
     */
     public function diyGetTransaction($txnId,$gateway='PayPal')
     {
          if($txnId)
          {
              $transData=$this->objWrapper->callAPI('GetTransactionDetails',array('TransactionID'=>$txnId));
              return $transData;
          }
          else
          {
              return false;
          }
          
     }



     /*
      * pharse date time using wrapper method
      */
       public function pharseDateTime($dateTime)
       {
           $result=$this->objWrapper->pharseDateTime($dateTime);
           return $result;
       }


     /*
      * pharse Amount comeup with currency codes
      */
       public function pharseAmount($amount)
       {
           $alphabet=range("A","Z");
           $value=trim(str_replace($alphabet,'',$amount));
           return $value;
       }


       public function calculateBuildingSupplierFare($customerId,$customerStatus,$package,$period='Month')
       {
          

          // Get fare details from the database
            require_once($this->core->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
            if(!is_object($objGlobalConfig)) $objGlobalConfig= new GlobalConfig;



           // Get customer status ----------------------------------------------
            
            for($cs=0;$cs<count($customerStatus);$cs++)
            {
                if($customerStatus[$cs][2]=='M')
                {
                    $currExpire=$customerStatus[$cs][5];
                    $currPackage=$customerStatus[$cs][3];
                    $currFrequent=$customerStatus[$cs][7];
                    $currProfile=$customerStatus[$cs][8];
                    $lastPayment=$customerStatus[$cs][9];
                    $noOfListings=$customerStatus[$cs][6];
                    $subscriptionFound=true;
                    break;
                }
            }
           // ------------------------------------------------------------------

           // Get Requested package information --------------------------------
            $packageData=explode("||",$package);
            $reqPackage=$packageData[0];
            $reqFrequent=$packageData[1];
            $reqFareData=$objGlobalConfig->pickAFare($reqPackage, $reqFrequent);
            $reqFare = $reqFareData[2];
           // ------------------------------------------------------------------

            
           // Main check - customer already subscribed or not ------------------
             if(!$subscriptionFound)
              {
                // First subscription ------------------------------------------
                   $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                   return array(
                              'Ack'                 =>'Ok',
                              'InitialPayment'      =>$reqFare,
                              'Package'             =>$reqPackage,
                              'Frequent'            =>$reqFrequent,
                              'Expiration'          =>$nextPaymentDate,
                              'CurrentExpire'       =>$currExpire,
                              'Action'              =>'FIRST-SUBCRIPTION',
                          );
                // End - First subscription -----------------------------------
              }
              else
              {
                // User Already subscribed to the buliding supplier package ----

                // Get Current (Existing) package information ------------------
                    $currFareData=$objGlobalConfig->pickAFare($currPackage, $currFrequent);
                    $currFare = $currFareData[2];
                // -------------------------------------------------------------

                // Check for recurring / Non recurring status ------------------
                    if($currProfile)
                    {
                        // Check the profile and get status
                        $rcProfile=$this->diyRecurringProfileGetFromGateway($currProfile);
                        if($rcProfile['ProfileStatus']=="ActiveProfile")
                        {
                            $activeProfile=true;
                        }
                        else
                        {
                            $activeProfile=false;
                        }
                            
                    }
                    else
                    {
                        $activeProfile=false;
                    }


                 // Check for Expire/Non Expire status -------------------------

                    if(time()>$currExpire)
                    {
                      // Subscription Expired ----------------------------------
                         $timeExeeded= $this->getTimeDifference($currExpire);
                         
                         // Fare calculation -----------------------------------
                         /*
                          * We get number of month exeeded (ceiling value) and
                          * calculate the fare for those months based on the
                          * current subscription fares
                          * then we should add new fare value for one time occurent
                          * and calculate the initial payment
                          * if customer selects the recurring payment, requested
                          * fare will be added to the recurring profile
                          *
                          * expiaration date will be calculated based on current date
                          * recurring payment start date will be exactly on expiaration date
                          */
                            $exeededBy=ceil($timeExeeded['Months']);
                            if($exeededBy>0 && $currFrequent!=0)
                            {
                                $chargeExpired=($currFare/$currFrequent)*$exeededBy;
                                $chargeExpiredCalc="($currFare/$currFrequent)*$exeededBy"; // To display purpose
                                $initialPayment=$chargeExpired + $reqFare;

                            }
                            $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                            if(!$initialPayment) $initialPayment=$reqFare;
                            return array(
                                      'Ack'                 =>'Ok',
                                      'InitialPayment'      =>$initialPayment,
                                      'Package'             =>$reqPackage,
                                      'Frequent'            =>$reqFrequent,
                                      'Expired'             =>array(
                                                                'By' => $exeededBy,
                                                                'Calculation'=>$chargeExpiredCalc,
                                                                ),
                                      'FareData'            =>array(
                                                                'EXP_PERIOD'=>$chargeExpired,
                                                                'NEW_PAY_CYCLE'=>$reqFare,
                                                                ),
                                      'Expiration'          =>$nextPaymentDate,
                                      'CurrentExpire'       =>$currExpire,
                                      'Action'              =>'EXPIRED|NEW-PROFILE',
                                      'NumberOfListings'    =>$noOfListings,
                                  );

                      // END Subscription Expired ----------------------------------

                    }
                    else
                    { 
                      // Subscription NOT Expired ----------------------------------
                         if($reqFare>$currFare) $initialPayment=$reqFare-$currFare;
                         if(!$nextPaymentDate) $nextPaymentDate=$this->calcNextBillingDateTime('Month', $reqFrequent);
                         if($currPackage==$reqPackage && $currFrequent==$reqFrequent) $sameSubscription=true;

                         // Fare calculation - Main ----------------------------
                         /*
                          * There are several scenarios for this section
                          * We get number of month spent (ceiling value) and
                          * calculate the fare for those months based on the
                          * current subscription fares
                          * rest of the calculation will be explained in each section
                          */
                          $timeS= $this->getTimeDifference($currExpire); 
                          $timeSpent=$currFrequent-intval(ceil($timeS['Months']));

                          if($timeSpent>0 && $currFrequent!=0)
                          {
                                $chargeSpent=($currFare/$currFrequent)*$timeSpent;
                                $chargeSpentCalc="($currFare/$currFrequent)*$timeSpent"; // To display purpose
                          }
                         // End fare calculation - Main ------------------------


                         if($activeProfile)
                         { 
                             // Recurring Payment
                               if($sameSubscription)
                              {
                                  // We dont need to proceed. throug and exlamation
                                  // customer can simply control same package from my account section
                                    return array(
                                              'Ack'             =>'Error',
                                              'Error'           =>'PKG_SAME',
                                              'CurrentExpire'   =>$currExpire,
                                        
                                    );
                                    exit;
                              }
                              else
                              {
                                  // different package
                                  // we have to calculate the values
                                     $initialPayment=$reqFare-$chargeSpent;
                                     $action='NON-EXPIRED|RECURRING|UPDATE-PROFILE';
                                     $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                              }

                         }
                         else
                         {
                            
                           // Non recurring Payment
                              $currProfile=''; // drop current profile Id
                              
                              if($sameSubscription)
                              {
                                  // We have to get the payment and extend the time expiaration
                                    $initialPayment=$reqFare;
                                    $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent, $currExpire);
                                    $action='NON-EXPIRED|NON-RECURRING|EXTEND-TIME';
                              }
                              else
                              {
                                  // different package
                                  // we have to calculate the values
                                     $initialPayment=$reqFare-$chargeSpent;
                                     $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                                     $action='NON-EXPIRED|NON-RECURRING|NEW-PROFILE';
                              }

                         }

                          if($initialPayment<0) $initialPayment=0;
                          return array(
                              'Ack'             =>'Ok',
                              'profileId'       =>$currProfile,
                              'InitialPayment'  =>$initialPayment,
                              'Package'         =>$reqPackage,
                              'Frequent'        =>$reqFrequent,
                              'Spent'           =>array(
                                                   'By' => $chargeSpent,
                                                   'Calculation'=>$chargeSpentCalc,
                                                        ),
                              'FareData'        =>array(
                                                    'ADJ_CHARGES'=>$initialPayment,
                                                    'NEW_PAY_CYCLE'=>$reqFare,
                                                ),


                              'NextPayDate'     =>$nextPaymentDate,
                              'CurrentExpire'   =>$currExpire,
                              'Action'          =>$action,
                              'NumberOfListings'=>$noOfListings,
                          );



                    }






                 // END - Check for Expire/Non Expire status -------------------
                    
                    
                    
                    




                // END User Already subscribed----------------------------------
              }// End if

           // END - First check - customer already subscribed or not -----------

       } // End function - calculateBuildingSupplierFare


       public function calculateBuildingServicesFare($customerId,$customerStatus,$package,$period='Month')
       {


          // Get fare details from the database
            //require_once($this->core->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
            //if(!is_object($objGlobalConfig)) $objGlobalConfig= new GlobalConfig;



           // Get customer status ----------------------------------------------

            for($cs=0;$cs<count($customerStatus);$cs++)
            {
                if($customerStatus[$cs][2]=='S')
                {
                    $currExpire=$customerStatus[$cs][5];
                    $currPackage=$customerStatus[$cs][3];
                    $currFrequent=$customerStatus[$cs][3];
                    $currProfile=$customerStatus[$cs][8];
                    $lastPayment=$customerStatus[$cs][9];
                    $subscriptionFound=true;
                    break;
                }
            }
           // ------------------------------------------------------------------


           // Get Requested package information --------------------------------
            $packageData=explode("||",$package);
            $reqPackage=$packageData[0];
            $reqFrequent=$reqPackage;//$packageData[1];

            $reqFare=$this->gConf["SUBSCRIPTION_".strtoupper($reqPackage.$period)."_PRICE"];

           // ------------------------------------------------------------------


           // Main check - customer already subscribed or not ------------------
             if(!$subscriptionFound)
              {
                // First subscription ------------------------------------------
                   $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                   return array(
                              'Ack'             =>'Ok',
                              'InitialPayment'  =>$reqFare,
                              'Package'         =>$reqPackage,
                              'Frequent'        =>$reqFrequent,
                              'Expiration'      =>$nextPaymentDate,
                              'CurrentExpire'   =>$currExpire,
                              'Action'          =>'FIRST-SUBCRIPTION',
                          );
                // End - First subscription -----------------------------------
              }
              else
              {
                // User Already subscribed to the buliding supplier package ----

                // Get Current (Existing) package information ------------------
                    $currFare=$this->gConf["SUBSCRIPTION_".strtoupper($currPackage.$period)."_PRICE"];
                // -------------------------------------------------------------

                // Check for recurring / Non recurring status ------------------
                    if($currProfile)
                    {
                        // Check the profile and get status
                        $rcProfile=$this->diyRecurringProfileGetFromGateway($currProfile);
                        if($rcProfile['ProfileStatus']=="ActiveProfile")
                        {
                            $activeProfile=true;
                        }
                        else
                        {
                            $activeProfile=false;
                        }

                    }
                    else
                    {
                        $activeProfile=false;
                    }


                 // Check for Expire/Non Expire status -------------------------

                    if(time()>$currExpire)
                    {
                      // Subscription Expired ----------------------------------
                         $timeExeeded= $this->getTimeDifference($currExpire);

                         // Fare calculation -----------------------------------
                         /*
                          * We get number of month exeeded (ceiling value) and
                          * calculate the fare for those months based on the
                          * current subscription fares
                          * then we should add new fare value for one time occurent
                          * and calculate the initial payment
                          * if customer selects the recurring payment, requested
                          * fare will be added to the recurring profile
                          *
                          * expiaration date will be calculated based on current date
                          * recurring payment start date will be exactly on expiaration date
                          */
                            $exeededBy=ceil($timeExeeded['Months']);
                            if($exeededBy>0 && $currFrequent!=0)
                            {
                                $chargeExpired=($currFare/$currFrequent)*$exeededBy;
                                $chargeExpiredCalc="($currFare/$currFrequent)*$exeededBy"; // To display purpose
                                $initialPayment=$chargeExpired + $reqFare;

                            }
                            $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);

                            return array(
                                      'Ack'             =>'Ok',
                                      'InitialPayment'  =>$initialPayment,
                                      'Package'         =>$reqPackage,
                                      'Frequent'        =>$reqFrequent,
                                      'Expired'         =>array(
                                                            'By' => $exeededBy,
                                                            'Calculation'=>$chargeExpiredCalc,
                                                        ),
                                      'FareData'        =>array(
                                                            'EXP_PERIOD'=>$chargeExpired,
                                                            'NEW_PAY_CYCLE'=>$reqFare,
                                                        ),
                                      'Expiration'      =>$nextPaymentDate,
                                      'CurrentExpire'   =>$currExpire,
                                      'Action'          =>'EXPIRED|NEW-PROFILE',
                                  );

                      // END Subscription Expired ----------------------------------

                    }
                    else
                    {
                      // Subscription NOT Expired ----------------------------------
                         if($reqFare>$currFare) $initialPayment=$reqFare-$currFare;
                         if(!$nextPaymentDate) $nextPaymentDate=$this->calcNextBillingDateTime('Month', $reqFrequent);
                         if($currPackage==$reqPackage && $currFrequent==$reqFrequent) $sameSubscription=true;

                         // Fare calculation - Main ----------------------------
                         /*
                          * There are several scenarios for this section
                          * We get number of month spent (ceiling value) and
                          * calculate the fare for those months based on the
                          * current subscription fares
                          * rest of the calculation will be explained in each section
                          */
                          $timeS= $this->getTimeDifference($currExpire);
                          $timeSpent=$currFrequent-intval(ceil($timeS['Months']));

                          if($timeSpent>0 && $currFrequent!=0)
                          {
                                $chargeSpent=($currFare/$currFrequent)*$timeSpent;
                                $chargeSpentCalc="($currFare/$currFrequent)*$timeSpent"; // To display purpose
                          }
                         // End fare calculation - Main ------------------------


                         if($activeProfile)
                         {
                             // Recurring Payment
                               if($sameSubscription)
                              {
                                  // We dont need to proceed. throug and exlamation
                                  // customer can simply control same package from my account section
                                    return array(
                                              'Ack'             =>'Error',
                                              'Error'           =>'PKG_SAME',
                                              'CurrentExpire'   =>$currExpire,

                                    );
                                    exit;
                              }
                              else
                              {
                                  // different package
                                  // we have to calculate the values
                                     $initialPayment=$reqFare-$chargeSpent;
                                     $action='NON-EXPIRED|RECURRING|UPDATE-PROFILE';
                                     $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                              }

                         }
                         else
                         {

                           // Non recurring Payment
                              $currProfile=''; // drop current profile Id

                              if($sameSubscription)
                              {
                                  // We have to get the payment and extend the time expiaration
                                    $initialPayment=$reqFare;
                                    $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent, $currExpire);
                                    $action='NON-EXPIRED|NON-RECURRING|EXTEND-TIME';
                              }
                              else
                              {
                                  // different package
                                  // we have to calculate the values
                                     $initialPayment=$reqFare-$chargeSpent;
                                     $nextPaymentDate=$this->calcNextBillingDateTime($period, $reqFrequent);
                                     $action='NON-EXPIRED|NON-RECURRING|NEW-PROFILE';
                              }

                         }

                          if($initialPayment<0) $initialPayment=0;
                          return array(
                              'Ack'             =>'Ok',
                              'profileId'       =>$currProfile,
                              'InitialPayment'  =>$initialPayment,
                              'Package'         =>$reqPackage,
                              'Frequent'        =>$reqFrequent,
                              'Spent'           =>array(
                                                   'By' => $chargeSpent,
                                                   'Calculation'=>$chargeSpentCalc,
                                                        ),
                              'FareData'        =>array(
                                                    'ADJ_CHARGES'=>$initialPayment,
                                                    'NEW_PAY_CYCLE'=>$reqFare,
                                                ),


                              'NextPayDate'     =>$nextPaymentDate,
                              'CurrentExpire'   =>$currExpire,
                              'Action'          =>$action,
                          );



                    }






                 // END - Check for Expire/Non Expire status -------------------








                // END User Already subscribed----------------------------------
              }// End if

           // END - First check - customer already subscribed or not -----------

       } // End function - calculateBuildingSupplierFare


       function getTimeDifference($time)
       {

            if($time>time())
            {
                $secondsDifference = $time - time();
            }
            else
            {
                $secondsDifference = time() - $time;
            }

            return array(
            
                'Months'=>$secondsDifference/60/60/24/31,
                /* IF NEED use the following commented guide and
                 * expand this further
                 */
                
                
                );
                
                


//            switch($format){
//                // Difference in Minutes
//                case 1:
//                    return floor($secondsDifference/60);
//                // Difference in Hours
//                case 2:
//                    return floor($secondsDifference/60/60);
//                // Difference in Days
//                case 3:
//                    return floor($secondsDifference/60/60/24);
//                // Difference in Weeks
//                case 4:
//                    return floor($secondsDifference/60/60/24/7);
//                // Difference in Months
//                case 5:
//                    return floor($secondsDifference/60/60/24/7/4);
//                // Difference in Years
//                default:
//                    return floor($secondsDifference/365/60/60/24);
//            }
       }
       

} // End - Class

?>