<?php

	  /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@fusis.com>         '
	  '    FILE            :  classes/user.class.php    				          '
	  '    PURPOSE         :  class page of the user section                      '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);

	class User extends Sql
	{
        // Added by Saliya ---------------->
        private $userRoles;

        function __Construct()
        {
            parent::__construct();
            $this->userRoles=array(
                0=>'Super Administrator',
                1=>'Administrator'

            );
        }

        /*
         * Return Admin User Roles
         */
         function getUserRoles()
         {
             return $this->userRoles;
         }
        //  /Added by Saliya ---------------->
        
		/**
		* validation part at the add data in to the @diy_____admin_users table.
		*/
		function add($fName,$lName,$uName,$eMail,$pWord,$vPWord,$uRole){
			
			if($fName=="" ||$lName=="" ||$uName=="" || $eMail==""){
				 $msg=array('ERR','BLANK');
			 
			} elseif ((preg_match ('/[^a-z ]/i', $fName))>0) {
                           $msg = array('ERR', 'FNAME_CHAR');
                           
                            }
                            elseif ((preg_match ('/[^a-z ]/i', $lName))>0) {
                           $msg = array('ERR', 'LNAME_CHAR');
                           
                            }
                        elseif(!($this->isValidEmail($eMail)))
			{
				$msg=array('ERR','EMAIL');
				
			} elseif ($pWord==""){
				$msg = array('ERR', 'PW_BLANK');
				
			} 
                        elseif($vPWord==""){
                                $msg = array('ERR', 'VPW_BLANK');
                        }
                        elseif(strlen($pWord) < 6)
			{
				$msg = array('ERR', 'PW_MIN');
				
			} 
                        elseif(!($this->pwordMatch($pWord,$vPWord)))
			{
				$msg=array('ERR','CONFIRM_PWORD');
				
			} elseif($this->matchData($uName))
			{
				$msg=array('ERR','EXIST');
				
			} else
			{
				$msg=$this->addToTbl($fName,$lName,$uName,$eMail,$pWord,$uRole);
			}
			
			return $msg;
		}
		
		/**
		* Check the username is already existing record at the revalidation part.
		*/
		function matchData($uName)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("SELECT COUNT(*) FROM `".$tblPrefix."admin_users` WHERE `uname`='".$uName."'");
			
			if($result[0]["COUNT(*)"]>0)
			{
				return true;
			} else
			{
				return false;
			}
		}
		
		/**
		* Check the password is matching with verify password at the revalidation part.
		*/
		function pwordMatch($pWord,$vPWord)
		{
			if ($pWord==$vPWord)
			{
				return true;
				
			} else
			{
				return false;
			}
		}
		
		/**
		* Check the email address is correctly insert at the revalidation part.
		*/
		function isValidEmail($eMail)
		{
			$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
			if (eregi($pattern, $eMail))
			{
				return true;
				
			}else
			{
				return false;
			}   
   		}
		
		/**
		* If inserted record is successfull record, it is added to the @diy_____admin_users table, at the revalidation part.
		*/
		function addToTbl($fName,$lName,$uName,$eMail,$pWord,$uRole){
		
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("INSERT INTO `".$tblPrefix."admin_users` (`fname`, `lname`, `uname` , `email`, `pword`, `lvisit`,`role`) VALUES ('$fName', '$lName', '$uName', '$eMail', '".md5($pWord)."', '".time()."', ".$uRole.")");
				
			if ($result){
				$msg=array('SUC','DONE');
				
			}else{
				$msg=array('ERR','NOT_ADDED');
			}
			return $msg;
		}
		
		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		function get_dList($id=''){
			if($id!=''){
                            //echo "hi1";
				$where = " WHERE id='".$id."'";
			} else
                        {
                            //echo "hi2";
                        }
			$list=$this->dList($where);
			return $list;
		}
		
		/**
		* Take correspond values that match with ID into a $list array. 
		*/
		function dList($where=''){
	
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("SELECT * FROM `".$tblPrefix."admin_users`".$where."ORDER BY `fname`");
	
			for($i=0;$i<count($result);$i++)
			{	
				$list[$i][]=$result[$i]['id']; // 0
				$list[$i][]=$result[$i]['fname']; // 1
				$list[$i][]=$result[$i]['lname']; // 2
				$list[$i][]=$result[$i]['uname']; // 3
				$list[$i][]=$result[$i]['email']; // 4
				$list[$i][]=$result[$i]['lvisit']; // 5
				$list[$i][]=$result[$i]['role']; // 6
			}
			return $list;
		}			
		
		/**
		* validation part at the edit data in the @diy_____admin_users table.
		*/
		function edit($fName,$lName,$uName,$eMail,$reqId,$uRole)
		{
			if($fName=="" ||$lName=="" || $eMail==""){
				 $msg=array('ERR','BLANK');
			 
			} elseif(!($this->isValidEmail($eMail)))
			{
				$msg=array('ERR','EMAIL');
				
			} else
			{
				$msg=$this->editTbl($fName,$lName,$eMail,$reqId,$uRole);
			}
			return $msg;
		}
		
		/** 
		* If inserted record is successfull record, edited the @diy_____admin_users table, at the revalidation part.
		*/	
		function editTbl($fName,$lName,$eMail,$reqId,$uRole)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("UPDATE `".$tblPrefix."admin_users` SET `fname`='".$fName."', `lname`='".$lName."',`lvisit`='".time()."', `email`='".$eMail."', `role`='".$uRole."' WHERE `id`='".$reqId."'");
			
			if ($result){
				$msg=array('SUC','UPDATE');
				
			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}
		
		/**
		* Delete data in the @diy_____admin_users table correspond to the ID.
		*/
		function delete($reqId,$logId)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			
			if($reqId!=$logId)
			{
				$result=$this->query("DELETE FROM `".$tblPrefix."admin_users` WHERE `id`='".$reqId."'");
				
				if ($result){
					$msg=array('SUC','DELETE');
					
				}else{
					$msg=array('ERR','NOT_DELETE');
				}
			} else
			{
				$msg=array('ERR','NOT_DELETE');
			}
			return $msg;
		}
		
		/**
		* Validation part at the change password.
		*/
		function changePword($nPWord,$rPWord,$cPWord,$reqId)
		{
			if ($cPWord=="" || $nPWord=="" || $rPWord=="")
			{
				$msg = array('ERR', 'PW_BLANK');
				
			} elseif(strlen($nPWord)< 6)
			{	
				$msg = array('ERR', 'PW_MIN');
				
			} elseif(!($this->pwordMatch($nPWord,$rPWord)))
			{
				$msg=array('ERR','CONFIRM_PWORD');
				
			} elseif(!($this->cPwordMatch($cPWord,$reqId)))
			{
				$msg=array('ERR','NOT_EXIST');	
					
			} else
			{
				$msg=$this->editPword($nPWord,$reqId);
			}
			return $msg;
		}
		
		/**
		* Change the password if inserted record is successfull.
		*/
		function editPword($nPWord,$reqId)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("UPDATE `".$tblPrefix."admin_users` SET `lvisit`='".time()."', `pword`='".md5($nPWord)."' WHERE `id`='".$reqId."'");
			if ($result){
				$msg=array('SUC','CHANGE');
				
			}else{
				$msg=array('ERR','NOT_CHANGE');
			}
			return $msg;
		}
		
		/**
		* Check the current password with existing password in the database.
		*/
		function cPwordMatch($cPWord,$reqId)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("SELECT `pword` FROM `".$tblPrefix."admin_users` WHERE `id`='".$reqId."'");

			if($result[0]['pword']==md5($cPWord))
			{
				return true;
				
			} else
			{
				return false;
			}
		}
        
        
        function getUser($uid)
        {
            $result=$this->dList(" WHERE `id`='".$uid."'");
            return array(
               'Id'         => $result[0][0],
               'Name'       => $result[0][1]." ".$result[0][2],
               'Email'      => $result[0][4],
               'LastVisit'  => $result[0][5],
               'Role'       => $result[0][6],

                
            );
        }
        
      
        
        
	}
        
?>
