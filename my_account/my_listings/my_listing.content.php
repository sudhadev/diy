<?php
/* 
 * This is the content for the <section> 
 * You can use HTML tags
 * 
 */

$pageContents=array(
  
 /*
  * For <purpose of the text>
  */ 
"listing_add"=> "<ol>
                        <li>
                            Look in the left hand column, &ldquo;Browse Categories &rdquo; and click on a category.</li>
                        <li>
                            Next, in the yellow bars below, choose a sub-category and click the arrows to open.</li>
                       
<li>Can you see a product that you sell in the open category? If there is, you can either just add your prices and delivery, yes or no. Or you can click on the image or manufacturer to add extra details about that product. Finally activate your listing and submit.</li> 
<li>If there isn't the product you sell, you can click on 'Add a new Product' in that category.</li>
<li>If there's a product and you want to add a new manufacturer click 'Add a new Manufacturer'.</li>
</ol>
                ",
    
 /*
  * For <purpose of the text>
  */
    
"my_listing_edit"=> "<p>
                        The left column contains your listings.</p>
                    <ol>
                        <li>
                            Select a category.</li>
                        <li>
                            Then below open a product type to edit your pricing and information.</li>
                        <li>
                            Click &ldquo;submit Listings&rdquo; to finish.</li>
                    </ol>
                    ",

 /*
  * For <purpose of the text>
  */

"infoSubsAlert"=> '<style></style><div style="width: 620px; margin-top: 10px; margin-left: 5px; display: block; padding-top:10px; padding-left:15px;" class="commonInfoBox" id="specialInfo">
                       <strong>Note*:</strong>
You have {%listCanAdd%} more listings to activate. When these are used, you may want to  <a href="{%subsURL%}"><strong>upgrade your subscription</strong></a>.
<div class="collapsibleContainer">
<div class="collapsibleContainerTitle">[Read More / Less]</div>
<div  class="collapsibleContainerContent" style="margin-left: 20px;display:none;">

<p> In &quot;Add Listings&quot;, you have added the following amount of listings;</p>
<table width="428" border="0" cellspacing="0" cellpadding="0" id="tbl_in_info_box">
  <tr>
    <td width="259"><i>How many can I add? </i></td>
    <td width="169"><i>No limit </i></td>
  </tr>
  <tr>
    <td><strong>Listings allowed to be active </strong></td>
    <td><strong>{%listAllowed%}</strong> <i>(Your subscription)</i></td>
  </tr>
  <tr>
    <td><strong>Listings added until now</strong></td>
    <td><strong>{%listTotal%}</strong></td>
  </tr>
  <tr>
    <td><i>Of those</i></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Activated</strong> </td>
    <td><strong>{%listActive%}</strong></td>
  </tr>
  <tr>
    <td><strong>Not activated</strong></td>
    <td><strong>{%listInactive%}</strong></td>
  </tr>
</table>
<p style="font-weight:bold;"> Advice: You need to choose more listings in &quot;Add Listings&quot; to make full use of your            subscription package and make sure your preferred listings are activated.</p>
</div></div>
</div>
</div>
',
    
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