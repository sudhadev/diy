<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of fusis login module                                '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  process.inc.php                                     '
  '    PURPOSE         :  processing page for the login                       '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :  $uid,$pw                                            '
  '--------------------------------------------------------------------------*/
    require_once ('../../classes/core/core.class.php');$objCore=new Core;

    require_once($objCore->_SYS['PATH']['SESS']);
    $objSession = new Session;
    $objSession->config=$objCore->_SYS['LCONF'];

    require_once($objCore->_SYS['PATH']['CLASS_EXPIRING_ITEMS']);
    if(!is_object($objExpiringItems)) $objExpiringItems = new ExpiringItems();

	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    if(!is_object($objCustomer)) $objCustomer = new Customer();

    //----------------------------------------------------------------------
      $errFlag=true;

      if($_REQUEST['slky'])
      {
            $accData=$objExpiringItems->getByAccessCode($_REQUEST['slky']); 
         
            if($accData['Ack']=='Ok')
            {
          
                // now we can get the user details from the database
                $cusData=$objCustomer->dList("WHERE customer_id='".$accData['CusId']."'");
              

                if($cusData[0][3]==$_REQUEST['email']){
                    // now we know that this user is exactly correct user
                       $errFlag=false;
                       $sessKey=$objSession->key();

                       // prepare the url for after login
                          if($accData['Subscript']=='C')
                          {
                              // we should take the specific classified advertiesement
                                 require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
                                 if(!is_object($objClassifiedAd)) $objClassifiedAd = new ClassifiedAd($objCore->gConf);
                   
                                 $adData=$objClassifiedAd->dList(" WHERE id='".$accData['SubscriptID']."'");    
                                 //
                              $urlEmbed="&auth=".$accData['CusId']."&classifiedPayment=".$adData[0][8]."&imgKey=".$adData[0][9]."&num=".$adData[0][11];
                          }
                          else
                          {
                             // packages <-- the variable to be passed
                                require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
                                $objCustomer = new Customer();

                                $csData = $objCustomer->getStatus($accData['CusId']);
                                for($cs=0;$cs<count($csData);$cs++)
                                {
                                    if($csData[$cs][2]==$accData['Subscript'])
                                    {
                                        $freez=$cs;
                                        break;
                                    }
                                }
                                
                                // get current package information
                                   
                                   $package=$csData[$cs][3];
                                   if($accData['Subscript']=="M") $package.="||".$csData[$cs][7];
                                   $urlEmbed="&packages=$package";


                             
                          }
                          $lfrom=$objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/payments/?listing=&selections=".$accData['Subscript'].$urlEmbed;
                          $objSession->config['LOGIN'][1]['LOGGED_IN_URL']=$lfrom;

                          // update the access code prevent unauthorised access
                          $objExpiringItems->updateAfterAccess($_REQUEST['slky'], $accData['CusId']);
//                          echo $lfrom;
//                          echo "<br/><br/>".__LINE__."<----- exit code";
//                          exit;
                          $objSession->register($sessKey, 1, $cusData[0][6], ",'".$cusData[0][1]."','".$cusData[0][2]."','".$cusData[0][0]."'", $lfrom, $custom_vars);
                }
               

                
            } // end sucess code
            
            
           // echo "<pre>";print_r($cusData);echo "</pre>";
      } // end check access key

      
      if($errFlag)
      {
          $url=$objCore->_SYS['CONF']['URL_FRONT'].'errors/?err=812&'.$objCore->curSection();
          header ("Location: $url");
      }







// if(!isset($_REQUEST['cusr']))$_REQUEST['cusr']=1;//print_r($objCore->_SYS['LCONF']['LOGIN'][$_REQUEST['cusr']]['ERROR_URL']);
//
//    if($_REQUEST['logout']=='y')
//    {
//        $objSession->logout($_REQUEST['cusr'],$_REQUEST['key'],$objCore->_SYS['LCONF']['LOGIN'][$_REQUEST['cusr']]['ERROR_URL'],$_REQUEST['bloc']);
//    }
//    else
//    {
//       $objSession->login($_REQUEST['uid'],$_REQUEST['pass'],$_REQUEST['cusr'],$_REQUEST['key'],$_LCONF['LOGIN'][$_REQUEST['cusr']]['ERROR_URL'],$_REQUEST['lfrom'][1]);
//    }
//


?>