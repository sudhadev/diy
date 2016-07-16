<?php
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


 /**
 * EXPRESS CHECKOUT USING CUSTOMER PAYPAL ACCOUNT
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 */

    $vals = array
    (
        'Action'=>'Sale',                       // [Sale/Authroization] *-Required
        'invoiceID'=>'1122333',                 // Invoice Id*-Optional

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




// For testing Purpases we can print the whole array
echo "<pre>
/**
 * EXPRESS CHECKOUT USING CUSTOMER PAYPAL ACCOUNT
 * -----------------------------------------------------------
 * Make sure to use the template with your appropiate testing data
 * Using the provided sample data may leads you to improper integration
 */
";
print_r($transactionData);
echo "</pre>";

?>
