<?php
/**
 * Description of Promotion
 *
 * @author saliya wijesinghe <saliya@ymail.com>
 */

require_once($objCore->_SYS['PATH']['CLASS_SQL']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);

class Promotion
extends sql {

    private $promotionCode;
    private $gracePeriod;
    
    private $processRecordCount;
    private $dateGap;
    private $arrSubscriptions;
    private $arrGap;
    private $objCustomer;

    /**
     *
     */
    function __Construct($gConf='') {
        parent::__Construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
        $this->processRecordCount=30;
        $this->dateGap=7;
        $this->arrSubscriptions =$this->core->_SYS['CONF']['SUBCRIPTIONS'];
        $this->arrGap=array(7,2,0,-7,-15);
        $this->gConf=$gConf;
        $this->gracePeriod=$this->gConf['GP_NUM_OF_DAYS'];
        $this->objCustomer=new Customer();

    }


    /**
     *
     */
    public function getCode() {
        return $this->promotionCode;
    }
    
   
    /**
     *
     */
    public function onRegistration($package,$email,$grace_period,$ex_period) {
    	
    	
        if(!$email) {   // Please note that the messages has been shared from customer section
            return array('ERR','BLANK');
        }
        elseif($this->isValidEmail($email)) {
            // TO DO : Should check for open key duplicates
            $key=$this->createKey(10);
            $this->promotionCode=date("m").$key;


            $this->add($package,$email,$this->promotionCode,$grace_period,$ex_period);
            return array('SUC','DONE');
        }
        else {
            return array('ERR','EMAIL_NOT_VALID');
        }
        return $this->promotionCode;
    }




    /**
     *
     */
    private function add($package,$email,$code,$grace_period,$ex_period) {

        $toBeExpired= mktime(date("H",time()), date("i",time()), date("s",time()), date("m",time())+$grace_period  , date("d",time()), date("Y",time()));
        
        $this->gracePeriod = $grace_period * 30;
        
        $key = $this->createKey('32', '1');
        
        $objCore=new Core;
        
        $promo_expire = time() + ($ex_period*24*60*60);
        
        $this->query("INSERT INTO `".$this->tblPrefix."promotional_codes`
                        (`code`, `key`, `generated`, `expire`, `package`, `grace_period`, `send_email_to`, `promo_expire`)
                        VALUES ('".$code."','".$key."','".time()."','".$toBeExpired."','".$package."','".$this->gracePeriod."','".$email."','".$promo_expire."')");
        return true;
    }




    /**
     *
     */
    function isValidEmail($email) {
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
        if (eregi($pattern, $email)) {
            return true;
        }
        else {
            return false;
        }
    }
      /**
     *Get all promocodes from db
     */
    public function getPromoteCode($sqlConditions) {
        
        $result=$this->query("SELECT `id`,`code` , `generated` , `expire` , `package` ,
                                `grace_period` , `used` , `cus_id` , `send_email_to`, `promo_expire`, `used_time`
                                FROM `".$this->tblPrefix."promotional_codes` ".$sqlConditions."");
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['id'];              //0
            $list[$i][]=$result[$i]['code'];            //1
            $list[$i][]=$result[$i]['generated'];       //2
            $list[$i][]=$result[$i]['expire'];          //3
            $list[$i][]=$result[$i]['package'];         //4
            $list[$i][]=$result[$i]['grace_period'];    //5
            $list[$i][]=$result[$i]['used'];            //6
            $list[$i][]=$result[$i]['cus_id'];          //7
            $list[$i][]=$result[$i]['send_email_to'];   //8
            $list[$i][]=$result[$i]['promo_expire'];   //9
            $list[$i][]=$result[$i]['used_time'];   //10
        } // End - loop

        return $list;
    }
    /**
     *
     */
    public function getByPromoteCode($code,$used='N') {
        // We need to validate the record
        // get the cus id from the string
        $expOne=explode("[",$code);
        $expTwo=explode("]",$expOne[1]);
        $cusIdFromKey=$expTwo[0];

        if($code) {
            if(!$status) $status='N';
            $result=$this->getFromDb(" WHERE code='$code' AND used='".$used."'" );//AND expire_on>".time()
            if(count($result)==1) {
                return array(
                        'Ack'               =>'Ok',
                        'Id'                =>$result[0][0],
                        'PromotionCode'     =>$result[0][1],
                        'TimeGenerated'     =>$result[0][2],
                        'TimeExpire'        =>$result[0][3],
                        'Package'           =>$result[0][4],
                        'GracePeriod'       =>$result[0][5],
                        'Used'              =>$result[0][6],
                        'CusId'             =>$result[0][7],
                        'MailAddress'       =>$result[0][8],
                        'CodeExpire'        =>$result[0][9],
                        'UsedTime'          =>$result[0][10],
                        'Key'               =>$result[0][11],
                );

            }
            else {
                return array(
                        'Ack'=>'Error',
                        'Message'=>'Invalid Key',
                );

            }
        }
        else {
            return array(
                    'Ack'=>'Error',
                    'Message'=>'Invalid Key',
            );
        }


    }

    /**
     *
     */
    private function getFromDb($sqlConditions,$page='') {
        if(!$page) $page=1;
        $result=$this->queryPg("SELECT `id`,`code` , `generated` , `expire` , `package` ,
                                `grace_period` , `used` , `cus_id` , `send_email_to`, `promo_expire`, `used_time`, `key`
                                FROM `".$this->tblPrefix."promotional_codes`
                $sqlConditions",$page,$this->processRecordCount);
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['id'];              //0
            $list[$i][]=$result[$i]['code'];            //1
            $list[$i][]=$result[$i]['generated'];       //2
            $list[$i][]=$result[$i]['expire'];          //3
            $list[$i][]=$result[$i]['package'];         //4
            $list[$i][]=$result[$i]['grace_period'];    //5
            $list[$i][]=$result[$i]['used'];            //6
            $list[$i][]=$result[$i]['cus_id'];          //7
            $list[$i][]=$result[$i]['send_email_to'];   //8
            $list[$i][]=$result[$i]['promo_expire'];   //9
            $list[$i][]=$result[$i]['used_time'];       //10
            $list[$i][]=$result[$i]['key'];             //11
        } // End - loop

        return $list;
    }
    
    
     /**
     *
     */
    function get_dList($status='', $search='', $searchBy='',$sortBy='',$page='',$from='') {
      if ($search!='' && $searchBy!='') {
                switch ($status){
                    case 'E':
                        $where = " WHERE used='N' AND promo_expire < ".time()." AND ".$searchBy." LIKE '%".$search."%'";
                        break;
                    case 'N':
                        $where = " WHERE used='N' AND promo_expire >= ".time()." AND ".$searchBy." LIKE '%".$search."%'";
                        break;
                    case 'Y':
                        $where = " WHERE used='Y' AND ".$searchBy." LIKE '%".$search."%'";
                        break;
                    default:
                        $where = " WHERE used='Y' AND ".$searchBy." LIKE '%".$search."%'";
                }
                $where .= " ORDER BY `".$sortBy."`";
            
        }
        elseif ($status!='') {
            switch ($status){
                    case 'E':
                        $where = " WHERE used='N' AND promo_expire < ".time()."";
                        break;
                    case 'N':
                        $where = " WHERE used='N' AND promo_expire >= ".time()."";
                        break;
                    case 'Y':
                        $where = " WHERE used='Y'";
                        break;
                    default:
                        $where = " WHERE used='Y'";
                }
                $where .= " ORDER BY `".$sortBy."`";
            
        }
        if($from=='pg'){
            $list=$this->getPromoteCode($where);
        }
        else{
            $list=$this->getFromDb($where,$page);
        }
        
        return $list;
    }
    /**
     *
     */
    public function useCode($code,$customerId) {

        $result= $this->query("UPDATE `".$this->tblPrefix."promotional_codes`
                                SET `used`='Y', `cus_id`='$customerId', `used_time`='".time()."'
                                WHERE `code`='$code'  AND `expire`>".time());
        if($result) {
            return true;
        }
        else {
            return false;
        }

    }
    
     /**
     *
     */
    public function sendAlert($day_before) {

        $list= $this->getFromDb(" WHERE NOT (used='Y') AND promo_expire = '".$day_before."'" );
        $result = array();
        //return $list;
        //exit;
        if(count($list)>0) {
              for($n=0;$n<count($list);$n++)
		{
                $result[$n] = array('code'=>$list[$n][1],'expire'=>$list[$n][3],'email'=>$list[$n][8],'package'=>$list[$n][4],'gracePeriod'=>$list[$n][5]);   
              }  
              return $result;
            }
           else{
               return false;
           }
    }
    
    /**
     *
     */
    private function createKey($alphKeyLength=8 /* length of key*/,$addTime=false) {
        // declare the $key variable
        $key = "";

        $alphSmall = range("a","z"); // create an array for simple letters
        $alphCaps = range("A","Z");  // create an array for capital letters
        $alphNum = range(0,9);  // create an array for numbers
        $alphSpec = array('.','_','@',"|","*",","); // *NOTE - dont use   & ] %  ? [


        $alphArray=array_merge($alphSmall,$alphCaps,$alphNum,$alphSpec);
        $alphArrayLength=count($alphArray)-1;


        for($i = 0; $i < $alphKeyLength; $i++) {

            $key .= $alphArray[rand(0,$alphArrayLength)];

        } // End of the for loop

        if($addTime) $key.=time();//  add the timestamp

        return $key;

    }
    
    public function deleteAuto() {
        $this->query("DELETE FROM `".$this->tblPrefix."promotional_codes`
                      WHERE
                       expire>".time()."
                       AND NOT (used='Y')
                    ");

    }

    /**
     *
     */
    function __Destruct() {


    }
}
?>
