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
 * GET EXISTING TRANSACTION DETAILS
 * -----------------------------------------------------------
 * Before test this method, make sure to made a transaction
 * using direct or express payment.
 * Then get the TransactionID and use it for this method
 *
    $vals=array
    (
        'TransactionID'=>'09802457L1738921N'
    );

    // Call the API through Wrapper
       $transactionData=$objPPWrapper->callAPI('GetTransactionDetails',$vals);


/**
 * DIRECT PAYMENT USING CREDIT CARD
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *

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
                'Number'=>'4846634321098630',   // Credit Card Number
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



 /**
 * EXPRESS CHECKOUT USING CUSTOMER PAYPAL ACCOUNT
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *

    $vals = array
    (
        'Action'=>'Sale',                       // [Sale/Authroization] *-Required

        'Order'=> array
            (
                'SubTotal'=>'20.80',            // Sub Total
                'Tax'=>'2',                     // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
                'Total'=>'22.80',               // Total of the Order [=SubTotal + Tax] *-Required
                'Currency'=>'',                 // Currency Code ie: USD/ GBP *-Optional - system will use the default value - USD
            ),

        'Payer'=> array                         // You can easially understand the each parameter to be passed - *-Required
            (
                'FirstName'=>'Test',
                'LastName'=>'User',
                'Email'=>'saliya_1264063573_per@gmail.com',

            ),

        'Items'=> array
            (
                // Item 1
                array
                (
                    'Item'  =>'Classified Ads', // Try to add meanful content here
                    'Qty'   =>1, // keep Qty as 1.
                    'Amount'=>20.80,
                )

                // NOTE: PPWrapper v0.1 supports one item
                // If you need to use more than one item enhance the wrapper class
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
       $transactionData=$objPPWrapper->callAPI('SetExpressCheckout',$vals);


/**
 * Create Recurring Payment Profile
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *

    $vals = array
    (
        'Action'=>'Sale',                       // [Sale/Authroization] *-Required
       // 'IPAddress'=>'127.0.0.1',               // IP address of the shopper *-Optional
       // 'SessionID'=>'',                        // Merchant session Id *-Optional

        'Order'=> array
            (
                'SubTotal'=>'25.00',               // Sub Total
                'Tax'=>'3.12',                    // Sales Tax : ie: SUM(VAT + GRT + etc) *-Optional
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
            'Description' => '2nd Profile',
            'BillingPeriod' => 'Day',
            'BillingFrequency' => '1',
            'TotalCycles' => '7',
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
       $transactionData=$objPPWrapper->callAPI('CreateRecurringProfile',$vals);



/**
 * Get Recurring Payment Profile
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 */

    $vals=array
    (
        'ProfileID'=>'I-0N9WUGCN1BPM'

    );

    // Call the API through Wrapper
       $transactionData=$objPPWrapper->callAPI('GetRecurringProfileDetails',$vals);



/**
 * Update Recurring Payment Profile
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
 *

    $vals = array
    (
        'Action'=>'AdditionalBillingCycles',                       // [Please check the above comment for options] *-Required
        'ProfileID'=>'I-UH1F9X2H30M9',          // Merchant session Id *-Optional

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
                'Number'=>'4697737210087117',   // Credit Card Number
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
       echo "<pre>";print_r($transactionData);echo "</pre>";
    // We can make sure that the profile has been updated with call it again
       $transactionData=$objPPWrapper->callAPI('GetRecurringProfileDetails',$vals);
       echo "<br/>========================================================<br/><br/>";



/**
 * Manage Recurring Payment Profile
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 *
 * NOTE: Action should be one of followings.
 *       -> Cancel
 *       -> Suspend
 *       -> Reactivate
 *

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
       echo "<pre>";print_r($transactionData);echo "</pre>";
    // We can make sure that the profile has been updated with call it again
       $transactionData=$objPPWrapper->callAPI('GetRecurringProfileDetails',$vals);
       echo "<br/>========================================================<br/><br/>";



/**
 * Bill Outstanding Amount
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

    /* Call the API through Wrapper *
       $transactionData=$objPPWrapper->callAPI('BillOutstandingAmount',$vals);
       echo "<pre>";print_r($transactionData);echo "</pre>";
    /* We can make sure that the profile has been updated with call it again */
       $transactionData=$objPPWrapper->callAPI('GetRecurringProfileDetails',$vals);
       echo "<br/>========================================================<br/><br/>";


/*
 *
 */


///------------------------------->
echo "<pre>";print_r($transactionData);echo "</pre>";

?>