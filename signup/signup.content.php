<?php
/* 
 * This is the content for the <section> 
 * You can use HTML tags
 * 
 */

$pageContents=array(
  

 /*
  * Main contents
  */

"textSupplier"=> "<span style=\"color:red;\">IMPORTANT : </span>If you run several businesses from different addresses, you’ll need one registration for each business. However, if you’ve got a Building Supplies and Building Services business running from the same address, you can subscribe to one or both, under one registration.
<br/><br/>
To register for a Building Supplies or Building Services account (or both under the same address) please enter the information below.",

"textBuyer"=> "Along with being able to search Diy Price Check for building products, registering as a buyer gives you the advantage of storing searches as wish list entries. With your wish list entries, you can compile simple quotations, ideal for individuals wanting to cut down on admin time.
    <p>To create an account, please enter the information below:</p> ",


 /*
  * For <purpose of the text>
  */
"textBuyerToSupplier"=> "<div class=\"msgBox\" style=\"height: 60px;\"><span style=\"color:red;\">You have registered with DIY Price Check as a <strong>Buyer</strong>. In order to use the promotional code and add listings
you have to register as a supplier</span><br/>
<p> Please register as a supplier using the following form
</p> </div>",

    
"loggedinotheruser"=> "<div class=\"msgBox\" style=\"height: 60px;\"><span style=\"color:red;\">IMPORTANT:</span> You are logged in to the DIY Price Check system using a separate user account already.
    
<p>In order to use this promocode please logout and login using the account which is relevant to this promocode. If you are not registered please register as a supplier and use the promocode.
Please register as a supplier using the following form
</p> </div>",
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
