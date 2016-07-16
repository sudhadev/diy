<?
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  ftp.imd.class.php                                   '
  '    PURPOSE         :  class for image uploading                           '
  '    PRE CONDITION   :  commented below                                     '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  /**
   * READ ME FIRST ------->
   *

   *
   */

require_once($objCore->_SYS['PATH']['CLASS_FTP']);
  class ftp_img extends ftp {

        var $img_dir;
        var $thumb_dir;
        var $mk;


      function ftp_img() {
         $this->extensions=array('.jpg','.gif','.jpeg');
         $this->ftp();

      }

      function img_upload() {
                $this->upload_dir=$this->img_dir;
                if($this->upload()){
                   $image = $this->img_dir.$this->file_copy;
                   $thumb = $this->thumb_dir.$this->file_copy;
                   $img = $this->img_dir.$this->file_copy;

                   if($this->thumb){$this->create_thumb($image, $thumb, $this->thumb_width, 85);}
                }

        }


        function create_thumb($file_name_src, $file_name_dest, $weight, $quality=80) {
                $ext=$this->get_extension($file_name_src);
                $size = getimagesize($file_name_src);
                $w = number_format($weight, 0, ',', '');
                $h = number_format(($size[1]/$size[0])*$weight,0,',','');
                $dest = imagecreatetruecolor($w, $h);
                //imageantialias($dest, TRUE);
                ini_set('memory_limit', '100M');
                switch($ext)
                {
                  case ".jpg":
                         $src = imagecreatefromjpeg($file_name_src);
                         imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
                         imagejpeg($dest, $file_name_dest, $quality);
                  break;
                  case ".jpeg":
                         $src = imagecreatefromjpeg($file_name_src);
                         imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
                         imagejpeg($dest, $file_name_dest, $quality);
                  break;
                  case ".gif":
                         $src = imagecreatefromgif($file_name_src);
                         imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
                         imagegif($dest, $file_name_dest, $quality);
                  break;

                }

        }

        function get_img_xy($file) {
                $img_size = getimagesize($file);
                $this->img_x = $img_size[0];
                $this->img_y = $img_size[1];
        }


        function new_xy(){

                if(!$this->thumb_width && !$this->thumb_height){

                }elseif(!$this->thumb_width && $this->thumb_height){

                       $this->new_x = $this->thumb_width;
                       $this->new_y =($this->img_x/$this->img_y)*$this->thumb_width;

                }elseif($this->thumb_width && !$this->thumb_height){
                       $this->new_x = ($this->img_y/$this->img_x)*$this->thumb_height;
                       $this->new_y =$this->img_y;
                }else{
                       $this->new_x = $this->img_x;
                       $this->new_y =$this->img_y;
                }







        }



  }

?>