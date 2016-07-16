<?php
/* ---------------------------------------------------------------------------
 * PLUGGIN - PAY PAL API
 * Configuration file - Keep all the important configurations
 *
 *
 * Written By Saliya Wijesinghe - Fusis IT
 * [saliya@ymail.com / 0773-505072]
 -----------------------------------------------------------------------------*/

// If you need you can easially get values from a global configuration file and
// Assign bellow as variables or just assign the value as I have done
// NOTEP * Enviorenment is from main configuration

    $HOST=$_SERVER['HTTP_HOST'];$IP_F=explode('.',$HOST);
    if($IP_F[0]=='127'||$IP_F[0]=='172'||$IP_F[0]=='localhost')
    {
        // DEV
         $ppapi=array
             (
                 'Enviorenment'         =>'sandbox',
                 'PathSDK'              =>$this->core->_SYS['CONF']['DIR_MODULES'].'/payments/PP-API/php-sdk',
                 'DefaultCurrency'      =>'GBP',

                 'APIUser'              =>'diy_1291771486_biz_api1.tekmaz.com',
                 'APIPassword'          =>'1291771494',
                 'APISignature'         =>'ArWW3AV7O6j1pGlerqaz2QiQ8YxvAFw1v-664.phQy0591eV360tgevW',

                 'APIUserId'            =>'WQV6FBJ45X9VJ',
                 'APIUserEmail'         =>'diy_1291771486_biz_api1@tekmaz.com',
                 'ECRetrunURL'          => str_replace("http://", "http://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/return_payment.php',
                 'ECCancelURL'          => str_replace("http://", "http://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/cancel_payment.php',

             );
    }
    elseif($HOST=='demo.diypricecheck.co.uk')
    {
        // DEMO
         $ppapi=array
             (
                 'Enviorenment'         =>'sandbox',
                 'PathSDK'              =>$this->core->_SYS['CONF']['DIR_MODULES'].'/payments/PP-API/php-sdk',
                 'DefaultCurrency'      =>'GBP',

                 'APIUser'              =>'diy_1291771486_biz_api1.tekmaz.com',
                 'APIPassword'          =>'1291771494',
                 'APISignature'         =>'ArWW3AV7O6j1pGlerqaz2QiQ8YxvAFw1v-664.phQy0591eV360tgevW',

                 'APIUserId'            =>'WQV6FBJ45X9VJ',
                 'APIUserEmail'         =>'diy_1291771486_biz_api1@tekmaz.com',
             // current demo server has an issue with SSL, once rectified 2nd param should be https://
                 'ECRetrunURL'          => str_replace("http://", "http://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/return_payment.php',
                 'ECCancelURL'          => str_replace("http://", "http://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/cancel_payment.php',


             );
           
    }
    else
    {
        // LIVE
         $ppapi=array
             (
                 'Enviorenment'         =>'live',
                 'PathSDK'              =>$this->core->_SYS['CONF']['DIR_MODULES'].'/payments/PP-API/php-sdk',
                 'DefaultCurrency'      =>'GBP',

                 'APIUser'              =>'jasonbillingham_api1.me.com',
                 'APIPassword'          =>'STNLBHMBFW6CLD64',
                 'APISignature'         =>'AFcWxV21C7fd0v3bYYYRCpSSRl31Aqn5t4apfzI3VYbesQwLL1WaLpqG',

                 'APIUserId'            =>'VCKB7L24JTRLG',
                 'APIUserEmail'         =>'accounts@diypricecheck.com',
                 'ECRetrunURL'          => str_replace("http://", "https://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/return_payment.php',
                 'ECCancelURL'          => str_replace("http://", "https://", $this->core->_SYS['CONF']['URL_MY_ACCOUNT']).'/payments/cancel_payment.php',

             );
    }

//print_r($ppapi);


?>