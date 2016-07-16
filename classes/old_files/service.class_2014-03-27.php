<?php
    require_once($objCore->_SYS['PATH']['CLASS_SQL']);
    require_once($objCore->_SYS['PATH']['CLASS_SPELL_CORRECTOR']);

    class Service extends Sql
	{
		private $tblPrefix;
		private $gConf;
        private $file;

        function __construct($gConf='')
        {
            parent:: __construct();
            $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
            $this->gConf=$gConf;
            $this->file = $this->core->_SYS['CONF']['FTP_SEARCH_FRONT']."/index.txt";
        }

        /*
         * validate a given url is in the valid format or not
         * inputs: $url, a web url
         * outputs: returns true if url is in the valid format. returns false if url is not in the valid format.
         */
        function validateURL($url)
        {
             $url = 'http://'.str_replace('http://', '', $url);
             
            if (eregi("^(https?|mail)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$", $url))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        /*
         * validating the values for service section
         * inputs: $businessName, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge
         * outputs : if there is a validation error return the error, else return true
         */
        function Validate($businessName, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge, $website)
        {
            if (!$businessName || !$description  || !$keywords  || !$contactPerson)
            {
                return array('ERR', 'BLANK');
            }
            else if ($price && !is_numeric($price))
            {
                return array('ERR', 'PRICE_NOT_NUMERIC');
            }
            else if($callOutCharge!="" && !is_numeric($callOutCharge))
            {
                return array('ERR', 'CALL_CHARGE_NOT_NUMERIC');
            }
           else if (!$this->validateURL($website) && $website)
            {
                return array('ERR', 'WRONG_URL');
            }
            else
            {
                return false;
            }
        }
        
        /*
         * checks whether perticuler service listing for a perticuler customer is exists or not
         */
        function checkExists($customerId, $catId='')
		{
			$sql = "SELECT COUNT(*) FROM `".$this->tblPrefix."services` WHERE supplier_id='".$customerId."'";
/*          if ($catId[1] && !$catId[2])
            {
                $sql.= " AND category_id_1='".$catId[1]."'";
            }
            if ($catId[2])
            {
              $sql.= " AND category_id_2='".$catId[2]."'";
            } */ 
			$result=$this->query($sql);
			if($result[0]["COUNT(*)"]>0)
			{  // this section to be changed when user can have multiple services in the future
				return array('ERR', 'SERVICE_EXISTS');
                
			}
			else
			{
				return false;
			}
		}
        
        /*
         * inserts values to the @diy_____services table
         * inputs: $businessName, $catId, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge, $accreditation, $website
         * outputs: if there is a validation error return the relevent error, else add into the database and return relevent message
         */
        function addToTbl($customerId, $businessName, $catId, $description, $affiliations, $keywords, $image, $contactPerson, $price, 
            $callOutCharge, $accreditation, $website,$image2,$image3,$image4)
        {
            
            $validated = $this->Validate($businessName, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge,
            $website);
            if (!$validated)
            {
                $checkStatus = $this->checkExists($customerId, $catId);
                if (!$checkStatus)
                {
                    $sql = "INSERT INTO `".$this->tblPrefix."services` (`supplier_id`, `category_id_0`, `category_id_1`, `category_id_2`, `title`,
`keywords`, `notes`, `price`, `call_out_charge`, `image`, `business_name`, `affiliations`, `contact_person`, `accreditation`, `website`,
`added_date`,`image2`,`image3`,`image4`) 
VALUES ('".$customerId."', '".$catId[0]."', '".$catId[1]."', '".$catId[2]."', '".$businessName."', '".$keywords."', '".$description."',
'".$price."', '".$callOutCharge."', '".$image."', '".$businessName."', '".$affiliations."', '".$contactPerson."', '".$accreditation."', '".$website."',
'".time()."','".$image2."','".$image3."','".$image4."')";
                    
                    $result = $this->query($sql);
                    
                    ///print_r($result);
                   $sql2="INSERT INTO `".$this->tblPrefix."tbl_natural_services_search` (`id`,`title`, `keywords`)
                            VALUES ('".$this->lastID."','".$businessName."', '".$keywords."')";
                    
                    $result2 = $this->query($sql2);
                    
                    if ($result)
                    {
                        $objSpellCorrector = new SpellCorrector;
                        $objSpellCorrector->addWords($keywords,$this->file);
                        return array('SUC', 'DONE');
                    }
                    else
                    {
                        return array('ERR', 'NOT_ADDED');
                    }
                }
                else
                {
                    return $checkStatus;
                }
            }
            else
            {
                return $validated;
            }
        }

        /*
         * updates values in the @diy_____services table
         * inputs: $customerId, $businessName, $catId, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge,
         *         $accreditation, $website
         * outputs: if there is a validation error return the relevent error, else if customer already have a service profile
         *          update the database and return relevent message
         */
        function updateTbl($customerId, $businessName, $catId, $description, $affiliations, $keywords, $image, $contactPerson, $price,
            $callOutCharge, $accreditation, $website,$image2,$image3,$image4)
        {         
            
            $validated = $this->Validate($businessName, $description, $affiliations, $keywords, $image, $contactPerson, $price, $callOutCharge,
            $website);
            if (!$validated)
            {
                   $sql = "UPDATE `".$this->tblPrefix."services` SET `supplier_id`='".$customerId."', `category_id_0`='".$catId[0]."',
`category_id_1`='".$catId[1]."', `category_id_2`='".$catId[2]."', `title`='".$businessName."',
`keywords`='".$keywords."', `notes`='".$description."', `price`='".$price."', `call_out_charge`='".$callOutCharge."', `image`='".$image."',
`business_name`='".$businessName."', `affiliations`='".$affiliations."', `contact_person`='".$contactPerson."', `accreditation`='".$accreditation."',
`website`='".$website."',`image2`='".$image2."',`image3`='".$image3."',`image4`='".$image4."' WHERE supplier_id='".$customerId."'";
                   $result = $this->query($sql);
                   
                   $sql3="SELECT `id` FROM `".$this->tblPrefix."services` WHERE `supplier_id`='".$customerId."'";
                   $result3 = $this->query($sql3);
                   
                  
                   
                   $sql2="UPDATE `".$this->tblPrefix."tbl_natural_services_search` SET 
                        `title` = '".$businessName."',
                        `keywords` = '".$keywords."'
                            WHERE `id` = '".$result3[0]['id']."'";
                    
                    $result2 = $this->query($sql2);
                   
                   if ($result)
                   {
                       $objSpellCorrector = new SpellCorrector;
                       $objSpellCorrector->addWords($keywords,$this->file);
                       return array('SUC', 'UPDATED');
                   }
                    else
                    {
                       return array('ERR', 'NOT_UPDATED');
                    }
            }
            else
            {
                return $validated;
            }
        }
        
        /*
         * gets services profile data for a perticuler customer
         * inputs: $customerId
         * outputs: values in the @diy_____services table for a perticuler customer if a match is there
         */
        function getServiceData($customerId){
            if($customerId){
                  $where="WHERE supplier_id='".$customerId."'";
                  $list = $this->dList($where);
            }
            return $list;
        }

        /*
         * dList the table data
         * inputs: $where
         * outputs: an array of table data
         */
        function dList($where)
        {
            $sql = "SELECT id,supplier_id, category_id_0, category_id_1, category_id_2, title,
keywords, notes, price, call_out_charge, image, business_name, affiliations, contact_person, accreditation, website,image2,image3,image4,website FROM
`".$this->tblPrefix."services` ".$where."";
            $result=$this->query($sql);
            if ($result)
            {
                for($i=0;$i<count($result);$i++)
                {
                    $list[$i][]=$result[$i]['category_id_0'];//0
                    $list[$i][]=$result[$i]['category_id_1'];//1
                    $list[$i][]=$result[$i]['category_id_2'];//2
                    $list[$i][]=$result[$i]['title'];//3
                    $list[$i][]=$result[$i]['keywords'];//4
                    $list[$i][]=$result[$i]['notes'];//5
                    $list[$i][]=$result[$i]['price'];//6
                    $list[$i][]=$result[$i]['call_out_charge'];//7
                    $list[$i][]=$result[$i]['image'];//8
                    $list[$i][]=$result[$i]['business_name'];//9
                    $list[$i][]=$result[$i]['affiliations'];//10
                    $list[$i][]=$result[$i]['contact_person'];//11
                    $list[$i][]=$result[$i]['accreditation'];//12
                    $list[$i][]=$result[$i]['website'];//13
                    $list[$i][]=$result[$i]['image2'];//14
                    $list[$i][]=$result[$i]['image3'];//15
                    $list[$i][]=$result[$i]['image4'];//16
                    $list[$i][]=$result[$i]['id'];//17
                    $list[$i][]=$result[$i]['website'];//18
                }
                return $list;
            }
        }

        function deleteService($serviceId, $deactReason)
        {

            if ($deactReason)
            {
                $sql = "UPDATE `".$this->tblPrefix."services` SET status='M', deact_reason='".$deactReason."' WHERE id='".$serviceId."'";
            }
            else
            {
                return array('ERR','REASON_EMPTY');
            }
            $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_DELETED');
            }
        }

        function restoreService($serviceId)
        {
            $sql = "UPDATE `".$this->tblPrefix."services` SET status='Y' WHERE id='".$serviceId."'";
            $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_RESTORED');
            }
        }

      /*
      * get listing count by categories
      */
        function getListingCountsByCategories($topLevel='1',$secondLevel='',$thirdLevel='')
        {
            $sql = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."services` WHERE status='Y' AND category_id_0='".$topLevel."'";
            if($secondLevel) $sql.=" AND  category_id_1='".$secondLevel."'";
            if($thirdLevel) $sql.=" AND  category_id_2='".$thirdLevel."'";
                  
            $result = $this->query($sql);
            return $result[0]['count'];

        }

    }

?>