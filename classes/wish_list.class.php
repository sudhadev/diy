<?php
/*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
    '    FILE            :  console/category/category_add.ajax.tpl.php          '
    '    PURPOSE         :  add users page of the user section                  '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
        require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
        require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
        require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
        require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
        require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
	
	class WishList extends Sql
	{
		private $tblPrefix; 
		private $gConf;
        private $wishListContent;
		
        function __construct($gConf='')
        {
            parent:: __construct();
            $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
            $this->core->sysCheck(); // we need to get the sysVars in order to retrieve the content of the wish list
            $this->wishListContent=$this->core->sysVars['WishList']; // take the content of the wish list
            $this->gConf=$gConf;
        }

        /*
         * take the checked values.
         * $listing_id is the values in the hidden field. it returns the all listing ids in the tpl.
         * $quantity is for the building supplies section. it returns the quantities for all the listings in the tpl.
         * $checkVal returns the listing ids in checked values.
         * $subscription is the parent category type for the regarding tpl.
        */
        function checkedValues($listing_id, $quantity, $checkVal,$subcription)
        {
            /*
                listing ids in hidden filed
                Array ( [0] => 143 [1] => 142 [2] => 144 [3] => 145 )
                quantities
                Array ( [0] => 10 [1] => 20 [2] => 30 [3] => 40 )
                cheked values
                Array ( [0] => 143 [1] => 142 [3] => 145 )
            */
            
            
            $str='-dlm-';
            $checkVal = array_values($checkVal);
            //print_r($checkVal);
            if($subcription == "M")
            {
                $arryVals = array();
                
                for($i=0; $i<count($listing_id); $i++)
                {
                    for($j=0; $j<count($checkVal); $j++)
                    {
                        if($listing_id[$i] == $checkVal[$j])
                        {
                            $arryVals[] = $listing_id[$i]."||".$quantity[$i];
                        }
                    }
                }
                
               
                
                for($i=0; $i<count($arryVals); $i++)
                {
                    $temp= explode('||',$arryVals[$i]);
                    $listingId= $temp[0];
                    $quantityValue = $temp[1];
                    $msg = $this->validateQty($quantityValue);

                    if($msg[0] == "ERR")
                    {
                        break;

                    }elseif($msg[0] == "SUC")
                    {
                        $str.=$subcription.$listingId."-spl-".intval($quantityValue)."-dlm-";
                        //echo $i."".$str."<br />";
                    }
                }
            } else
            {
                for($i=0; $i<count($checkVal); $i++)
                {
                    $listingId = $checkVal[$i];
                    $str.= $subcription.$listingId."-spl-0-dlm-";
                    $msg = array("SUC");
                }
            }
            return array($msg,$str);
        }

        /*
         * validate the quantity field.
         */
        function validateQty($quantityValue)
        {
            if($quantityValue == "")
            {
                $msg = array("ERR", "BLANK");
            } elseif(!is_numeric($quantityValue))
            {
                $msg = array("ERR", "NOT_NUMERIC");
            } else
            {
                $msg = array("SUC");
            }
            return $msg;
        }

        /*
         * get database data to display with in the tpl.
         */
        function getValues($tempValue,$customer_id,$pg,$subscriTpl)
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

             $mIndex = 0; $sIndex = 0; $cIndex = 0;
             $this->itemCounts['M']=$this->itemCounts['S']=$this->itemCounts['C']=0;// initialize the total count
             for($i=1; $i<count($temp); $i++)
             {
                $tempRecord = explode('-spl-',$temp[$i]);
                $subscriptionAndId = $tempRecord[0];
                $subscription = $subscriptionAndId[0];
                $listing_id = str_replace($subscription, '', $subscriptionAndId);

                //Get Total counts ---------
                // Added By Saliya
                    if($subscription) $this->itemCounts[$subscription]++;


                //---------------------
                if($subscription == "M" && $subscriTpl == "M")
                {
                    $quantity = $tempRecord[1];

                    $where = " WHERE `id`= '".$listing_id."' AND `listing_active`='Y' ";
                    $list = $objListing->dList($where);
                    $subcategory_id = $list[0][3];
                    $specification_id = $list[0][4];
                    $manufacturer_id = $list[0][13];
					/* change to new function to get wishlist list - maduranga**/
                    $listValues[$mIndex] = $objSearch->getSuppliers_wishlist($subcategory_id, $specification_id, $manufacturer_id,$pg,'','','','',$latitude,$longitude,'',$listing_id);
                    $listValues[$mIndex][0]["qty"]=$quantity;
                    $mIndex++;

                }  elseif($subscription == "S" && $subscriTpl == "S")
                {
                    $where = " WHERE `id`= '".$listing_id."' AND `status`='Y' ";
                    $list = $objService->dList($where);
                    $subcategory_id = $list[0][2];
                    if($subcategory_id == "")
                    {
                        $subcategory_id = $list[0][1];
                    }
                    $listValues[$sIndex] = $objSearch->getServiceList('', $latitude, $longitude, '', $pg, $subcategory_id, '', '', '',$listing_id);
                    $sIndex++;
                    
                }elseif($subscription == "C" && $subscriTpl == "C")
                {
                    $where = " WHERE `id`= '".$listing_id."' AND `status`='Y'";
                    $list = $objClassifiedAd->dList($where);
                    $subcategory_id = $list[0][4];
                    if($subcategory_id == "")
                    {
                        $subcategory_id = $list[0][3];
                    }
                    $listValues[$cIndex] = $objSearch->getClassifiedList('', $latitude, $longitude,'', $pg, $subcategory_id, '', '', '', $listing_id);
                    $cIndex++;
                }
            }
            //print_r($objSearch);
             //print_r($listValues);
            return $listValues;
        }

        /*
         * If client is adding a record, this will check that listing id is already added one
         * and then it replace the with the new values. if not already existing record, then
         * newly amment that to the database record.
         * 1st parametere : old database value
         * 2nd parameter : newly added temp value in the database
         */
        function updateTmpValue($dbVal, $newVal)
        { 
            //echo "old db val = ".$dbVal."<br />";
            //echo "new val = ".$newVal."<br />";
            $arrydbVal = explode('-dlm-',$dbVal);
            //print_r($arrydbVal);
            //echo "**************<br />";
            $arryWishListItems = array();
            
            for($j=1; $j<count($arrydbVal)-1;$j++)
            {
                $tempNewRecordDb = explode('-spl-',$arrydbVal[$j]);
                $arryWishListItems[$tempNewRecordDb[0]]['completeValue']=$arrydbVal[$j];
                $arryWishListItems[$tempNewRecordDb[0]]['index']=$j;
                $arryWishListItems[$tempNewRecordDb[0]]['item']=$tempNewRecordDb[0];
                $arryWishListItems[$tempNewRecordDb[0]]['qty']=$tempNewRecordDb[1];
            }

            //print_r($arryWishListItems);
            $arryWishListItemsKeys = array_keys($arryWishListItems);

            $itemCount = count($arrydbVal);
            $nxtVal = $itemCount - 1;
            $arryNewVal = explode('-dlm-',$newVal);

            for($i=1;$i<count($arryNewVal)-1;$i++)
            {
                $tempNewRecord = explode('-spl-',$arryNewVal[$i]);
                if($tempNewRecord[1] == "")
                {
                    $qty = 0;
                }else
                {
                    $qty = $tempNewRecord[1];
                }
                //echo $tempNewRecord[0]."<br />";
                //print_r($arryWishListItemsKeys);
                if(in_array($tempNewRecord[0],$arryWishListItemsKeys))
                {
                    $arrydbVal[$arryWishListItems[$tempNewRecord[0]]['index']]=$arryWishListItems[$tempNewRecord[0]]['item']."-spl-".$tempNewRecord[1];
                    //echo "match ".$arrydbVal[$arryWishListItems[$tempNewRecord[0]]['index']]." = ".$arryWishListItems[$tempNewRecord[0]]['item']."-spl-".$tempNewRecord[1]."<br />";
                }else
                {
                    $add_dlm = 1;
                    $arrydbVal[$nxtVal++] = $arryNewVal[$i];
                    //echo "no match <br />";
                }
            }
            $str=implode("-dlm-",$arrydbVal);
            if($dbVal == "")
            {
                $str = "-dlm-".$str;
            }
            if($add_dlm == 1)
            {
                 $str = $str."-dlm-";
            } else
            {
                $str = $str;
            }
            return $str;
        }

        /*
         * delete the selected record from the wishlist.
         */
        function delete($suscri_listingId, $dbVal)
        {
            $arrydbVal = explode('-dlm-',$dbVal);
            for($j=1; $j<count($arrydbVal);$j++)
             {
                $tempdbRecord = explode('-spl-',$arrydbVal[$j]);

                $subscriptionAndId = $tempdbRecord[0];
                $dbSubscription = $subscriptionAndId[0];
                $dbListing_id = $subscriptionAndId[1];

                if($suscri_listingId == $subscriptionAndId)
                {
                    $dbVal = str_replace("-dlm-".$arrydbVal[$j],'', $dbVal);
                    break;
                }
             }
             //echo "after delete 1 =>".$dbVal."+++<br />";
             if($dbVal == "-dlm-")
             {
                 //$dbVal = '';
             }
             //echo "after delete 2 =>".$dbVal."++++<br />";
             return $dbVal;
        }

        function itemCount($dbVal='')
        {
            if(!$dbVal)
            {
                $dbVal = $this->wishListContent;
            }
            $arrydbVal = explode('-dlm-',$dbVal);
            if(count($arrydbVal) > 1)
            {
                $totCount = count($arrydbVal) - 2;
            } else
            {
                $totCount = 0;
            }
            return $totCount;
        }
}
?>