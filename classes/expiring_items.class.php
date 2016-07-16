<?php
/**
 * Description of expiring_packages
 *
 * @author saliya
 */

require_once($objCore->_SYS['PATH']['CLASS_SQL']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);

class ExpiringItems
    extends sql
{

    private $objCAdds;
    private $processRecordCount;
    private $dateGap;
    private $arrSubscriptions;
    private $arrGap;
    
    
    /**
     *
     */
    function __Construct()
    {
        parent::__Construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
        $this->processRecordCount=5;
        $this->dateGap=7;
        $this->arrSubscriptions =$this->core->_SYS['CONF']['SUBCRIPTIONS'];
        $this->arrGap=array(7,2,0,-7,-15);

    }

    


    /**
     *
     *
     * 
     */
    public function addExpiringSubscriptions()
    {
        if(!is_object($this->objCAdds)) $this->objCAdds=new ClassifiedAd;

        // get expiring records
           $toBeExpired= mktime(0, 0, 0, date("m",time())  , date("d",time())+$this->dateGap, date("Y",time()));
           $this->dev=true;
           $result=$this->queryPg("SELECT subs.id as subs_id,subs.customer_id,subs.subscription_type,subs.package_type,
                                    subs.package_type_extend,subs.date,subs.last_modified,subs.expire as subs_expire,
                                    subs.no_of_listings,subs.subscription_status,subs.recurring_profile_id,cus.f_name,cus.l_name,cus.email
           FROM `".$this->tblPrefix."subscriptions` subs
           JOIN `".$this->tblPrefix."customers` cus
           ON (
                 subs.expire<$toBeExpired AND
                 subs.alert!='Y'
                 AND cus.customer_id=subs.customer_id
                 AND NOT (subs.subscription_type='C')
               )
          
           ",1,$this->processRecordCount);


                $values="";$comma="";$updateSql="";
                for($i=0;$i<count($result);$i++)
                {
                    // prepare inserts
                       $key=$this->createKey();
                       $key.="[".$result[$i]['customer_id']."]";
                       $key.=$this->createKey(54,true);

                       $orderPeriod="Month";

                       if($result[$i]['subscription_type']=="M")
                       {
                            $title=$this->arrSubscriptions['M']['OPTION']." - ".$this->arrSubscriptions['M'][$result[$i]['package_type']]." - ".$result[$i]['package_type_extend']." ".$orderPeriod."(s)";
                       }
                       else
                       {
                            $title=$this->arrSubscriptions['S']['OPTION']." - ".$result[$i]['package_type']." ".$orderPeriod."(s)";
                       }

                        $type="";
                        if($result[$i]['recurring_profile_id']=="") $type="E";
                            
   
                        $strValues.=$comma." ('".$result[$i]['customer_id']."','".$result[$i]['subscription_type']."', '".$result[$i]['subs_id']."', '".$result[$i]['recurring_profile_id']."',
                                       '".$result[$i]['subs_expire']."', '".$key."', ".time().",'".$title."','".$result[$i]['f_name']." ".$result[$i]['l_name']."','".$result[$i]['email']."','".$type."')";
                        $comma=",";

                        $updateSql[]="UPDATE `".$this->tblPrefix."subscriptions`
                                SET `alert`='Y' WHERE customer_id='".$result[$i]['customer_id']."' AND subscription_type='".$result[$i]['subscription_type']."' LIMIT 1 ; ";


                } // End - loop

                if($strValues) 
                {
                    $this->add($strValues); echo "OK->ITEMS QUEUED -----------------------<br/>";
                    // update the subscription page
                    foreach($updateSql as $value)
                    {
                        $this->query($value);echo "OK->UPDATED ---------------------------<br/>";
                    }
                    
                }


    }
    
    /**
     * 
     */    
    public function addExpiringClassifieds()
    {
        if(!is_object($this->objCAdds)) $this->objCAdds=new ClassifiedAd;

        // get expiring records
           $toBeExpired= mktime(0, 0, 0, date("m",time())  , date("d",time())+$this->dateGap, date("Y",time()));

         // Execute the Query
          $this->dev=true;
          $result=$this->queryPg("SELECT cad.id as cad_id,cad.supplier_id,cad.ad_title,cad.keywords,cad.notes,cad.price,cad.status as cad_status,
           cad.invoice_no,cad.added_date,cad.modified_date,cad.expire_date,cad.recurring_profile_id,cad.image,cus.f_name,cus.l_name,cus.email
           FROM `".$this->tblPrefix."classified_ads` cad
           JOIN `".$this->tblPrefix."customers` cus
           ON (
                cad.expire_date<$toBeExpired
                subs.alert!='Y'
                AND cus.customer_id=cad.supplier_id
               )
           ",1,$this->processRecordCount);


                $values="";$comma="";$updateSql="";
                for($i=0;$i<count($result);$i++)
                {


                    // prepare inserts
                       $key=$this->createKey();
                       $key.="[".$result[$i]['supplier_id']."]";
                       $key.=$this->createKey(54,true); 
                    //
                       $type="";
                       if($result[$i]['recurring_profile_id']=="") $type="E";

                    $strValues.=$comma." ('".$result[$i]['supplier_id']."', 'C', '".$result[$i]['cad_id']."', '".$result[$i]['recurring_profile_id']."',
                                       '".$result[$i]['expire_date']."', '".$key."', ".time().",'".$this->arrSubscriptions['C']['OPTION']." - ".$result[$i]['ad_title']."','".$result[$i]['f_name']." ".$result[$i]['l_name']."','".$result[$i]['email']."','".$type."')";
                    $comma=",";

                     $updateSql.="UPDATE `".$this->tblPrefix."classified_ads`
                                SET `alert`='Y' WHERE customer_id='".$result[$i]['supplier_id']."' AND ID='".$result[$i]['cad_id']."' LIMIT 1 ; ";

                } // End - loop

                if($strValues)
                {
                    $this->add($strValues); echo "OK->ITEMS QUEUED -----------------------<br/>";
                    // update the subscription page
                    $this->query($updateSql);echo "OK->UPDATED ---------------------------<br/>";
                }
    }

    /**
     *
     */
    private function add($strValues)
    {
        if($strValues)
        {
            $this->query("INSERT INTO `".$this->tblPrefix."expiring_items` (`cus_Id`, `subscription`, `subs_id`, `profile_id`, `expire_on`, `access_code`,`record_created`,`description`,`cus_name`,`cus_email`,`type`)
                      VALUES $strValues;");           
        }

 
    }

    /**
     *
     */
    public function getByAlertNo($alertNo=0,$type='E')
    {

           $dateGap=$this->arrGap[$alertNo];
           // get expiring records
           $toBeExpired= mktime(0, 0, 0, date("m",time())  , date("d",time())+$dateGap, date("Y",time()));

           $result=$this->getFromDb(" WHERE expire_on<$toBeExpired AND alert_no='".$alertNo."' AND type='".$type."' ORDER BY expire_on" );
           return $result;


    }

    /**
     *
     */
    public function updateAfterEmailSent($accessCode,$newAlertNo)
    {

           if(!($newAlertNo<0) && $newAlertNo<=count($this->arrGap))
           {
               $this->query("UPDATE `".$this->tblPrefix."expiring_items` SET
                             `alert_no`='".$newAlertNo."', `last_email_sent`='".time()."'
                              WHERE access_code='".$accessCode."'");
           }

    }

    /**
     *
     */
    public function updateAfterAccess($accessCode,$cusId)
    {
         // prepare inserts
            $key=$this->createKey();
            $key.="[".$cusId."]";
            $key.=$this->createKey(54,true);

           if($accessCode && $cusId)
           {
               $this->query("UPDATE `".$this->tblPrefix."expiring_items` SET
                             `access_code`='".$key."'
                              WHERE `access_code`='".$accessCode."'");
           }

    }

    
    /**
     *
     */
    public function getByAccessCode($code)
    {
     // We need to validate the record
        // get the cus id from the string
           $expOne=explode("[",$code);
           $expTwo=explode("]",$expOne[1]);
           $cusIdFromKey=$expTwo[0];
           
           if($cusIdFromKey)
           {
                $result=$this->getFromDb(" WHERE access_code='$code'" );//AND expire_on>".time()
                if(count($result) && $result[0][2]==$cusIdFromKey)
                {
                    return array(
                        'Ack'               =>'Ok',
                        'Id'                =>$result[0][0],
                        'Type'              =>$result[0][1],
                        'CusId'             =>$result[0][2],
                        'Subscript'         =>$result[0][3],
                        'SubscriptID'       =>$result[0][4],
                        'Descript'          =>$result[0][5],
                        'ProfileId'         =>$result[0][6],
                        'ExpireOn'          =>$result[0][7],
                        'AccessCode'        =>$result[0][8],
                        'AlertNo'           =>$result[0][9],
                        'LastEmailedTime'   =>$result[0][10],
                        'RecordCreated'     =>$result[0][11],
                        'Status'            =>$result[0][12],
                        
                    );

                }
                else
                {
                    return array(
                        'Ack'=>'Error',
                        'Message'=>'Invalid Key',
                        );

                }
           }
           else
           {
                    return array(
                        'Ack'=>'Error',
                        'Message'=>'Invalid Key',
                        );
           }


    }

    /**
     *
     */
    private function getFromDb($sqlConditions,$page=1)
    {
        if(!$page) $page=1;
        $result=$this->queryPg("SELECT `id`, `type`, `cus_Id`, `subscription`, `subs_id`,
                             `description`, `profile_id`, `expire_on`, `access_code`,
                             `alert_no`, `last_email_sent`, `record_created`, `status`
                             , `cus_name`, `cus_email`
                              FROM `".$this->tblPrefix."expiring_items`
                              $sqlConditions",$page,$this->processRecordCount);
                for($i=0;$i<count($result);$i++)
                {
                    $list[$i][]=$result[$i]['id'];              //0
                    $list[$i][]=$result[$i]['type'];            //1
                    $list[$i][]=$result[$i]['cus_Id'];          //2
                    $list[$i][]=$result[$i]['subscription'];    //3
                    $list[$i][]=$result[$i]['subs_id'];         //4
                    $list[$i][]=$result[$i]['description'];     //5
                    $list[$i][]=$result[$i]['profile_id'];      //6
                    $list[$i][]=$result[$i]['expire_on'];       //7
                    $list[$i][]=$result[$i]['access_code'];     //8
                    $list[$i][]=$result[$i]['alert_no'];        //9
                    $list[$i][]=$result[$i]['last_email_sent']; //10
                    $list[$i][]=$result[$i]['record_created'];  //11
                    $list[$i][]=$result[$i]['status'];          //12
                    $list[$i][]=$result[$i]['cus_name'];        //13
                    $list[$i][]=$result[$i]['cus_email'];       //14

                } // End - loop

                return $list;
    }

    /**
     * 
     */ 
    private function createKey($alphKeyLength=120 /* length of key*/,$addTime=false)
    {
          // declare the $key variable
            $key = "";

            $alphSmall = range("a","z"); // create an array for simple letters
            $alphCaps = range("A","Z");  // create an array for capital letters
            $alphNum = range(0,9);  // create an array for numbers
            $alphSpec = array('.','_','@',"|","*",","); // *NOTE - dont use   & ] %  ? [


            $alphArray=array_merge($alphSmall,$alphCaps,$alphNum,$alphSpec);
            $alphArrayLength=count($alphArray)-1; 

            
            for($i = 0; $i < $alphKeyLength; $i++)
            {
              
              $key .= $alphArray[rand(0,$alphArrayLength)];

            } // End of the for loop

            if($addTime) $key.=time();//  add the timestamp

            return $key;

    }
    
    
    /**
     *
     */
     public function setDateGap($noOfDate)
     {
         if($noOfDate>7) $this->dateGap=(int)$noOfDate;
     }
     
     
     
    /**
     *
     */
    public function devideExpireRenew()
    {
        $this->processRecordCount=5;
        $result=$this->getFromDb(" WHERE type='' ORDER BY expire_on" );
        $objPayment=new Payment();
        $cyclesRemaining="";
        for($i=0;$i<count($result);$i++)
        {
            $profile=$objPayment->diyRecurringProfileGetFromGateway($result[$i][6]);
            $cyclesRemaining=$profile['RecurringPaymentsSummary']['NumberCyclesRemaining']; 
               if($cyclesRemaining==-1||$cyclesRemaining>0)
               {
                    $type="R";
               }
               else
               {
                     $type="E";
               }

             
             $this->query("UPDATE  `".$this->tblPrefix."expiring_items` SET `type`='".$type."'
                              WHERE access_code='".$result[$i][8]."'");
  
            echo "profile---->$type <br/>";
        } // End - loop


    }    
     
    public function deleteAuto()
    {
        $this->query("DELETE FROM `".$this->tblPrefix."expiring_items`
                      WHERE
                       (type='R' AND alert_no='2')
                       OR (type='E' AND subscription='C' AND alert_no='3')
                       OR (type='E' AND NOT(subscription='C') AND alert_no='5')
                    ");

    }

    /**
     *
     */
    function __Destruct()
    {
   

    }
}
?>
