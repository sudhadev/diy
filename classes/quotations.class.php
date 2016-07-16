<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sadaruwan Hettiarachchi <sandaruwan@fusis.com>      '
  '    FILE            :  category.class.php                                  '
  '    PURPOSE         :                             			      '
  '    PRE CONDITION   :                                            	      '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once($objCore->_SYS['PATH']['CLASS_SQL']);
require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);

class Quotation extends Sql {

private $logUser;
private $table = "quotations";
private $recscount = "";
private $gConf = "";
public  $grandTotal;


    function __construct($logId='',$gConf='',$user='')
	{
        parent:: __construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
        $this->logUser = $user;
        $this->gConf=$gConf;
        $this->recscount =  $this->gConf['RECS_IN_LIST_FRONT'];
    }

// Get number of quotations
    function getQuotationCount()
    {
        $result = $this->query("SELECT COUNT(*) as count FROM `".$this->tblPrefix.$this->table."` WHERE client_id='".$this->logUser."'");
        return $result['0']['count'];
    }

// Get all quotations
    function getQuotationList($pg='')
    {
    $where = "client_id='".$this->logUser."' ORDER BY id DESC";
    return $this->dList($where,$pg);
    }


    function addQuotation($str)
	{
		$arr = $this->toArray($str) ;
		$n=0;
			foreach ($arr as &$value) {
				$tostringarr[$n][0] = 	$value['id'];
				$tostringarr[$n][1] = 	$value['qty'];
				$tostringarr[$n][2] = 	'0';
				$tostringarr[$n][3] = 	$n;
				$n++;
		}
                $quotation_id = 'Q'.time();
		$strdata = $this->toString($tostringarr);
        $thisTime=time();
        $result=$this->query("INSERT INTO `".$this->tblPrefix.$this->table."`(`client_id`, `quotationid`, `title` ,`content`, `moddate`, `status`)"
                . "VALUES ('".$this->logUser."', '$quotation_id', 'New Quotation','".$strdata."','".$thisTime."','open')");
	
     if ($result){
            // GetThe added record

                $newQuote = $this->query("SELECT id FROM `".$this->tblPrefix.$this->table."` WHERE client_id='".$this->logUser."' AND moddate='".$thisTime."' AND content='".$strdata."'");
            // Update the Wish list
                $this->getQuotationItems($newQuote[0]['id']);
                $this->query("UPDATE `".$this->tblPrefix.$this->table."` SET amount='".$this->grandTotal."' WHERE id='".$newQuote[0]['id']."'");

                        return 1;

                    }else{
                           return 0;
                    }
                   
    }
	
//
    function addQuotationFromWishList($str,$wqLink)
    {
        if($wqLink)
        {//echo "<br/><br/>".$str;
            $arr = $this->toArray($str) ;
            $n=0;
            $quotedItems=$this->getQuotationItems($wqLink);//print_r($this->itemData);
                foreach ($arr as &$value) {
                    $tostringarr[$n][0] = 	$value['id'];
                    $tostringarr[$n][1] = 	$value['qty'];if(!$tostringarr[$n][1])$tostringarr[$n][1]=1;
                    $tostringarr[$n][2] = 	$this->itemData[$value['id']]['cp'];
                    $tostringarr[$n][3] = 	$n;
                    $n++;
            }
            $strdata = $this->toString($tostringarr);//echo "<br/><br/>===>".$strdata;

             $this->query("UPDATE `".$this->tblPrefix.$this->table."` SET `content`='".$strdata."' WHERE id='".$wqLink."'");
             $this->getQuotationItems($wqLink); // its importent to run this function again to get the correct grand total
             $this->query("UPDATE `".$this->tblPrefix.$this->table."` SET amount='".$this->grandTotal."' WHERE id='".$wqLink."'");
             $this->query("UPDATE `".$this->tblPrefix."sys_support` SET wish_quote_link='' WHERE client_id='".$this->logUser."'");


        }
        else
        {
            return $this->addQuotation($str);
        }

    }

// Send data to wish list
    function loadQuotationToWishlist($qid)
    {
   	$result = $this->query("SELECT * FROM `".$this->tblPrefix.$this->table."` WHERE client_id='".$this->logUser."' and id='".$qid."'");
	$arr = $this->toArray($result[0]['content']) ;
        if($arr)
        {
            foreach ($arr as &$value) {
                        $tostringarr[$n][0] = 	$value['id'];
                        $tostringarr[$n][1] = 	$value['qty'];
                        $n++;
                }
            $str = $this->toString($tostringarr);
                 
            // Create the Quotation
            // Updated by Saliya Wijesinghe
            $thisTime=time();
            $thisQuoteId="RE:".$result[0]['quotationid'];
            $this->query("INSERT INTO`".$this->tblPrefix.$this->table."` (client_id,quotationid,title,content,amount,moddate,himage,cdetails,othertxt,status)
            VALUES ('".$this->logUser."', '".$thisQuoteId."', '".$result[0]['title']."','".$result[0]['content']."','".$result[0]['amount']."',
            '".$thisTime."','".$result[0]['himage']."','".$result[0]['cdetails']."','".$result[0]['othertxt']."','open')");

            // GetThe added record
                $newQuote = $this->query("SELECT id FROM `".$this->tblPrefix.$this->table."` WHERE client_id='".$this->logUser."' AND moddate='".$thisTime."' AND content='".$result[0]['content']."'  AND quotationid='".$thisQuoteId."'");
            // Update the Wish list
                $result = $this->query("UPDATE `".$this->tblPrefix."sys_support` SET content_wlist='".$str."',wish_quote_link='".$newQuote[0]['id']."' WHERE client_id='".$this->logUser."'");

                if($result) return $msg = array('SUC','QUOTE_RE_CREATED');
           
        }
	 	 
    }



    function deleteQuotation($qid)
    {
        $result=$this->query("DELETE FROM `".$this->tblPrefix.$this->table."` WHERE `id`='".$qid."'");

            if ($result) {
                $msg=array('SUC','DELETE');

            }else {
                $msg=array('ERR','NOT_DELETE');
            }

    }
	

// Get all items in a quotations
    function getQuotationItems($qid)
    {
    $where = "id='".$qid."'";
    $result = $this->dList($where);
    $itemArr = $this->getValues($result[0][4],$this->logUser);
	$cusItemArr = $this->toArray($result[0][4]);
	$n=0;$this->grandTotal=0;$this->itemData='';
	foreach ($itemArr as &$value) {
		$arr[$n][0] = $value[0];
		$arr[$n][0]['cp'] = $cusItemArr[$value[0]['id']]['cp'];
		$arr[$n][0]['order'] = $cusItemArr[$value[0]['id']]['order'];
		$this->itemData[$value[0]['id']]['cp']=$arr[$n][0]['cp'] ;
		if($cusItemArr[$value[0]['id']]['cp'] && $arr[$n][0]['qty']){
		
		$arr[$n][0]['totle'] = $cusItemArr[$value[0]['id']]['cp'] * $arr[$n][0]['qty'];
		 }elseif($cusItemArr[$value[0]['id']]['cp'])
		 {
			 $arr[$n][0]['totle'] = $cusItemArr[$value[0]['id']]['cp'];
		 }else
		 {
			 switch($arr[$n][0]['type']){
				case"M": {
			 $arr[$n][0]['totle'] = ($arr[$n][0]['qty'])? $arr[$n][0][6] * $arr[$n][0]['qty'] : $arr[$n][0][6];
				} break;
				case"S":{
			 $arr[$n][0]['totle'] = ($arr[$n][0]['qty']) ? $arr[$n][0][10] * $arr[$n][0]['qty'] : $arr[$n][0][10];
				}break;
				case"C":{
			 $arr[$n][0]['totle'] = ($arr[$n][0]['qty']) ? $arr[$n][0][10] * $arr[$n][0]['qty'] : $arr[$n][0][10];
				}break;
			 }
		 }
		$this->grandTotal+=$arr[$n][0]['totle'];
		$n++;
	}

    if(!empty($arr))
          {usort($arr, array("Quotation", "compare"));}

	 return $arr;
    }

    function compare($a, $b)
    {
     if ( $a[0]['order'] == $b[0]['order'] )
      return 0;
     else if ( $a[0]['order'] < $b[0]['order'] )
      return -1;
     else
      return 1;
    }

	function getQuotationDtails($qid)
	{
		$result = $this->query("SELECT * FROM `".$this->tblPrefix.$this->table."` WHERE client_id='".$this->logUser."' and id='".$qid."'");
		return $result;
	}

	function editGenInfo($dataArry)
	{

	          if ($dataArry['title'] == "")
            {
                return array('ERR', 'TITLE_EMPTY');
            }
            
            $tmpvf = explode("/",$dataArry['vfrom']);
	
            if(is_numeric($tmpvf['1']) && checkdate( $tmpvf['1'], $tmpvf['0'], $tmpvf['2']))
            {    
			$vfrom = mktime(0, 0, 0, $tmpvf['1'], $tmpvf['0'], $tmpvf['2']);
            }
            $tmpvt = explode("/",$dataArry['vto']);
            if(is_numeric($tmpvt['1']) && checkdate( $tmpvt['1'], $tmpvt['0'], $tmpvt['2']))
            {
            $vto   = mktime(0, 0, 0, $tmpvt['1'], $tmpvt['0'], $tmpvt['2']);
            }
            if($vto < $vfrom){
                return array('ERR','WRNG_DATE');
            }
            
	$sql = " UPDATE `".$this->tblPrefix.$this->table."` SET `title`='".$dataArry['title']."',`quotationid`='".$dataArry['quotationid']."', `cdetails`='".$dataArry['cusdetails']."', `himage`='".$dataArry['imagename']."', `vfrom`='".$vfrom."', `vto`='".$vto."', `othertxt`='".$dataArry['othertext']."',`pay_method`='".$dataArry['paymethod']."', `status`='".$dataArry['status']."', `moddate`='".time()."' WHERE id='".$dataArry['qid']."'";
    $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_UPDATED');
            }

            }
	
/*	function getArr($qid){
			$where = "quotationid='".$qid."'";
		$result = $this->dList($where);
		return $this->toArray($result[0][4]);
	}*/
	
