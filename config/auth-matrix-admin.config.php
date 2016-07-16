<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  auth-matrix-admin.config.php                                  '
  '    PURPOSE         :  containing all the file names                       '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


$_AUTH_M_ADMIN=array(

/*
 *  Previlage settings for all the major sections
 */
'category'                      =>array(0=>true,    1=>true),// Main section after login
'classified_ads'                =>array(0=>true,    1=>true), // classified ads
'cms'                           =>array(0=>true,    1=>true), // content management section
'customers'                     =>array(0=>true,    1=>true), // customer management
'global_config'                 =>array(0=>true,    1=>false), // global configuration
'listing'                       =>array(0=>true,    1=>true),   // customer listing management
    'cus_listings'                       =>array(0=>true,    1=>true),   // customer listing management
'manufacturers'                 =>array(0=>true,    1=>true), // manufacturer management
'revenue'                       =>array(0=>true,    '1'=>false), // revanue reports
'specifications'                =>array(0=>true,    1=>true), // specification management
'users'                         =>array(0=>true,    '1'=>false), // user management
'login'                         =>array(0=>true,    1=>true, ''=>true),  // Login Section

'ajax'                          =>array(0=>true,    1=>true), // specification management
'bin'                          =>array(0=>true,    1=>true), // specification management
'help'                          =>array(0=>true,    1=>true), // specification management
'my_profile'                    =>array(0=>true,    1=>true), // specification management
'blog'                           =>array(0=>true,    1=>true), // blog section

);

?>
