<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  encryption.class.php                                '
  '    PURPOSE         :  class for encryption                                '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  class Encode{

      /**
       *  variable difining
       */

      /**
       *  Function for presets
       */
           function arrays(){
                $this->url_vals=array( "=" => "_eql_" , "&" => "_amp_" , "?" => "_qst_" );
                $this->file_name_vals=array( "/" => "_slh_" , "*" => "_ast_" , "?" => "_qst_", " " => "_" );

           }



      /**
       *  Function for url encode
       */
           function encodeURL(){
                $this->arrays();
                $this->arrayFirst=array_keys($this->url_vals);
                $this->arraySecond=array_keys(array_flip($this->url_vals));
                $this->outText = str_replace($this->arrayFirst, $this->arraySecond, $this->inText);
           }


      /**
       *  Function for url encode
       */
           function decodeURL(){
                $this->arrays();
                $this->arrayFirst=array_keys(array_flip($this->url_vals));
                $this->arraySecond=array_keys($this->url_vals);
                $this->outText = str_replace($this->arrayFirst, $this->arraySecond, $this->inText);
           }


      /**
       *  Function for url encode
       */
           function encodeFileName(){
                $this->arrays();
                $this->arrayFirst=array_keys($this->file_name_vals);
                $this->arraySecond=array_keys(array_flip($this->file_name_vals));
                $this->outText = str_replace($this->arrayFirst, $this->arraySecond, $this->inText);
           }


      /**
       *  Function for url encode
       */
           function decodeFileName(){
                $this->arrays();
                $this->arrayFirst=array_keys(array_flip($this->file_name_vals));
                $this->arraySecond=array_keys($this->file_name_vals);
                $this->outText = str_replace($this->arrayFirst, $this->arraySecond, $this->inText);
           }


      /**
       *  Function for set new array from array keys
       */

           function arr_keys($arrThis){
               return array_keys ($arrThis); //$newArray;
           }



  }
?>