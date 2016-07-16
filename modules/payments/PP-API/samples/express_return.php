<?
/* ---------------------------------------------------------------------------
 * PAY PAL API
 * Wrapper Class Sample / Unit testing Module
 * This code will be used to capture successful response from PayPal API
 * on Express checkout.
 * Once we get the positive response from the PayPal API, its important to
 * get the exact express checkout order detail using GetExpressCheckout and
 * tally it with the values we get from the PayPal from the return URL
 * I have mentioned these query string values as parameters bellow.
 * Please note that its advisable to use $_REQUEST method to capture those.
 *
 * @param string paymentType
 * @param string token
 * @param string paymentAmount
 * @param string currencyCodeType
 *
 * Written By Saliya Wijesinghe - Fusis IT
 * [saliya@ymail.com / 0773-505072]
 -----------------------------------------------------------------------------*/

/**
 * IMPORTANT !
 * ------------------------------------------------------------
 * I think its always good to have our own variable names rather than
 * using the $_REQUEST type here and there
 */

   $paymentType         =$_REQUEST['paymentType'];
   $token               =$_REQUEST['token'];
   $paymentAmount       =$_REQUEST['paymentAmount'];
   $currencyCodeType    =$_REQUEST['currencyCodeType'];

   // If there isn't a Token, no point executing the code further
      if(!$token) {
          echo "Provide a Token to proceed";
          exit;
      }

/**
 * IMPORTANT !
 * ------------------------------------------------------------
 * Before you start testing the wrapper, you should call the class
 * and should create the object
 * Make sure to add the correct parth to the wrapper from your testing code
 */
    require_once 'PPWrapper.class.php';
    $objPPWrapper=new PPWrapper();

    // Common values - required
       $objPPWrapper->setAPIEnviornment('sandbox');
       $objPPWrapper->setPathSDK('/var/www/pp_api/php-sdk');
       $objPPWrapper->setDefaultCurrency('USD');

    // API Credentials - Most important values for API integration
       $objPPWrapper->setAPIUser('seller_1264051179_biz_api1.gmail.com');
       $objPPWrapper->setAPIPassword('PYBQD84F3M79HPDB');
       $objPPWrapper->setAPISignature('A9fwm6FVfqG1KqFnjKcVJpuoeHjqADvllwRsSv1.iHUd50b8-2cs5jjr');

    // Specially needs in Instant Notification section (listner of the site)
       $objPPWrapper->setAPIUserId('ZFJ7RKZLQUVF2');
       $objPPWrapper->setAPIUserEmail('seller_1264051179_biz_api1@gmail.com');

    // Specially needs in Express checkout seciton
       $objPPWrapper->setAPIExpressCheckoutReturnURL('http://localhost/php-sdk/mytest/expReturn.php');
       $objPPWrapper->setAPIExpressCheckoutCancelURL('http://localhost/php-sdk/mytest/Cancel.php');



/**
 * GET EXPRESS CHECKOUT DETAILS
 * -----------------------------------------------------------
 * Before test this method, make sure to make a transaction
 * using express checkout and pass the exact token value.
 * If you didn't execute this file separately, it should be
 * expected to be execute without an error.
 */

    $vals=array
    (
        'Token'=>$token
    );

    $transactionData=$objPPWrapper->callAPI('GetExpressCheckoutDetails',$vals);
    echo "<pre>GET EXPRESS CHECKOUT DETAILS [For Token: $token]";
    echo "<br/>-----------------------------------------------------------";
    print_r($transactionData);
    echo "</pre>";

/**
 * DO EXPRESS CHECKOUT (COMPLETE THE ORDER)
 * -----------------------------------------------------------
 * To test this method, you should get a return value 
 * from GetExpressCheckoutDetails using above method
 * Then you can compare previously returned order total from PayPal and
 * the values you get from the GetExpressCheckoutDetails method
 * NOTE: however you should handle the exceptions on failure acknowlagements
 */

   if($transactionData['PaymentDetails']['OrderTotal']!=$paymentAmount.$currencyCodeType)
   {
          echo "Error in provided Token";
          exit;
   }

   // Prepare necessory values to confirm the order
      $vals=array
      (
            'Token'=>$token,
            'Action'        =>$paymentType,
            'OrderTotal'    =>$paymentAmount,
            'Currency'      =>$currencyCodeType,
            'Payer'         => array
                               (
                                    'ID' =>$transactionData['PayerInfo']['PayerID'],
                               ),

      );

    $transactionData=$objPPWrapper->callAPI('DoExpressCheckout',$vals);

    // Print and check the return array
        echo "<pre>GET EXPRESS CHECKOUT DETAILS [For Token: $token]";
        echo "<br/>-----------------------------------------------------------";
        print_r($transactionData);
        echo "</pre>";


?>