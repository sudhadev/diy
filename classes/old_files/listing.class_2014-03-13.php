<?php

/*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  classes/listing.class.php    				  		  '
	  '    PURPOSE         :  class page of the listings section             	  '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/

require_once($objCore->_SYS['PATH']['CLASS_SQL']);
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);

class Listing extends Sql {
    private $tblPrefix;
    private $tbl;

    function __construct() {
        parent::__construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];

        $arrParentId[0] =1;
        switch($arrParentId[0]) {
            case 1: {
                    $this->tbl = "listing_materials";
                }break
                ;

            case 2: {
                    $this->tbl = "listing_services";
                }break
                ;

        }
    }

    /**
     * validation part at the add data in to the @diy_____lising_materials or @diy_____lising_services table.
     */

    function add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4) {
        //echo "=======>".$delivery;
        //if($unitCost == "" && $delivery == "" && $bulkDiscount == "0" && $bulkPrice == "")
        //{
        //$msg=array('SUC','DONE');
        //$msg="";
        // echo "came0";

        // }else{
        if($bulkPrice == "0") {
            $bulkPrice = "";
        }

        if(($unitCost == "" ||($bulkPrice == "" &&  $bulkDiscount!=0) )) {
            //echo "came1";
            $msg=array('ERR','BLANK');

        }elseif(!is_numeric((int)$unitCost) || ((int)$delivery!="" && !is_numeric((int)$del_rate)) || !is_numeric((int)$bulkDiscount) || $this->check_numeric((int)$bulkPrice)) {
            $msg=array('ERR','NOT_NUMERIC');

        } elseif((int)$unitCost < (int)$bulkPrice) {
            $msg=array('ERR','NOT_GREATER');

        } elseif($bulkPrice != "" && $bulkDiscount == 0) {
            $msg=array('ERR','FILL_BULKDISCOUNT');

        } else {
            $msg=$this->add_edit_tbl($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4);
        }
        //}
        //$this->dev = true;
        return $msg;
    }

    /**
     * check the fields are numeric.
     */
    function check_numeric($bulkPrice) {
        if($bulkPrice == "") {
            return false;
        } else {
            if(is_numeric($bulkPrice)) {
                return false;
            } else {
                return true;
            }
        }
    }

   

    /**
     * If inserted record is successfull record, it is added to the @diy_____lising_materials or @diy_____lising_services table
     * or edit, at the revalidation part.
     */
    function add_edit_tbl($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4) {
        
        $no_error=TRUE;
               
        try{
            $result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix.$this->tbl."` 
                WHERE `category_id_0`='".$arrParentId[0]."' 
                    AND `category_id_1`='".$arrParentId[1]."' 
                        AND `category_id_2`='".$arrParentId[2]."' 
                            AND `specification_id`='".$arrParentId[3]."' 
                                AND `manufacturer_id`='".$arrParentId[4]."' 
                                    AND `supplier_id`='".$logId."'"); /*for the block duplicate entry*/
        }catch(Exception $e) {
            $no_error=FALSE;
          return  $msg=array('ERR','NOT_ADDED');
        }
        
        
        //if($this->checkExistOfAListing($arrParentId, $logId)==0) {//$arrParentId[5] == "" <---- prevouse check removed by saliya, to be check again if any issue occured with the speed
         if($arrParentId[5] == "" && $result[0]['COUNT(*)']==0 && $no_error ){ //Check has been enabled by sudharshan  
            // $result.='---- 0';
        //exit;
            if($this->checkQuotaExceed($logId , "1")) {
                $msg=array('ERR','QUOTA_EXCEED');

            } else {
                
                $msg=$this->addToTbl_Listing($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4);
            }
        } else if($arrParentId[5] == ""){
            //return  $msg=array('ERR','NOT_ADDED');
        } else if($no_error) {
           // $result.='---- 1';
            $msg=$this->editTbl_Listing($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4);
        }else {
            //return  $msg=array('ERR','NOT_ADDED');
        }
        
        
        return $msg;
        //return $result;
    }

    /**
     * If inserted record is successfull record, it is added to the @diy_____specification table, at the revalidation part.
     */
    function addToTbl_Listing($arrParentId,$logId,$unitCost,$bulkDiscount,$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,$list_spec,$del,$del_rate,$header,$url,$img2,$img3,$img4) {
        try{
            $result=$this->query("INSERT INTO `".$this->tblPrefix.$this->tbl."` (`category_id_0`,`category_id_1`,`category_id_2`,`specification_id`,`manufacturer_id`,
                                                `supplier_id`, `unit_cost` , `bulk_discount`,`bulk_price`,`delivery`,`listing_active`,`added_time`,`last_modified_time`,`image`,`description`,`supplier_code`,`specification`,`can_deliver`,`delivery_rate`,`listing_header`,`product_url`,`image2`,`image3`,`image4`) 
                                                VALUES (".$arrParentId[0].", ".$arrParentId[1].", ".$arrParentId[2].", ".$arrParentId[3].", ".$arrParentId[4].",'".$logId."', '".$unitCost."', '".$bulkDiscount."',
                                               '".$bulkPrice."', '".$delivery."', '".$listingActive."', '".time()."', '".time()."', '".$img."', '".$desc."','".$supplier_code."', '".$list_spec."', '".$del."', '".$del_rate."','".$header."','".$url."', '".$img2."','".$img3."','".$img4."')");

            if ($result) {
                $msg=array('SUC','DONE');

            }else {
                $msg=array('ERR','NOT_ADDED');
            }
        }catch(Exception $e) {
          return  $msg=array('ERR','NOT_ADDED');
        }
        return $msg;
    }

    /**
     * If inserted record is successfull record, edited the @diy_____lising_materials or @diy_____lising_services table, at the
     * revalidation part.
     */
    function editTbl_Listing($arrParentId,$logId,$unitCost,$bulkDiscount='',$bulkPrice='',$delivery='',$listingActive='',$img,$desc,$supplier_code,$list_spec,$del,$del_rate='',$header,$url,$img2,$img3,$img4) {
         try{
             $result=$this->query("UPDATE `".$this->tblPrefix.$this->tbl."` SET `unit_cost`='".$unitCost."',`bulk_discount`='".$bulkDiscount."',
                                                `bulk_price`='".$bulkPrice."',`delivery`='".$delivery."',`listing_active`='".$listingActive."',
                                                `last_modified_time`='".time()."',`image`='".$img."',`description`='".$desc."',`specification`='".$list_spec."',`listing_header`='".$header."',`supplier_code`='".$supplier_code."',`can_deliver`='".$del."',`delivery_rate`='".$del_rate."',`product_url`='".$url."',
                                                    `product_url`='".$url."',`image2`='".$img2."',`image3`='".$img3."',`image4`='".$img4."' WHERE `id`=".$arrParentId[5]."");
    //echo $result;
            if ($result) {
                $msg=array('SUC','UPDATE');

            }else {
                $msg=array('ERR','NOT_UPDATE');
            }
        }catch(Exception $e) {
            $no_error=FALSE;
          return  $msg=array('ERR','NOT_ADDED');
        }
        return $msg;
    }


    function add($manufacturer, $ids, $logId, $need_to_add_listings) {
        $arrParentId = explode('_',$ids);

        if($manufacturer == "") {
            $msg=array('ERR','BLANK');

        } else {
            $objManufacturer = new Manufacturer;
            $where = " WHERE `manufacturer`= '".$manufacturer."' AND `status`='Y' ";
            $list = $objManufacturer->dList($where,'','');

            if(count($list)>0) {
                if($this->checkExistRecs($list[0][0],$arrParentId, $logId)) {
                    $msg=array('ERR','ALREADY_ADDED');

                } else {
                    $msg = $this->addToTbl($list[0][0],$arrParentId, $logId);
                }

            } else {
                //echo "added new manufacturer ";
                $msg = $objManufacturer->add($manufacturer,$logId);
                if($msg[0] == "SUC") {
                    $objManufacturer = new Manufacturer;
                    $where = " WHERE `manufacturer`= '".$manufacturer."' AND `status`='Y' ";
                    $list = $objManufacturer->dList($where,'','');

                    $msg = $this->addToTbl($list[0][0],$arrParentId, $logId);
                }
            }
        }
        return $msg;
    }

    function checkExistRecs($manufacId, $arrParentId, $logId) {
        $result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix.$this->tbl."` WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `specification_id`='".$arrParentId[3]."' AND `supplier_id`='".$logId."' AND `manufacturer_id`= '".$manufacId."'");

        if($result[0]["COUNT(*)"] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if listing add for materials and supplier quota is exceed.
     */
    function checkQuotaExceed($logId, $need_to_add_listings) {
        $objCustomer = new Customer;
        $list = $objCustomer->getStatus($logId);
        $return_val = true;

        if($this->tbl == "listing_materials") {
            $type = "M";

        } elseif($this->tbl == "listing_services") {
            $type = "S";
        }

        for($i=0;$i<count($list);$i++) {
            if($list[$i][2] == $type) //subscription_type
            {
                if($list[$i][0] == "Y" && $list[$i][4] == "Y" && $list[$i][6] > 0)
                //customer_status,subscription_status,no_of_listings
                {
                    $where = " WHERE `supplier_id`='".$logId."'";
                    $list_listing = $this->dList($where);

                    $available_listings = $list[$i][6] - count($list_listing);

                    if($available_listings >= $need_to_add_listings) {
                        $return_val = false;
                    } else {
                        if($available_listings == 0) {
                            $objCustomer->setStatus($logId, 'E', $type, 'sub');
                        }
                        $return_val = true;
                    }
                } else {
                    $return_val = true;
                }
                break;
            }
        }
        return $return_val;
    }

    /**
     * If inserted record is successfull record, it is added to the @diy_____specification table, at the revalidation part.
     */
    function addToTbl($manufacId, $arrParentId, $logId) {

        $result=$this->query("INSERT INTO `".$this->tblPrefix.$this->tbl."` (`category_id_0`,`category_id_1`,`category_id_2`,`specification_id`, `supplier_id`, `manufacturer_id`, `added_time`,`last_modified_time`) VALUES ('$arrParentId[0]', '$arrParentId[1]', '$arrParentId[2]', '$arrParentId[3]','$logId', '$manufacId', ".time().", ".time().")");

        if ($result) {
            $msg=array('SUC','DONE');

        } else {
            $msg=array('ERR','NOT_ADDED');
        }

        return $msg;
    }

    /*function tempValues($tmpValue)
                {
                    //-dlm-1_45_56_184_17_||12||10||11||13||N-dlm-1_45_56_184_216_||13||30||10||9||Y-dlm-
                    
                    $arryVal = explode('-dlm-',$tmpValue);
                    /*$values = array();
                    for($i=0; $i<count($arryVal);$i++)
                    {
                        $values[$i]=
                    }
                    values_of_rows[i] =  unitCost+"||"+bulkDiscount+"||"+bulkPrice+"||"+delivery+"||"+listingActive+"||"+ids;

                }*/


    /**
     * Call to dList function to take correspond values that match with ID into a $list array.
     */
    function get_dList_listing($arrParentId,$specification_id,$logId) {

        $where = " WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `specification_id`='".$specification_id."' AND `supplier_id`='".$logId."'";

        $list=$this->dList($where);
        return $list;
    }

 



    /**
     * Take correspond values that match with ID into an array.
     */
    function dList($where='') {

        $listing_result=$this->query("SELECT * FROM `".$this->tblPrefix.$this->tbl."`".$where);

        for($i=0;$i<count($listing_result);$i++) {
            $listing_list[$i][]=$listing_result[$i]['id'];                  // 0
            $listing_list[$i][]=$listing_result[$i]['category_id_0'];       // 1
            $listing_list[$i][]=$listing_result[$i]['category_id_1'];       // 2
            $listing_list[$i][]=$listing_result[$i]['category_id_2'];       // 3
            $listing_list[$i][]=$listing_result[$i]['specification_id'];    // 4
            $listing_list[$i][]=$listing_result[$i]['supplier_id'];         // 5
            $listing_list[$i][]=$listing_result[$i]['unit_cost'];           // 6
            $listing_list[$i][]=$listing_result[$i]['bulk_discount'];       // 7
            $listing_list[$i][]=$listing_result[$i]['bulk_price'];          // 8
            $listing_list[$i][]=$listing_result[$i]['delivery'];            // 9
            $listing_list[$i][]=$listing_result[$i]['listing_active'];      // 10
            $listing_list[$i][]=$listing_result[$i]['added_time'];          // 11
            $listing_list[$i][]=$listing_result[$i]['last_modified_time'];  // 12
            $listing_list[$i][]=$listing_result[$i]['manufacturer_id'];     // 13
            $listing_list[$i][]=$listing_result[$i]['image'];               // 14
            $listing_list[$i][]=$listing_result[$i]['description'];         // 15
            $listing_list[$i][]=$listing_result[$i]['supplier_code'];         // 16
            $listing_list[$i][]=$listing_result[$i]['can_deliver'];         // 17
            $listing_list[$i][]=$listing_result[$i]['delivery_rate'];         // 18
            $listing_list[$i][]=$listing_result[$i]['product_url'];         // 19
            $listing_list[$i][]=$listing_result[$i]['specification'];         // 20
            $listing_list[$i][]=$listing_result[$i]['listing_header'];         // 21
            $listing_list[$i][]=$listing_result[$i]['image2'];         // 22
            $listing_list[$i][]=$listing_result[$i]['image3'];         // 23
            $listing_list[$i][]=$listing_result[$i]['image4'];         // 24
            $listing_list[$i][]=$listing_result[$i]['website'];         // 25
            
        }
        return $listing_list;
    }
    
    
    /**
     * Take correspond values that match with ID into an array.
     * Replicated this to get the extra details and spec image and description
     */
    function dList_spec($where='') {

        $listing_result=$this->query("SELECT image, description, specification_desc, specification FROM `".$this->tblPrefix."specifications` ".$where);
        
        for($i=0;$i<count($listing_result);$i++) {
            $listing_list[$i][]=$listing_result[$i]['image'];       // 0
            $listing_list[$i][]=$listing_result[$i]['description'];       // 1
            $listing_list[$i][]=$listing_result[$i]['specification_desc']; //2           
			$listing_list[$i][3]=$listing_result[$i]['specification']; //3
        }        
        return $listing_list;
    }
    /**
     * Call to dList function to take correspond values that match with ID into a $list array.
     */
    /*function get_dList_specification($arrParentId,$status){
			
			$where = " WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND `category_id_2`='".$arrParentId[2]."' AND `status`='".$status."'";
	
			$objSpecification = new Specification;
			$list=$objSpecification->dList($where);
			return $list;
		}*/ 

    /**
     * Call to dList function to take correspond values that match with ID into a $list array.
     */
    function get_dList_subcategory($arrParentId,$level,$status) {

        $where = "`level`='".$level."' AND `parent`='".$arrParentId[1]."' AND `status`='".$status."'";

        $objCategory = new Category;
        $list=$objCategory->dList($where);
        return $list;
    }

    function get_dList_topMostCatId($pid) {

        $where = "`level`='1' AND `parent`='".$pid."' AND `status`='Y'";

        $objCategory = new Category;
        $list=$objCategory->dList($where);
        $topMostCat = $list[0][0];
        return $topMostCat;
    }

    /**
     * Call to dList function to take correspond values that match with ID into a $list array.
     */
    function get_dList_category($arrParentId,$status) {

        $where = "`id`='".$arrParentId[1]."' AND `status`='".$status."'";

        $objCategory = new Category;
        $list=$objCategory->dList($where);
        return $list;
    }

    function calculate_credit($logId) {
        //echo "-------------";
        $objCustomer = new Customer;
        $list = $objCustomer->getStatus($logId);
        $return_val = 0;
        //print_r($list);
        //echo date('d M Y',1253879884)."<br />";
        for($i=0;$i<count($list);$i++) {
            if($this->tbl == "listing_materials") {
                $type = "M";

            } elseif($this->tbl == "listing_services") {
                $type = "S";
            }

            if($list[$i][2] == $type) //subscription_type
            {
                if($list[$i][0] == "Y" && $list[$i][4] == "Y" && $list[$i][6] > 0)
                //customer_status,subscription_status,no_of_listings
                {
                    $where = " WHERE `supplier_id`='".$logId."'";
                    $list_listing = $this->dList($where);
                    $list_listing=$this->getTotals($logId,'Y');
                    $list_total=$this->getTotals($logId);
                     $activeListings=$list_listing[0]['total_count'];
                    //print_r($list_listing).'ksjdfhkjdshfdsh';
                    //echo $list[$i][6];
                    //echo "+++>".count($list_listing); //echo "<br/>--------------->".$list[$i][6]."====>".$list_listing[0]['total_count'];
                    if($list[$i][6] > $activeListings) {
                        $available_listings = $list[$i][6] - $activeListings;
                    }
                    // Modified by Saliya Wijesinghe , 24th Nov 2010
//                    else {
//                        $available_listings = $activeListings - $list[$i][6];
//                    }

                    // Modified by Saliya Wijesinghe , 24th Nov 2010
                    $return_val = array(
                            'listCanAdd' => (int)$available_listings,
                            'listTotal'     => $list_total[0]['total_count'],
                            'listInactive'  => $list_total[0]['total_count']- $list_listing[0]['total_count'],
                            'listActive'    => $list_listing[0]['total_count'],
                            'listAllowed'   => $list[$i][6],
                            
                            );
                } else {
                    $return_val = 0;
                }
                break;
            }
        }
        return $return_val;
    }

    function getSpecifications($categoryId) {
        $sql = "SELECT DISTINCT(listing_materials.specification_id), listing_materials.manufacturer_id, specifications.specification, manufacturers.manufacturer FROM `".$this->tblPrefix."listing_materials` listing_materials JOIN `".$this->tblPrefix."specifications` specifications ON listing_materials.specification_id=specifications.id JOIN `".$this->tblPrefix."manufacturers` manufacturers ON listing_materials.manufacturer_id=manufacturers.id WHERE listing_materials.category_id_2 = '".$categoryId."' AND listing_materials.listing_active='Y' ORDER BY specifications.specification";
        return $this->query($sql);
    }

    function getManufacturers($categoryId, $specificationId) {
        $sql = "SELECT DISTINCT(listing_materials.specification_id), listing_materials.manufacturer_id, specifications.specification, manufacturers.manufacturer FROM `".$this->tblPrefix."listing_materials` listing_materials JOIN `".$this->tblPrefix."specifications` specifications ON listing_materials.specification_id=specifications.id JOIN `".$this->tblPrefix."manufacturers` manufacturers ON listing_materials.manufacturer_id=manufacturers.id WHERE listing_materials.category_id_2 = '".$categoryId."' AND listing_materials.specification_id='".$specificationId."' AND listing_materials.listing_active='Y'";
        return $this->query($sql);
    }

    function deleteListing($listingId, $deactReason) {
        if ($deactReason) {
            $sql = "UPDATE `".$this->tblPrefix."listing_materials` SET listing_active='M', deact_reason='".$deactReason."' WHERE id='".$listingId."'";
        }
        else {
            return array('ERR','REASON_EMPTY');
        }
        $result = $this->query($sql);
        if ($result) {
            return array('SUC', 'DONE');
        }
        else {
            return array('ERR','NOT_DELETED');
        }
    }

    function restoreListing($listingId) {
        $sql = "UPDATE `".$this->tblPrefix."listing_materials` SET listing_active='Y' WHERE id='".$listingId."'";
        $result = $this->query($sql);
        if ($result) {
            return array('SUC', 'DONE');
        }
        else {
            return array('ERR','NOT_RESTORED');
        }
    }

    function getTotals($customerId,$active='') {
      
        $sql = "SELECT COUNT(supplier_id) as total_count, SUM(unit_cost) as total_sum FROM `".$this->tblPrefix."listing_materials` WHERE
supplier_id='".$customerId."' ";
        if($active) $sql.=" AND listing_active='".$active."'";
        $result = $this->query($sql);
        return $result;
    }

    function get_dList_specification($arrParentId,$status,$supId,$filter=false/* flag for return all the specifications or only listings available specifications*/) {
        $sql = "SELECT specifications.id as specifications_id, specifications.category_id_0, specifications.category_id_1, specifications.category_id_2,
                    specifications.specification, specifications.average_price,manufacturers.id as manufacturers_id, manufacturers.manufacturer,
                    suplistings.unit_cost,	suplistings.bulk_discount,suplistings.bulk_price, suplistings.delivery, suplistings.listing_active,
                    suplistings.deact_reason,	suplistings.added_time, suplistings.last_modified_time, suplistings.id as listing_id,
                    suplistings.image,suplistings.image2,suplistings.image3,suplistings.image4,suplistings.description, suplistings.supplier_code,  specifications.image as spec_image, specifications.description as spec_desc,
                    suplistings.specification as list_spec,suplistings.can_deliver,suplistings.delivery_rate,suplistings.product_url,suplistings.listing_header
                    FROM `".$this->tblPrefix."specifications` specifications JOIN `".$this->tblPrefix."spec_n_manufac` spec_n_manufac ON specifications.id=spec_n_manufac.spec_id
                    JOIN  `".$this->tblPrefix."manufacturers` manufacturers ON manufacturers.id=spec_n_manufac.manu_id ";

        if(!$filter) $sql.=  " LEFT OUTER ";

        $sql.=  "JOIN `".$this->tblPrefix."listing_materials` suplistings ON suplistings.category_id_0=specifications.category_id_0 AND
                    suplistings.category_id_1=specifications.category_id_1 AND suplistings.category_id_2=specifications.category_id_2 AND
                    suplistings.specification_id=specifications.id AND 	suplistings.manufacturer_id=manufacturers.id AND
                    suplistings.supplier_id='".$supId."'

                    WHERE specifications.category_id_0='".$arrParentId[0]."'";
        
         $sql.=      "AND specifications.category_id_1='".$arrParentId[1]."' AND specifications.category_id_2='".$arrParentId[2]."' AND specifications.status='".$status."' ORDER BY specifications.specification, manufacturers.manufacturer";

        $result = $this->query($sql);
        if ($result) {
            for ($i=0; $i<count($result); $i++) {

                $list[$result[$i]['specifications_id']][$result[$i]['manufacturers_id']]=array(
                        $result[$i]['specification'],       // 0
                        $result[$i]['manufacturer'],        // 1
                        $result[$i]['average_price'],       // 2
                        $result[$i]['unit_cost'],           // 3
                        $result[$i]['bulk_discount'],       // 4
                        $result[$i]['bulk_price'],          // 5
                        $result[$i]['delivery'],            // 6
                        $result[$i]['listing_active'],      // 7
                        $result[$i]['deact_reason'],        // 8
                        $result[$i]['added_time'],          // 9
                        $result[$i]['last_modified_time'],  // 10
                        $result[$i]['listing_id'],          // 11
                        $result[$i]['image'],               // 12
                        $result[$i]['description'],         // 13
                        $result[$i]['supplier_code'],       // 14
                        $result[$i]['spec_image'],          // 15
                        $result[$i]['spec_desc'],           // 16
                        $result[$i]['can_deliver'],         // 17
                        $result[$i]['delivery_rate'],       // 18
                        $result[$i]['product_url'],          // 19
                        $result[$i]['listing_header'],           // 20
                        $result[$i]['list_spec'],           // 21
                        $result[$i]['image2'],          // 22
                        $result[$i]['image3'],           // 23
                        $result[$i]['image4'],           // 24
                );
            }

            return $list;
        }
    }


    /*
      *
    */
    function getListingCountsBySpecManufact($specId='') {
        $sql = "SELECT COUNT(*) as count,manufacturer_id FROM `".$this->tblPrefix."listing_materials` WHERE
                    specification_id='".$specId."' GROUP BY manufacturer_id";
        $result = $this->query($sql);

        for ($i=0; $i<count($result); $i++) {
            $arrResult[$result[$i]['manufacturer_id']]=$result[$i]['count'];
        }

        return $arrResult;

    }

    function getListingCountsByCustomer($cusId='') {
        $sql = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."listing_materials`";
        if($cusId) $sql .= " WHERE supplier_id='".$cusId."' ";

        $result = $this->query($sql);

        return $result[0]['count'];
    }

    /*
      * get listing count by categories
    */
    function getListingCountsByCategories($topCategory='1') {
        $sql = "SELECT category_id_0,category_id_1,category_id_2,COUNT(*) as count FROM `".$this->tblPrefix."listing_materials` WHERE
                    category_id_0='".$topCategory."' GROUP BY category_id_0,category_id_1,category_id_2";
        $result = $this->query($sql);

        for ($i=0; $i<count($result); $i++) {
            $arrResult[$result[$i]['category_id_0']][$result[$i]['category_id_1']][$result[$i]['category_id_2']]=$result[$i]['count'];
        }

        return $arrResult;

    }
    /*
      * get listing count by categories
    */
    function getListingCountsByACategory($category,$topCategory='1',$level='0') {
        $list=$this->getListingCountsByCategories($topCategory);

        switch($level) {
            case "0": {

                    // to impliement
                }
                break;
            case "1": {
                    $count=array_sum($list[$topCategory][$category]);
                }
                break;
            case "2": {
                    // to implement
                }
                break;
            default: {
                    $count=0;
                }

        }

        return $count;

    }

    /*
       * get Avarage for given specification and manufacturere
    */
    function getAvgByThirdlevelCategory($thirdLevelCategoryId) {

        $result=$this->query("SELECT Specification_id,manufacturer_id,`category_id_2`,AVG(unit_cost) as average FROM `".$this->tblPrefix."listing_materials` WHERE category_id_2='".$thirdLevelCategoryId."' GROUP BY Specification_id,manufacturer_id ");
        // print_r($result);
        for ($i=0; $i<count($result); $i++) {
            if($result[$i]['average']) {

                $arrResult[$result[$i]['Specification_id']][$result[$i]['manufacturer_id']]=$result[$i]['average'];

            }
        }

        return $arrResult;
    }



    /*
	 * added by chelanga
	 * get number of listing for each thired level category for listing count
    */
    function getListingsforACategory($carlevel1,$catlevel2='',$catlevel3='') {
        //$this->dev=TRUE;
        /*
         * edit by maduranga 2014-01-07
         */
        switch ($carlevel1) {

            case "2":
                $sql = "SELECT COUNT(`".$this->tblPrefix."services`.id) AS count  FROM `".$this->tblPrefix."services` 
                        INNER JOIN `".$this->tblPrefix."subscriptions`
                        ON `".$this->tblPrefix."services`.supplier_id = `".$this->tblPrefix."subscriptions`.customer_id
                        WHERE
                        `".$this->tblPrefix."subscriptions`.subscription_status = 'Y' 
                            AND `@diy_____subscriptions`.customer_id IN (
                            SELECT `customer_id` FROM `".$this->tblPrefix."customers` WHERE `customer_status`='Y')

                        AND category_id_0='".$carlevel1."'"." AND `".$this->tblPrefix."subscriptions`.expire > '".time()."' AND `@diy_____services`.status='Y'";
                break;
            case "3":
                $sql = "SELECT COUNT(id) AS count FROM `".$this->tblPrefix."classified_ads` WHERE category_id_0='".$carlevel1."' AND status='Y'";
                break;
            case "1";
               // $sql = "SELECT COUNT(id) AS count FROM `".$this->tblPrefix."listing_materials` WHERE category_id_0='".$carlevel1."' AND listing_active='Y' AND subscriptions.expire > '".time()."'";
                //break;
            $sql = "SELECT COUNT(`".$this->tblPrefix."listing_materials`.id) AS count  FROM `".$this->tblPrefix."listing_materials` 
                        INNER JOIN `".$this->tblPrefix."subscriptions`
                        ON `".$this->tblPrefix."listing_materials`.supplier_id = `".$this->tblPrefix."subscriptions`.customer_id
                        WHERE
                        `".$this->tblPrefix."subscriptions`.subscription_status = 'Y' 
                            AND `@diy_____subscriptions`.customer_id IN (
                            SELECT `customer_id` FROM `".$this->tblPrefix."customers` WHERE `customer_status`='Y')

                        AND `".$this->tblPrefix."listing_materials`.category_id_0='".$carlevel1."'"." AND `".$this->tblPrefix."subscriptions`.expire > '".time()."'";
                break;

        }

        if($sql) {
            if($catlevel2) $sql.=" AND category_id_1='".$catlevel2."'";
            if($catlevel3) $sql.=" AND category_id_2='".$catlevel3."'";

            $result=$this->query($sql);
        }

        return $result[0]['count'];

    }


    /*
     * view the image in the 
    */
    function image($imgId,$url_ftp,$url_http,$cusId) { 
        
        if(is_file($url_ftp."/".$cusId."/thumbs/".$imgId)) {
            $imgUrl = $url_http."/".$cusId."/thumbs/".$imgId;

        } else {
            $imgUrl = $url_http."/thumbs/no_image.jpg";
        }

        return $imgUrl;
    }
    
    function check_Image_Available($imgId,$url_ftp,$url_http,$cusId){ /*Add my maduranga */
        if(is_file($url_ftp."/".$cusId."/thumbs/".$imgId)) {
           return true;
        } else {
            return false;
        }
    }


    function infoBox($boxIdentifier,$boxContent,$arrValues)
    {
            // default box ideitifier =limitExeed
        $arrKeys=array('{%listCanAdd%}','{%listTotal%}','{%listInactive%}','{%listActive%}','{%listAllowed%}','{%subsURL%}');
        $arrReplace=array($arrValues['listCanAdd'],$arrValues['listTotal'],$arrValues['listInactive'],$arrValues['listActive'],$arrValues['listAllowed'],  $this->core->_SYS['CONF']['URL_MY_ACCOUNT'].'/my_subscriptions/?selections=S&packages=1#upgSubscript',);
        return str_replace($arrKeys, $arrReplace, $boxContent);

    }


    private function checkExistOfAListing($arrParentId,$logId)
    {
        $result=$this->query("SELECT COUNT(*) as count FROM `".$this->tblPrefix."listing_materials`
                              WHERE `category_id_0`='".$arrParentId[0]."' AND `category_id_1`='".$arrParentId[1]."' AND
                                    `category_id_2`='".$arrParentId[2]."' AND `specification_id`='".$arrParentId[3]."' AND
                                     `manufacturer_id`='".$arrParentId[4]."' AND `supplier_id`='$logId'
                              ");
        return $result[0]['count'];
    }
    //end
}



?>
