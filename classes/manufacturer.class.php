<?php

	  /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara        '
	  '    FILE            :  classes/manufacturer.class.php    				          '
	  '    PURPOSE         :  class page of the user section                      '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
	require_once($objCore->_SYS['PATH']['CLASS_USER']);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
      
	class Manufacturer extends Sql
	{	
		function __Construct()
		{
			parent::__Construct();
			$this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			
			//echo "Table name = ".$arrParentId[0]; write an another method with bellow switch case. And call it inside the other methods with $arrParentId[0] parameter. checkListingTbl($arrParentId[0]){}
			
			$arrParentId[0] =1;
			switch($arrParentId[0])
			{
				case 1:
				{ 
					$this->tbl = "listing_materials";
				}break;
				
				case 2:
				{
					$this->tbl = "listing_services";
				}break;
				
			}
		}
		/**
		* validation part at the add data in to the @diy_____admin_users table.
		*/
		function add($mName,$logId){
			
			if($mName==""){
				 $msg=array('ERR','BLANK');
			 
			} elseif($this->matchData($mName))
			{
				$msg=array('ERR','EXIST');
				
			} else
			{
				$msg=$this->addToTbl($mName,$logId);
			}
			
			return $msg;
		}

                function addSpecManu($specId,$manuId)
                {
                    if($specId == "" || $manuId == "")
                    {
			$msg = array('ERR','BLANK');
                        
                    }elseif($this->matchSpecManu($specId,$manuId))
                    {
                         $msg = array('ERR','EXIST_REC');

                    } else
                    {
                         $msg = $this->addSpecManuToTbl($specId,$manuId);
                    }
                    return $msg;
                }

		/**
		* Check the username is already existing record at the revalidation part.
		*/
		function matchSpecManu($specId,$manuId)
		{
			$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."spec_n_manufac` WHERE `spec_id`='".$specId."' AND `manu_id`='".$manuId."'");

			if($result[0]["COUNT(*)"]>0)
			{
				return true;
			} else
			{
				return false;
			}
		}
                
                function addSpecManuToTbl($specId,$manuId)
                {
                    $result=$this->query("INSERT INTO `".$this->tblPrefix."spec_n_manufac`(`spec_id`, `manu_id`)VALUES ('$specId', '$manuId')");

                    if ($result){
                            $msg=array('SUC','DONE');

                    }else{
                            $msg=array('ERR','NOT_ADDED');
                    }
                    return $msg;
                }


		/**
		* Check the username is already existing record at the revalidation part.
		*/
		function matchData($mName,$id='')
		{
			//$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."manufacturers` WHERE `manufacturer`='".$mName."' AND NOT(id='$id')");
			
			if($result[0]["COUNT(*)"]>0)
			{
				return true;
			} else
			{
				return false;
			}
		}
		
		/*
		* need to insert the added_by coloum in the databse in the manufacturer table.(username)
		*/
		function getUserName($id)
		{
			$objUser = new User;
			$list_user=$objUser->get_dList($id);
                        //print_r($list_user);
			if($list_user != "")
			{
                           // echo "came1";
				$uname = $list_user[0][3]; 
				
			} elseif($list_user == "")
			{
                           // echo "came2";
				$objCustomer = new Customer;
				$where = " WHERE customer_id='".$id."'";
				$list_user=$objCustomer->dList($where);
				$uname = $list_user[0][3]; 
			}
                        //echo $uname;
			return $uname;
		}
		
		/**
		* If inserted record is successfull record, it is added to the @diy_____admin_users table, at the revalidation part.
		*/
		private function addToTbl($mName,$logId){
		    // convert the first letter in to upper case - if only this record from a front user
            if(strlen($logId)>20) $mName=ucwords(strtolower($mName));

			$uname = $this->getUserName($logId);
                        /*$objSpecification = new Specification;
                        if($objSpecification->userType($logId))
			{
				$status="Y";
                                
			} else{
				$status="P";
                                
			}*/
                        $status="Y";
			//$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("INSERT INTO `".$this->tblPrefix."manufacturers` 
    (`manufacturer`, `requested_by`, `added_time` , `modified_by`, `modified_time`, `status`)
 VALUES ('$mName', '$uname', '".time()."', '$uname', '".time()."','".$status."')");
				
			if ($result){
				$msg=array('SUC','DONE');
				
			}else{
				$msg=array('ERR','NOT_ADDED');
			}
			return $msg;
		}
		
		/*
		* need to get the "Added By" coloum in the manufacturer list.(with [Administrator])
		*/
		function getAddedBy($uname)
		{
			$objUser = new User;
			$where = " WHERE `uname`='".$uname."'";
			$list_user=$objUser->dList($where);
			if($list_user != "")
			{
				$logged_user = $uname." [Administrator]";
				
			} elseif($list_user == "")
			{
				$logged_user = $uname;
			}
			return $logged_user;
		}
		
		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		
		function get_dList($id='',$pg='',$paginationSize=''){
			if($id!=''){
				$where = " WHERE `id`='".$id."' AND `status`='Y'";
			} else
			{
				$where = " WHERE `status`='Y'";
			}
			$list=$this->dList($where,$pg,$paginationSize);
			return $list;
		}
		
		/**
		* Take correspond values that match with ID into a $list array. 
		*/
		function dList($where='',$pg='', $paginationSize=''){
			
			//$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
		
			if($paginationSize != '')
			{
				$result = $this->queryPg("SELECT * FROM `".$this->tblPrefix."manufacturers`".$where." ORDER BY `manufacturer`", $pg, $paginationSize, '');
			} else
			{
				$result=$this->query("SELECT * FROM `".$this->tblPrefix."manufacturers`".$where." ORDER BY `manufacturer`");
			}
		
			for($i=0;$i<count($result);$i++)
			{	
				$list[$i][]=$result[$i]['id']; // 0
				$list[$i][]=$result[$i]['manufacturer']; // 1
				$list[$i][]=$result[$i]['requested_by']; // 2
				$list[$i][]=$result[$i]['added_time']; // 3
				$list[$i][]=$result[$i]['modified_by']; // 4
				$list[$i][]=$result[$i]['modified_time']; // 5
				$list[$i][]=$result[$i]['status']; // 6
			}
			return $list;
		}			
		
		/*
		* need to get the "Added By" row in the manufacturer edit part.(with first name and the last name.)
		*/
		function getUser($uname)
		{
			$objUser = new User;
			$where = " WHERE uname='".$uname."'";
			$list_user=$objUser->dList($where);
			if($list_user != "")
			{
				$user = $list_user[0][1]." ".$list_user[0][2]; 
				
			} elseif($list_user == "")
			{
				$objCustomer = new Customer;
				$where = " WHERE `email`='".$uname."'";
				$list_user=$objCustomer->dList($where);
				$user = $list_user[0][1]." ".$list_user[0][2]; 
			}
			return $user;
		}

               /* function get_dList_autosuggest($logId)
                {
                    $where = " WHERE `status`='Y'";
                    $sub_1 = $this->dList($where);
                   
                    $uname = $this->getUserName($logId);
                    $where = " WHERE `status`='P' AND `requested_by`='".$uname."'";
                    $sub_2 = $this->dList($where);
                    
                    if($sub_1 == "")
                    {
                        $sub = $sub_2;
                    } elseif($sub_2 == "")
                    {
                        $sub = $sub_1;
                    }else
                    {
                        $sub = array_merge($sub_1,$sub_2);
                    }
                    return $sub;
		}*/

                /**
		* validation part at the edit data in the @diy_____admin_users table.
                 * Completely rewritten by Saliya Wijesinghe
		*/
		function editSpecManu($specId,$manufacturer)
		{
                //Delete Existing relations
                  $this->query("DELETE FROM `".$this->tblPrefix."spec_n_manufac` WHERE `spec_id`='".$specId."'
                                AND manu_id NOT IN (SELECT manufacturer_id FROM `".$this->tblPrefix."listing_materials` WHERE 	specification_id='".$specId."')" );

                /* Adding new relations
                 */
                    if(count($manufacturer))
                    {  $manufacturerCount=count($manufacturer);
                       $sqlAdd="INSERT INTO `".$this->tblPrefix."spec_n_manufac` (spec_id,manu_id) VALUES ";
                       for($ml=0;$ml<$manufacturerCount;$ml++)
                       {  
                           if($manufacturer[$ml])
                           {
                               $sqlAdd.="('".$specId."','".$manufacturer[$ml]."')";
                               if($ml==$manufacturerCount-2){$sqlAdd.="; ";}else{$sqlAdd.=",";}
                               $executeSql=true;
                           }

                       }
                       // execute the sql
                       if($executeSql && $this->query($sqlAdd))
                            $msg=array('SUC','UPDATE');
                    }




//
//                        $where1 = " WHERE `manufacturer`='".$manufacturer."'";
//                        $manuList1 = $this->dList($where1,'', '');
//                        $manu_id = $manuList1[0][0];
//
//                        $where2 = " WHERE `manufacturer`='".$oldmanu."'";
//                        $manuList2 = $this->dList($where2,'', '');
//                        $manu_id_old = $manuList2[0][0];
//
//                        $result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."spec_n_manufac` WHERE `spec_id`='".$specId."' AND `manu_id`='".$manu_id."'");
//
//			if($result[0]["COUNT(*)"]< 0)
//			{
//                                $result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."spec_n_manufac` WHERE `spec_id`='".$specId."'");
//				if($result[0]["COUNT(*)"]> 0)
//                                {
//                                    $result=$this->query("UPDATE `".$this->tblPrefix."spec_n_manufac` SET `manu_id`='".$manu_id."' WHERE `spec_id`='".$specId."' AND `manu_id`='".$manu_id_old."'");
//                                    if ($result){
//                                            $msg=array('SUC','UPDATE');
//
//                                    }else{
//                                            $msg=array('ERR','NOT_UPDATE');
//                                    }
//                                }else
//                                {
//                                    $msg= $this->addSpecManuToTbl($specId,$manu_id);
//                                }
//                        } else
//                        {
//                            $msg=array('SUC','UPDATE');
//                        }
			return $msg;
		}
                
                function replaceManufacturers($id, $manuId){
                   return $this->query("UPDATE `".$this->tblPrefix."spec_n_manufac` SET `manu_id`=".$manuId." WHERE `manu_id`=".$id."");
                }
                
		/**
		* validation part at the edit data in the @diy_____admin_users table.
		*/
		function edit($mName,$logId,$reqId)
		{   
			
			if($mName==""){
				 $msg=array('ERR','BLANK');
			 
			} 
			// This part is edited by Chelanga to change the manufactures name even if there is a listing
			/* elseif($this->checkListings($reqId))
                        {
                                $msg=array('ERR','EXIST_LISTINGS');

                        } */ 
              elseif($this->matchData($mName,$reqId))
			{
				$msg=array('ERR','EXIST');
				
			} else
			{
				$msg=$this->editTbl($mName,$logId,$reqId);
			}
			return $msg;
		}
		
		/** 
		* If inserted record is successfull record, edited the @diy_____admin_users table, at the revalidation part.
		*/	
		private function editTbl($mName,$logId,$reqId)
		{
		    // convert the first letter in to upper case - if only this record from a front user
            if(strlen($logId)>20) $mName=ucwords(strtolower($mName));


			//$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("UPDATE `".$this->tblPrefix."manufacturers` SET `manufacturer`='".$mName."', `modified_by`='".$uName."',`modified_time`='".time()."' WHERE `id`='".$reqId."'");
			
			if ($result){
				$msg=array('SUC','UPDATE');
				
			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}
		
		function checkListings($manufacId)
		{
			$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix.$this->tbl."` WHERE `manufacturer_id`='".$manufacId."'");
			if($result[0]["COUNT(*)"]==0)
			{
				return false;
			} else
			{
				return true;
			}
		}
		
		
		/**
		* Delete data in the @diy_____admin_users table correspond to the ID.
		*/
		function delete($reqId)
		{
			//$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			if($this->checkListings($reqId))
			{
				$msg=array('ERR','EXIST_LISTINGS');
				
			} else
			{
				$result=$this->query("DELETE FROM `".$this->tblPrefix."manufacturers` WHERE `id`='".$reqId."'");
					
				if($result){
					$msg=array('SUC','DELETE');
				
				} else{
					$msg=array('ERR','NOT_DELETE');
				}
			}
			return $msg;
		}
		
		function checkMerge($mergeName,$id)
		{
			$where = " WHERE `manufacturer`='".$mergeName."'";				
			$list=$this->dList($where);	
			$manufacturer_id = $list[0][0];
		
			$objListing = new Listing;
			$where = " WHERE `manufacturer_id`='".$id."'";
			$supplier_list = $objListing->dList($where);
			
			$val = 0;
			$return_val = false;
			
			for($j=0;$j<count($supplier_list);$j++)
			{
				$keep_manu=$this->query("SELECT * FROM `".$this->tblPrefix.$this->tbl."` WHERE `manufacturer_id`='".$manufacturer_id."' AND `supplier_id`='".$supplier_list[$j][5]."'");
				
				$change_manu=$this->query("SELECT * FROM `".$this->tblPrefix.$this->tbl."` WHERE `manufacturer_id`='".$id."' AND `supplier_id`='".$supplier_list[$j][5]."'");
			
				if($keep_manu=="")
				{
					$return_val = false;
				} else
				{
					for($i=0;$i<count($keep_manu);$i++)
					{
						for($n=0;$n<count($change_manu);$n++)
						{	
							if($keep_manu[$i]['specification_id'] == $change_manu[$n]['specification_id'])
							{
								$val = 1;
								break;
							} else
							{
								$val = 2;
							}
						}
						if($val == 1)
						{
							$return_val = true;
							break;
						}
					}
					if($val == 2)
					{
						$return_val = false;
					}	
				}				
				if($val == 1)
				{
					$return_val = true;
					break;
				}
			}
			return $return_val;
		}
		
		function merge($mergeName,$logId,$id,$manufac) //$mergeName = new merge name, $logId = logged id,$id = manufacturer id of $manufac,$manufac = old manufacturer name
		{
			if($manufac != "")
			{
				if($mergeName != $manufac)
				{
					if($this->checkListings($id))
                                        {
                                                $msg=array('ERR','EXIST_LISTINGS');

                                        }elseif($this->checkMerge($mergeName,$id))
					{
						$msg=array('ERR','CANT_MERGE');
						
					} else
					{
						$uName =  $this->getUserName($logId);
						$result1=$this->query("UPDATE `".$this->tblPrefix."manufacturers` SET `status`='D', `modified_by`='".$uName."',`modified_time`='".time()."' WHERE `id`='".$id."'");
						
						$where = " WHERE `manufacturer`='".$mergeName."'";				
						$list=$this->dList($where);		
						$result2=$this->query("UPDATE `".$this->tblPrefix.$this->tbl."` SET `manufacturer_id`='".$list[0][0]."',`last_modified_time`='".time()."' WHERE `manufacturer_id`='".$id."'");
                                                $result3=$this->replaceManufacturers($id, $list[0][0]);
                                                $result4=$this->query("UPDATE `".$this->tblPrefix."specifications` SET `keywords`= replace(`keywords`,'".$mergeName."','".$list[0][1]."')");
                                                
                                                
						if ($result1 && $result2 && $result3)
						{
							$msg=array('SUC','UPDATE');
						
						}else
						{
							$msg=array('ERR','NOT_UPDATE');
						}
					}
				} else
				{
					$msg=array('ERR','NOT_UPDATE');
				}
			} else
			{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}

                function testManufac($manufacturer,$logId)
                {
                    $returnVal = $this->matchData($manufacturer);
                    if($returnVal == false)
                    {
                        $msg = $this->addToTbl($manufacturer,$logId);
                        if($msg[0]=="SUC")
                        {
                            $manu_add = "added";
                            $where = " WHERE `manufacturer`='".$manufacturer."'";
                            $manuList = $this->dList($where,'', '');
                            $manu_id = $manuList[0][0];
                           
                        } else
                        {
                            $manu_add = "not_added";
                        }
                    } else
                    {
                        $manu_add = "exist";
                        $where = " WHERE `manufacturer`='".$manufacturer."'";
                        $manuList = $this->dList($where,'', '');
                        $manu_id = $manuList[0][0];
                    }
                    return array($manu_add, $manu_id);
                }
                
         /*
          * return the manufacturer list for a given specifiation vise versa
          * Added by Saliya
          */
           function getListForASpecifcation($specificationId,$keyValue=false)
           {

                $result=$this->query("SELECT man.id,man.manufacturer FROM `".$this->tblPrefix."spec_n_manufac` manspec JOIN `".$this->tblPrefix."manufacturers` man WHERE spec_id = '".$specificationId."'AND man.id=manspec.manu_id");

                for($i=0;$i<count($result);$i++)
                {
                	if($keyValue)
                	{
                		$list[$result[$i]['id']]=$result[$i]['manufacturer'];
                	}else{
                    	$list[$i][]=$result[$i]['id']; // 0
                    	$list[$i][]=$result[$i]['manufacturer']; // 1                    	
                	}

                }
                return $list;
               
           }



	}
?>
