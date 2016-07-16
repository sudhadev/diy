<?
ini_set ('display_errors', 1);
/* ---------------------------------------------------------------------------
 * PAY PAL API
 * Wrapper Class Sample / Unit testing Module
 *
 *
 * Written By Saliya Wijesinghe - Fusis IT
 -----------------------------------------------------------------------------*/


/**
 * IMPORTANT !
 * ------------------------------------------------------------
 * Before you start testing the wrapper, you should call the class
 * and should create the object
 * Make sure to add the correct parth to the wrapper from your testing code
 */
    require_once '../PPWrapper.class.php';
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
 * GET EXISTING TRANSACTION DETAILS
 * -----------------------------------------------------------
 * Before test this method, make sure to made a transaction
 * using direct or express payment.
 * Then get the TransactionID and use it for this method
 */
    $vals=array
    (
        'TransactionID'=>'8LS91104WY5075034'
    );

    // Call the API through Wrapper
       $transactionData=$objPPWrapper->callAPI('GetTransactionDetails',$vals);



 
// For testing Purpases we can print the whole array
echo "<pre>
/**
 * GET EXISTING TRANSACTION DETAILS
 * -----------------------------------------------------------
 * Before test this method, make sure to made a transaction
 * using direct or express payment.
 * Then get the TransactionID and use it for this method
 *
 * Currently Using ===> [".$vals['TransactionID']."]
-------------------------------------------------------------
";
print_r($transactionData);
echo "</pre>";

?>
