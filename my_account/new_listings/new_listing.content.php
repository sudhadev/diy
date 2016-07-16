<?php
/* 
 * This is the content for the <section> 
 * You can use HTML tags
 * 
 */

$pageContents=array(
  
 /*
  * Main content of the section
  */ 
"common_text"=> "Use the forms below to send new requests. Each request will be checked,
                    approved and added to the systems data. Approving may take up to 12 hours,
                    at which point return to Supplier Area and Add Listings to add prices, image etc.",
    

 /*
  * Information box text - New category request for 2nd Level
  */

"infoAddSecCategory"=> "<strong>Note*:</strong> You are currently requesting a <strong>Second Level Category</strong>. <br/>
            When you submit the data, System will automatically prompt you the Third Level Category request form. <br/>
            Then, if you need you can request a <strong>Third Level Category</strong> as the next step of this process.<br/>
            <strong>Please note that all requests are subject to the Administrators approval.</strong>",

 /*
  * Information box text - New category request for 3rd Level
  */

"infoAddThirdCategory"=> "<strong>Note*:</strong> You are currently requesting a <strong>Third Level Category</strong>. <br/>
            When you submit the data, System will automatically prompt you the Product request form.<br/>
            Then, if you need you can request a <strong>Product</strong> as the next step of this process.<br/>
            <strong>Please note that all requests are subject to the Administrator's approval.</strong>",

"infoAddThirdCategoryNonSupplies"=> "<strong>Note*:</strong> You are currently requesting a <strong>Third Level Category</strong>. <br/>
           <strong>Please note that all requests are subject to the Administrators approval.</strong>",

 /*
  * Information box text - New category request for 2nd Level
  */

"infoAddSpecificaton"=> "<strong>Note*:</strong> You are currently adding a new <strong>Product</strong> . <br/>
System will automatically suggest Manufacturer when you start to key-in information. You can either select an existing one or type a new one.<br/>
            <strong>Please note that all requests are subject to the Administrators approval.</strong>"

//requesting a <strong>Specification</strong> - Changed by SUdharshan - CR by Jason
 /*
  * For <purpose of the text>
  */

    
 /*
  * Comments to developper - remove this section
  *
  * 1) Call the relevant file in index.php in each section
  *    ie:
  *       in wish list section index.php ---> include("content_wishlist.php");
  * 2) Just use the respective array element in the place you need to display
  *     ie: in wish list, building supplier heading text section -------> echo $pageContent['B-SUPLIER-HEAD-TEXT'];
  *
  */
    
);

?>
