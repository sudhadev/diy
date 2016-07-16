<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of fusis login module                                '
  '    (C) Copyright 2002-2006 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  config.inc.php                                      '
  '    PURPOSE         :  All configurations for login module                 '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  /*
     Warning ====>
     Dont change any of following lines, contact Saliya<saliyasoft@yahoo.com>[+94773505072] for more information
  */
     

  /* ------------------------------------------------------------------------  */
  /*
    NOTE : Following array values are editable
  */
   $_LCONF=array(

      /* Base Class Path*/
   //    'CLASS_BASE'=>'../../config/@shop_____base.class.php',



      /* Logins */
       'LOGIN'=>array(
            /* 0 - you can use this INDEX as the user type -------------------------- */
               0=>array(
                   'USER_TABLE'=>$this->_SYS['CONF']['PREFIX_TBL'].'admin_users',
                   'SESSION_TABLE'=>$this->_SYS['CONF']['PREFIX_TBL'].'admin_user_session',
                   'REQ_FIELDS'=>array('`id`','`uname`','`pword`'),
                   'EXTRA_FIELDS'=>',`fname`,`lname`,`role`',
                   'SESS_KEY_FIELD'=>'s_key',
                   'COOKIE_NAME'=>$this->_SYS['CONF']['COOKIE_CONSOLE_KEY'],  // Name of cookie
                   'COOKIE_URL'=>$this->_SYS['CONF']['COOKIE_CONSOLE_URL'],  // cookie URL for restriction <optional>
                   'LOGIN_URL'=>$this->_SYS['CONF']['URL_CONSOLE'].'/login/index.php', //  Login page for this user
                   'ERROR_URL'=>$this->_SYS['CONF']['URL_CONSOLE'].'/login/index.php', //  On error redirect to
                   'LOGGED_IN_URL'=>$this->_SYS['CONF']['URL_CONSOLE'].'/?', //  Just after login redirect to
                   'SESSION_EXPIRE'=>30, // session will expire if user idle (Minutes)
                   'AJAX'=>'',  // Null or y
                   'NEW_KEY'=>'y',
               ),

            /* 1 - you can use this INDEX as the user type -------------------------- */
               array(
                   'USER_TABLE'=>$this->_SYS['CONF']['PREFIX_TBL'].'customers',
                   'SESSION_TABLE'=>$this->_SYS['CONF']['PREFIX_TBL'].'cus_session',
                   'REQ_FIELDS'=>array('`id`','`email`','`password`'),
                   'EXTRA_FIELDS'=>',`f_name`,`l_name`,customer_id',
                   'SESS_KEY_FIELD'=>'s_key',
                   'COOKIE_NAME'=>$this->_SYS['CONF']['COOKIE_FRONT_KEY'],
                   'COOKIE_URL'=>$this->_SYS['CONF']['COOKIE_CONSOLE_URL'],
                   'LOGIN_URL'=>$lfrom[1], //
                   'ERROR_URL'=>$this->_SYS['CONF']['URL_LOGIN_FRONT'].'/index.php', //  On error redirect to
                   'LOGGED_IN_URL'=>$this->_SYS['CONF']['URL_LOGIN_FRONT'].'/log.php?sess=[%KEY%]', //  Just after login redirect to
                   'AJAX'=>'',  // Null or y
                   'NEW_KEY'=>'y',
               ),



            /* ---------------------------------------------------------------------- */
       ),


      /*
        KEY? This key is never duplicate one and it will be as follow
        KEY = <alfa numeric randome key><timestamp>
        WARNING: field lenght for this key in the db must be equal or more than value configured in here
        AND This length must be greater than 10 ***
      */
      'SESS_KEY_LENGTH'=>18,

      /* Genereal format
         0 = <alfa numeric randome key><timestamp>
         1 = <timestamp><alfa numeric randome key>
         2 = <alfa numeric randome key> <timestamp><alfa numeric randome key>
      */
      'G_FORMAT'=>0,


      /* Alfa numeric key format   [ # - numeric / a - alphabatical char]
         NOTE* - Keep format length as same as to  $keyLength-10
      */
      'ALPHA_FORMAT'=>'#aa#a##a',

   );





?>