	function moveItemUp($qid,$id)
	{
		$where = "id='".$qid."'";
		$result = $this->dList($where);
		$arr = $this->toArray($result[0][4]);
		if($arr[$id]['order'] == '0')
		{
			return 0;
		}else{
		$arr[$id]['order']--;
		$n=0;
		foreach ($arr as &$value) {
			$tostringarr[$n] = 	$value;
			if($value['order']==$arr[$id]['order'] && $value['id'] != $id)
			{
			$tostringarr[$n]['order']++;
			}
			$n++;
		}
		}
		$content = $this->toString($tostringarr);
		
		$sql = " UPDATE `".$this->tblPrefix.$this->table."` SET content='".$content."' WHERE id='".$qid."'";
		 $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_MOVED');
            }
			return 0;
	}


	function moveItemDown($qid,$id)
	{
		$where = "id='".$qid."'";
		$result = $this->dList($where);
		$arr = $this->toArray($result[0][4]);
		if($arr[$id]['order'] == count($arr))
		{
			return 0;
		}else{
		$arr[$id]['order']++;
		$n=0;
		foreach ($arr as &$value) {
			$tostringarr[$n] = $value;
			if($value['order']==$arr[$id]['order'] && $value['id'] != $id)
			{
			$tostringarr[$n]['order']--;
			}
			$n++;
		}
		}
		$content = $this->toString($tostringarr);
		
		$sql = " UPDATE `".$this->tblPrefix.$this->table."` SET content='".$content."' WHERE id='".$qid."'";
		 $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_MOVED');
            }
			return 0;
	}
	
	function delItem($qid,$id)
	{
				$where = "id='".$qid."'";
		$result = $this->dList($where);
		$arr = $this->toArray($result[0][4]);

		$n=0;
		foreach ($arr as &$value) {
			
			if($value['id'] != $id)
			{
				$tostringarr[$n] = 	$value;
				$tostringarr[$n]['order'] = $n;
				$n++;
			}
			
		}
		
		$content = $this->toString($tostringarr);
		
		$sql = " UPDATE `".$this->tblPrefix.$this->table."` SET content='".$content."' WHERE id='".$qid."'";
		 $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_MOVED');
            }
			return 0;
	}
	
	function editItem($itemData){
		
		$where = "id='".$itemData['qid']."'";
		$result = $this->dList($where);
		$arr = $this->toArray($result[0][4]);
		$n=0;
        if(empty($arr)){return 0;}
        
		foreach ($arr as &$value) {
				$tostringarr[$n]['id'] = 	$value['id'];
				$tostringarr[$n]['qty'] = 	$itemData['qty'][$value['id']]; if(!$tostringarr[$n]['qty'])$tostringarr[$n]['qty']=1;
				$tostringarr[$n]['cp'] = 	$itemData['unitp'][$value['id']];
				$tostringarr[$n]['order'] = 	$value['order'];
				$n++;
		}
		
	 $content = $this->toString($tostringarr);
		$this->getQuotationItems($itemData['qid']);
		$sql = " UPDATE `".$this->tblPrefix.$this->table."` SET content='".$content."',amount='".$this->grandTotal."' WHERE id='".$itemData['qid']."'";
		 $result = $this->query($sql);
            if ($result)
            {
                return array('SUC', 'DONE');
            }
            else
            {
                return array('ERR','NOT_MOVED');
            }
			return 0;
	}
	
	function getValues($tempValue,$customer_id)
        {
             $temp= explode('-dlm-',$tempValue);
             $objCustomer = new Customer();
             $cusData = $objCustomer->getCustomerData($customer_id);
             $latitude = $cusData[0][15];
             $longitude = $cusData[0][16];

             $objSearch = new Search($this->gConf);
             $objService = new Service($this->gConf);
             $objListing = new Listing();
             $objClassifiedAd = new ClassifiedAd($this->gConf);

             for($i=1; $i<count($temp); $i++)
             {
                $tempRecord = explode('-spl-',$temp[$i]);
              
                $subscriptionAndId = $tempRecord[0];
                $subscription = $subscriptionAndId[0];
                $listing_id = str_replace($subscription, '', $subscriptionAndId);
                     $quantity = $tempRecord[1];
                if( "M" == substr($temp[$i],0,1))
                {
                   
                    $where = " WHERE `id`= '".$listing_id."' AND `listing_active`='Y' ";
                    $list = $objListing->dList($where);
                    $subcategory_id = $list[0][3];
                    $specification_id = $list[0][4];
                    $manufacturer_id = $list[0][13];

                    $listValues[$i] = $objSearch->getSuppliers($subcategory_id, $specification_id, $manufacturer_id,$pg,'','','','',$latitude,$longitude,'',$listing_id);
                    $listValues[$i][0]["qty"]=$quantity;
					$listValues[$i][0]["type"]="M";
					$listValues[$i][0]["id"]="M".$listValues[$i][0][18];
                    
                }  elseif("S" == substr($temp[$i],0,1))
                {
                    $where = " WHERE `id`= '".$listing_id."' AND `status`='Y' ";
                    $list = $objService->dList($where);
                    $subcategory_id = $list[0][2];
                    if($subcategory_id == "")
                    {
                        $subcategory_id = $list[0][1];
                    }
                    $listValues[$i] = $objSearch->getServiceList('', $latitude, $longitude, '', $pg, $subcategory_id, '', '', '',$listing_id);
                    $listValues[$i][0]["type"]="S";
                    $listValues[$i][0]["qty"]=$quantity;
					$listValues[$i][0]["id"]="S".$listValues[$i][0][20];

                }elseif("C" == substr($temp[$i],0,1))
                {
                    $where = " WHERE `id`= '".$listing_id."' AND `status`='Y'";
                    $list = $objClassifiedAd->dList($where);
                    $subcategory_id = $list[0][4];
                    if($subcategory_id == "")
                    {
                        $subcategory_id = $list[0][3];
                    }
                    $listValues[$i] = $objSearch->getClassifiedList('', $latitude, $longitude,'', $pg, $subcategory_id, '', '', '', $listing_id);
					$listValues[$i][0]["type"]="C";
                    $listValues[$i][0]["qty"]=$quantity;
					$listValues[$i][0]["id"]="C".$listValues[$i][0][14];
                }
            }
           if($listValues){
            return array_values($listValues);
           }
           return array();
        }

