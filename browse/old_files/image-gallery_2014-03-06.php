<?php 

require_once("../classes/core/core.class.php");

$objCore=new Core;

require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
require_once($objCore->_SYS['PATH']['CLASS_FTP']);
require_once($objCore->_SYS['PATH']['CLASS_FTP_IMG']);     
  
	$objftp_img = new ftp_img;
        
         $ftploc='';
         $httploc='';
       
        if (!is_object($objCategory))
        {
            $objCategory = new Category();
        }
        
 	$catid = $_GET['catid'];
        //echo $catid;
        
        if($catid=='1'){
            $com = 'listing';
             $ftploc='FTP_LISTINGS';
             $httploc='URL_IMAGES_LISTINGS';
             require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
             
             if(!is_object($objListing)) 
                 $objListing=new Listing();
             $cusId = '/'.$_REQUEST['cid'];   
             $lid = $_REQUEST['lid'];
             $where = " WHERE `id` = ".$lid."";
             $list = $objListing->dList($where);
             $list_spec = $objListing->dList_spec(" WHERE `id` = ".$list[0][4]."");
             if($list[0][14]==""){
             $ftploc='FTP_SPECS';
             $httploc='URL_IMAGES_SPECS';
             }
             //echo $list[0][23];
             $image_arrays_raw = array(0=>$list[0][14],1=>$list[0][22],2=>$list[0][23],3=>$list[0][24]);
        }
         elseif($catid=='2'){
             $com = 'services';
             require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);  
             
             if (!is_object($objService))
                {
                $objService = new Service;
                }
             $cusId = '';   
             $ftploc='FTP_SERVICES';
             $httploc='URL_IMAGES_SERVICES';

             $lid = $_REQUEST['lid'];
             $where = " WHERE `id` = ".$lid."";
             $list = $objService->dList($where);
             
             $image_arrays_raw = array(0=>$list[0][8],1=>$list[0][14],2=>$list[0][15],3=>$list[0][16]);
         }
          elseif($catid=='3'){
              $com = 'clas_ads';
                require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
                
                $ftploc='FTP_CLAS_ADS';
                $httploc='URL_IMAGES_CLAS_ADS';  
                   
                if (!is_object($objClassified))
                {
                    $objClassified = new ClassifiedAd($objCore->gConf);
                }
                $cusId = '';
                $lid = $_REQUEST['lid'];
                $where = " WHERE `id` = ".$lid."";
                $list = $objClassified->dList($where);
 
                $image_arrays_raw = array(0=>$list[0][9],1=>$list[0][20],2=>$list[0][21],3=>$list[0][22]);
                
          }         
               $image_arrays = array();
               foreach($image_arrays_raw as $images){
                   if($images=="no_image.jpg"||$images==""){
                       
                   }
                   else{
                       array_push($image_arrays, $images);
                   }
               }
                
               
                
                if($image_arrays[0]!='no_image.jpg'||$image_arrays[0]!=''){
                    $thumb_imgUrl = $objCategory->image($image_arrays[0],$objCore->_SYS['CONF'][$ftploc].$cusId,$objCore->_SYS['CONF'][$httploc].$cusId);
                    $fnameFTP = $objCore->_SYS['CONF'][$ftploc].$cusId."/large/".$image_arrays[0];
                }
                if($image_arrays[1]!='no_image.jpg'||$image_arrays[1]!=''){
                    $thumb_imgUrl1 = $objCategory->image($image_arrays[1],$objCore->_SYS['CONF'][$ftploc].$cusId,$objCore->_SYS['CONF'][$httploc].$cusId);
                    $fnameFTP1 = $objCore->_SYS['CONF'][$ftploc].$cusId."/large/".$image_arrays[1];
                }
                if($image_arrays[2]!='no_image.jpg'||$image_arrays[2]!=''){
                    $thumb_imgUrl2 = $objCategory->image($image_arrays[2],$objCore->_SYS['CONF'][$ftploc].$cusId,$objCore->_SYS['CONF'][$httploc].$cusId);
                    $fnameFTP2 = $objCore->_SYS['CONF'][$ftploc].$cusId."/large/".$image_arrays[2];
                }
                if($image_arrays[3]!='no_image.jpg'||$image_arrays[3]!=''){
                    $thumb_imgUrl3 = $objCategory->image($image_arrays[3],$objCore->_SYS['CONF'][$ftploc].$cusId,$objCore->_SYS['CONF'][$httploc].$cusId);
                    $fnameFTP3 = $objCore->_SYS['CONF'][$ftploc].$cusId."/large/".$image_arrays[3];
                }
                
                
                
                
                $no_of_images = 0;
                $image_slider = array();
                
                if(is_file($fnameFTP))
                {
                $objftp_img->get_img_xy($fnameFTP);
		$imgUrl = $objCore->_SYS['CONF'][$httploc].$cusId."/large/".$image_arrays[0];
                $no_of_images++;
                array_push($image_slider, $imgUrl);
                }else
                {
                $imgUrl = $objCore->_SYS['CONF'][$httploc]."/large/no_image.jpg";   
                $objftp_img->img_x=270;   $objftp_img->img_y=200;
                
                }
                
                if(is_file($fnameFTP1))
                {
                $objftp_img->get_img_xy($fnameFTP2);
		$imgUrl1 = $objCore->_SYS['CONF'][$httploc].$cusId."/large/".$image_arrays[1];
                $no_of_images++;
                array_push($image_slider, $imgUrl1);
                }else
                {
                $imgUrl1 = $objCore->_SYS['CONF'][$httploc]."/large/no_image.jpg";   
                $objftp_img->img_x=200;   $objftp_img->img_y=200;
                }
                
                if(is_file($fnameFTP2))
                {
                $objftp_img->get_img_xy($fnameFTP2);
		$imgUrl2 = $objCore->_SYS['CONF'][$httploc].$cusId."/large/".$image_arrays[2];
                $no_of_images++;
                array_push($image_slider, $imgUrl2);
                }else
                {
                $imgUrl2 = $objCore->_SYS['CONF'][$httploc]."/large/no_image.jpg";   
                $objftp_img->img_x=200;   $objftp_img->img_y=200;
                }
                
                if(is_file($fnameFTP3))
                {
                $objftp_img->get_img_xy($fnameFTP3);
		$imgUrl3 = $objCore->_SYS['CONF'][$httploc].$cusId."/large/".$image_arrays[3];
                $no_of_images++;
                array_push($image_slider, $imgUrl3);
                }else
                {
                $imgUrl3 = $objCore->_SYS['CONF'][$httploc]."/large/no_image.jpg";   
                $objftp_img->img_x=200;   $objftp_img->img_y=200;
                }
        
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT']?>/jquery.ad-gallery.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.ad-gallery.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/common.js"></script>
  <script type="text/javascript">
  $(function() {
    $('img.image1').data('ad-desc', 'Whoa! This description is set through elm.data("ad-desc") instead of using the longdesc attribute.<br>And it contains <strong>H</strong>ow <strong>T</strong>o <strong>M</strong>eet <strong>L</strong>adies... <em>What?</em> That aint what HTML stands for? Man...');
    $('img.image1').data('ad-title', 'Title through $.data');
    $('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');
    $('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');
    var galleries = $('.ad-gallery').adGallery();
    galleries[0].settings.height = '300';
    
    $('.ad-image-wrapper').css('height','280px');
    
    $('.ad-thumb-list').css('width','310px');
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $('#toggle-description').click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $('#descriptions');
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );
  });
  function changediv(divId){
      
      var count = $('#count-zoom').val();
      
      for(var i=0;i<count;i++){
          if(i==divId){
              
          }
          else{
              $('#zoom-'+i).hide();
          }
         
      }
      $('#zoom-'+divId).show();
      
  }
  </script>

  <style type="text/css">
 
  ul {
    list-style-image:url(list-style.gif);
  }
 
  #gallery {
