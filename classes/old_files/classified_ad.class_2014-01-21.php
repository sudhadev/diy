<?php

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
        require_once($objCore->_SYS['PATH']['CLASS_SPELL_CORRECTOR']);
        require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);

	//require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	class ClassifiedAd extends Sql
	{
		private $tblPrefix; 
		private $gConf;
		private $amount;
		private $percentage;
                private $file;
		
        function __construct($gConf='')
        {
            parent:: __construct();
            $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
            $this->gConf=$gConf;
            $this->amount = $this->gConf['CLASSIFIED_ADS_AMOUNT'];
            $this->percentage = $this->gConf['CLASSIFIED_ADS_PERCENTAGE'];
            $this->file = $this->core->_SYS['CONF']['FTP_SEARCH_FRONT']."/index.txt";
        }

        /*
         * validate data (by lakshyami)
        */
        function add($logId,$title,$cat_ids,$notes,$keywords,$price,$keyName,$keyName1,$keyName2,$keyName3,$sel_name,$sup_code,$pr_url)
        {
            //print_r($cat_ids);
           // echo "------------->".$cat_ids[0];
            $category_id_0 = $cat_ids[0];
            $category_id_1 = $cat_ids[1];
            $category_id_2 = $cat_ids[2];
            /*
             * validation of add classified ads.
            */
            if($category_id_0 == "" || $title == "" || $notes == "" || $keywords == "" || $price == "" || $sel_name == "")
            {
                $msg=array('ERR','BLANK');

            }  elseif(!is_numeric($price))
            {
                $msg = array('ERR','NOT_NUMERIC');

            }else
            {
                /*
                 * call to this method to check the amount.
                */
               $amount_to_pay = $this->getClassifiedFares($price);
               if(!intval($amount_to_pay))
               {
                    $staus = "Y";
               } else
               {
                    $staus = "N";
               }
                $msg = $this->addToTbl($logId,$category_id_0,$category_id_1,$category_id_2,$title,$keywords,$notes,$price,$keyName,$keyName1,$keyName2,$keyName3,$staus,$amount_to_pay,$sel_name,$sup_code,$pr_url);
            }
            return $msg;
        }

        /*
         * add data to the table (modified by lakshyami)
        */
   	function addToTbl($customerId, $category_id_0, $category_id_1, $category_id_2, $adTitle, $keywords, $notes, $price,$keyName,$keyName1,$keyName2,$keyName3,$status,$amount_to_pay,$sel_name,$sup_code,$pr_url)
   	{
            $time=time(); $expire_time=mktime(0, 0, 0, date("m",$time)+3, date("d",$time), date("Y", $time));
            $sql = "INSERT INTO `".$this->tblPrefix."classified_ads` (`supplier_id`, `category_id_0`, `category_id_1`, `category_id_2`, `ad_title`, `keywords`, `notes`, `price`, `fee`, `image`,`image2`,`image3`,`image4`, `status`, `added_date`, `modified_date`,`expire_date`, `sellers_name`, `supplier_code`,`product_url`)
                    VALUES ('".$customerId."', '".$category_id_0."', '".$category_id_1."', '".$category_id_2."', '".$adTitle."', '".$keywords."', '".$notes."', '".$price."', '".$amount_to_pay."', '".$keyName."', '".$keyName1."', '".$keyName2."', '".$keyName3."','".$status."','".$time."','".$time."','".$expire_time."','".$sel_name."','".$sup_code."','".$pr_url."')";
            $result = $this->query($sql);
            
            if($result && $status == "Y")
            {
                $objSpellCorrector = new SpellCorrector;
                $objSpellCorrector->addWords($keywords,$this->file);
                return array('SUC', 'DONE');
            }elseif($result && $status == "N")
            {
                return array('PAY', $amount_to_pay, $keyName, $time);
            }
            else
            {
                return array('ERR', 'NOT_ADDED');
            }
   	}

        /**
         * Return the price of resting free ads or have to pay message (by lakshyami)
       
        function available_price($logId)
        {
            $dbPrice = $this->count_db_val($logId);
            if($this->amount > $dbPrice)
            {
                 $available_price = $this->amount - $dbPrice;
            } else
            {
                 $available_price = "have_to_pay";
            }
            //echo "available amount = ".$available_price."<br />";
            return $available_price;
            
        } */

        /**
         * Return the total amount of ads and their total price without considering status. (by lakshyami)
        */
        function total_ads_price($logId,$status="Y")
        {
            /*$result_ads = $this->query("SELECT COUNT(supplier_id) FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$logId."'");
            //print_r($result_ads);
            $totAds = (int)$result_ads[0]['COUNT(supplier_id)'];
            //echo "total ads = ".$totAds."<br />";

            $result_price = $this->query("SELECT SUM(price) FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$logId."'");
            //print_r($result_price);
            $totPrice = (int)$result_price[0]['SUM(price)'];
            //echo "total price = ".$totPrice."<br />";*/

           $q1 = "SELECT COUNT(supplier_id) FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$logId."' AND status='$status'";
           $q2 = "SELECT SUM(price) FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$logId."' AND status='$status'";
           $sql = $q1." UNION ".$q2;
           $result = $this->query($sql);
           
           $totAds =  $result[0]['COUNT(supplier_id)'];
           $totPrice=  $result[1]['COUNT(supplier_id)'];
           
            return array($totAds, $totPrice);
        }

        /**
         * Check available price for status "Y", in the database. (by lakshyami)
        */
        function count_db_val($logId, $status)
        {
            $sql = "SELECT SUM(price) FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$logId."' AND `status`='".$status."'";
            $result = $this->query($sql);
            $dbPrice = (int)$result[0]['SUM(price)'];
            //echo "db amount = ".$dbPrice."<br />";
            return $dbPrice;
        }
        
        /**
         * Check amount. If the supplier's free of charge ads over, then he has to pay. At that
         * time  calculate the price with commission (modified by lakshyami)
        */
   	function checkAmount($customerId, $price)
   	{
            $dbPrice = $this->count_db_val($customerId,"Y");


            //echo "db amount = ".$dbPrice."<br />";
            if($dbPrice >= $this->amount)
            {
                $totAmount = (int)$price;
                $restAmount = ($totAmount * $this->percentage) / 100;
                //echo "have to pay 1 = ".$restAmount."<br />";
                return $restAmount;
            } else
            {
                $totAmount = $dbPrice + (int)$price;
                //echo "tot amount = ".$totAmount."<br />";
                if ($totAmount > $this->amount)
                {
                    $amount = $totAmount - $this->amount;
                    $restAmount = ($amount * $this->percentage) / 100;
                    //echo "have to pay 2 = ".$restAmount."<br />";
                    return $restAmount;
                }else
                {
                    $restAmount = "nopay";
                    //echo "no need to pay <br />";
                    return $restAmount;
                }
            }


   	}

        /*
         * use this to add invoice number to the classified ads table.
         */
        function addInvoiceNo($logId,$invoiceNo,$imgKey,$time)
        {
            $result=$this->query("UPDATE `".$this->tblPrefix."classified_ads` SET `invoice_no`='".$invoiceNo."', `modified_date`='".time()."' WHERE `supplier_id`='".$logId."' AND `added_date`='".$time."' AND `image`='".$imgKey."'");

            if ($result)
            {
                    $msg=array('SUC','UPDATE');
            }else
            {
                    $msg=array('ERR','NOT_UPDATE');
            }
            return $msg;
        }

        /*
         * use this for, after redirect to payment gateway and pay amount, then change his status.(by lakshyami)
        */
        function changeStatus($logId,$invoiceNo,$profileId='')
        {
            $result=$this->query("UPDATE `".$this->tblPrefix."classified_ads` SET `status`='Y', `modified_date`='".time()."',recurring_profile_id='".$profileId."',alert='N' WHERE `supplier_id`='".$logId."' AND `invoice_no`='".$invoiceNo."'");

            if ($result){
                    $msg=array('SUC','UPDATE');

            }else{
                    $msg=array('ERR','NOT_UPDATE');
            }
            return $msg;
        }
        
        /**
        * Call to dList function to take correspond values that match with ID into a $list array. (by lakshyami)
        */
        function get_dList($id='',$logId=''){
            $where = " WHERE id='".$id."' AND `supplier_id`='".$logId."'";
            $list=$this->dList($where);
            return $list;
        }

        /**
        * Take correspond values that match with ID into a $list array.(by lakshyami)
        */
        function dList($where='',$pg='', $paginationSize='', $cat_selection=''){
            if($paginationSize != '')
            {
                $result = $this->queryPg("SELECT * FROM `".$this->tblPrefix."classified_ads` ".$where." ORDER BY `ad_title`", $pg, $paginationSize, 'f=manage&category_selection='.$cat_selection);
            } else
            {
                $result=$this->query("SELECT * FROM `".$this->tblPrefix."classified_ads` ".$where." ORDER BY `ad_title`");
            }
            
            for($i=0;$i<count($result);$i++)
            {
                $list[$i][]=$result[$i]['id']; // 0
                $list[$i][]=$result[$i]['supplier_id']; // 1
                $list[$i][]=$result[$i]['category_id_0']; // 2
                $list[$i][]=$result[$i]['category_id_1']; // 3
                $list[$i][]=$result[$i]['category_id_2']; // 4
                $list[$i][]=$result[$i]['ad_title']; // 5
                $list[$i][]=$result[$i]['keywords']; // 6
                $list[$i][]=$result[$i]['notes']; // 7
                $list[$i][]=$result[$i]['price']; // 8
                $list[$i][]=$result[$i]['image']; // 9
                $list[$i][]=$result[$i]['status']; // 10
                $list[$i][]=$result[$i]['added_date']; // 11
                $list[$i][]=$result[$i]['invoice_no']; // 12
                $list[$i][]=$result[$i]['modified_date']; // 13
                $list[$i][]=$result[$i]['expire_date']; // 14
                $list[$i][]=$result[$i]['recurring_profile_id']; // 15
                $list[$i][]=$result[$i]['fee']; // 16
                $list[$i][]=$result[$i]['sellers_name']; // 17
                $list[$i][]=$result[$i]['supplier_code']; // 18
                $list[$i][]=$result[$i]['product_url']; // 19
                $list[$i][]=$result[$i]['image2']; // 20
                $list[$i][]=$result[$i]['image3']; // 21
                $list[$i][]=$result[$i]['image4']; // 22
            }
            return $list;
        }

        /**
        * validation part at the edit data in the @diy_____admin_users table.
        */
        function edit($logId,$id,$title,$cat_ids,$notes,$keywords,$keyName,$keyName1,$keyName2,$keyName3,$sel_name,$sup_code,$pr_url)
        {
            $category_id_0 = $cat_ids[0];
            $category_id_1 = $cat_ids[1];
            $category_id_2 = $cat_ids[2];

            /*
             * validation of edit classified ads.
            */
            if($category_id_0 == "" || $title == "" || $notes == "" || $keywords == "" || $sel_name == "")
            {
                $msg=array('ERR','BLANK');

            } else
            {
                $section = "";
                $msg = $this->editTbl($logId,$id,$category_id_0,$category_id_1,$category_id_2,$title,$keywords,$notes,$keyName,$section,$sel_name,$sup_code,$pr_url,$keyName1,$keyName2,$keyName3);
            }
            return $msg;
        }

        /**
        * If inserted record is successfull record, edited the @diy_____classified_ads table, at the revalidation part.
        */
        function editTbl($logId='',$id='',$category_id_0='',$category_id_1='',$category_id_2='',$title='',$keywords='',$notes='',$keyName='',$section='',$sel_name='',$sup_code='',$pr_url='',$keyName1='',$keyName2='',$keyName3='')
        {
                if ($section!='')
                {
                    $result = $this->query("UPDATE `".$this->tblPrefix."classified_ads` SET `keywords`='".$keywords."', `image`='".$keyName."', `image2`='".$keyName1."', `image3`='".$keyName2."', `image4`='".$keyName3."',`modified_date`='".time()."' WHERE `supplier_id`='".$logId."' AND `id`='".$id."'");
                }
                else
                {
                    $result = $this->query("UPDATE `".$this->tblPrefix."classified_ads` SET `category_id_0`='".$category_id_0."', `category_id_1`='".$category_id_1."', `category_id_2`='".$category_id_2."', `ad_title`='".$title."', `keywords`='".$keywords."', `notes`='".$notes."', `image`='".$keyName."',`image2`='".$keyName1."', `image3`='".$keyName2."', `image4`='".$keyName3."', `modified_date`='".time()."',`sellers_name`='".$sel_name."',`supplier_code`='".$sup_code."',`product_url`='".$pr_url."' WHERE `supplier_id`='".$logId."' AND `id`='".$id."'");
                }
               
                if ($result){
                    $objSpellCorrector = new SpellCorrector;
                    $objSpellCorrector->addWords($keywords,$this->file);
                    
                    $list=$this->get_dList($id,$logId);
                   // print_r($list);
                    if($list[0][10] == "N")
                    {
                        // get current advertisement charges and update the value
                        $amount_to_pay = $this->checkAmount($logId, $list[0][8]);
                        $this->query("UPDATE `".$this->tblPrefix."classified_ads` SET `fee`='".$amount_to_pay."',`modified_date`='".time()."' WHERE `supplier_id`='".$logId."' AND `id`='".$id."'");
                        $msg = array('PAY', $amount_to_pay, $keyName,$list[0][11]);
                    } else
                    {
                        $msg=array('SUC','UPDATE');
                    }
                }else{
                    $msg=array('ERR','NOT_UPDATE');
                }
                return $msg;
        }

        /*
         * get the category ids (by lakshyami)
        */
        function get_cat_id($id)
        {
            $objCategory = new Category();
            $cat_list = $objCategory->getParentCpath($id);
            $cpath ='';
            for($i=0;$i<count($cat_list);$i++)
            {
              $cpath = $cpath."_".$cat_list[$i]['id'];
            }
            $arry_cpath = explode("_", $cpath);
            /*
             * if the category is not belong to third level $category_id_2 is null, otherwise id will pass to the database.
            */
            $category_id_0 = $arry_cpath[1];
            $category_id_1 = $arry_cpath[2];

            if(count($arry_cpath) > 3)
            {
                $category_id_2 = $arry_cpath[3];
            } else
            {
                $category_id_2 = '';
            }
            return array($category_id_0, $category_id_1, $category_id_2);

            /*$topList=$objCategory->getTopcList();
            $list=$objCategory->getSubcList($topList[$_REQUEST['tcid']]['id'],'sub_arr');
            for ($m=0; $m<count($list); $m++)
            {
                    if ($list[$m][0]==$_REQUEST['pcid']) $temp = $m;
            }
            $listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
            for ($n=0; $n<count($listSub); $n++)
            {
                    if ($listSub[$n][0]==$_REQUEST['catId']) $tempSub = $n;
            }*/

        }

        function deleteClassifiedAd($classifiedAdId, $deactReason)
        {
            if ($deactReason)
            {
                $sql = "UPDATE `".$this->tblPrefix."classified_ads` SET status='M', deact_reason='".$deactReason."' WHERE id='".$classifiedAdId."'";
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

        function restoreClassifiedAd($classifiedAdId)
        {
            $sql = "UPDATE `".$this->tblPrefix."classified_ads` SET status='Y' WHERE id='".$classifiedAdId."'";
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
          * Classified Ads fare handiling section
          */
          function getClassifiedFares($amountOfAd)
          {
                  $result=$this->query("SELECT id,code,price_from,price_to,price,discounts,unit
                                        FROM `".$this->tblPrefix."classified_ads_prices`
                                        WHERE price_from<=$amountOfAd
                                        ORDER BY price_from DESC
                                        ");
                  /*
                   * Calculate the payable and pass it
                   */
                     if($result[0]['unit']=="%"){
                        $orderAmount=$amountOfAd*($result[0]['price']/100);
                     }
                     else
                     {
                        $orderAmount=$result[0]['price'];
                     }

                    return $orderAmount;

          }

          private function getAllClassifiedFares()
          {

                $result=$this->query("SELECT id,code,price_from,price_to,price,discounts FROM `".$this->tblPrefix."classified_ads_prices`");

                for($i=0;$i<count($result);$i++)
                {
                    $list[$i][]=$result[$i]['id'];              // 0
                    $list[$i][]=$result[$i]['code'];            // 1
                    $list[$i][]=$result[$i]['price_from'];      // 2
                    $list[$i][]=$result[$i]['price_to'];        // 3
                    $list[$i][]=$result[$i]['price'];           // 4
                    $list[$i][]=$result[$i]['discounts'];       // 5
                }
                return $list;

          }

      /*
      * get listing count by categories
      */
        function getListingCountsByCategories($topLevel='1',$secondLevel='',$thirdLevel='')
        {
            $sql = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."classified_ads` WHERE status='Y' AND category_id_0='".$topLevel."'";
            if($secondLevel) $sql.=" AND  category_id_1='".$secondLevel."'";
            if($thirdLevel) $sql.=" AND  category_id_2='".$thirdLevel."'";

            $result = $this->query($sql);
            return $result[0]['count'];

        }


    /**
     * Extend the expiaration date
     * ------------------------------------------------------------
     * This method will be used to extend the current expire date
     * of an given add
     *
     * @param string $id
     * @param string $months
     *
     * @return bool
     */
       public function extendExpiration($id,$months)
       {
           $selResult=$this->query("SELECT expire_date,modified_date FROM `".$this->tblPrefix."classified_ads` WHERE id='".$id."'");
           
           // Now We know the current expiaration
              $currExpire=$selResult[0]['expire_date'];


              /*
               * We needs to take some security mesurments to avoid unnecesory atacks as this function is in the public scope
               * 
               */


           // if we passed from all the validating / verification hurdles, now its time to update the expiaration
              $newExp=mktime(date("H",$currExpire), date("i",$currExpire), date("s",$currExpire), date("m",$currExpire)+(int)$months, date("d",$currExpire), date("Y", $currExpire));

              // Update the db
                 if($this->query("UPDATE `".$this->tblPrefix."classified_ads` SET status='Y', `expire_date`='".$newExp."',`modified_date`='".time()."' WHERE id='".$id."'"))
                 {
                     return true;
                 }
                 else
                 {
                     return false;
                 }

       } // End Function - extendExpiration



      /*
       * Function to check expiaration on a given subscription data array
       */
		function getStatus($id)
        {

           $recSet=$this->query("SELECT `status`,`expire_date`,`recurring_profile_id` FROM `".$this->tblPrefix."classified_ads` WHERE id='".$id."'");

           // Now We know the current expiaration , profile etc
              $toBeExpired=$recSet[0]['expire_date'];
              $currStatus=$recSet[0]['status'];
              $currProfile=$recSet[0]['recurring_profile_id'];


           // we have the requested subscription as $freez
           //
           // Now we can check whether specific profile has been expired or not


              $toBeAlerted= mktime(0, 0, 0, date("m",$toBeExpired)  , date("d",$toBeExpired)-14, date("Y",$toBeExpired));

           // Check profile if available
              if($currProfile)
              {
                  $profileFound=true;
                    // Rucurring profile found
                    // Profile details in the 100th index
                       $cyclesRemaining=$subcriptionData[$freez][100]['RecurringPaymentsSummary']['NumberCyclesRemaining'];
                       if($cyclesRemaining==-1||$cyclesRemaining>0)
                       {
                            $activeSchedule=true;
                       }
                       else
                       {
                            $activeSchedule=false;
                       }
              }
              else
              {
                   $profileFound=false;
              }

              // we have necessory information in our hand now
              // lets do checking each status

              if($toBeExpired<time())
              {
                  $flag[0]='EXPIRED';
              }
              elseif($toBeAlerted<time())
              {
                  $flag[0]='ACTIVE'; // currently active

                  if($activeSchedule)
                  {
                        $flag[1]='AUTO'; // auto payment on
                  }
                  else
                  {
                        $flag[1]='TO-EXPIRE'; // auto payment on
                  }



              }
              else
              {
                   $flag[0]='ACTIVE'; // Active
                   if($activeSchedule) $flag[1]='AUTO'; // auto payment on
              }

              return array(
                  // TO be expanded when necessory
                  'Subscription'=>'',
                  'Package'=>'',
                  'Expire'=>$toBeExpired,

                  'Flags'=>$flag,
              );



        } // End - function
}
?>