<?php
/**
 * Provide a common interface for Pay Pal API (Using SOAP)
 *
 *
 * PPWrapper.class.php  v1.0  - Written by Saliya Wijesinghe
 *
 *
 * SPECIAL NOTES ------------------>
 * 1) Shipping address not support  in this version
 * 2) Express checkout currently supports for one item at a time
 * 3) Discounts/ insuarense not supported
 * 4) Wrapper class supports only for iso-8859-1 in Currency format
 *
 *
 * Error Numbers --------------->
 *
 *      999000991   = Transaction id is blank
 *      999000002   = Recurring profile status is invalid
 *
 */



Class PPWrapper
{

    /**
     * Server path to the PayPal SDK source folder .
     *
     * @access protected
     *
     * @var string $SDKPath
     */
    private $SDKPath;


    /**
     * Username for PayPal API.
     *
     * @access protected
     *
     * @var string $APIUser
     */
    private $APIUser;


    /**
     * Password for PayPal API.
     *
     * @access protected
     *
     * @var string $APIPass
     */
    private $APIPass;


    /**
     * Signature for PayPal API.
     *
     * @access protected
     *
     * @var string $APISign
     */
    private $APISign;


    /**
     * Enviorenment of current integration. i.e: live/sandbox
     *
     * @access protected
     *
     * @var string $APIEnviornment
     */
    private $APIEnviornment;


    /**
     * Email address of the User (Seller's account email)
     *
     * @access protected
     *
     * @var string $APIUserEmail
     */
    private $APIUserEmail;


    /**
     * User Id of the User (Seller's Profile ID - can find under profile section)
     *
     * @access protected
     *
     * @var string $APIUserId
     */
    private $APIUserId;


    /**
     * Express Checkout Return URL
     * (Will be used if the buyer went through the complete process).
     *
     * @access protected
     *
     * @var string $APIExpressCheckoutReturnURL
     */
    private $APIExpressCheckoutReturnURL;


    /**
     * Express Checkout Cancel URL
     * (Will be used if the buyer cancelled the transaction).
     *
     * @access protected
     *
     * @var string $APIExpressCheckoutCancelURL
     */
    private $APIExpressCheckoutCancelURL;


    /**
     * Paypal API Profile object.
     *
     * @access protected
     *
     * @var object $PPAPIProfile
     */
    private $PPAPIProfile;




    /**
     * This will contains the Token for specific express checkout.
     *
     * @access protected
     *
     * @var string $token
     */
    private $token;


    /**
     * Unique Id that issued by Pay Pal for a paticular buyer.
     *
     * @access protected
     *
     * @var string $payerId
     */
    private $payerId;


    /**
     * Unique transaction Id for Pay Pal
     *
     * @access protected
     *
     * @var string $transId
     */
    private $transId;



    /**
     * This will be used to store a value for action, depending on the methond
     * In Direct Payment, Express checkout sections, action will be used to pass
     * the payment action such as Sales/ Authorization etc
     * In Update recurring profile section, action will be used to pass a specific
     * action such as UpdateCreditCard, UpdateDescription etc
     *
     * @access protected
     *
     * @var string $action
     */
    private $action;


    /**
     * IP Address of the server/ user acording to the context.
     *
     * @access protected
     *
     * @var string $ipAddress
     */
    private $ipAddress;


    /**
     * Will stores the Total Amount of the order
     *
     * @access protected
     *
     * @var mixed $orderAmount
     */
    private $orderAmount;


    /**
     * This will contains the Gross Amount of the order without adding or deducting
     * Tax / shipping etc.
     *
     * @access protected
     *
     * @var mixed $orderSubAmount
     */
    private $orderSubAmount;


    /**
     * Total of all the tax which involved with an Order.
     *
     * @access protected
     *
     * @var mixed $orderTax
     */
    private $orderTax;


    /**
     * Default currency will be stored within this. This record will be override
     * any time with the passed currency as a parameter array.
     *
     * @access protected
     *
     * @var string $defaultCurrency
     */
    private $defaultCurrency;


    /**
     * Currency for the specific order. If currency not specified, default 
     * currency will be the order currency.
     *
     * @access protected
     *
     * @var string $orderCurrency
     */
    private $orderCurrency;



    /**
     * First name of the Payer.
     *
     * @access protected
     *
     * @var string $payerFName
     */
    private $payerFName;


    /**
     * Last name of the Payer.
     *
     * @access protected
     *
     * @var string $payerLName
     */
    private $payerLName;


    /**
     * Home Number/ Identifier of the Payer's Address.
     *
     * @access protected
     *
     * @var string $payerAddress
     */
    private $payerAddress;


    /**
     * Street of the Payer's Address.
     *
     * @access protected
     *
     * @var string $payerStreet
     */
    private $payerStreet;


    /**
     * City of the Payer's Address.
     *
     * @access protected
     *
     * @var string $payerCity
     */
    private $payerCity;


    /**
     * State of the Payer's Address.
     *
     * @access protected
     *
     * @var string $payerState
     */
    private $payerState;


    /**
     * Zip of the Payer's Address.
     *
     * @access protected
     *
     * @var string $payerZip
     */
    private $payerZip;


    /**
     * Payer Country - 2 digits iso code
     *
     * @access protected
     *
     * @var string $payerCountry
     */
    private $payerCountry;


    /**
     * Payer Email. This should be similar to his paypal email in express
     * checkout payment secitons.
     *
     * @access protected
     * 
     * @var string $payerEmail
     */
    private $payerEmail;


    /**
     * Phone number of the Payer (with all the country codes).
     *
     * @access protected
     *
     * @var string $payerPhone
     */
    private $payerPhone;



    /**
     * Credit Card Type (Visa/Master).
     *
     * @access protected
     *
     * @var string $ccType
     */
    private $ccType;


    /**
     * Credit Card Number.
     *
     * @access protected
     *
     * @var string $ccNumber
     */
    private $ccNumber;


    /**
     * Credit Card - Expiary Month.
     *
     * @access protected
     *
     * @var string $ccExpDateMonth
     */
    private $ccExpDateMonth;


    /**
     * Credit Card - Expiary Year.
     *
     * @access protected
     *
     * @var string $ccExpDateYear
     */
    private $ccExpDateYear;


    /**
     * Credit Card - CVV2Number.
     *
     * @access protected
     *
     * @var string $ccCV2Number
     */
    private $ccCV2Number;



    /**
     * Recurring Profile Id which issued from PayPal.
     *
     * @access protected
     *
     * @var string $recurringProfileId
     */
    private $recurringProfileId;


    /**
     * Description of Recurring Profile.
     *
     * @access protected
     *
     * @var string $pfDescription;
     */
    private $pfDescription;


    /**
     * Note of Recurring Profile - useful when Manage the profile status.
     *
     * @access protected
     *
     * @var string $pfNote
     */
    private $pfNote;


    /**
     * Billing period of the Recurring Profile (From Date to start Date).
     *
     * @access protected
     *
     * @var string $pfBillPeriod
     */
    private $pfBillPeriod;


    /**
     * Billing Frequency of Recurring profile.
     *
     * @access protected
     *
     * @var string $pfBillFrequency
     */
    private $pfBillFrequency;


    /**
     * Number of cycles of a specific billing profile.
     *
     * @access protected
     *
     * @var mixed $pfCycles
     */
    private $pfCycles;


    /**
     * Recurring Profile start day.
     *
     * @access protected
     *
     * @var string $pfStartDateDay
     */
    private $pfStartDateDay;


    /**
     * Recurring Profile start Month.
     *
     * @access protected
     *
     * @var string $pfStartDateMonth
     */
    private $pfStartDateMonth;


    /**
     * Unique Invoice Number for the payment
     *
     * @access protected
     *
     * @var string $invoiceId
     */
       private $invoiceId;



    /**
     * Recurring Profile start Year.
     *
     * @access protected
     *
     * @var string $pfStartDateYear
     */
    private $pfStartDateYear;



    /**
     * Current Version of the Wrapper Class.
     *
     * @access protected
     *
     * @var string $wrapperVersion
     */
    private $wrapperVersion;




    /**
     * Construction of the Class
     * ------------------------------------------------------------
     * Standard construct method - will automatically execute with the keyword new
     * @access Static
     *
     */
    function __construct()
    {

         /*
          * DONT CHANGE FOLLOWING LINE IF NOT YOU DEVELOP A NEW VERSION
          * Create Paypal profile object and initiate the connection with the 
          */
            $this->wrapperVersion='WV1.0';
            

    } // End - Function __construct




    /**
     * Destruction of the Class
     * ------------------------------------------------------------
     * Standard destruct method
     * @access Static
     *
     */
     function __destruct()
     {
        unset($this->PPAPIProfile); // unset profile object
        unset($this->SDKPath,$this->APIUser,$this->APIUserEmail,$this->APIUserId,$this->APIPass,$this->APISign,$this->APIEnviornment,$this->APIExpressCheckoutReturnURL,$this->APIExpressCheckoutCancelURL,$this->defaultCurrency,$this->wrapperVersion);

     } // End - Function __destruct




    /**
     * Initialize 
     * ------------------------------------------------------------
     * Initializing the class from here. this method will create necessory
     * variables for the created object.
     * This will be automatically called through the API funcitons and
     * you can call in any new function as required
     */
     private function init()
     {
         // check for the essensial variable settings
         //
           if(!$this->SDKPath)                      die("SDK path is required");
           if(!$this->APIEnviornment)               die("API Enviornment is required");
           if(!$this->APIUser)                      die("API Username is required");
           if(!$this->APIPass)                      die("API Password is required");
           if(!$this->APISign)                      die("API Signature is required");

           if(!$this->APIUserId)                    die("Seller Profile Id is required");
           if(!$this->APIUserEmail)                 die("Seller Paypal Email is required");

           if(!$this->APIExpressCheckoutReturnURL)  die("Return URL is required");
           if(!$this->APIExpressCheckoutCancelURL)  die("Cancel URL is required");
           if(!$this->defaultCurrency)              die("Default Currency is required");


         
         // Set sdk Path
            set_include_path($this->SDKPath . DIRECTORY_SEPARATOR . 'lib' . PATH_SEPARATOR . get_include_path());

         // Including necessory core source files
            require_once 'PayPal.php';
            require_once 'PayPal/Profile/Handler/Array.php';
            require_once 'PayPal/Profile/API.php';

         // Create the Profile Handler/ Object
            $handler = & ProfileHandler_Array::getInstance(array(
                        'username' => $this->APIUser,
                        'certificateFile' => null,
                        'subject' => null,
                        'environment' => $this->APIEnviornment ));

            $id=ProfileHandler::generateID();
            $this->PPAPIProfile=new APIProfile($id,$handler);
            $this->PPAPIProfile->setAPIUsername($this->APIUser);
            $this->PPAPIProfile->setAPIPassword($this->APIPass);
            $this->PPAPIProfile->setSignature($this->APISign);
            $this->PPAPIProfile->setEnvironment($this->APIEnviornment);
     }





    /**
     * Call API
     * ------------------------------------------------------------
     * Comman Interface for call all the functions of Paypal API
     * @param string $function  Exact function to be executed
     * @param array $values  should contain all necessory values as per the documentation
     * @return array contains necessory data for success or failier trasacions.
     *
     * if you need to add more API calles,
     * 1) add necessory methods in private scope
     * 2) add new case within the callAPI method for relevent API call
     *      
     */ 
     public function callAPI($function,$values)
     {
      // Initializing
         $this->init();
      // Devide and call specific section
         switch ($function)
         {
             case ('GetTransactionDetails'):
                 {
                    return $this->getTransaction($values);
                 }
                 break;
             case ('DoDirectPayment'):
                 {
                     return $this->doDirectPayment($values);
                 }
                 break;
             case ('SetExpressCheckout'):
                 {
                     return $this->setExpressCheckout($values);
                 }
                 break;
             case ('GetExpressCheckoutDetails'):
                 {
                     return $this->getExpressCheckoutDetails($values);
                 }
                 break;
             case ('DoExpressCheckout'):
                 {
                     return $this->doExpressCheckout($values);
                 }
                 break;
             case ('GetRecurringProfileDetails'):
                 { 
                     return $this->getRecurringProfile($values);
                 }
                 break;
             case ('CreateRecurringProfile'):
                 {
                     return $this->setRecurringProfile($values);
                 }
                 break;
             case ('UpdateRecurringProfile'):
                 {
                     return $this->updateRecurringProfile($values);
                 }
                 break;
             case ('ManageRecurringProfile'):
                 {
                     return $this->manageRecurringProfile($values);
                 }
                 break;
             case ('BillOutstandingAmount'):
                 {
                     return $this->billOutstandingAmount($values);
                 }
                 break;


             default:
                 {
                     // return error
                        return array(
                                'Ack'           =>'Failure',
                                'ErrorCode'     =>999000006,
                                'LongMessage'   =>'Invalid request found. Please check the documentation for more details.',
                                'Section'       =>'Call API',
                                'Log'           =>array('function'=>$function),
                                'Version'       =>$this->wrapperVersion
                                );
                 }
                 break;

         }
     }



    /**
     * Get Transacion Details
     * ------------------------------------------------------------
     * Get Transacion Details for a given Transaction ID
     * @param array $value  Contain the value of Transaction ID     
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function getTransaction($values)
     {
        $this->transId=$values['TransactionID'];
        if($this->transId)
        {   // Exucute this if only if transaction Id is provided
            require_once 'PayPal/Type/GetTransactionDetailsRequestType.php';
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile); 
            $gtdRequestType = & PayPal::getType('GetTransactionDetailsRequestType');
            $gtdRequestType->setTransactionID($this->transId);
            $response = $objCaller->GetTransactionDetails($gtdRequestType);

            $arrData=$this->pharseResponse($response);

            return $arrData;
        }
        else
        {
            return array(
                    'Ack'           =>'Failure',
                    'ErrorCode'     =>999000001,
                    'LongMessage'   =>'Transaction id is blank',
                    'Section'       =>'Get Transaction',
                    'Log'           =>$values,
                    'Version'       =>$this->wrapperVersion
                    );
         }// End - If
        
     } // End Function - getTransaction



    /**
     * Do Direct Payment
     * ------------------------------------------------------------
     * Direct payment integration with PayPal API
     * Both Sales and Authorization payment types are supported
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function doDirectPayment($values)
     {
//print_r($values);
        require_once 'PayPal/Type/DoDirectPaymentRequestType.php';
        require_once 'PayPal/Type/DoDirectPaymentRequestDetailsType.php';
        require_once 'PayPal/Type/DoDirectPaymentResponseType.php';
        // Add all of the types
        require_once 'PayPal/Type/BasicAmountType.php';
        require_once 'PayPal/Type/PaymentDetailsType.php';
        require_once 'PayPal/Type/AddressType.php';
        require_once 'PayPal/Type/CreditCardDetailsType.php';
        require_once 'PayPal/Type/PayerInfoType.php';
        require_once 'PayPal/Type/PersonNameType.php';

        $this->action          =$values['Action'];
        $this->ipAddress        =$values['IPAddress'];
        $this->sessID           =$values['SessionID'];

        $this->orderAmount      =$values['Order']['Total'];
        $this->orderSubAmount   =$values['Order']['SubTotal'];
        $this->orderTax         =$values['Order']['Tax'];
        $this->orderCurrency    =$values['Order']['Currency'];

        $this->payerFName       =$values['Payer']['FirstName'];
        $this->payerLName       =$values['Payer']['LastName'];
        $this->payerAddress     =$values['Payer']['Address'];
        $this->payerStreet      =$values['Payer']['Street'];
        $this->payerCity        =$values['Payer']['CityName'];
        $this->payerState       =$values['Payer']['StateOrProvince'];
        $this->payerZip         =$values['Payer']['PostalCode'];
        $this->payerCountry     =$values['Payer']['CountryCode'];
        $this->payerPhone       =$values['Payer']['Phone'];
        $this->payerEmail       =$values['Payer']['Email'];

        $this->ccType           =$values['CCard']['Type'];
        $this->ccNumber         =$values['CCard']['Number'];
        $this->ccExpDateMonth   =$values['CCard']['ExpMonth'];
        $this->ccExpDateYear    =$values['CCard']['ExpYear'];
        $this->ccCV2Number      =$values['CCard']['CVV2'];

        // Month and Year should be 2 digits (0 should be added to single digit values)
           $this->ccExpDateMonth   = str_pad($this->ccExpDateMonth, 2, '0', STR_PAD_LEFT);
           $this->ccExpDateYear    = str_pad($this->ccExpDateYear, 2, '0', STR_PAD_LEFT);

        // Ip address can be override if necessory - We use server IP if there isnt IP address within the parameters
           if(!$this->ipAddress) $this->ipAddress=$_SERVER['SERVER_ADDR'] ;
           
        // Default currency can be overide if necessory
           if(!$this->orderCurrency) $this->orderCurrency=$this->defaultCurrency;

        // Populate SOAP request information


         // Direct Payment Request Type - prepare the request for API
            $dpRequestType =& PayPal::getType('DoDirectPaymentRequestType');

         // Direct Payment Details Type
            $dpDetailsType =& PayPal::getType('DoDirectPaymentRequestDetailsType');

         // Payment details - preparing
            $PaymentDetailsType =& PayPal::getType('PaymentDetailsType');

            // Sub Amount **[= Order Total - Tax ]
               $itemAmountType =& PayPal::getType('BasicAmountType');
                    if (PayPal::isError($itemAmountType)) {
                        var_dump($itemAmountType);
                        exit;
                    }
               $itemAmountType->setattr('currencyID', $this->orderCurrency);
               $itemAmountType->setval($this->orderSubAmount, 'iso-8859-1');
               
               $PaymentDetailsType->setItemTotal($itemAmountType);// Set Item total within payment details object

            // Tax Amount **[= Order Total - Sub Total ]
               $taxAmountType =& PayPal::getType('BasicAmountType');
                    if (PayPal::isError($taxAmountType)) {
                        var_dump($taxAmountType);
                        exit;
                    }
               $taxAmountType->setattr('currencyID', $this->orderCurrency);
               $taxAmountType->setval($this->orderTax, 'iso-8859-1');

               $PaymentDetailsType->setTaxTotal($taxAmountType); // Set tax total within payment details object


             // Total order Amount ** [= Sub Total + Tax ]
                $OrderTotalType =& PayPal::getType('BasicAmountType');
                   if (PayPal::isError($OrderTotalType)) {
                        var_dump($OrderTotalType);
                        exit;
                   }
                $OrderTotalType->setattr('currencyID', $this->orderCurrency);
                $OrderTotalType->setval($this->orderAmount, 'iso-8859-1');

                $PaymentDetailsType->setOrderTotal($OrderTotalType);// Set Order total within payment details object
            
            
             // Payer type - Prepare Payer details
                $payerInfoType =& PayPal::getType('PayerInfoType');
                $payerInfoType->setPayer($this->payerEmail);

                // Person Name Type - set payer name
                   $personNameType =& PayPal::getType('PersonNameType');
                   $personNameType->setFirstName($this->payerFName);
                   $personNameType->setLastName($this->payerLName);

                $payerInfoType->setPayerName($personNameType);
                
                // Address Type - set payer address
                   $addressType = & PayPal::getType('AddressType');
                   $addressType->setName($personNameType);
                   $addressType->setStreet1($this->payerAddress);
                   $addressType->setStreet2($this->payerStreet);
                   $addressType->setCityName($this->payerCity);
                   $addressType->setPostalCode($this->payerZip);
                   $addressType->setStateOrProvince($this->payerState);
                   $addressType->setPhone($this->payerPhone);
                   $addressType->setCountry($this->payerCountry);

                $payerInfoType->setAddress($addressType);
                $payerInfoType->setPayerCountry($this->payerCountry);
                

             // Credit Card details type - prepare credit card information
                $cardDetailsType = & PayPal::getType('CreditCardDetailsType');
                $cardDetailsType->setCreditCardType($this->ccType);
                $cardDetailsType->setCreditCardNumber($this->ccNumber);
                $cardDetailsType->setExpMonth($this->ccExpDateMonth);
                $cardDetailsType->setExpYear($this->ccExpDateYear);
                $cardDetailsType->setCVV2($this->ccCV2Number);
                $cardDetailsType->setCardOwner($payerInfoType);


            $dpDetailsType->setPaymentDetails($PaymentDetailsType);
            $dpDetailsType->setCreditCard($cardDetailsType);
            $dpDetailsType->setIPAddress($this->ipAddress);
            $dpDetailsType->setPaymentAction($this->action);

            $dpRequestType->setDoDirectPaymentRequestDetails($dpDetailsType);

           
         // Execute SOAP request
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);//print_r($this->PPAPIProfile);
            $response = $objCaller->DoDirectPayment($dpRequestType);

         // Pharse and return the response
            $arrData=$this->pharseResponse($response);
            return $arrData;
        
     } // End Function - doDirectPayment



    /**
     * Set Express Checkout
     * ------------------------------------------------------------
     * Direct payment integration with PayPal API
     * This method will
     *      1) Create the initial Express checkout transaction,
     *      2) Will retrieve the token for the payment from the pay pal
     *      3) Will redirect user to the appropiate Enviorenment
     * Sales / Authorization / Order payment types are supported
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function setExpressCheckout($values)
     {

        require_once 'PayPal/Type/BasicAmountType.php';
        require_once 'PayPal/Type/SetExpressCheckoutRequestType.php';
        require_once 'PayPal/Type/SetExpressCheckoutRequestDetailsType.php';
        require_once 'PayPal/Type/SetExpressCheckoutResponseType.php';

        $this->action           =$values['Action'];
        $this->invoiceId        =$values['invoiceID'];
        
        $this->payerFName       =$values['Payer']['FirstName'];
        $this->payerLName       =$values['Payer']['LastName'];
        $this->payerEmail       =$values['Payer']['Email'];
        
        $this->orderItems       =$values['Items'];
        $this->orderAmount      =$values['Order']['Total'];
        $this->orderSubAmount   =$values['Order']['SubTotal'];
        $this->orderTax         =$values['Order']['Tax'];
        $this->orderCurrency    =$values['Order']['Currency'];        


        // Default currency can be overide if necessory
           if(!$this->orderCurrency) $this->orderCurrency=$this->defaultCurrency;


        // Set the Paypal URL
           switch ($this->APIEnviornment)
           {
                case 'live':
                    {
                        $ppURL='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
                    }break;
                default:
                    {
                        $ppURL='https://www.' . $this->APIEnviornment . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
                    }
           }
        
         // Set the Return URLs
            $returnURLParams='?paymentAmount='.$this->orderAmount.'&currencyCodeType='.$this->orderCurrency .'&paymentType='.$this->action ;
            $this->APIExpressCheckoutReturnURL.= $returnURLParams;
            $this->APIExpressCheckoutCancelURL.= $returnURLParams;

         // Populate SOAP request information

             // Express Checkout request type
                $ecRequestType =& PayPal::getType('SetExpressCheckoutRequestType');

             // Express Checkout Details type
                $ecDetailsType =& PayPal::getType('SetExpressCheckoutRequestDetailsType');
                $ecDetailsType->setReturnURL($this->APIExpressCheckoutReturnURL);
                $ecDetailsType->setCancelURL($this->APIExpressCheckoutCancelURL);
                $ecDetailsType->setCallbackTimeout('4');
                $ecDetailsType->setBuyerEmail($this->payerEmail);
                $ecDetailsType->setPaymentAction($this->action);
                $ecDetailsType->setInvoiceID($this->invoiceId);


             // Addition of Product Details.
                $paymentDetailsType = &PayPal::getType('PaymentDetailsType');

                /**  NOTE !!!!!!
                 * If you need to display multiple items in the paypal screen,
                 * loop following code
                 * and prepare and push relavent array to the setPaymentDetialsItem method
                 */
                 // START ---------->
                    $paymentDetailsItem[0] = &PayPal::getType('PaymentDetailsItemType');
                    $paymentDetailsItem[0]->setName($this->orderItems[0]['Item']);
                    $paymentDetailsItem[0]->setQuantity($this->orderItems[0]['Qty'], 'iso-8859-1');
                    $paymentDetailsItem[0]->setAmount($this->orderItems[0]['Amount'], 'iso-8859-1');

                    $paymentDetailsType->setPaymentDetailsItem(array('PaymentDetailsItem00' => $paymentDetailsItem[0]));
                 // END ---------->


             // Setting up OrderTotal on PaymentDetails.
                $itemTotalType =& PayPal::getType('BasicAmountType');
                $itemTotalType->setattr('currencyID', $this->orderCurrency);
                $itemTotalType->setval($this->orderSubAmount, 'iso-8859-1');
                $paymentDetailsType->setItemTotal($itemTotalType);

             // Setting up Tax details
                $taxTotalType =& PayPal::getType('BasicAmountType');
                $taxTotalType->setattr('currencyID', $this->orderCurrency);
                $taxTotalType->setval($this->orderTax, 'iso-8859-1');
                $paymentDetailsType->setTaxTotal($taxTotalType);

             // Setting up OrderTotal.
                $orderTotal =& PayPal::getType('BasicAmountType');
                $orderTotal->setattr('currencyID', $this->orderCurrency);
                $orderTotal->setval($this->orderAmount, 'iso-8859-1');

                $ecDetailsType->setOrderTotal($orderTotal);

             // Finalize the Request preparing
                $ecDetailsType->setPaymentDetails($paymentDetailsType);
                $ecRequestType->setSetExpressCheckoutRequestDetails($ecDetailsType);


         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);
            $objCaller->USE_ARRAYKEY_AS_TAGNAME = true;
            $objCaller->SUPRESS_OUTTAG_FOR_ARRAY = true;
            $objCaller->OUTTAG_SUPRESS_ELEMENTS = array('PaymentDetailsItem','FlatRateShippingOptions');

         // Execute SOAP request
            $response = $objCaller->SetExpressCheckout($ecRequestType);

         // Pharse and return the response
            $arrData=$this->pharseResponse($response); 

         // Get the acknowladgement
            $ack = $response->getAck();

            switch ($ack)
            {
                case 'Success':
                case 'SuccessWithWarning':
                    {
                         // Redirect to paypal.com here
                            $token = $response->getToken();
                            $payPalURL = $ppURL.$token;

                            //$logger->_log('Redirect to PayPal for payment: '. $payPalURL);
                            //header("Location: ".$payPalURL);
                            echo "OK|spl|".$payPalURL;
                 exit;

                    }break;
                default:
                    return $arrData;
            }


     } // End Function - doExpressCheckout



    /**
     * Get Express Checkout
     * ------------------------------------------------------------
     * Direct payment integration with PayPal API
     * This method will get necessory information from Paypal using the transaction Token
     * Sales / Authorization / Order payment types are supported
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function getExpressCheckoutDetails($values)
     {

        require_once 'PayPal/Type/GetExpressCheckoutDetailsRequestType.php';
        require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseDetailsType.php';
        require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseType.php';

        $this->token=$values['Token'];

         // Express Checkout request type
            $ecRequestType =& PayPal::getType('GetExpressCheckoutDetailsRequestType');
            $ecRequestType->setToken($this->token);

         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

         // Execute SOAP request
            $response = $objCaller->GetExpressCheckoutDetails($ecRequestType);

         // Pharse and return the response
            return $this->pharseResponse($response);

     }// End Function - getExpressCheckoutDetails



    /**
     * Do Express Checkout
     * ------------------------------------------------------------
     * Direct payment integration with PayPal API
     * This method will finalize the process of making express checkout
     * Sales / Authorization / Order payment types are supported
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function doExpressCheckout($values)
     {
        require_once 'PayPal/Type/BasicAmountType.php';
        require_once 'PayPal/Type/PaymentDetailsType.php';

        require_once 'PayPal/Type/DoExpressCheckoutPaymentRequestType.php';
        require_once 'PayPal/Type/DoExpressCheckoutPaymentRequestDetailsType.php';
        require_once 'PayPal/Type/DoExpressCheckoutPaymentResponseType.php';

        $this->action          =$values['Action'];
        $this->orderAmount      =$values['OrderTotal'];
        $this->token            =$values['Token'];
        $this->orderCurrency    =$values['Currency'];
        $this->payerId          =$values['Payer']['ID'];

        // Default currency can be overide if necessory
           if(!$this->orderCurrency) $this->orderCurrency=$this->defaultCurrency;

          // Populate SOAP request information

             // Express Checkout Details type
                $ecDetailsType =& PayPal::getType('DoExpressCheckoutPaymentRequestDetailsType');
                $ecDetailsType->setToken($this->token);
                $ecDetailsType->setPayerID($this->payerId);
                $ecDetailsType->setPaymentAction($this->action);

             // Setting up OrderTotal.
                $orderTotal =& PayPal::getType('BasicAmountType');
                $orderTotal->setattr('currencyID', $this->orderCurrency);
                $orderTotal->setval($this->orderAmount, 'iso-8859-1');

             // Payment Details type <-- Add order amount
                $paymentDetailsType = &PayPal::getType('PaymentDetailsType');
                $paymentDetailsType->setOrderTotal($orderTotal);

             // Now we should add the payment details to the express checout details type
                $ecDetailsType->setPaymentDetails($paymentDetailsType);

             // Express Checkout request type
                $ecRequestType =& PayPal::getType('DoExpressCheckoutPaymentRequestType');
                $ecRequestType->setDoExpressCheckoutPaymentRequestDetails($ecDetailsType);

             // Creating CallerServices object
                $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

             // Execute SOAP request
                $response = $objCaller->DoExpressCheckoutPayment($ecRequestType);

             // Pharse and return the response
                return $this->pharseResponse($response);
                
     } // End Function - doExpressCheckout



    /**
     * Create Recurring Payment Profile
     * ------------------------------------------------------------
     * This method will create recurring payment profile for given order
     * Sales / Authorization / Order payment types are supported
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function setRecurringProfile($values)
     {

        require_once 'PayPal/Type/CreateRecurringPaymentsProfileRequestType.php';
        require_once 'PayPal/Type/CreateRecurringPaymentsProfileRequestDetailsType.php';
        require_once 'PayPal/Type/CreateRecurringPaymentsProfileResponseType.php';
        require_once 'PayPal/Type/RecurringPaymentsProfileDetailsType.php';
        require_once 'PayPal/Type/ScheduleDetailsType.php';
        require_once 'PayPal/Type/BillingPeriodDetailsType.php';

        // Add all of the types
        require_once 'PayPal/Type/BasicAmountType.php';
        require_once 'PayPal/Type/PaymentDetailsType.php';
        require_once 'PayPal/Type/AddressType.php';
        require_once 'PayPal/Type/CreditCardDetailsType.php';
        require_once 'PayPal/Type/PayerInfoType.php';
        require_once 'PayPal/Type/PersonNameType.php';


       // $this->action          =$values['Action'];
       // $this->ipAddress        =$values['IPAddress'];
       // $this->sessID           =$values['SessionID'];

        $this->orderAmount      =$values['Order']['Total'];
        $this->orderSubAmount   =$values['Order']['SubTotal'];
        $this->orderTax         =$values['Order']['Tax'];
        $this->orderCurrency    =$values['Order']['Currency'];

        $this->payerFName       =$values['Payer']['FirstName'];
        $this->payerLName       =$values['Payer']['LastName'];
        $this->payerAddress     =$values['Payer']['Address'];
        $this->payerStreet      =$values['Payer']['Street2'];
        $this->payerCity        =$values['Payer']['CityName'];
        $this->payerState       =$values['Payer']['StateOrProvince'];
        $this->payerZip         =$values['Payer']['PostalCode'];
        $this->payerCountry     =$values['Payer']['CountryCode'];
        $this->payerPhone       =$values['Payer']['Phone'];
        $this->payerEmail       =$values['Payer']['Email'];

        $this->ccType           =$values['CCard']['Type'];
        $this->ccNumber         =$values['CCard']['Number'];
        $this->ccExpDateMonth   =$values['CCard']['ExpMonth'];
        $this->ccExpDateYear    =$values['CCard']['ExpYear'];
        $this->ccCV2Number      =$values['CCard']['CVV2'];

        $this->pfDescription    =$values['Schedule']['Description'];
        $this->pfBillPeriod     =$values['Schedule']['BillingPeriod'];
        $this->pfBillFrequency  =$values['Schedule']['BillingFrequency'];
        $this->pfCycles         =$values['Schedule']['TotalCycles'];
        $this->pfStartDateDay   =$values['Schedule']['StartDateDay'];
        $this->pfStartDateMonth =$values['Schedule']['StartDateMonth'];
        $this->pfStartDateYear  =$values['Schedule']['StartDateYear'];


        // Month and Year should be 2 digits (0 should be added to single digit values)
           $this->ccExpDateMonth   = str_pad($this->ccExpDateMonth, 2, '0', STR_PAD_LEFT);
           $this->ccExpDateYear    = str_pad($this->ccExpDateYear, 2, '0', STR_PAD_LEFT);

        // Default currency can be overide if necessory
           if(!$this->orderCurrency) $this->orderCurrency=$this->defaultCurrency;
                  
        // Schedule Date also needs to be well formatted
           $this->pfStartDateDay   = str_pad($this->pfStartDateDay, 2, '0', STR_PAD_LEFT);
           $this->pfStartDateMonth = str_pad($this->pfStartDateMonth, 2, '0', STR_PAD_LEFT);
           $this->pfStartDateYear  = str_pad($this->pfStartDateYear, 2, '0', STR_PAD_LEFT);

           $pfStartDate            = $this->pfStartDateYear . '-' . $this->pfStartDateMonth . '-' . $this->pfStartDateDay . 'T00:00:00Z';
        
        // Populate SOAP request information

         // Create Recurring Profile Request object
            $crppRequestType =& PayPal::getType('CreateRecurringPaymentsProfileRequestType');

         // Create Recurring Payment Request Details type - set created payment details type
            $crpProfileDetailsType =& PayPal::getType('CreateRecurringPaymentsProfileRequestDetailsType');

             // Payer type - Prepare Payer details
                $payerInfoType =& PayPal::getType('PayerInfoType');
                $payerInfoType->setPayer($this->payerEmail);

                // Person Name Type - set payer name
                   $personNameType =& PayPal::getType('PersonNameType');
                   $personNameType->setFirstName($this->payerFName);
                   $personNameType->setLastName($this->payerLName);

                $payerInfoType->setPayerName($personNameType);

                // Address Type - set payer address
                   $addressType = & PayPal::getType('AddressType');
                   $addressType->setName($personNameType);
                   $addressType->setStreet1($this->payerAddress);
                   $addressType->setStreet2($this->payerStreet);
                   $addressType->setCityName($this->payerCity);
                   $addressType->setPostalCode($this->payerZip);
                   $addressType->setStateOrProvince($this->payerState);
                   $addressType->setPhone($this->payerPhone);
                   $addressType->setCountry($this->payerCountry);

                $payerInfoType->setAddress($addressType);
                $payerInfoType->setPayerCountry($this->payerCountry);


             // Recurring Payment Details type - set billing date
                $rpProfileDetailsType =& PayPal::getType('RecurringPaymentsProfileDetailsType');
                $rpProfileDetailsType->setBillingStartDate($pfStartDate);
                $rpProfileDetailsType->setSubscriberName(trim($this->payerFName." ".$this->payerLName));

         // Set Profile details within Profile Request details object
            $crpProfileDetailsType->setRecurringPaymentsProfileDetails($rpProfileDetailsType);


             // Credit Card details type - prepare credit card information
                $cardDetailsType = & PayPal::getType('CreditCardDetailsType');
                $cardDetailsType->setCreditCardType($this->ccType);
                $cardDetailsType->setCreditCardNumber($this->ccNumber);
                $cardDetailsType->setExpMonth($this->ccExpDateMonth);
                $cardDetailsType->setExpYear($this->ccExpDateYear);
                $cardDetailsType->setCVV2($this->ccCV2Number);
                $cardDetailsType->setCardOwner($payerInfoType);


        // Set Credit card in Recurring Payment Profile Request Details
           $crpProfileDetailsType->setCreditCard($cardDetailsType);


             // Billing Details Type - prepare in order to use in Recurring Payment Profile
                $billingPeriodDetailsType =& PayPal::getType('BillingPeriodDetailsType');
                $billingPeriodDetailsType->setBillingPeriod($this->pfBillPeriod);
                $billingPeriodDetailsType->setBillingFrequency($this->pfBillFrequency);
                $billingPeriodDetailsType->setTotalBillingCycles($this->pfCycles);


                // Sub Amount **[= Order Total - Tax ]
                   $itemAmountType =& PayPal::getType('BasicAmountType');
                        if (PayPal::isError($itemAmountType)) {
                            var_dump($itemAmountType);
                            exit;
                        }
                   $itemAmountType->setattr('currencyID', $this->orderCurrency);
                   $itemAmountType->setval($this->orderSubAmount, 'iso-8859-1');

             // Set sub amount in Billing period details object
                $billingPeriodDetailsType->setAmount($itemAmountType);


                // Tax Amount
                   $taxAmountType =& PayPal::getType('BasicAmountType');
                        if (PayPal::isError($taxAmountType)) {
                            var_dump($taxAmountType);
                            exit;
                        }
                   $taxAmountType->setattr('currencyID', $this->orderCurrency);
                   $taxAmountType->setval($this->orderTax, 'iso-8859-1');


             // Set tax amount in Billing period details object
                $billingPeriodDetailsType->setTaxAmount($taxAmountType);

             // Billing Schedule Type - prepare in order to use in Recurring Payment Profile
                $scheduleDetailsType =& PayPal::getType('ScheduleDetailsType');
                $scheduleDetailsType->setDescription($this->pfDescription);
                $scheduleDetailsType->setPaymentPeriod($billingPeriodDetailsType);

         // set Schedule Details in Recurring Payment Profile Request Details
            $crpProfileDetailsType->setScheduleDetails($scheduleDetailsType);

         // Prepare the Request obect befor call the API
            $crppRequestType->setCreateRecurringPaymentsProfileRequestDetails($crpProfileDetailsType);

         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

         // Execute SOAP request
            $response = $objCaller->CreateRecurringPaymentsProfile($crppRequestType);

         // Pharse and return the response
            return $this->pharseResponse($response);
     } // End Function - setRecurringProfile



    /**
     * Get Recurring Payment Profile
     * ------------------------------------------------------------
     * This method will returns the recurring payment profile for given profile Id
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function getRecurringProfile($values)
     {

        require_once 'PayPal/Type/GetRecurringPaymentsProfileDetailsRequestType.php';
        require_once 'PayPal/Type/GetRecurringPaymentsProfileDetailsResponseType.php';
        require_once 'PayPal/Type/UpdateRecurringPaymentsProfileResponseType.php';
        require_once 'PayPal/Type/UpdateRecurringPaymentsProfileResponseDetailsType.php';

        $this->recurringProfileId   =$values['ProfileID'];
        
        // Populate SOAP request information

         // Prepare Get Recurring Profile Details type & assign recurring profile
            $grpRequestType =& PayPal::getType('GetRecurringPaymentsProfileDetailsRequestType');
            $grpRequestType->setProfileID($this->recurringProfileId);

         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

         // Execute SOAP request
            $response = $objCaller->GetRecurringPaymentsProfileDetails($grpRequestType);

         // Pharse and return the response
            return $this->pharseResponse($response);
        
     } // End Function - getRecurringProfile




    /**
     * Get Recurring Payment Profile
     * ------------------------------------------------------------
     * This method will returns the recurring payment profile for given profile Id
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function updateRecurringProfile($values)
     {
        require_once 'PayPal/Type/UpdateRecurringPaymentsProfileRequestType.php';
        require_once 'PayPal/Type/UpdateRecurringPaymentsProfileRequestDetailsType.php';
        require_once 'PayPal/Type/CreateRecurringPaymentsProfileRequestType.php';

        // Add all of the types
        require_once 'PayPal/Type/BasicAmountType.php';
        require_once 'PayPal/Type/PaymentDetailsType.php';
        require_once 'PayPal/Type/AddressType.php';
        require_once 'PayPal/Type/CreditCardDetailsType.php';
        require_once 'PayPal/Type/PayerInfoType.php';
        require_once 'PayPal/Type/PersonNameType.php';


        $this->action               =$values['Action'];
        $this->orderTax             =$values['Tax'];
        $this->recurringProfileId   =$values['ProfileID'];

        $this->orderAmount          =$values['Order']['Total'];
        $this->orderSubAmount       =$values['Order']['SubTotal'];
        $this->orderTax             =$values['Order']['Tax'];
        $this->orderCurrency        =$values['Order']['Currency'];

        $this->payerFName           =$values['Payer']['FirstName'];
        $this->payerLName           =$values['Payer']['LastName'];
        $this->payerAddress         =$values['Payer']['Address'];
        $this->payerStreet          =$values['Payer']['Street2'];
        $this->payerCity            =$values['Payer']['CityName'];
        $this->payerState           =$values['Payer']['StateOrProvince'];
        $this->payerZip             =$values['Payer']['PostalCode'];
        $this->payerCountry         =$values['Payer']['CountryCode'];
        $this->payerPhone           =$values['Payer']['Phone'];
        $this->payerEmail           =$values['Payer']['Email'];

        $this->ccType               =$values['CCard']['Type'];
        $this->ccNumber             =$values['CCard']['Number'];
        $this->ccExpDateMonth       =$values['CCard']['ExpMonth'];
        $this->ccExpDateYear        =$values['CCard']['ExpYear'];
        $this->ccCV2Number          =$values['CCard']['CVV2'];

        $this->pfDescription        =$values['Schedule']['Description'];
        $this->pfBillPeriod         =$values['Schedule']['BillingPeriod'];
        $this->pfBillFrequency      =$values['Schedule']['BillingFrequency'];
        $this->pfCycles             =$values['Schedule']['TotalCycles'];
        $this->pfStartDateDay       =$values['Schedule']['StartDateDay'];
        $this->pfStartDateMonth     =$values['Schedule']['StartDateMonth'];
        $this->pfStartDateYear      =$values['Schedule']['StartDateYear'];


        // Month and Year should be 2 digits (0 should be added to single digit values)
           $this->ccExpDateMonth   = str_pad($this->ccExpDateMonth, 2, '0', STR_PAD_LEFT);
           $this->ccExpDateYear    = str_pad($this->ccExpDateYear, 2, '0', STR_PAD_LEFT);

        // Default currency can be overide if necessory
           if(!$this->orderCurrency) $this->orderCurrency=$this->defaultCurrency;

        // Populate SOAP request information

         // Prepare Update Recurring Profile Request type
            $urppRequestType= & PayPal::getType('UpdateRecurringPaymentsProfileRequestType');

         // Prepare Update Recurring Profile Request Deatails Type
            $urrpDetailsType= & PayPal::getType('UpdateRecurringPaymentsProfileRequestDetailsType');
            $urrpDetailsType->setProfileID($this->recurringProfileId);
            
            // Prepare necessory data for update the profile, depending on the request
               switch($this->action)
               {
                   case 'ChangeCreditCard':
                       {
                         // Payer type - Prepare Payer details
                            $payerInfoType =& PayPal::getType('PayerInfoType');
                            $payerInfoType->setPayer($this->payerEmail);

                            // Person Name Type - set payer name
                               $personNameType =& PayPal::getType('PersonNameType');
                               $personNameType->setFirstName($this->payerFName);
                               $personNameType->setLastName($this->payerLName);

                            $payerInfoType->setPayerName($personNameType);

                            // Address Type - set payer address
                               $addressType = & PayPal::getType('AddressType');
                               $addressType->setName($personNameType);
                               $addressType->setStreet1($this->payerAddress);
                               $addressType->setStreet2($this->payerStreet);
                               $addressType->setCityName($this->payerCity);
                               $addressType->setPostalCode($this->payerZip);
                               $addressType->setStateOrProvince($this->payerState);
                               $addressType->setPhone($this->payerPhone);
                               $addressType->setCountry($this->payerCountry);

                            $payerInfoType->setAddress($addressType);
                            $payerInfoType->setPayerCountry($this->payerCountry);

                         // Credit Card details type - prepare credit card information
                            $cardDetailsType = & PayPal::getType('CreditCardDetailsType');
                            $cardDetailsType->setCreditCardType($this->ccType);
                            $cardDetailsType->setCreditCardNumber($this->ccNumber);
                            $cardDetailsType->setExpMonth($this->ccExpDateMonth);
                            $cardDetailsType->setExpYear($this->ccExpDateYear);
                            $cardDetailsType->setCVV2($this->ccCV2Number);
                            $cardDetailsType->setCardOwner($payerInfoType);

                        // Set Credit card in Update Recurring Payment Profile Request Details
                           $urrpDetailsType->setCreditCard($cardDetailsType);
                           
                       } // End Case - ChangeCreditCard
                       break;

                   case 'ChangeTax':
                   case 'ChangeAmount':
                       {
                             // Tax Amount
                                $taxAmountType =& PayPal::getType('BasicAmountType');
                                if (PayPal::isError($taxAmountType)) {
                                    var_dump($taxAmountType);
                                    exit;
                                }
                                $taxAmountType->setattr('currencyID', $this->orderCurrency);
                                $taxAmountType->setval($this->orderTax, 'iso-8859-1');
                                
                                $urrpDetailsType->setTaxAmount($taxAmountType);

                             // Setting up OrderTotal.
                                $orderTotal =& PayPal::getType('BasicAmountType');
                                $orderTotal->setattr('currencyID', $this->orderCurrency);
                                $orderTotal->setval($this->orderSubAmount, 'iso-8859-1');

                                $urrpDetailsType->setAmount($orderTotal);

                       } // End Case - ChangeTax/ChangeAmount
                       break;

                   case 'AdditionalBillingCycles':
                       {
                            $urrpDetailsType->setAdditionalBillingCycles($this->pfCycles);
                            
                       } // End Case - AdditionalBillingCycles
                       break;

                   case 'ChangeDescription':
                       {
                            $urrpDetailsType->setDescription($this->pfDescription);
                       } // End Case - ChangeDescription
                       break;
                   default:
                       {
                           // return wrapper error message
                              return false;
                       }
               } // End Swtich ($this->action)

          
         // Finalize the Request Object
            $urppRequestType->setUpdateRecurringPaymentsProfileRequestDetails($urrpDetailsType);

         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

         // Execute SOAP request
            $response = $objCaller->UpdateRecurringPaymentsProfile($urppRequestType);

         // Pharse and return the response
            return $this->pharseResponse($response);

    } // End Function - editRecurringProfile




    /**
     * Manage Recurring Payment Profile
     * ------------------------------------------------------------
     * This method will be useful to manage the status of
     * recurring payment profile for given profile Id
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function manageRecurringProfile($values)
     {
        require_once 'PayPal/Type/ManageRecurringPaymentsProfileStatusRequestType.php';
        require_once 'PayPal/Type/ManageRecurringPaymentsProfileStatusRequestDetailsType.php';

        $this->action               =$values['Action'];
        $this->recurringProfileId   =$values['ProfileID'];
        $this->pfNote               =$values['Note'];

        // Private Validation - action should be constrained
           switch($this->action)
           {
                case 'Cancel':
                case 'Suspend':
                case 'Reactivate':
                    {
                        // Ok to proceed
                        // Populate SOAP request information

                         // Prepare Manage Recurring Profile Request type
                            $mrppsRequestType= & PayPal::getType('ManageRecurringPaymentsProfileStatusRequestType');

                         // Prepare Manage Recurring Profile Details type
                            $mrppsDetailsType= & PayPal::getType('ManageRecurringPaymentsProfileStatusRequestDetailsType');
                            $mrppsDetailsType->setAction($this->action);
                            $mrppsDetailsType->setProfileID($this->recurringProfileId);
                            $mrppsDetailsType->setNote($this->pfNote);
                            
                         // Add details to the request object
                            $mrppsRequestType->setManageRecurringPaymentsProfileStatusRequestDetails($mrppsDetailsType);

                         // Creating CallerServices object
                            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

                         // Execute SOAP request
                            $response = $objCaller->ManageRecurringPaymentsProfileStatus($mrppsRequestType);

                         // Pharse and return the response
                            return $this->pharseResponse($response);

                    }
                    break;
                default:
                    {
                        // Error
                        return array(
                                'Ack'=>'Failure',
                                'ErrorCode'=>999000002,
                                'LongMessage'=>'Recurring profile status is invalid',
                                'Version'=>$this->wrapperVersion);
                    }

           }



         
     } // End Function - manageRecurringProfile




    /**
     * BillOutstandingAmount
     * ------------------------------------------------------------
     * Any recurring payment can be failed due to lots of reasons and
     * then the paypal will keep such payment as outstanding payments
     * from this method we can get such payments
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */
     private function billOutstandingAmount($values)
     {
        require_once 'PayPal/Type/BillOutstandingAmountRequestType.php';
        require_once 'PayPal/Type/BillOutstandingAmountRequestDetailsType.php';

        $this->orderAmount          =$values['Amount'];
        $this->recurringProfileId   =$values['ProfileID'];
        $this->pfNote               =$values['Note'];

        // Populate SOAP request information

         // Prepare Bill Outstanding Amount Request type
            $boaRequestType = & PayPal::getType('BillOutstandingAmountRequestType');

         // Prepare Bill Outstanding Amount Details type
            $boaDetailsType = & PayPal::getType('BillOutstandingAmountRequestDetailsType');
            $boaDetailsType->setAmount($this->orderAmount);
            $boaDetailsType->setNote($this->pfNote);
            $boaDetailsType->setProfileID($this->recurringProfileId);

         // Finalize the Request Object
            $boaRequestType->setBillOutstandingAmountRequestDetails($boaDetailsType);

         // Creating CallerServices object
            $objCaller = & PayPal::getCallerServices($this->PPAPIProfile);

         // Execute SOAP request
            $response = $objCaller->BillOutstandingAmount($boaRequestType);

         // Pharse and return the response
            return $this->pharseResponse($response);
            
     } // End Function - manageRecurringProfile



    /**
     * API LISTNER
     * ------------------------------------------------------------
     * This method will be execute from the common listner file and validate the
     * message from paypal. if valid message, this will automatically invoke the
     * specified Program oriented method.
     * @param array $args  Contain all the values sent by paypal (POST)
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success messages
     *
     */
     public function listenAPI($args)
     {
        // Initializing
           $this->init();
           
        // Set the Paypal URL
           switch ($this->APIEnviornment)
           {
                case 'live':
                    {
                        $ppURL='https://www.paypal.com';
                    }break;
                default:
                    {
                        $ppURL='https://www.' . $this->APIEnviornment . '.paypal.com';
                    }
           }


        // We should double check information only related with our account
           if($this->APIUserEmail==$args['receiver_email'] && $this->APIUserId==$args['receiver_id'])
           {

                // Read the post from PayPal and add 'cmd'
                   $req = 'cmd=_notify-validate';

                   if(function_exists('get_magic_quotes_gpc')) $get_magic_quotes_exits = true;

                    foreach ($args as $key => $value)
                    {
                        // Handle escape characters, which depends on setting of magic quotes
                           if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
                           {
                                $value = urlencode(stripslashes($value));
                           }
                           else
                           {
                                $value = urlencode($value);
                           }
                           
                           $req .= "&$key=$value";
                           
                        // Prepare New Array for Wrapper
                        // If in case Paypal changed any key, system can run without fail
                        // with overriding following keys as follows
                        // 
                        // Imaging that paypal has been changed the payer_id Key to payerid
                        // So previouskey is payer_id therefore specific wrapper key is PayerId
                        // override key after this foreach loop as $returnArgs[PayerId]=$args['payerid'];

                        // Automatic key setting for wrapper class
                           $newKey=str_replace(" ","",ucwords(str_replace("_"," ",$key))); 
                           $returnArgs[$newKey]=$value;
                           
                       /*
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
                        */
                    }

                 // Post back to PayPal to validate
                    $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
                    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
                    $fp = fsockopen ($ppURL, 80, $errno, $errstr, 30);

                 // Process validation from PayPal
                    if (!$fp) {
                        // HTTP ERROR
                            return array(
                                    'Ack'           =>'Failure',
                                    'ErrorCode'     =>999000004,
                                    'LongMessage'   =>'Error in connection with PayPal',
                                    'Section'       =>'Instant Payment Notification',
                                    'Log'           =>$args,
                                    'Version'       =>$this->wrapperVersion
                                    );
                    } else {
                                
                        // NO HTTP ERROR
                           fputs ($fp, $header . $req);
                           while (!feof($fp)) {
                                $res = fgets ($fp, 1024);
                                  if (strcmp ($res, "VERIFIED") == 0) {
                                    // VERIFIED
                                    // Pass prepared return arry which prepared
                                       return $returnArgs;
                                  } 
                                  else if (strcmp ($res, "INVALID") == 0)
                                  {
                                    // INVALID
                                    // Error
                                    return array(
                                            'Ack'               =>'Failure',
                                            'ErrorCode'         =>999000005,
                                            'LongMessage'       =>'Invalid transaction request found - user varified',
                                            'Section'           =>'Instant Payment Notification',
                                            'Log'               =>$args,
                                            'Version'           =>$this->wrapperVersion
                                            );
                                 } // End - if (strcmp ($res, "VERIFIED") == 0)

                            } // End - While Loop
                          
                    }// End - if (!$fp) 
           }// Else - if($this->APIUserEmail==$args['receiver_email'] && $this->APIUserId==$args['receiver_id'])
           else
           {
            // Error
            return array(
                    'Ack'               =>'Failure',
                    'ErrorCode'         =>999000003,
                    'LongMessage'       =>'Invalid transaction request found - user Invalid',
                    'Section'           =>'Instant Payment Notification',
                    'Log'               =>$args,
                    'Version'           =>$this->wrapperVersion
                    );

           } // End - if($this->APIUserEmail==$args['receiver_email'] && $this->APIUserId==$args['receiver_id'])

           fclose ($fp);
     }




    /***************************************************************
     * Set and Get method category
     * ------------------------------------------------------------
     * This category will maintains all the set and get methods
     * for the wrapper class
     * if you need any similar method, please included under this
     * category for maintain the clarity of the source
     **************************************************************/

    /**
     * SET SDK Path
     * ------------------------------------------------------------
     * @param string $path  Server path from the SDK folder
     */
     public function setPathSDK($path)
     {
         $this->SDKPath=$path;
     }

    /**
     * GET SDK Path
     * ------------------------------------------------------------
     * @return string $path  Server path from the SDK folder
     */
     public function getPathSDK()
     {
         return $this->SDKPath;
     }


    /**
     * SET API User (seller's API credentials)
     * ------------------------------------------------------------
     * @param string $name  API username (Not the email)
     */
     public function setAPIUser($name)
     {
         $this->APIUser=$name;
     }
     
    /**
     * GET API User (seller's API credentials)
     * ------------------------------------------------------------
     * @return string $name  API username
     */
     public function getAPIUser()
     {
         return $this->APIUser;
     }


    /**
     * SET API User Email (seller's email)
     * ------------------------------------------------------------
     * @param string $email  API user email
     */
     public function setAPIUserEmail($email)
     {
         $this->APIUserEmail=$email;
     }

    /**
     * GET API User Email (seller's email)
     * ------------------------------------------------------------
     * @return string $email  API user email
     */
     public function getAPIUserEmail()
     {
         return $this->APIUserEmail;
     }


    /**
     * SET API User Id (seller's Id)
     * ------------------------------------------------------------
     * @param string $id  Id can be found from PayPal>My profile
     */
     public function setAPIUserId($id)
     {
         $this->APIUserId=$id;
     }

    /**
     * GET API User Id (seller's Id)
     * ------------------------------------------------------------
     * @return string $id  API user Id
     */
     public function getAPIUserId()
     {
         return $this->APIUserId;
     }


    /**
     * SET API User Password (seller's API credentials)
     * ------------------------------------------------------------
     * @param string $password  Sellers API passowrd
     */
     public function setAPIPassword($password)
     {
         $this->APIPass=$password;
     }

    /**
     * GET API User Password (seller's API credentials)
     * ------------------------------------------------------------
     * @return string $password  Sellers API password
     */
     public function getAPIPassword()
     {
         return $this->APIPass;
     }


    /**
     * SET API Signature (seller's API credentials)
     * ------------------------------------------------------------
     * @param string $signature  Signature for API
     */
     public function setAPISignature($signature)
     {
         $this->APISign=$signature;
     }

    /**
     * GET API Signature (seller's API credentials)
     * ------------------------------------------------------------
     * @return string $signature  Signature for API
     */
     public function getAPISignature()
     {
         return $this->APISign;
     }


    /**
     * SET API Enviornment
     * ------------------------------------------------------------
     * @param string $enviornment  Server enviornment for API integration
     */
     public function setAPIEnviornment($enviornment)
     {
         switch($enviornment)
         {
             case "live":
             case "sandbox":
             case "beta-sandbox":
             case "stage2ek":
                 {
                     $this->APIEnviornment=$enviornment;
                 }
                 break;
             default:
                 {
                     die("Paypal API Enviornment Invalid");
                 }               
         } // Swith($enviornment)
     }

    /**
     * GET API Enviornment
     * ------------------------------------------------------------
     * @return string $enviornment  Server enviornment for API integration
     */
     public function getAPIEnviornment()
     {
         return $this->APIEnviornment;
     }


    /**
     * SET Express Checkouts Return URL
     * ------------------------------------------------------------
     * @param string $url  Return URL for Express Checkouts
     */
     public function setAPIExpressCheckoutReturnURL($url)
     {
         $this->APIExpressCheckoutReturnURL=$url;
     }

    /**
     * GET Express Checkouts Return URL 
     * ------------------------------------------------------------
     * @return string $url  Return URL for Express Checkouts
     */
     public function getAPIExpressCheckoutReturnURL()
     {
         return $this->APIExpressCheckoutReturnURL;
     }
     
     
     /**
     * SET Express Checkouts Canel URL
     * ------------------------------------------------------------
     * @param string $url  Cancel URL for Express Checkouts
     */
     public function setAPIExpressCheckoutCancelURL($url)
     {
         $this->APIExpressCheckoutCancelURL=$url;
     }

    /**
     * GET Express Checkouts Canel URL
     * ------------------------------------------------------------
     * @return string $url  Cancel URL for Express Checkouts
     */
     public function getAPIExpressCheckoutCancelURL()
     {
         return $this->APIExpressCheckoutCancelURL;
     }    
     
     
     /**
     * SET Default Currency Code 
     * ------------------------------------------------------------
     * @param string $currency  Currency for Paypal API (3-character ISO-4217)
     */
     public function setDefaultCurrency($currency)
     {
         
         switch($currency)
         {
             case 'AUD': // Australian Dollar
             case 'CAD': // Canadian Dollar
             case 'EUR': // Euro
             case 'JPY': // Japanese Yen
             case 'GBP': // Pound Sterling
             case 'USD': // United States Dollar
                 {
                    $this->defaultCurrency=$currency;                   
                 }
                 break;
             default:
                 {
                    die("Invalid Default Currency");
                 }
         }
     }

    /**
     * GET Default Currency Code
     * ------------------------------------------------------------
     * @return string $currency  Currency for Paypal API
     */
     public function getDefaultCurrency()
     {
         return $this->defaultCurrency;
     }    
     




    /***************************************************************
     * Other Supporting Methods
     * ------------------------------------------------------------
     * This category will maintains the supporting methods which
     * not directly deal with API
     * if you need any misc method, please included under this
     * category for maintain the clarity of the source
     **************************************************************/
        /**
         * Pharse the Response and get it via an array
         */
         private function pharseResponse($response)
         {
            $arrResponse=array();
            foreach($response as $key => $value) {
                if(is_object($value)){
                    $arrDumpObject=$this->dumpObject($value);
                    if(is_array($arrDumpObject)) $arrResponse=array_merge($arrResponse,$arrDumpObject);
                }
                else {
                    if($key[0] != '_' && $value != null)
                    $arrResponse[$key]=$value;
                }
            }
            return $arrResponse;
         }


        /**
         * Recursive function for pharse object
         * this will call through the pharseResponse function
         */
         private function dumpObject($obj)
         {

            foreach($obj as $key => $value) {
                if($key != 'RegularRecurringPaymentsPeriod') {
                    if(is_object($value)){
                        if(is_a($value, 'basicamounttype')) {
                            $currency = $value->_attributeValues;
                            $arrResponse[$key]=$value->_value.  $currency["currencyID"];
                        }
                        else {
                            $arrResponse[$key]=$this->dumpObject($value);
                        }
                    }
                    else {
                        if($key[0] != '_' && $value != null)
                            $arrResponse[$key]=$value;
                    }
                }
            } // End loop

            return $arrResponse;

         } // end function dumpObject



        /**
         * Pharse the Date and Time that recieved from the Paypal
         * @param string date (format: 03:00:00 Apr 01, 2010 PDT)
         * @return array (Year,Month,Day,Hours,Minute,Second,Stamp)
         *
         */
         public function pharseDateTime($dateTime)
         {

            // Check the format
               if($dateTime[10]=='T' && $dateTime[19]=='Z')
               {
                  // 2010-05-16T10:00:00Z
                     $tmpDT=str_replace(array('Z','T'),array('',' '),$dateTime);

                     $expDT=explode(" ",trim($tmpDT));
                     $expTm=explode(":",$expDT[1]); // time
                     $expYMD=explode("-",$expDT[0]); // date
                     
                     $tStamp=mktime($expTm[0],$expTm[1],$expTm[2],$expYMD[1],$expYMD[2],$expYMD[0]);

               }
               else
               {
                  // 03:00:00 Apr 01, 2010 PDT
                     $tmpDT=str_replace(array(',','PDT'),'',$dateTime);
                                                                       
                     $expDT=explode(" ",trim($tmpDT));
                     $expTm=explode(":",$expDT[0]);
                     $arrMonths = array('Jan'=>'01', 'Feb'=>'02', 'Mar'=>'03', 'Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07', 'Aug'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12');
                     $tStamp=mktime($expTm[0],$expTm[1],$expTm[2],$arrMonths[$expDT[1]],$expDT[2],$expDT[3]);
               }
            
               //if(substr($dateTime,strlen($dateTime)-1);



           return  array (
                        'Year'   =>$expDT[3],
                        'Month'  =>$arrMonths[$expDT[1]],
                        'Day'    =>$expDT[2],
                        'Hour'   =>$expTm[0],
                        'Minute' =>$expTm[1],
                        'Second' =>$expTm[2],
                        'Stamp'  =>$tStamp
               
                    );
         } // end function dumpObject

} // End Class

?>