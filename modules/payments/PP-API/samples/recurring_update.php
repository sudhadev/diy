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
 * UPDATE RECURRING PROFILE DETAILS
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *
 * NOTE: Action should be one of followings. Please note that
 * you don't need to pass the whole array and pass only the mentioned
 * block of the array with each Action
 * However its compulsory to pass the Action and ProfileID,
 * as the whole operation depends on these 2 values
 *
 *       -> ChangeCreditCard            [CCard] + [Payer]
 *       -> ChangeTax                   [Order]
 *       -> ChangeAmount                [Order]
 *       -> AdditionalBillingCycles     [Schedule] - Only TotalCycles would be enough
 *       -> ChangeDescription           [Schedule] - Only Description would be enough
 */

    $vals = array
    (
        'Action'=>'ChangeCreditCard',                       // [Please check the above comment for options] *-Required
        'ProfileID'=>'I-DPLFD3CRXNY5',         

        'Order'=> array
            (
                'SubTotal'=>'88.8',               // Sub Total *- Required
                'Tax'=>'',                    // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                'Currency'=>'',                   // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
            ),

        'Payer'=> array                          // You can easially understand the each parameter to be passed
            (
                'FirstName'=>'Test',
                'LastName'=>'User',
                'Address'=>'1 ',
                'Street'=>'Main St',
                'CityName'=>'San Jose',
                'StateOrProvince'=>'CA',
                'PostalCode'=>'95131',
                'CountryCode'=>'US',
                'Phone'=>'1223949555',
                'Email'=>'saliya_1264063573_per@gmail.com',

            ),

        'CCard'=> array
            (
                'Type'=>'Visa',                 // Credit Card Type [Visa/ Master/ etc]
                'Number'=>'4377406963727231',   // Credit Card Number
                'ExpMonth'=>'01',               // Expire Month in 2 digits
                'ExpYear'=>'2014',              // Expire Month in 2 digits
                'CVV2'=>'123',                  // This is the code in back side of the card 3/4 digits depending on the card type
            ),

        'Schedule'       => array
        (
            'Description' => 'Here I changed the Description via wrapper',
            'BillingPeriod' => 'Day',
            'BillingFrequency' => '1',
            'TotalCycles' => '8',
            'StartDateDay' => '18',
            'StartDateMonth' => '02',
            'StartDateYear' => '2010'

        ),

        // Wrapper class v0.1 not supports ship address
        // Please impliment it before use
        // -------------------------------------->

        'ShipToAddress' => array
            (
                'Name' => '',
                'Street1' => '',
                'Street2' => '',
                'CityName' => '',
                'StateOrProvince'=> '',
                'Country' => '',
                'PostalCode' => ''
            )

    );

    // Call the API through Wrapper
       $transactionData=$objPPWrapper->callAPI('UpdateRecurringProfile',$vals);



// For testing Purpases we can print the whole array
echo "<pre>
/**
 * UPDATE RECURRING PROFILE DETAILS
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
