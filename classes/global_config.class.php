<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  classes/global_config.class.php    				  '
  '    PURPOSE         :  class page of the  global configuration section     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
	require_once($objCore->_SYS['PATH']['CLASS_USER']);

	class GlobalConfig extends Sql
	{	
		function __Construct()
		{
			parent::__Construct();
			$this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
		}
	
		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		function get_dList($configType){
		
			$where = " WHERE `con_categ`='".$configType."'";
			
			$list=$this->dList($where);
			return $list;
		}
	
		/**
		* Take correspond values that match with config type into a $list array.
		*/ 
		function dList($where=''){
	
			$result=$this->query("SELECT * FROM `".$this->tblPrefix."global_config`".$where);

			for($i=0;$i<count($result);$i++)
			{	
				$list[$i][]=$result[$i]['id']; // 0
				$list[$i][]=$result[$i]['con_categ']; // 1
				$list[$i][]=$result[$i]['con_key']; // 2
				$list[$i][]=$result[$i]['con_value']; // 3
			}
			return $list;
		}			
		
		/**
		* validation part at the edit data in the @diy_____global_config table.
		*/
		function edit($newArrayValues,$arrayKeys,$type,$logId)
		{	
			$j=0;
			switch($type)
			{
				case "email":
				{
					for($i=0; $i<count($arrayKeys);$i++)
					{
						if(!($this->validateEmail($newArrayValues[$arrayKeys[$i]])))
						{
							$j=1;
							$msg=array('ERR','EMAIL');
							break;
						}
					}	
				} break;
				
				case "subscription":
				{
					for($i=0; $i<count($arrayKeys);$i++)
					{
						if($newArrayValues[$arrayKeys[$i]] == "")
						{
							$j=1;
							$msg=array('ERR','BLANK');
							break;
							
						} elseif(!is_numeric($newArrayValues[$arrayKeys[$i]]))
						{
							$j=1;
							$msg=array('ERR','NOT_NUMERIC');
							break;
							
						} elseif($arrayKeys[$i] == "CLASSIFIED_ADS_PERCENTAGE")
						{
							if($newArrayValues[$arrayKeys[$i]]>100)
							{
								$j=1;
								$msg=array('ERR','SHOULD_LESS');
								break;
							}							
						}						
					}
				} break;
				
				case "titles":
				{
					$j=0;
					
				} break;
				
				case "discount":
				{
					if($newArrayValues[$arrayKeys[0]] == "" || $newArrayValues[$arrayKeys[1]] == "")
					{
						$j=1;
						$msg=array('ERR','BLANK');
					
					} elseif(!is_numeric($newArrayValues[$arrayKeys[0]]) || !is_numeric($newArrayValues[$arrayKeys[1]]))
					{
						$j=1;
						$msg=array('ERR','NOT_NUMERIC');
	
					} elseif((int)$newArrayValues[$arrayKeys[0]] <= (int)$newArrayValues[$arrayKeys[1]])
					{
						$j=1;
						$msg=array('ERR','NOT_GREATER');
						
					} else
					{
						$newArrayValues[$arrayKeys[0]] = intval($newArrayValues[$arrayKeys[0]]);
						$newArrayValues[$arrayKeys[1]] = intval($newArrayValues[$arrayKeys[1]]);
					}
				} break;
				
				case "recs_in_list":
				{
					for($i=0; $i<count($arrayKeys);$i++)
					{
						if($newArrayValues[$arrayKeys[$i]] == "")
						{
							$j=1;
							$msg=array('ERR','BLANK');
							break;
							
						} elseif(!is_numeric($newArrayValues[$arrayKeys[$i]]))
						{
							$j=1;
							$msg=array('ERR','NOT_NUMERIC');
							break;
							
						}  else
						{
							$newArrayValues[$arrayKeys[$i]] = intval($newArrayValues[$arrayKeys[$i]]);
						} 
					}
				} break;
				
				case "search":
				{
					for($i=0; $i<count($arrayKeys);$i++)
					{
						if($newArrayValues[$arrayKeys[$i]] == "")
						{
							$j=1;
							$msg=array('ERR','BLANK');
							break;
							
						} elseif($arrayKeys[$i] != "SEARCH_UNIT")
						{
							if(!is_numeric($newArrayValues[$arrayKeys[$i]]))
							{
								$j=1;
								$msg=array('ERR','NOT_NUMERIC');
								break;
								
							} elseif($arrayKeys[$i] == "SEARCH_RADIOUS_MAX")
							{
								if($newArrayValues[$arrayKeys[$i]] <= $newArrayValues["SEARCH_RADIOUS_DIFFERENCE"])
								{
									$j=1;
									$msg=array('ERR','SHOULD_GREATER');
									break;
									
								} else
								{
									$newArrayValues[$arrayKeys[$i]] = intval($newArrayValues[$arrayKeys[$i]]);
								}
							} else
							{
								$newArrayValues[$arrayKeys[$i]] = intval($newArrayValues[$arrayKeys[$i]]);
							} 
						}
					}
				} break;
				
				case "other":
				{
					for($i=0; $i<count($arrayKeys);$i++)
					{
						if($newArrayValues[$arrayKeys[$i]] == "")
						{
							$j=1;
							$msg=array('ERR','BLANK');
							break;
							
						} elseif($arrayKeys[$i] == "ORDER_VAT_VALUE" || $arrayKeys[$i] == "GP_NUM_OF_DAYS")
						{
							if(!is_numeric($newArrayValues[$arrayKeys[$i]]))
							{
								$j=1;
								$msg=array('ERR','NOT_NUMERIC');
								break;
							}
						}
					}	
				} break;
			}
			
			if($j != 1)
			{
				$msg=$this->editTbl($newArrayValues,$arrayKeys,$type,$logId);
			}
			return $msg;
		}
	
		function validateEmail($eMail)
		{
			if($eMail != "")
			{
				return $this->isValidEmail($eMail);
			} else
			{
				return true;
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
		* If inserted record is successfull record, edited the @diy_____global_config table, at the revalidation part.
		*/	
		function editTbl($newArrayValues,$arrayKeys,$type,$logId)
		{		
			for($i=0; $i<count($arrayKeys);$i++)
			{
				$result=$this->query("UPDATE `".$this->tblPrefix."global_config` SET `con_value`='".addslashes(htmlspecialchars($newArrayValues[$arrayKeys[$i]]))."',`modified_by`='".$logId."',`modified_time`='".time()."' WHERE `con_key`= '".addslashes(htmlspecialchars($arrayKeys[$i]))."'");
				
				if($result)
				{
					$msg=array('SUC','UPDATE');
				}else{
					$msg=array('ERR','NOT_UPDATE');
					break;
				}
			}
			return $msg;
		}




    /***************************************************************
     * Subscription Payments section
     * ------------------------------------------------------------
     * This category will maintains the fare handling methods which
     * not directly deal with global configurations
     * 
     * - Added by Saliya Wijesinghe
     *
     **************************************************************/


    /**
     * Manage Fares - Supplies
     * ------------------------------------------------------------
     * This method will be useful to manage the fare details for buliding
     * supplies
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data for success or failier trasacions.
     *
     */

     public function manageSuppliesFares($arrData,$admin)
     {
       
       // SQL- Backup all the data & Flush the table
          $sqlBackup="INSERT INTO `".$this->tblPrefix."zzz_backup_listing_fares`
                    (`id`, `label` ,`plan` ,`months` ,`price` ,`updated_time` ,`updated_by`)
                    SELECT  `id`, `label` ,`plan` ,`months` ,`price` ,`updated_time` ,`updated_by` FROM `".$this->tblPrefix."listing_fares`";
       // SQL - Delete all the data
          $sqlDelete="DELETE FROM `".$this->tblPrefix."listing_fares`" ;
         
       // SQL - Insert new data
          $sqlInsert="INSERT INTO `".$this->tblPrefix."listing_fares`
                    (`label` ,`plan` ,`months` ,`price` ,`updated_time` ,`updated_by`)
                    VALUES ";
             foreach($arrData as $key=>$value)
             {
                 if(is_numeric((int)$value))
                 {
                 // prepare the code for insert
                    $keysOnly=str_replace('SUP_FARE_','',$key);
                    $planNFrequent=explode("___",$keysOnly);
                    //foreach($key as $month=>$frequent)
                    $sqlInsert.="('', '".$planNFrequent[1]."', '".$planNFrequent[0]."', '".(float)$value."', '".time()."', '".$admin."'),";
                 }
                 else
                 {
                     $flgNaN=true;
                     break;
                 }

             }
             
            if($flgNaN)
            {
                 return array('ERR','NOT_NUMERIC');
            }
            else
            {
              // Finalize the insert
                $sqlInsert=substr($sqlInsert,0,(strlen($sqlInsert)-1)).";";

             // Execute Queries
                if($this->query($sqlBackup))
                    if($this->query($sqlDelete))
                        if($this->query($sqlInsert))
                          return array('SUC','UPDATE');
               
            }

     } // End Function - manageSuppliesFares

    /**
     * Get Fares - Supplies
     * ------------------------------------------------------------
     * Get current fare details for buliding
     *
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data 
     *          [array('Plan'=>array('frequency')=>array('<id>'<label>','<price>','<time>','<by>']
     */


     public function getSuppliesFares($type='')
     {
        $result=$this->query("SELECT  `id` ,`label` , `plan` , `months` , `price` , `updated_time` , `updated_by` FROM `".$this->tblPrefix."listing_fares` ORDER BY `months`");

        switch($type)
        {
            case "ByPlan":
                {
                     for($i=0;$i<count($result);$i++) {
                        $arrayFares[$result[$i]['plan']][$result[$i]['months']]=array(
                                                                                    $result[$i]['id'],
                                                                                    $result[$i]['label'],
                                                                                    $result[$i]['price'],
                                                                                    $result[$i]['updated_time'],
                                                                                    $result[$i]['updated_by']
                                                                                );// End Array

                    }
                }
                break;
            case "ByMonthFilterd":
                {
                     
                     for($i=0;$i<count($result);$i++) {
                        if($result[$i]['price']>0)
                        {
                            $arrayTmpFares[$result[$i]['plan']][]=array(
                                                                                        $result[$i]['id'],           //0
                                                                                        $result[$i]['label'],        //1
                                                                                        $result[$i]['price'],           //2
                                                                                        $result[$i]['updated_time'],    //3
                                                                                        $result[$i]['updated_by'],      //4
                                                                                        $result[$i]['months'],          //5
                                                                                        $result[$i]['plan']             //6
                                                                                    );// End Array
                        }
                     }

                     for($l=0;$l<4;$l++)
                     {
                         $arrayFares[$l][0]=$arrayTmpFares['B'][$l];
                         $arrayFares[$l][1]=$arrayTmpFares['S'][$l];
                         $arrayFares[$l][2]=$arrayTmpFares['G'][$l];
                     }

                    
                }
                break;

            default:
                {
                     for($i=0;$i<count($result);$i++) {
                        $arrayFares[$result[$i]['months']][$result[$i]['plan']]=array(
                                                                                    $result[$i]['id'],
                                                                                    $result[$i]['label'],
                                                                                    $result[$i]['price'],
                                                                                    $result[$i]['updated_time'],
                                                                                    $result[$i]['updated_by']
                                                                                );// End Array

                    }
                } 
        } // End Switch 

        return $arrayFares; // retrun the array
     }


    /**
     * Get Fares - Supplies
     * ------------------------------------------------------------
     * Get current fare details for buliding
     *
     * @param array $value  Contain all the values in predifine template
     *                      (Please refer support document for wrapper class)
     *
     * @return array contains necessory data 
     *          [array('Plan'=>array('frequency')=>array('<id>'<label>','<price>','<time>','<by>']
     */


     public function pickAFare($plan,$frequency)
     {
        $arrayFares=$this->getSuppliesFares();
        
        return $arrayFares[$frequency][$plan]; // retrun the array
     }


        

	}
?>
