<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  classes/specification.class.php    				  '
  '    PURPOSE         :  class page of the specification section             '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    require_once($objCore->_SYS['PATH']['CLASS_USER']);
	require_once($objCore->_SYS['PATH']['CLASS_SPELL_CORRECTOR']);
	
	class Specification extends Sql
	{	

        private $pagination;
        private $specStatus;
        private $maxLengthName;
        
        function __Construct($gConf='')
		{
			parent::__Construct();

                       $this->maxLengthName=50;
			$this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
            $this->gConf=$gConf;
            $this->pagination =  $this->gConf['RECS_IN_LIST_FRONT'];
			
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
		* Check listings are available to specific specifications before edit them.
		*/ 
		function checkListings($arrParentId)
		{
			$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix.$this->tbl."` WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `specification_id`='".$arrParentId[3]."'");
			if($result[0]["COUNT(*)"]==0)
			{
				return false;
			} else
			{
				return true;
			}
		}
	
		/**
		* validation part at the add data in to the @diy_____specifications table.
		*/
		function add($arrParentId,$specification,$averagePrice='',$description='',$keywords='',$img='',$logId='',$file='',$manu_id='',$supplier_code='',$specification_desc=''){

		    // convert the first letter in to upper case - if only this record from a front user
            if(strlen($logId)>20) $specification=ucwords(strtolower($specification));
                
                
			if($specification=="" || $keywords==""|| ($logId<10 && $averagePrice=="" /*Avarage price is compulsory for */)){
				 $msg=array('ERR','BLANK');
			 
			} elseif($this->checkCategoryLevel($arrParentId))
			{
				$msg=array('ERR','NOT_EXIST');
				
			} elseif($this->checkAvailableSpecification($arrParentId,$specification,$logId))
			{ 
                if(strlen($logId)>20){$frontUser=true;} 
                switch($this->specStatus)
                {
                    case "P":
                    {
                            $msg= array("ERR","PENDING");

                    }break;
                    case "D":
                    {
                        if($frontUser)
                            $msg= array("ERR","DELETED");
                        else
                            $msg= array("ERR","DELETED_ADMIN");


                    }break;
                    case "R":
                    {
                        if($frontUser)
                            $msg= array("ERR","REJECTED");
                        else
                            $msg= array("ERR","REJECTED_ADMIN");


                    }break;
                    default:
                    {
                        $msg= array("ERR","EXIST");
                    }
                }

			} else
			{       if($averagePrice != "")
                                {
                                    if(!is_numeric($averagePrice))
                                    {
                                        $msg=array('ERR','NOT_NUMERIC');
                                    }else
                                    {
                                        $msg=$this->addToTbl($arrParentId,$specification,$averagePrice,$description,$keywords,$img,$logId,$file,$manu_id,$supplier_code,$specification_desc);
                                    }
                                } else
                                {
                                    $msg=$this->addToTbl($arrParentId,$specification,$averagePrice,$description,$keywords,$img,$logId,$file,$manu_id,$supplier_code,$specification_desc);
                                }
                                $msg2 = $this->addToNaturalSearchTbl($msg[2], $specification, $keywords);
                        }
			return $msg;
		}

		/**
		* Check the 3rd level category.
		*/
		function checkCategoryLevel($arrParentId)
		{
			return false;
		}
		
		/**
		* Check the specification is already existing record.
		*/
		function checkAvailableSpecification($arrParentId,$specification,$logId)
		{
			//$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."specifications` WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `specification`='".$specification."' AND `requested_by`='".$logId."'");
			$result=$this->query("SELECT COUNT(*) as count,status FROM `".$this->tblPrefix."specifications` WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `specification`='".$specification."' GROUP BY specification");
                        if($result[0]["count"]>0)
			{
				$this->specStatus=$result[0]["status"];
                return true;
			} else
			{
				return false;
			}
		}
		
		/**
		* check the loged user is admin or supplier
		*/
		function userType($logId)
		{
                    $objUser= new User;
                    $objCustomer= new Customer;
                    
                    $cusList = $objCustomer->getCustomerData($logId);
                    
                    //$userList = $objUser->get_dList($logId);
                    
                    if($cusList != "")
                    {
                       // echo "go1";
                        return false;

                    }else
                    {
                        //echo "go2";
			return true;
                    }
			
		}
		
		/**
		* If inserted record is successfull record, it is added to the @diy_____specification table, at the revalidation part.
		*/
		function addToTbl($arrParentId,$specification,$averagePrice = '',$description='',$keywords='',$img='',$logId,$file,$manu_id='',$supplier_code='',$specification_desc=''){
			
			/*later check the $logId and check supplier or admin added, specification.*/
                    //echo $arrParentId.", ".$specification.", ".$averagePrice.", ".$description.", ".$keywords.", ".$logId.", ".$file.", ".$manu_id."<br /><br />";
			if($this->userType($logId))
			{
				$status="Y";
			} else{
				$status="P";
			}
                        $specification = str_replace('-amp;', '&', $specification);
                        $keywords = str_replace('-amp;', '&', $keywords);         
                        $description = str_replace('-amp;', '&', $description);
                        $supplier_code = $supplier_code;
                        //$image = $img;
                        $specification_desc = str_replace('-amp;', '&', $specification_desc);
			$objSpellCorrector = new SpellCorrector;
			$objSpellCorrector->addWords($keywords,$file);

                        if($manu_id == "")
                        {
                            $manu_id = 0;
                        }
                       // echo "===>".$status."<br />";
                       //$logId = 'abc';
			$result=$this->query("INSERT INTO `".$this->tblPrefix."specifications` 
    (`category_id_0`,`category_id_1`,`category_id_2`,`specification`, `description`, `average_price`, `status` , `keywords`,`image`,`added_time`,`last_modified_time`,`requested_by`,`specification_desc`) VALUES
    ('$arrParentId[0]', '$arrParentId[1]', '$arrParentId[2]', '$specification', '$description', '$averagePrice','$status', '$keywords','$img',".time().", ".time().", '$logId','$specification_desc')");
				
			if ($result){
				$msg=array('SUC','DONE',$this->lastID);
				
			}else{
				$msg=array('ERR','NOT_ADDED');
			}
			
			return $msg;
		}
		
                
                /*
                 * Add keywords to the Natural Search Table
                 */
                function addToNaturalSearchTbl($specId,$specification,$keywords=''){
			
			$specification = str_replace('-amp;', '&', $specification);
                        $keywords = str_replace('-amp;', '&', $keywords);         
                        $result=$this->query("INSERT INTO `".$this->tblPrefix."tbl_natural_search` 
    (`id`,`specification`, `keywords`) VALUES
    ('$specId', '$specification', '$keywords')");
				
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
		function get_dList($arrParentId='',$status='', $orderBy = '')
		{
			if($arrParentId!='' ){
				$where = " WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `status`='".$status."' ORDER BY ".$orderBy;
			}
			$list=$this->dList($where);
			return $list;
		}

                
        function get_dList_pending($arrParentId,$status,$orderBy,$pg=1)
        {
            $sql = "SELECT t1.id, t1.category_id_0, t1.category_id_1, t1.category_id_2, t1.specification, t1.description, t1.average_price, t1.email,t1.added_time, t2.manufacturer FROM
            (SELECT a.id, a.category_id_0, a.category_id_1, a.category_id_2, a.specification, a.average_price, a.description, b.email, b.customer_id,a.added_time FROM (SELECT spec.id, spec.category_id_0, spec.category_id_1, spec.category_id_2, spec.specification, spec.average_price,spec.description, spec.requested_by,spec.added_time
             FROM `".$this->tblPrefix."specifications` spec WHERE spec.category_id_0='".$arrParentId[0]."'";
            
            if($arrParentId[1]) $sql.=" AND spec.category_id_1='".$arrParentId[1]."'";
            if($arrParentId[2]) $sql.=" AND spec.category_id_2='".$arrParentId[2]."'";

        
             $sql .=" AND spec.status='".$status."') a LEFT JOIN
             (SELECT cus.email,cus.customer_id FROM `".$this->tblPrefix."customers` cus) b
             ON a.requested_by = b.customer_id) t1
            LEFT JOIN (SELECT maf.manufacturer,specman.manu_id,specman.spec_id FROM `".$this->tblPrefix."manufacturers` maf, `".$this->tblPrefix."spec_n_manufac` specman
                        WHERE  specman.manu_id =maf.id) t2
            ON t1.id = t2.spec_id
            ORDER BY t1.".$orderBy."";

             //echo $sql;
           
            if($arrParentId[0]){ 
                $result = $this->queryPg($sql, $pg, $this->pagination, $url);

                for ($i=0;$i<count($result);$i++)
                {
                    $list[$i][]=$result[$i]['id']; // 0
                    $list[$i][]=$result[$i]['category_id_0']; // 1
                    $list[$i][]=$result[$i]['category_id_1']; // 2
                    $list[$i][]=$result[$i]['category_id_2']; // 3
                    $list[$i][]=$result[$i]['specification']; // 4
                    $list[$i][]=$result[$i]['description']; // 5
                    $list[$i][]=$result[$i]['average_price']; // 6
                    $list[$i][]=$result[$i]['email']; // 7
                    $list[$i][]=$result[$i]['manufacturer']; // 8                  
                    $list[$i][]=$result[$i]['added_time']; // 9
                }
            }

            return $list;
        }


		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		function get_dList_edit($arrParentId){

			$where = " WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `id`='".$arrParentId[3]."'";

			$list=$this->dList($where);
			return $list;
		}

                function getSpecId($specName,$subCatId)
                {
                    $where = " WHERE `specification`='".$specName."' AND `category_id_2`='".$subCatId."'";
                    $list=$this->dList($where);
                    $specId = $list[0][0];
                    return $specId;
                }

		/**
		* Take correspond values that match with ID into a $list array.
		*/ 
		function dList($where=''){
			$result=$this->query("SELECT * FROM `".$this->tblPrefix."specifications`".$where);
			for($i=0;$i<count($result);$i++)
			{	
				$list[$i][]=$result[$i]['id']; // 0
				$list[$i][]=$result[$i]['category_id_0']; // 1
				$list[$i][]=$result[$i]['category_id_1']; // 2
				$list[$i][]=$result[$i]['category_id_2']; // 3
				$list[$i][]=$result[$i]['specification']; // 4
				$list[$i][]=$result[$i]['status']; // 5
				$list[$i][]=$result[$i]['average_price']; // 6
				$list[$i][]=$result[$i]['added_time']; // 7
				$list[$i][]=$result[$i]['requested_by']; // 8
				$list[$i][]=$result[$i]['description']; // 9
                $list[$i][]=$result[$i]['keywords']; // 10
                $list[$i][]=$result[$i]['approved_by']; // 11
                $list[$i][]=$result[$i]['image']; // 12
                $list[$i][]=$result[$i]['specification_desc']; // 13
			}
			return $list;
		}			
		
		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		function get_dList_subcategory($id){
		
			$where = "`id`='".$id."' AND `status`='Y'";
			
			$objCategory = new Category;
			$list=$objCategory->dList($where);
			return $list;
		}
		
		/**
		* Call to dList function to take correspond values that match with ID into a $list array. 
		*/
		function get_dList_parent($id){
		
			$where = "`parent`='".$id."' AND `status`='Y'";
			
			$objCategory = new Category;
			$list=$objCategory->dList($where);
			return $list;
		}
		
		/**
		* validation part at the edit data in the @diy_____specifications table.
		*/
		function edit($ids,$specification,$description,$averagePrice,$kWords,$image,$status='',$specification_desc='')
		{
		    // convert the first letter in to upper case - if only this record from a front user
            if(strlen($logId)>20) $specification=ucwords(strtolower($specification));

			if($specification=="" || $kWords==""){
				 $msg=array('ERR','BLANK');
			 
			} elseif($this->checkSpecification($ids,$specification))
			{
				$msg=array('ERR','EXIST');
				
			} else
			{
                                if($averagePrice != "")
                                {
                                    if(!is_numeric($averagePrice))
                                    {
                                        $msg=array('ERR','NOT_NUMERIC');
                                    }else
                                    {
                                        $msg=$this->editTbl($ids,$specification,$description,$averagePrice,$kWords,$image,$specification_desc);
                                        
                                    }
                                } else
                                {
                                    $msg=$this->editTbl($ids,$specification,$description,$averagePrice,$kWords,$image,$specification_desc);
                                }
                                $msg2 = $this->editNatualSearchTbl($ids, $specification, $kWords);
			}
			return $msg;
		}
		
		/**
		* Check the specification is already existing record.
		*/
		function checkSpecification($ids,$specification)
		{
			$result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix."specifications` WHERE `category_id_0`='".$ids[0]."' AND `category_id_1`='".$ids[1]."' AND `category_id_2`='".$ids[2]."' AND `id`!='".$ids[3]."' AND `specification`='".$specification."'");
			if($result[0]["COUNT(*)"]>0)
			{
				return true;
			} else
			{
				return false;
			}
		}
		
		/**
		* If inserted record is successfull record, edited the @diy_____specifications table, at the revalidation part.
		*/	
		function editTbl($ids,$specification,$description,$averagePrice,$kWords,$image,$specification_desc)
		{
			$result=$this->query("UPDATE `".$this->tblPrefix."specifications` SET `specification`='".$specification."',`keywords`='".$kWords."',`image`='".$image."',`specification_desc`='".$specification_desc."',`description`='".$description."',`average_price`='".$averagePrice."',`last_modified_time`='".time()."' WHERE `id`='".$ids[3]."' AND `category_id_0`='".$ids[0]."' AND `category_id_1`='".$ids[1]."' AND `category_id_2`='".$ids[2]."'");

			if ($result){
				$msg=array('SUC','UPDATE');

			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}
                
                function editNatualSearchTbl($ids,$specification,$kWords)
		{
			$result=$this->query("UPDATE `".$this->tblPrefix."tbl_natural_search` SET `specification`='".$specification."',`keywords`='".$kWords."' WHERE `id`='".$ids[3]."'");

			if ($result){
				$msg=array('SUC','UPDATE');

			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}
/**
		* If inserted record is successfull record, edited the @diy_____specifications table, at the revalidation part.
		*/	
		function updateStatus($specId,$status,$logId)
		{
                   // $this->dev = true;
			$result=$this->query("UPDATE `".$this->tblPrefix."specifications` SET `status`='".$status."',`approved_by`='".$logId."',`last_modified_time`='".time()."' WHERE `id`='".$specId."'");
                       
			if ($result){
				$msg=array('SUC','UPDATE');

			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}

                /*function insertDropDown($categoryId,$logId)
                {
                    $list = $this->specDropDown($categoryId, $logId);
                    $drop_down_list = $this->createDrop('spec_selection',$list,'spec','textfield_right_font');
                    if($list == "")
                    {
                         $msg = array('ERR','NOT_EXIST_CAT');
                         
                    } else
                    {
                         $msg = array('SUC','');
                    }
                    return $drop_down_list."||".$msg[0];
                }*/


		/**
		* Delete data in the @diy_____specifications table correspond to the ID.
		*/
		function delete($arrParentId)
		{
			if($this->checkListings($arrParentId))
			{
				$msg=array('ERR','EXIST_LISTINGS');
				
			} else
			{
				//echo "DELETE FROM `".$this->tblPrefix."specifications` WHERE `id`='".$arrParentId[3]."' AND `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."'";
                $result=$this->query("DELETE FROM `".$this->tblPrefix."specifications` WHERE `id`='".$arrParentId[3]."' AND `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."'");
					
				if ($result)
				{
					$msg=array('SUC','DELETE');
						
				}else
				{
					$msg=array('ERR','NOT_DELETE');
				}
			}
			return $msg;
		}

                function specDropDown($categoryId, $logId)
                {
                    $where = " WHERE `category_id_2`='".$categoryId."' AND `requested_by`='".$logId."' AND `status`='P'";
                    $list_1=$this->dList($where);

                    $where = " WHERE `category_id_2`='".$categoryId."' AND `status`='Y'";
                    $list_2 = $this->dList($where);

                    if($list_1 == "" && $list_2 == "")
                    {
                        $list = "";
                        //$msg = array('ERR','NOT_EXIST_CAT');
                        //echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||"."SUC"."||".$ids;
                    }
                    elseif($list_1 == "")
                    {
                        $list = $list_2;
                    } elseif($list_2 == "")
                    {
                        $list = $list_1;
                    }else
                    {
                        $list = array_merge($list_1,$list_2);
                    }
                    return $list;
                }

                function createDrop($id,$list,$type,$class='',$selecId='')
                {
                     $name = $id;
                     $tmp1 = '<select name='.$name.' id='.$id.' class='.$class.' onChange="javascript:doChanges();">';
                     //echo '<select name='.$name.' id='.$id.' class='.$class.'>';
                     switch($type)
                     {
                         case 'spec':
                         {
                                //echo '<option value="">Please select a specificaion</option>';
                                $tmp1 = $tmp1.'<option value="">Please select a product</option>';
                                if($list != "")
                                {
                                   for($i=0;$i<count($list);$i++)
                                    {
                                        if($selecId == $list[$i][0])
                                        {
                                            $sel="Selected";
                                        }
                                        else
                                        {
                                            $sel="";
                                        }
                                        //echo '<option value="'.$list[$i][0].'">'.$list[$i][4].'</option>';
                                        $tmp2 = $tmp2.'<option '.$sel.' value="'.$list[$i][0].'">'.$list[$i][4].'</option>';
                                    }
                                    $tmp = $tmp1.$tmp2; 
                                } else
                                {
                                    $tmp = $tmp1;
                                }
                                
                         }break;
                     }
                     //echo '</select>';
                     $tmp =  $tmp.'</select>';
                     return $tmp;
                }


      function getRequestedSpecifications($customerId, $categoryId, $pg=1 , $url='')
      {
          $sql = "SELECT specifications.id, specifications.specification, specifications.category_id_0, specifications.category_id_1, specifications.category_id_2,
specifications.status, specifications.added_time ,specifications.keywords, categories.category, manufacturers.manufacturer FROM
`".$this->tblPrefix."specifications` specifications JOIN `".$this->tblPrefix."categories` categories ON specifications.category_id_2 = categories.id
LEFT OUTER JOIN `".$this->tblPrefix."spec_n_manufac` spec_n_manufac ON specifications.id = spec_n_manufac.spec_id LEFT OUTER JOIN `".$this->tblPrefix."manufacturers` manufacturers ON manufacturers.id=spec_n_manufac.manu_id
WHERE specifications.category_id_0='".$categoryId."' AND specifications.requested_by='".$customerId."' ORDER BY specifications.added_time DESC";
          //echo $sql;
          $result = $this->queryPg($sql, $pg , $this->pagination, $url);
          $this->dev = true;

          if ($result)
          {
            for ($i=0;$i<count($result);$i++)
            {
                $list[$i][]=$result[$i]['id']; // 0
                $list[$i][]=$result[$i]['specification']; // 1
				$list[$i][]=$result[$i]['category_id_0']; // 2
				$list[$i][]=$result[$i]['category_id_1']; // 3
				$list[$i][]=$result[$i]['category_id_2']; // 4
				$list[$i][]=$result[$i]['status']; // 5
				$list[$i][]=$result[$i]['added_time']; // 6
				$list[$i][]=$result[$i]['category']; // 7
				$list[$i][]=$result[$i]['manufacturer']; // 8
                                $list[$i][]=$result[$i]['keywords']; // 9
            }
            
            return $list;
          }
          else
          {
            return array('ERR', 'NO_RESULTS');
          }
      }

    function getRequestedSpecificationCount($customerId='', $parentCategory='')
    {
        // complete logic re written by saliya on 29th Oct 2009
         $AND="";
         
         if($parentCategory) {$where="category_id_0='".$parentCategory."'";$AND=" AND "; }
         if($customerId){$where.=$AND." requested_by='".$customerId."'";}
         
          $sqlCount = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."specifications` WHERE ".$where;

          // PLEASE REMOVE BELLOW COMMENT IF YOU ARE EDITING THIS AFTER 2009
          /*
         if($categoryId && $customerId)
         {
            
            $where="category_id_0='".$categoryId."' AND requested_by='".$customerId."'";
            $sqlCount = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."specifications` WHERE category_id_0='".$categoryId."' AND requested_by='".$customerId."'";
         }
         elseif($categoryId)
         {
             
         }
         else
         {
             $sqlCount = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."specifications` WHERE requested_by='".$customerId."'";
         }
        */
         $result=$this->query($sqlCount);
         return $result[0]['count'];
    }


    function getSpecificationCount($where)
    {

         $result=$this->query("SELECT COUNT(*) as count FROM `".$this->tblPrefix."specifications` WHERE ".$where);
         return $result[0]['count'];
    }
    
    function getMaxLength($control='')
    {
        // to be expanded by a swith
        return $this->maxLengthName;
    }
    
   
    }


?>