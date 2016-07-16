<?
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
 * BILL OUTSTANDING AMOUNT
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *

 */

    $vals = array
    (
        'ProfileID'=>'I-0N9WUGCN1BPM',                  // Profile Id *-Required
        'Amount'=>'',                                   // Amount to be charged [should be equal or less then total outstanding] *-Optional
        'Note' => '',                                   // remarks about this payment *-Optional


    );

    // Call the API through Wrapper *
       $transactionData=$objPPWrapper->callAPI('BillOutstandingAmount',$vals);




 
// For testing Purpases we can print the whole array
echo "<pre>
/**
 * BILL OUTSTANDING AMOUNT
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
";
print_r($transactionData);

echo "
/**
 * GET UPDATED PROFILE FOR DUBLE CHECK THE UPDATION
 * -----------------------------------------------------------

";

$transactionData=$objPPWrapper->callAPI('GetRecurringProfileDetails',$vals);
print_r($transactionData);
echo "</pre>";
?>