/*    padding: 30px;*/
/*    margin-top: -42px;*/
/*    float: right;*/
    width: 305px;
/*    background: #e1eef5;*/
  }
      .ad-image-description{
          display: none;
      }
  </style>
  <title></title>
</head>
<body>
    <?php
    if(count($image_slider)){
        
        ?>
      <input type="hidden" name="count-zoom" id="count-zoom" value="<?php echo count($image_slider);?>">
    <div id="gallery" class="ad-gallery" >
        <?php
        $j = 0;
        
        foreach($image_arrays as $images){
            if($j==0){
                $style = "";
            }
            else{
                $style = "display:none";
            }
            ?>
        <a id="zoom-<?php echo $j; ?>" style="<?php echo $style; ?>" href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $images.'_spl_'.$_REQUEST['cid']; ?>','<?php echo $com; ?>');"><img  border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png"/></a>
        <?php 
        $j++;
        }
                ?>
      <div class="ad-image-wrapper">
        </div>
           
      <div class="ad-controls" style="display: none;">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
            <?php
            $n = 0;
            
            foreach($image_arrays as $images){
                
                ?>
                <li>
                    
              <a href="<?php echo $image_slider[$n]; ?>">
                <img src="<?php echo $objCategory->image($images,$objCore->_SYS['CONF'][$ftploc].$cusId,$objCore->_SYS['CONF'][$httploc].$cusId); ?>" class="image<?php echo $n;?>" id="image<?php echo $n; ?>" onclick="changediv('<?php echo $n; ?>');">
              </a>
                    </li>
                <?php
                
                $n++;
            }
            
            ?>
          </ul>
        </div>
      </div>
    </div>
  <?php } ?>
</body>
</html>
