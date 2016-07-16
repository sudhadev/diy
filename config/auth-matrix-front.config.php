<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  auth-matrix-front.config.php                                  '
  '    PURPOSE         :  containing all the file names                       '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


$_AUTH_M_FRONT=array(

/*
 *  Previlage settings for all the major sections
 */
'my_account'                    =>array('B'=>true, 'S'=>true),// Main section after login
'my_profile'                    =>array('B'=>true, 'S'=>true), // Profile Editing
'my_subscriptions'               =>array('B'=>false, 'S'=>true), // Subscriptions of Suppliers
'my_orders'                     =>array('B'=>false, 'S'=>true), // Order History
'my_schedules'                   =>array('B'=>false, 'S'=>true), // Order History
    'change_password'               =>array('B'=>true, 'S'=>true), // Change the password
 // -----------------
'wish_list'                     =>array('B'=>true, 'S'=>true),   // Wish List
'my_quotations'                 =>array('B'=>true, 'S'=>false), // Quotation Section
 // -----------------
'new_listings'                  =>array('B'=>false, 'S'=>true), // Add new Listings
'my_listings'                   =>array('B'=>false, 'S'=>true), // Add My Listings
'my_listings_edit'                   =>array('B'=>false, 'S'=>true), // Edit My Listings
'my_requests'                   =>array('B'=>false, 'S'=>true), // Request Listings
'classified_ads'                =>array('B'=>false, 'S'=>true),// Classified adds
'services'                      =>array('B'=>false, 'S'=>true),
 // -----------------
'payments'                      =>array('B'=>false, 'S'=>true), // Payments
'thanks'                        =>array('B'=>false, 'S'=>true), // Thanks section for payments
 // -----------------
'welcome'                       =>array('B'=>false, 'S'=>true),  // Welcome section in registration
'first_login'                   =>array('B'=>false, 'S'=>true), // Supplier first login after the registration

// ----------------
'image_upload'                     =>array('B'=>true, 'S'=>true),   // Image Upload
  
 // Guest sections --------------------
'browse'                        =>array('B'=>true, 'S'=>true, ''=>true),  // Browse sections
'signup'                        =>array('B'=>true, 'S'=>true, ''=>true),  // Browse sections
'search'                        =>array('B'=>true, 'S'=>true, ''=>true),  // Browse sections
'ajax'                          =>array('B'=>true, 'S'=>true, ''=>true),  // Browse sections
'login'                         =>array('B'=>true, 'S'=>true, ''=>true),  // Login Section
'emails'                        =>array('B'=>true, 'S'=>true, ''=>true),  // Login Section
'blog'							 =>array('B'=>true, 'S'=>true, ''=>true),  // Login Section

 // -------------------
'diy'                      =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in developement enviorenment
'v0.6'                          =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'demo.diypricecheck.co.uk'            =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'www.diypricecheck.com'         =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'diypricecheck.com'             =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'www.diypricecheck.co.uk'       =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'diypricecheck.co.uk'           =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
''                              =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment
'gateway'                       =>array('B'=>true, 'S'=>true, ''=>true),  // Will be useful in demo enviorenment



);

?>