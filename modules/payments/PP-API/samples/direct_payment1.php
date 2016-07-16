<?php //ini_set('display_errors','1');
/* ---------------------------------------------------------------------------
 * PAY PAL API
 * Wrapper Class Sample / Unit testing Module
 *
 *
 * Written By Saliya Wijesinghe - Fusis IT
 * [saliya@ymail.com / 0773-505072]
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
       $objPPWrapper->setPathSDK('/var/www/sites/admin/diypricecheck.com/subdomains/www/html/modules/payments/PP-API/php-sdk');
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


           // API Credentials - Most important values for API integration
       $objPPWrapper->setAPIUser('diy_1291355702_biz_api1.tekmaz.com');
       $objPPWrapper->setAPIPassword('1291355717');
       $objPPWrapper->setAPISignature('As21zq.EPWRFHB2xDcc5MvDRXVOMAsKWrZXDTS0SBh1qPPBm3yuacc8l');

    // Specially needs in Instant Notification section (listner of the site)
       $objPPWrapper->setAPIUserId('7QYRLBQD4PGGJ');
       $objPPWrapper->setAPIUserEmail('diy_1291355702_biz_api1@tekmaz.com');







/**
 * DIRECT PAYMENT USING CREDIT CARD
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 */

    $vals = array
    (
        'Action'=>'Sale',                       // [Sale/Authroization] *-Required
        'IPAddress'=>'127.0.0.1',               // IP address of the shopper *-Optional
        'SessionID'=>'',                        // Merchant session Id *-Optional

        'Order'=> array
            (
                'SubTotal'=>'12',               // Sub Total
                'Tax'=>'2',                     // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                'Total'=>'14',                    // Total of the Order [=SubTotal + Tax] *-Required
                'Currency'=>'',                 // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
            ),

        'Payer'=> array                         // You can easially understand the each parameter to be passed
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
       $transactionData=$objPPWrapper->callAPI('DoDirectPayment',$vals);





// For testing Purpases we can print the whole array
echo "<pre>
/**
 * DIRECT PAYMENT USING CREDIT CARD
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 */
";
print_r($transactionData);
echo "</pre>";


?>
