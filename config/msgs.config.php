<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  msgs.arr.php                                      '
  '    PURPOSE         :  Table configuration                                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


$_MSGS=array(
	
	// Message Numbers for Login Module
	'LOGIN'=>array(
	    428=>array('ERR','Both Username and Password is required'), // sucess/error, message
	    422=>array('ERR','Password Incorrect'), // sucess/error, message
	    426=>array('ERR','User not found'), // sucess/error, message
	    528=>array('ERR','Username  is Required'), // sucess/error, message
	    529=>array('SUC','New Password has been sent. Please check your emails'), // sucess/error, message
            530=>array('SUC','Your account has been activated. Please login to continue'), // sucess/error, message
	),

	// Messages  for file image upload Module
	'IMG_UPLOAD'=>array(
        
	    500100=>array('ERR','Image has been uploaded'), // Successfully uploaded!
	    500101=>array('ERR','Error occurred in the Server. Please contact Administrator'), // Uploded file size not valid with server configurations
	    500102=>array('ERR','Maximum Image size is exeeded. Please upload an image lesser than {%MAX_SIZE%}'), // MAX_FILE_SIZE Exeeded
	    500103=>array('ERR','Error occurred. Please retry.'), // Was only partially uploaded
	    500104=>array('ERR','Error occurred. Please retry.'), // File was not uploade

	    500405=>array('ERR','Uploaded File already exists'), // File already exists
	    500406=>array('ERR','Uploaded file type not allowed. Please upload JPG or GIF image'), // File type not allowed

	),


	
	'SEARCH'=>array( 
	    'NOARG'=>array('ERR','no_argument'), // sucess/error, message
	
	),


'USER'=>array( // User  Section
   'BLANK'=>array('ERR','Please fill all the Fields'), // sucess/error, message
   'EMAIL'=>array('ERR','Email address is not valid. Please insert a correct email address'), // sucess/error, message
   'PW_BLANK'=>array('ERR', 'Password is Required'),
    'VPW_BLANK'=>array('ERR', 'Verify the password'),
   'CONFIRM_PWORD'=>array('ERR','The password and the confirmation password do not match. Please type the same password in both boxes.'), // sucess/error, message
   'PW_MIN'=>array('ERR', 'The Password should be Minimum 6 Characters'),
   'EXIST'=>array('ERR','User already exists'), // sucess/error, message
   'NOT_EXIST'=>array('ERR','Current Password is invalid'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'DELETE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'CHANGE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_CHANGE'=>array('ERR','Error occured. Please try again!'), // sucess/error, message
    'FNAME_CHAR'=>array('ERR', 'First Name should only contain letters'),
    'LNAME_CHAR'=>array('ERR', 'Last Name should only contain letters'),
),

'SPECIFICATION'=>array( // Specification  Section
   'BLANK'=>array('ERR','Please fill out all required Fields Marked *'), // sucess/error, message
   'NOT_NUMERIC'=>array('ERR','Average Price should be a Numeric value'), // sucess/error, message
   'EXIST'=>array('ERR','Specification already used'), // sucess/error, message
   'NOT_EXIST_SPEC'=>array('ERR','There are no Specifications in the selected subcategory'), // sucess/error, message
   'NOT_EXIST_CAT'=>array('ERR','Subcategories not found in the selected category'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'DELETE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'CHANGE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'EXIST_LISTINGS'=>array('ERR','Listings are available'), // sucess/error, message
   'EXIST_LISTINGS_SPEC'=>array('ERR','You cannot edit more information, because Listings are available'), // sucess/error, message
   'SELECT'=>array('ERR','Please select a subcategory.'), // sucess/error, message
   'CANNOT_ADD'=>array('ERR','You cannot Add Specifications to Classified Ads.'), // sucess/error, message
   'MANUFACT_NEED'=>array('ERR','Please select at least one Manufacturer to proceed.'), // sucess/error, message

     // added by saliya---------->
    'PENDING'=>array('ERR', 'This Specification has been already requested and Pending for the approval.'),

    'DELETED'=>array('ERR', 'This Specification has been Deleted by the Administrator. Please do the request by an email'),
    'REJECTED'=>array('ERR', 'This Specification has been already Requested and Rejected by the Administrator. Please Re request by an email'),

    'DELETED_ADMIN'=>array('ERR', 'This Specification has been Deleted before. Please Activete it from the Deleted Specification List'),
    'REJECTED_ADMIN'=>array('ERR', 'This Specification has been Rejected before. Please Activete it from the Rejected Specification List'),
    'NO_RESULTS'=>array('ERR', 'No Results Founds'),
),

'LISTING'=>array( // Listing  Section
   'BLANK'=>array('ERR','Please fill the required Fields'), // sucess/error, message
   'NOT_NUMERIC'=>array('ERR','Please enter Numeric values'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Record is not updated!'), // sucess/error, message
   'DELETE'=>array('SUC','Selected listings are deleted successfully'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Listings are not deleted!'), // sucess/error, message
   'CHANGE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_GREATER'=>array('ERR','Bulk Price should be less than Unit Cost'), // sucess/error, message
   'FILL_BULKDISCOUNT'=>array('ERR','You should select a Bulk Discount!'), // sucess/error, message
   'SELECT_ITEMS'=>array('ERR','Please select the listings to delete'), // sucess/error, message
   'NOT_EXIST_SPEC'=>array('ERR','There are no Specifications in the selected subcategory'), // sucess/error, message
   'ALREADY_ADDED'=>array('ERR','Listing already exists'), // sucess/error, message
   'CLEAR'=>array('SUC','Selected Items cleared Successfully '), // sucess/error, message
   'QUOTA_EXCEED'=>array('SUC','Your Quotation is Exceeded. Cannot add all Listings.'), // sucess/error, message
   'NOT_EXIST_CAT'=>array('ERR','Subcategories not found in the selected category'), // sucess/error, message
   'REASON_EMPTY'=>array('ERR','Please provide the reason to Deactivate'),
   'NOT_DELETED'=>array('ERR','Deactivation failed.  Please try later'),
   'NOT_RESTORED'=>array('ERR','Activation failed.  Please try later'),
   'SELECT'=>array('ERR','Please select a subcategory.'), // sucess/error, message
),

'GLOBAL_CONFIG'=>array( // Global Configuration Section
   'EMAIL'=>array('ERR','Email address is not valid. Please insert correct email address'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'DELETE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'NOT_GREATER'=>array('ERR','Bulk Max should be greater than Bulk Difference'), // sucess/error, message
   'FILL_BULKDISCOUNT'=>array('ERR','You should fill Bulk Difference!'), // sucess/error, message
   'NOT_NUMERIC'=>array('ERR','Please enter Numeric values'), // sucess/error, message
   'BLANK'=>array('ERR','Please fill all the Fields'), // sucess/error, message
   'SHOULD_LESS'=>array('ERR','Classified Ads Percentage should be less the 100'), // sucess/error, messag
),



'PAGE'=>array( // Page  Section
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Page is not updated!'), // sucess/error, message
   'SELECT_PAGE'=>array('ERR','Please select a page to edit!'), // sucess/error, message
),

'CONTACT_US'=>array( // Contact Us  Section
   'BLANK'=>array('ERR','Please fill out all required Fields Marked *'), // sucess/error, message
   'SEND_EMAIL'=>array('SUC','Thank you for contacting DIY Price Check. We will respond to you as soon as possible.'), // sucess/error, message
   'NOT_SEND_EMAIL'=>array('ERR','Your information has not been sent.'), // sucess/error, message
   'EMAIL'=>array('ERR','Email address is not valid. Please insert a correct email address!'), // sucess/error, message
   'INVALID_PHONE'=>array('ERR','The Phone Number is Invalid'), // sucess/error, message
   'INVALID_LENGTH'=>array('ERR','Phone Number should be a Valid Length'), // sucess/error, message
),

'CUSTOMER'=>array(
	'FNAME_BLANK'=>array('ERR', 'First Name cannot be blank'),
        'FNAME_CHAR'=>array('ERR', 'First Name should only contain letters'),
	'LNAME_BLANK'=>array('ERR', 'Last Name cannot be blank'),
        'LNAME_CHAR'=>array('ERR', 'Last Name should only contain letters'),
	'CUS_EXISTS'=>array('ERR', 'Email already in use '),
	'EMAIL_BLANK'=>array('ERR', 'Email cannot be blank'),
	'EMAIL_NOT_VALID'=>array('ERR', 'Invalid Email Address'),
        'CON_EMAIL_BLANK'=>array('ERR', 'Confirm Email cannot be blank'),
	'CON_EMAIL_NOT_VALID'=>array('ERR', 'Invalid Confirm Email Address'),
	'EMAIL_NOTMATCH'=>array('ERR', 'Please confirm your Email correctly'),
	'PW_BLANK'=>array('ERR', 'Password cannot be blank'),
        'CPW_BLANK'=>array('ERR', 'Confirm Password cannot be blank'),
	'PW_MIN'=>array('ERR', 'Password should be at least 6 characters long'),
        'PW_MIN'=>array('ERR', 'Password should be at least 6 characters long'),
	'PW_NOTMATCH'=>array('ERR', 'The password and the confirmation password do not match. Please type the same password in both boxes.'),
	'CAPTCHA_NOT_MATCH'=>array('ERR', 'Security code did not match'),
	'COMPANY_BLANK'=>array('ERR', 'Company cannot be blank'),
	'ADDRESS_BLANK'=>array('ERR', 'Address cannot be blank'), 
	'STREET_BLANK'=>array('ERR', 'Street cannot be blank'),
	'CITY_BLANK'=>array('ERR', 'City cannot be blank'),
        'POSTCODE_BLANK'=>array('ERR', 'Postcode cannot be blank'),
        'POSTCODE_INVALID'=>array('ERR', 'Postcode not valid'),
	'COUNTRY_BLANK'=>array('ERR', 'Country cannot be blank'),
	'PHONE_BLANK'=>array('ERR', 'Phone cannot be blank'),
	'PHONE_NOT_NUMERIC'=>array('ERR', 'Phone number not valid'),
	'PHONE_MIN'=>array('ERR', 'Phone number should be at least 8 characters long'), 
        'MOBILE_NOT_NUMERIC'=>array('ERR', 'Mobile number not valid'),
	'MOBILE_MIN'=>array('ERR', 'Mobile number should be at least 8 characters long'),
        'FAX_NOT_NUMERIC'=>array('ERR', 'Fax number not valid'),
	'FAX_MIN'=>array('ERR', 'Fax number should be at least 8 characters long'),
	'DONE_SUPPLIER'=>array('SUC','Supplier registered successfully'),
	'DONE_BUYER'=>array('SUC','Buyer registered successfully'),
	'NOT_ADDED'=>array('ERR','An Error occurred during the Process'),
	'CUS_NOT_EXISTS'=>array('ERR','Email address is blank or email not exists'),
	'PASSWORD_CHANGED'=>array('SUC','Password has been changed successfully and new Password sent to your email'),
	'NO_MATCHES'=>array('ERR', 'No matches found'),
	'CUSTOMER_DELETED'=>array('SUC', 'Customer has been deleted'),
	'CUSTOMER_NOT_DELETED'=>array('ERR', 'Error occured, Please try again'),
	'FILL_ALL'=>array('ERR', 'Fill all the required fields'),
	'CONTACT_UPDATED'=>array('SUC', 'Contact details updated successfully'),
	'PERSONAL_UPDATED'=>array('SUC', 'Personal details updated successfully' ), 
	'ADDRESS_UPDATED'=>array('SUC', 'Address details updated successfully' ), 
        'BUSINESS_UPDATED'=>array('SUC', 'Business details updated successfully' ), 
	'WRONG_PASSWORD'=>array('ERR', 'Current password is invalid'),  
	'CUS_ACTIVATED'=>array('SUC', "Customer Activated"), 
	'CUS_REJECTED'=>array('SUC', "Customer Rejected"),
        'BLANK'=>array('ERR', 'Please fill all the required Fields'),
        'NO_RESULT'=>array('ERR', 'No results available under selected category'),
        'SUB_CAT_NOT_SELECTED'=>array('ERR', 'Please select a sub-category'),
        'DONE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
        'ALREADY_ACTIVATED'=>array('ERR', 'This account has been already activated'),
        'DONE_REGISTER'=>array('SUC', 'Registration completed succesfully'),
        'INVALID_VERIFICATION_CODE'=>array('ERR', 'You entered an invalid account verification code'),
        'TIME_EXPIRED'=>array('ERR', 'The verification code has been expired. Click the reset verification link to receive a new verification code'),
        'EMAIL_SUBSCRIPTIONS_UPDATED'=>array('SUC', 'Email subscriptions has been updated successfully'),
        'VERIFYCODE_CHANGED'=>array('SUC', 'Security code has been changed. Please check your email.'),
), 	   
	
'CATEGORY'=>array( // Category  Section
   	'BLANK'=>array('ERR','Please Fill out All Required Fields Marked *'), // sucess/error, message
   	//'DONE'=>array('SUC','New Category Added Successfully.'), 
        'ADDED'=>array('SUC','New Category Added Successfully.'),
        'DONE'=>array('SUC','Request sent for Administrators Approval.'),
   	'EXIST'=>array('ERR','Category Already Exist.'), 
   	'NOT_ADDED'=>array('ERR','Error occured, Please try again!'),
   	'EDITED'=>array('SUC','Process Completed Successfully.'),
	'NOT_EDITED'=>array('ERR','Category is not updated'),
	'SUB_EXIST'=>array('ERR','Category is not deleted, Sub Category Exist.'),
	'SPEC_EXIST'=>array('ERR','Category is not deleted, Specifications Exist.'),
	'DELETE'=>array('SUC','Category deleted successfully.'),
	'NOT_DELETE'=>array('ERR','Error occured, Please try again!'),
	'CANNOT_ADD'=>array('ERR','Cannot add Subcategories for the selected level.'),
	'NOT_EXIST_CAT'=>array('ERR','Subcategories not found in the selected category'), // sucess/error, message
	'NOT_UPLOADED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
	'UPLOADED'=>array('SUC','Successfully Uploaded!'), // sucess/error, message
    'NO_RESULTS'=>array('ERR', 'No Results Founds'),
        // added by saliya---------->
    'PENDING'=>array('ERR', 'This Category has been already requested and Pending for the approval.'),

    'DELETED'=>array('ERR', 'This Category has been Deleted by the Administrator. Please do the request by an email'),
    'REJECTED'=>array('ERR', 'This Category has been already Requested and Rejected by the Administrator. Please Re request by an email'),

    'DELETED_ADMIN'=>array('ERR', 'This Category has been Deleted before. Please Activete it from the Deleted Category List'),
    'REJECTED_ADMIN'=>array('ERR', 'This Category has been Rejected before. Please Activete it from the Rejected Category List'),


    ''=>array('ERR', 'No Results Founds'),

),

'MANUFACTURER'=>array( // Manufacturer  Section
   'BLANK'=>array('ERR','Please fill the required Field'), // sucess/error, message
   'EXIST'=>array('ERR','Manufacturer is already exists'), // sucess/error, message
   'EXIST_REC'=>array('ERR','Record already exists'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully!'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Record is not updated!'), // sucess/error, message
   'DELETE'=>array('SUC','Process Completed Successfully!'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Record is not deleted!'), // sucess/error, message
   'EXIST_LISTINGS'=>array('ERR','Listings are available'), // sucess/error, message
   'SELECT'=>array('ERR','Please select a specificaion.'), // sucess/error, message
   'EXIST_SPEC'=>array('ERR','Manufacturer is already exists for the selected specificaion'), // sucess/error, message
   'CANT_MERGE'=>array('ERR','Cannot Merge! Same Listing is available for the same supplier'), // sucess/error, message
),

'ORDER'=>array(
	'ORDER_DELETED'=>array('SUC', 'Order Deleted Successfully'), 
	'ORDER_NOT_DELETED'=>array('ERR', 'Order Deletion Failed'),
	'NO_MATCHES'=>array('ERR', 'No Matches Found'),
	'FORCE_UPDATED'=>array('SUC', 'Order has been Updated. Please search the confirmed order list bellow.'),
	'FORCE_UPDATE_FAILED'=>array('ERR', 'Error occured while processing. Please check values and resubmit'),
	'NOT_REFUNDED'=>array('ERR', 'Error occured while processing. Please check values and resubmit'),
	'ORDER_NOT_FOUND'=>array('ERR', 'Specified Order could not be found. Please check the values and resubmit'),
    'DONE'=>array('SUC','Process Completed Successfully!'), // sucess/error, message
    'REFUND_AMOUNT'=>array('SUC','Amount to be refunded should be less than the order total (exc. VAT)'), // sucess/error, message

), 

'CLASSIFIED_ADS'=>array( // Classified Ads Section
   'BLANK'=>array('ERR','Please fill all the required Fields'), // sucess/error, message
   'DONE'=>array('SUC','Process Completed Successfully!'), // sucess/error, message
   'NOT_ADDED'=>array('ERR','Error occured, Please try again!'), // sucess/error, message
   'UPDATE'=>array('SUC','Process Completed Successfully'), // sucess/error, message
   'NOT_UPDATE'=>array('ERR','Record is not updated!'), // sucess/error, message
   'DELETE'=>array('SUC','Process Completed Successfully!'), // sucess/error, message
   'NOT_DELETE'=>array('ERR','Record is not deleted!'), // sucess/error, message
   'NOT_NUMERIC'=>array('ERR','Price should be a Numeric value'), // sucess/error, message
   'NOT_EXIST_ADS'=>array('ERR','There are no Classified Ads in the selected category'), // sucess/error, message
   'REASON_EMPTY'=>array('ERR','Reason can not be empty'),
   'NOT_DELETED'=>array('ERR','Deactivation failed.  Please try later'),
   'NOT_RESTORED'=>array('ERR','Activation failed.  Please try later'),
),

'SERVICES'=>array( // service section
     'BLANK'=>array('ERR','Please fill all the required Fields'),
     'DONE'=>array('SUC','Process Completed Successfully!'),
     'PRICE_NOT_NUMERIC'=>array('ERR','Price should be a numeric value'),
     'CALL_CHARGE_NOT_NUMERIC'=>array('ERR','Call charge should be a numeric value'),
     'WRONG_URL'=>array('ERR','Invalid Website Address'),
     'SERVICE_EXISTS'=>array('ERR','Service already exists'),
     'NOT_ADDED'=>array('ERR','Fatal Error. Please try later'),
     'UPDATED'=>array('SUC','Update Completed Successfully!'),
     'NOT_UPDATED'=>array('ERR','Error occured, Please try again'),
     'REASON_EMPTY'=>array('ERR','Reason can not be empty'),
     'NOT_DELETED'=>array('ERR','Deactivation failed.  Please try later'),
     'NOT_RESTORED'=>array('ERR','Activation failed.  Please try later'),
),

'WISHLIST'=>array( // wishlist section
     'BLANK'=>array('ERR','Please fill the quantity'),
     'DONE'=>array('SUC','Selected items are added to the Wish List Successfully!'),
     'NOT_NUMERIC'=>array('ERR','Quantity should be a numeric value'),
     'NOT_ADDED'=>array('ERR','Error occured, Please try again!'),
     'UPDATED'=>array('SUC','Updated  Successfully!'),
     'NOT_UPDATED'=>array('ERR','Error occured, Please try again!'),
     'SELECT'=>array('ERR','Please select the products'),
     'NOT_DELETE'=>array('ERR','Error occured, Please try again!'),
     'DELETE'=>array('SUC','Record deleted successfully!'),
     'NO_WISHLIST'=>array('ERR','No items in wish list, search to add items!'),
),

'QUOTATIONS'=>array( // quotation section
     'TITLE_EMPTY'=>array('ERR', 'Title cannot be empty'),
     'ERROR'=>array('ERR','Error occured, Please try again!'),
     'DONE'=>array('SUC','Process Completed Successfully!'),
     'BLANK'=>array('ERR','Please fill the quantity'),
     'NOT_UPDATED'=>array('ERR','Error occured, Please try again'),
     'WRNG_DATE'=>array('ERR','Valid To date cannot be less than Valid From date'),
     'QUOTE_RE_CREATED'=>array('SUC','Quotation has been Recreated Successfully. Please Visit the Wish List to add new Items to New Quotation.'),
),

'PAYMENT'=>array( // payment section
     'ERROR'=>array('ERR','Error occured, Please try again!'),
     'DONE'=>array('SUC','Process Completed Successfully!'),
     'BLANK'=>array('ERR','Required field has been missed. Please check and retry.'),
     'QUOTE_RE_CREATED'=>array('SUC','Quotation has been Recreated Successfully. Please Visit the Wish List to add new Items to New Quotation.'),
),

/*
 * Follwoing messages are common messages to show in the various section within the system
 */
'COMMON'=>array( // wishlist section
     'IMAGE_PRE_UPLOAD'=>'* The image file should be in <strong>JPEG</strong> or <strong>GIF</strong> format and size should be less than <strong>{%MAX_SIZE%}</strong>',
),

);

?>
