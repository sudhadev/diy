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
 * MANAGE RECURRING PROFILE DETAILS
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *
 * NOTE: Action should be one of followings.
 *       -> Cancel
 *       -> Suspend
 *       -> Reactivate
 */

    $vals = array
    (
        'Action'=>'Reactivate',                       // [Please check the above comment for options] *-Required
        'ProfileID'=>'I-UH1F9X2H30M9',                  // Profile Id *-Required

        'Schedule'       => array
        (
            'Note' => 'Here I changed the Note via wrapper',  // Reason for do this status change - can use for future references

        ),

    );

    // Call the API through Wrapper
       $transactionData=$objPPWrapper->callAPI('ManageRecurringProfile',$vals);


 
// For testing Purpases we can print the whole array
echo "<pre>
/**
 * MANAGE RECURRING PROFILE DETAILS
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *
 * NOTE: Action should be one of followings.
 *       -> Cancel
 *       -> Suspend
 *       -> Reactivate
 * --------------------------------------------------------------

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
