<?php

require_once("../../classes/core/core.class.php");
$objCore=new Core;

require_once($objCore->_SYS['PATH']['CLASS_FTP_IMG']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
if(!is_object($objCustomer)) {
    $objCustomer = new Customer();
}


$filename = strip_tags($_REQUEST['filename']);
$filesize_image = $_FILES[$filename]['size'];

$fname= $_FILES[$filename]['name'];
$fTmp = $_FILES[$filename]['tmp_name'];

/*
         * image folder is the type of uploading image folder. eg: categories, classified_ads,...etc
*/
$imgFolder = $_REQUEST['imgFolder'];

//$logUser= $objCore->sessCusId;

$where = " WHERE `customer_id`='".$objCore->sessCusId."'";
$cus_list = $objCustomer->dList($where);
$cus_tbl_id = $cus_list[0][6];
$logUser= $cus_tbl_id;

$objftp_img= new ftp_img;
$objftp_img->file= $fname;
$objftp_img->fileTemp= $fTmp;

$objftp_img->thumb_width=100;

/*
     * Handle the message box/ area
*/
$divMessage='error_msg'; // Place for display the image. please override if you need to change this within the switch - Added by Saliya
$widthMessage='100%';


switch($imgFolder) {
    case "cats": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_CATS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_CATS']."/thumbs/";
            $divMessage='divMessage';
            $widthMessage='75%';
        } break
        ;
    case "specs": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_SPECS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_SPECS']."/thumbs/";
            $divMessage='divMessage';
            $widthMessage='75%';
        } break
        ;
    case "cats_request": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_CATS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_CATS']."/thumbs/";
            $widthMessage='98%';
        } break
        ;
   case "specs_request": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_SPECS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_SPECS']."/thumbs/";
            $widthMessage='98%';
        } break
        ;
    case "clas_ads": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_CLAS_ADS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_CLAS_ADS']."/thumbs/";
        } break
        ;

    case "services": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_SERVICES']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_SERVICES']."/thumbs/";
        } break
        ;

    case "quotations": {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_QUOTATIONS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_QUOTATIONS']."/thumbs/";
            $objftp_img->thumb_width=300;
        } break
        ;

    case "listings": {
            $listUser= $_REQUEST['logUser'];
            $baseDir=$objCore->_SYS['CONF']['FTP_LISTINGS']."/".$listUser;
            if(!is_dir($baseDir)) {
                mkdir($baseDir,0750);
                mkdir($baseDir."/large/",0750);
                mkdir($baseDir."/thumbs/",0750);
            }
            $objftp_img->img_dir = $baseDir."/large/";
            $objftp_img->thumb_dir = $baseDir."/thumbs/";
            $objftp_img->thumb_width=300;
           
        } break
        ;

    default: {
            $objftp_img->img_dir = $objCore->_SYS['CONF']['FTP_CATS']."/large/";
            $objftp_img->thumb_dir = $objCore->_SYS['CONF']['FTP_CATS']."/thumbs/";
        }break
        ;
}


$objftp_img->replace="y";
$objftp_img->extensions=array('.jpeg','.jpg','.gif');
$objftp_img->thumb='y';
$objftp_img->maxSize=$objCore->_SYS['CONF']['F_SIZE']['IMAGE']*1024;
//$objftp_img->ren_file_to=$renTo=time().'_'.key_img().$_REQUEST['extraKey'];
$objftp_img->ren_file_to=$renTo = $logUser.'_'.time().'_'.key_img();
$objftp_img->imgExt = $objftp_img->get_extension($fname);
$objftp_img->img_upload();




$errNumber=$objftp_img->show_error_string();
if($errNumber) {
    $msg=array('ERR',$errNumber);

    $msgText=str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['IMG_UPLOAD'][$msg[1]][1]);
    //echo "<span style='color:#FF0000'>Image is not Uploaded!d"."</span>";
    $msgBox=addslashes(str_replace("\n","",$objCore->msgBox("IMG_UPLOAD",$msg,$widthMessage,1,$msgText)));
    echo "<script>window.parent.showMsg('$divMessage','$msgBox');</script>";
} else {
    echo "<script>window.parent.showMsg('$divMessage','<input type=\"hidden\" id=\"imgUploaded\" value=\"y\" />');window.parent.hideZoom();</script>";
    $imageName=$renTo.''.$objftp_img->imgExt;
    //chmod($objftp_img->img_dir.$imageName,755);
   // chmod($objftp_img->thumb_dir.$imageName,755);
    switch($imgFolder) {
        case "cats": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_CATS']."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;        
        case "specs": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_SPECS']."/thumbs/".$imageName.'" border="0" width="65"/>';
                //echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_SPECS']."/large/".$imageName.'" border="0" width="65"/>';
            } break
            ;
        case "cats_request": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_CATS']."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;
        case "specs_request": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_SPECS']."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;
            
        case "clas_ads": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;

        case "services": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_SERVICES']."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;

        case "quotations": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_QUOTATIONS']."/thumbs/".$imageName.'" border="0" width="300"/>';
            } break
            ;

        case "listings": {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_LISTINGS']."/".$listUser."/thumbs/".$imageName.'" border="0" width="65"/>';
            } break
            ;
        default: {
                echo '<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_CATS']."/thumbs/".$imageName.'" border="1" width="65"/>';
            }break
            ;
    }
}

function key_img() {
    /**
     * declare the $key variable
     */
    $key = "";

    /**
     * generate session's key
     */
    $letters = range("a","z");
    $alphaTxt="aaa##a#aa";
    for($i = 0; $i < 9; $i++) {
        if($alphaTxt[$i]=="#") {
            $key .= rand(0,9);
        }else {
            $key .= $letters[rand(0,25)];
        }
    }
    return $key;
}

?>
<?php if($imageName) {?>
<script language="Javascript" type="text/javascript">
    window.parent.passImgKey('<?php echo $imageName;?>');
</script>
    <?php }?>


