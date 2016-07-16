<?
  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  delete.ajax.php                                          '
  '    PURPOSE         :                          '
  '    PRE CONDITION   :  param image id & customer id                                       '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

    require_once("../../classes/core/core.class.php");$objCore=new Core;
	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
    $objSql=new Sql();
    /*
     * We need following parameters to proceed
     */
        $use= $_REQUEST['use'];if(!$use) $use=1;
        $imgFolder=$_REQUEST['section'];
        $imageName=$_REQUEST['image'];
        $imageOwner=$_REQUEST['safeKey'];

    if($use && $imgFolder && $imageName && $imageOwner)
    {
        // we need to make sure that the correct person is deleting the images
            $cookie='';$reqSql="";
           if($use==1)
           { // Front User
               $cookie=$_COOKIE[$objCore->_SYS['CONF']['COOKIE_FRONT_KEY']];
               $reqSql="SELECT customer_id FROM `".$objCore->_SYS['CONF']['PREFIX_TBL']."cus_session` WHERE s_key='".$cookie."'";
               $reqResult=$objSql->query($reqSql);
               $loggedUser=$reqResult[0]['customer_id'];
           }
           elseif($use==0)
           { // Admin User 
               $cookie=$_COOKIE[$objCore->_SYS['CONF']['COOKIE_CONSOLE_KEY']];
               $reqSql="SELECT uid FROM `".$objCore->_SYS['CONF']['PREFIX_TBL']."admin_user_session` WHERE s_key='".$cookie."'";
               $reqResult=$objSql->query($reqSql);
               $loggedUser=$reqResult[0]['uid'];
           }

        // image deletion can be done by only loggedin users
        if($loggedUser)
        {
            // We need the exact image folder path
            switch($imgFolder)
            {
                case "categ":
                case "cats_request":
                    {
                        $ftploc='FTP_CATS';
                        $httploc='URL_IMAGES_CATS';
                    }
                    break;
                case "clas_ads":
                     {
                         $ftploc='FTP_CLAS_ADS';
                         $httploc='URL_IMAGES_CLAS_ADS';

                     }
                    break;
                case "services":
                     {
                         $ftploc='FTP_SERVICES';
                         $httploc='URL_IMAGES_SERVICES';

                     }
                    break;

                case "quotations":
                     {
                         $ftploc='FTP_QUOTATIONS';
                         $httploc='URL_IMAGES_QUOTATIONS';

                     }
                    break;
                case "specs":
                    {/* add by Maduranga - for image delete issue*/
                         $ftploc='FTP_SPECS';
                         $httploc='URL_IMAGES_SPECS';
                    }
            }// end the switch

               $folder = $objCore->_SYS['CONF'][$ftploc];
               $frontUrl = $objCore->_SYS['CONF'][$httploc];

            // Now we know the exact image paths
               if($folder)
               {
                    $imageToDelete=$folder."/large/".$imageName;
                    $thumbToDelete=$folder."/thumbs/".$imageName;
                    $noImageUrl=$frontUrl."/thumbs/no_image.jpg";
               }



///echo "//".$imageToDelete."\\";
            // we have to check whether the file exist or not
            // we assume that if large image available, the thumbnail also available vise versa
               if(is_file($imageToDelete))
               {
                    if(unlink($imageToDelete))
                    {
                        unlink($thumbToDelete);
                        // MESSAGE: Success Message to be displayed
                        echo 'DONE||<img width="65" src="'.$noImageUrl.'" alt="" style="margin-bottom:8px;"/>';
                    }
                    else
                    {
                        echo 'ERROR';
                    }
               }
               else
               {
                   // MESSAGE: Image not available or already deleted
                   echo 'NOT_EXIST';
               }
        }
        else
        {
            // requester not logged in
            echo 'NOT_A_USER';
        }
    }
    else
    {  // missed one of essencial data
        echo "BLANK";
    }

// add delemeter at the end
   echo '||';

?>