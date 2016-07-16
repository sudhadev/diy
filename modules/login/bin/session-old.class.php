<?php 
/*----------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  session.class.inc.php                               '
  '    PURPOSE         :  class SQL                                           '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

   if($incWithinCore)
   {
        require_once($this->_SYS['PATH']['CLASS_SQL']);
        require_once($this->_SYS['PATH']['CLASS_ENCODE']);
   }else{
        require_once($objCore->_SYS['PATH']['CLASS_SQL']);
        require_once($objCore->_SYS['PATH']['CLASS_ENCODE']);
   
   }
class Session extends Sql{

       // Variable defining  --------------->
          var $key;
          var $memid;
          var $extFields;
          var $extFieldsVals;
          var $path;
          var $gFormat;
          var $alphaFormat;
          var $keyLength;
          var $thisMem;
          var $remember;
          var $uid;
          var $reloc;
          var $flush;
          var $config;
       // ---------------------------------->

       function __Construct() 
       {      
          
          	$this->core=new Core; 
				
       }
			
       function login($user,$pass,$cusr=0,$key='',$errUrl='',$lfrom='',$custom_vars='')
       {
           if($user && $pass)
           {          
                $result=$this->query("SELECT ".$this->config['LOGIN'][$cusr]['REQ_FIELDS'][0].','.$this->config['LOGIN'][$cusr]['REQ_FIELDS'][1].','.$this->config['LOGIN'][$cusr]['REQ_FIELDS'][2].$this->config['LOGIN'][$cusr]['EXTRA_FIELDS']."
                					FROM `".$this->config['LOGIN'][$cusr]['USER_TABLE']."` WHERE ".$this->config['LOGIN'][$cusr]['REQ_FIELDS'][1]."='$user'");
              	
                if($result){ //echo $result[0][str_replace("`","",$this->config['LOGIN'][$cusr]['REQ_FIELDS'][2])]."=".md5($pass);
                   if($result[0][str_replace("`","",$this->config['LOGIN'][$cusr]['REQ_FIELDS'][2])]!=md5($pass))
                   {
                        $redirect=$this->config['LOGIN'][$cusr]['ERROR_URL']."?err=422&bloc=$lfrom";
                        if($this->config['LOGIN'][$cusr]['AJAX'])
                        {
                           echo '<script type="text/javascript">window.parent.login_redirect(\''.$redirect.'\');</script> ';
                        }

                        else{
									
                           header("Location: $redirect");exit; // password incorrect
                        }
                   }else{ 
                      // session creation will goes here
                         $this->force_remove($key,$cusr) ;
                         $this->register($key,$cusr,$result[0]['id'],$this->ext_vals($cusr,$result),$lfrom,$custom_vars);
                   }

                }else{
                        $redirect=$this->config['LOGIN'][$cusr]['ERROR_URL']."?err=426&bloc=$lfrom";
                        if($this->config['LOGIN'][$cusr]['AJAX']){
                           echo '<script type="text/javascript">window.parent.login_redirect(\''.$redirect.'\');</script> ';
                        }
                        else
                        {
                        	
                          header("Location: $redirect");exit;  // password incorrect
                        }
                }
           }
           else // user or password missing
           {
					$redirect=$this->config['LOGIN'][$cusr]['ERROR_URL']."?err=428&bloc=$lfrom";
					if($this->config['LOGIN'][$cusr]['AJAX'])
					{
   					echo '<script type="text/javascript">window.parent.login_redirect(\''.$redirect.'\');</script> ';
  					}
  					else
 					{ 
                         header("Location: $redirect");exit; 
 					}
 			}

			}


       function force_remove($key,$cusr)
       {
				
          $result=$this->query("DELETE FROM `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."` WHERE `".$this->config['LOGIN'][$cusr]['SESS_KEY_FIELD']."`='". $key."'");			 
			 return $result;
        
       }

       // start() will initialize the session by generating the session key or ID
              function key($timeout = "") {
                      // declare the $key variable
                      $key = "";

                      // generate session's key
                         $letters = range("a","z");
                         $alphKeyLength=$this->config['SESS_KEY_LENGTH']-10;
                         $alphaTxt=$this->config['ALPHA_FORMAT'];
                            for($i = 0; $i < $alphKeyLength; $i++) {
                                if($alphaTxt[$i]=="#"){
                                     $key .= rand(0,9);
                                }else{
                                      $key .= $letters[rand(0,25)];
                                }
                            }

                      // store the session's key
                            switch ($this->gFormat) {

                                   case 1:
                                         $key= time().$key;
                                         break;
                                   case 2:
                                          $middle=$alphKeyLength/2;
                                            if($middle!=intval($middle)){$middle=intval($middle)+1;}
                                            $key= substr($key,0,$middle).time().substr($key,$middle);
                                          break;
                                   default:
                                         $key=$key.time();
                            }

                      // store the session's key
                       return $key;
              }

       // this function will register a value to session. (only one value, see replace() to update the value)
             function register($key,$cusr,$uid,$extvals,$lfrom,$custom_vars) {
                 // if key is not generated run start()
                 if($this->config['LOGIN'][$cusr]['NEW_KEY']=='y' || $key == ""){$sess=$key;$key=$this->key();}
					
						if($custom_vars){$cusvarField='{,}CUS_SESS.CUS_VAR';$cusvarValue=",'".$custom_vars."'";}
                        $time=time();
                        $timeExpire=$time+ ($this->config['LOGIN'][$cusr]['SESSION_EXPIRE']*60);

                     
                        $result=$this->query("INSERT INTO `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."`(`s_key`,`t_key`,`uid`,`ip`,`access`,`expire`".$this->config['LOGIN'][$cusr]['EXTRA_FIELDS'].") VALUES ('" .$key. "','" .$sess. "','" . $uid . "',
                                         '" . $_SERVER["REMOTE_ADDR"] . "','".$timeExpire."','" . $time ."' ". $extvals .$cusvarValue.")");



                        // set the cookie that will store the session key
                        //setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME'],$key,time()+48600,"/",$this->config['LOGIN'][$cusr]['COOKIE_URL'],0);
                        setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME'],$key,0,"/",$this->config['LOGIN'][$cusr]['COOKIE_URL'],0);

                        
                        if($this->remember){
                           setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME']."_REM_ID",$uid,time()+31536000,"/",$this->config['LOGIN'][$cusr]['LOGIN_URL'],0);
                        }

                        $objEncode= new Encode;
                        $objEncode-> inText =$this->config['LOGIN'][$cusr]['LOGGED_IN_URL'];
                        $objEncode-> decodeURL();
                        $redirect= addslashes($objEncode-> outText);

                        /* ----------------------------------------- */
                           $arr_index=array('[%KEY%]');
                           $arr_vals=array($sess);
                           $redirect=str_replace($arr_index,$arr_vals,$redirect)."&lfrom=".$lfrom;
                        /* ----------------------------------------- */
                        if($lfrom=='SELF')
                        {
                            return true;
                        }
                        elseif($this->config['LOGIN'][$cusr]['AJAX']){
                           echo '<script type="text/javascript">window.parent.login_redirect(\''.$redirect.'\');</script> ';
                        }
                        else{
						
                           header("Location: $redirect");
                        }

            }

       function read($cusr=0,$cookie='',$auth='') { //echo $_COOKIE[$cookie];
          // If the cookie doesn't exisit send them back to the login screen.
             if(!$_COOKIE[$cookie] && $auth=='Y') {
                 if($this->reloc=="N")
                 {
                    $this->flush="Y";
                 }else{
                           /*echo '<script type="text/javascript">window.parent.location.href=\''.$this->errorURL.'\';</script> ';*/
                           header("Location:".$this->config['LOGIN'][$cusr]['ERROR_URL'].""); exit;
                 }
             }else{
                  $vars=$this->get_usr_dat($cusr);
                  if(!$vars  && $auth=='Y'){
                          header("Location:".$this->config['LOGIN'][$cusr]['ERROR_URL'].""); exit;
                  }else{
                      return $vars;
                  }

             }




       }
       // this function will update the session value
          function replace($key,$cusr) {

                  // Fetch the user key from cookie
                   $timeExpire=time()+ ($this->config['LOGIN'][$cusr]['SESSION_EXPIRE']*60);
                  // update cookie
                     //setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME'],$key,time()+48600,"/",$this->config['LOGIN'][$cusr]['COOKIE_URL'],0);
                  setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME'],$key,0,"/",$this->config['LOGIN'][$cusr]['COOKIE_URL'],0);
                
                  // update the database with the new value
                  		return $this->query("UPDATE `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."`
                  						  SET `expire`='" . $timeExpire. "',`access`='" . time() . "' 
                  						  WHERE `s_key`='" .$key."'");

          }

       // this function will kill the session
       function logout($cusr=1,$key='',$errUrl,$lfrom) {

               // fetch the user key from cookie
               $key = $_COOKIE[$this->config['LOGIN'][$cusr]['COOKIE_NAME']];  //echo $this->config['LOGIN'][$cusr]['COOKIE_NAME'];
               // delete session from database
               $this->query("DELETE  FROM `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."`
                  						  		  WHERE `s_key`='" .$key."'");
                   

               // remove cookie from the user's computer

               $delete = setcookie($this->config['LOGIN'][$cusr]['COOKIE_NAME'], "out",time()-46800,"/",$this->config['LOGIN'][$cusr]['COOKIE_URL'],0);
               $query = $this->query("OPTIMIZE TABLE `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."`");
               
               if($query && $delete) {

                        if($this->config['LOGIN'][$cusr]['AJAX']){
                           echo '<script type="text/javascript">window.parent.login_redirect(\''.$redirect.'\');</script> ';
                        }else{
                             if($lfrom){
                             
                                 $objEncode= new Encode;
                        			$objEncode-> inText =$lfrom;
                        			$objEncode-> decodeURL();
                        			$redirect= addslashes($objEncode-> outText);
                        			
                        			header("Location: $redirect"); exit;
                             }else{
							      
                                	header("Location: ".$this->config['LOGIN'][$cusr]['ERROR_URL']);  exit;
                             }


                        }

                           //$err="Successfully Logout";$errNo="444";
                            /*echo '<script type="text/javascript">window.parent.logout_response(\''.$errNo.'\',\''.$this->errorURL.'\');</script> ';*/
                          // header("Location:".$this->errorURL."?errNo=$errNo");

               }

       }


       // function for get user detail from the aession table
       function get_usr_dat($cusr=0)
       {
          // Fetch the session key from the cookie
             $key=$_COOKIE[$this->config['LOGIN'][$cusr]['COOKIE_NAME']];
					
          // Fetch the session value
              if($key)
              { 
                $vars=$this->tbl_read($key,$cusr);
                $this->ext_vals($cusr,$vars);
                if($vars) {
                     $this->replace($key,$cusr);
                     return $vars;
                }
              }
       }



      function tbl_read($key,$cusr)
      {
     
          $result=$this->query("SELECT  `s_key`,`t_key`,`uid`,`ip`,`access`,`expire`".$this->config['LOGIN'][$cusr]['EXTRA_FIELDS']."
          							 FROM `".$this->config['LOGIN'][$cusr]['SESSION_TABLE']."`
          							 WHERE `s_key`='". $key."'");
	


         // parent::get_records();
         // $this->sqlExe=mysql_query($this->sqlText) or die(mysql_error());
         // $this->sqlcount=mysql_num_rows($this->sqlExe);

                // Explode the field list
                   if($result[0]){
                   		$arrVals['user']=$result[0]['uid'];
                  		$arrVals['uType']=$cusr;
                   		$arrVals['role']=$result[0]['role'];
                   		$arrVals['sKey']=$result[0]['s_key'];
                    		$arrVals['tKey']=$result[0]['t_key'];

                   		$arrVals['ip']=$result[0]['ip'];
                   		$arrVals['access']=$result[0]['access'];
                   		$arrVals['expire']=$result[0]['expire'];

                        $arrField=explode(",",$this->config['LOGIN'][$cusr]['EXTRA_FIELDS']);
                        for($l=1;$l<count($arrField);$l++){                              
                           $arrVals['eFields'][]=$result[0][str_replace("`","",$arrField[$l])];
                        }
                        return $arrVals ;
                   }
       }



       function ext_vals($cusr,$data)
       { 
                if($this->config['LOGIN'][$cusr]['EXTRA_FIELDS'])
                {
                     $exp_fields=explode(",",$this->config['LOGIN'][$cusr]['EXTRA_FIELDS']);
                     for($ef=1;$ef<count($exp_fields);$ef++){
               
                         $exp_values.=",'".$data[0][str_replace("`","",$exp_fields[$ef])]."'";
                     }
                     return $exp_values;
                }
       }



}
 
?>