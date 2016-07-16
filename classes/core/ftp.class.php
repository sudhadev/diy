<?
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  ftp.class.php                                       '
  '    PURPOSE         :  class for file uploading                            '
  '    PRE CONDITION   :  commented below                                     '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  /**
   * READ ME FIRST ------->
   *

   *
   */


  class ftp{

      var $file;
      var $fileTemp;
      var $distFile;
      var $ren_file_to;

      function ftp() {
          if(!$this->extensions){$this->extensions=array('.jpg','.htm','.php','.zip','.doc');}

          $this->pre_sets();
          //if(!$this->form){echo ">>>>>>>".$this->uploadForm; }


      }


      /**
       *  Function for upload the files
       */
               function upload() {

                               if ($this->checkExtention()) {

                                       if ($this->check_max_size()) {

                                                  if (is_uploaded_file($this->fileTemp)) {
                                                                                      // this check/conversion is used for unique filenames
                                                         if($this->ren_file_to){$newFileName=$this->ren_file_to.$this->get_extension($this->file);}else{$newFileName=$this->file; }
                                                         $this->file_copy = ($this->rename_file) ? strtotime("now").$this->get_extension($this->file) : $newFileName;
                                                                if ($this->move_upload($this->fileTemp, $this->file_copy)) {
                                                                     $this->message[] = $arrErrNo[$this->http_error];
                                                                     return true;
                                                                }
                                                  } else {
                                                         $this->message[] = $arrErrNo[$this->http_error];
                                                         return false;
                                                  }

                                       }else{
                                                $this->message[] = $this->errNo=500102;// Max file size exeeded
                                                return false;
                                       }


                               } else {
                                       //$this->show_extensions();
                                       $this->message[] = $this->errNo=500406;// file type not allowed
                                       return false;
                               }

               }


      /**
       *  Function for upload the files
       */
       function move_upload($tmp_file, $new_file) {
                umask(0);
                if ($this->existing_file()) {
                        $newfile = $this->upload_dir.$new_file;
                        if ($this->check_dir()) {
                                if (move_uploaded_file($tmp_file, $newfile)) {
                                        if ($this->replace == "y") {
                                                system("chmod 0777 $newfile");
                                        } else {
                                                system("chmod 0755 $newfile");
                                        }
                                        return true;
                                } else {
                                        return false;
                                }
                        } else {
                                $this->message[] = $this->errNo=500404;// no directory exist to upload the file
                                return false;
                        }
                } else {
                        $this->message[] = $this->errNo=500405;// file already exist
                        return false;
                }
        }


     /**
       *  Validating for maximum file type
       */
               function check_max_size() {
                     if($this->byPassMaxSize=="y"){
                           return true;
                     }else{

                         if (filesize($this->fileTemp) > $this->maxSize) {
                              return false;
                         } else {
                               return true;
                         }
                     }

               }


     /**
       *  Check for the directory existing
       */
               function check_dir() {
                       if (!is_dir($this->upload_dir)) {
                               return false;
                       } else {
                               return true;
                       }
               }


     /**
       *  Check for file existing
       */
               function existing_file() {
                       if ($this->replace == "y") {
                               return true;
                       } else {
                               if (file_exists($this->upload_dir.$this->file)) {
                                       return false;
                               } else {
                                       return true;
                               }
                       }
               }

     /**
       *  Validating for the allowed file types. * checking for file extentions
       */

               function checkExtention() {
                       $extension = $this->get_extension($this->file);
                       $ext_array = $this->extensions;
                       if (in_array($extension, $ext_array)) {
                               return true;
                       } else {
                               return false;
                       }
               }


      /**
       *  Getting file extention
       */
               function get_extension($from_file) {
                       $ext = strtolower(strrchr($from_file,"."));
                       return $ext;
               }





          /*
           * function for preset variables
           */
              function pre_sets(){

                       if(!$this->uploadForm){$this->uploadForm="<form name=\"frmUpload\" enctype=\"multipart/form-data\" method=\"post\" action=\"$PHP_SELF\">
                                                       <input type=\"file\" name=\"upload\" size=\"30\"><input type=\"submit\" name=\"Submit\" value=\"Upload\">
                                                     </form>";}

                       if(!$this->maxSize){$this->maxSize=1024*512;}// in  kb
                      /* Error Numbers define for server genaration (http)errors
                      */
                         $arrErrNo[0]=500100;  // Successfully uploaded!
                         $arrErrNo[1]=500101;  // Uploded file size not valid with server configurations
                         $arrErrNo[2]=500102;  // MAX_FILE_SIZE Exeeded
                         $arrErrNo[3]=500103;  // Was only partially uploaded
                         $arrErrNo[4]=500104;  // File was not uploaded
              }




              function show_error_string() {
                $msg_string = "";
                foreach ($this->message as $value) {
                       if($value){$msg_string = $value;}
                }
                return $msg_string;
        }
}

?>