//Convert String to array
	function toArray($str)
	{
		$tmpItemArr = array_filter(explode('-dlm-',$str));
		foreach ($tmpItemArr as &$value) {
    		$ItemArr = explode('-spl-', $value);
			$arr[$ItemArr[0]]['id'] = &$ItemArr[0]; // Item ID
			$arr[$ItemArr[0]]['qty'] = &$ItemArr[1]; // Item Quantity
			$arr[$ItemArr[0]]['cp'] = &$ItemArr[2]; // Item custom price
			$arr[$ItemArr[0]]['order'] = &$ItemArr[3]; // Item order
		}
		return $arr;
	}

//convert to Array
	function toString($arr)
	{
		$n = 0;
		foreach ($arr as &$value) {
		$temparr[$n] = implode("-spl-", $value);
		$n++;
		}
		$str = implode("-dlm-", $temparr);
		$str = "-dlm-".$str."-dlm-";
		return $str;
	}
	
// Take correspond values that match with ID into a $list array.
    function dList($where='', $pg='', $url='') {
        $sql = "SELECT * FROM `".$this->tblPrefix.$this->table."` WHERE ".$where."";
        $result = $this->queryPg($sql, $pg ,$this->recscount, $url);

      for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['id'];				// 0
            $list[$i][]=$result[$i]['client_id']; 		// 1
            $list[$i][]=$result[$i]['quotationid']; 	// 2
            $list[$i][]=$result[$i]['title']; 		    // 3
            $list[$i][]=$result[$i]['content']; 	    // 4
            $list[$i][]=$result[$i]['amount']; 		    // 5
            $list[$i][]=$result[$i]['moddate']; 	    // 6
        }
        return $list;
    }

    /*
     * view the image added by saliya (initial code written by lakshyami)
    */
    function image($imgId,$type='thumbs') {
        if(is_file($this->core->_SYS['CONF']['FTP_QUOTATIONS']."/".$type."/".$imgId)) {
            $imgUrl = $this->core->_SYS['CONF']['URL_IMAGES_QUOTATIONS']."/".$type."/".$imgId;
        }

        return $imgUrl;
    }

}
