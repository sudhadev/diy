<?php

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	class Order extends Sql 
	{
		private $tblPrefix; 
		private $gConf;
		private $paginationConsole;
		private $paginationFront;
		private $vatStatus;
		private $vat;
        private $adminUser;
		
		function __construct($gConf='')
   	{
		parent:: __construct();   		
   		$this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
   		$this->gConf=$gConf;
   		$this->paginationConsole =  $this->gConf['RECS_IN_LIST_CONSOLE'];
   		$this->paginationFront  =  $this->gConf['RECS_IN_LIST_FRONT'];
   		$this->vatStatus = $this->gConf['ORDER_VAT_CALCULATE'];
   		$this->vatPercentage = $this->gConf['ORDER_VAT_VALUE'];

   	}

    /*
     * Following function is to overcome the issue found
     * on accessing variables with private scope within the child classes
     * if you found a solution - we dont need to use this
     */
    public function getConfigValues()
    {
        return array(
            'tblPrefix'=>$this->tblPrefix,
            'gConf'=>$this->gConf,
            'paginationConsole'=>$this->paginationConsole,
            'paginationFront'=>$this->paginationFront,
            'vatStatus'=>$this->vatStatus,
            'vatPercentage'=>$this->vatPercentage,

        );
    }
   	
   	function setOrder($customerId, $subcription, $package, $amount, $payMethod,$title='')
   	{
   		$objCustomer = new Customer(); 
   		$customerData = $objCustomer->getCustomerData($customerId);
   		$customerInfo = $customerData[0];
   		$content = $subcription."||".$package;
   		$invoiceNo = "1-".str_pad(($customerInfo[17]+284),7,0,STR_PAD_LEFT)."-".time();
   		if ($this->vatStatus == 'Y')
   		{
   			$vat = $amount * ($this->vatPercentage * 0.01);
   		}
   		else
   		{
   			$vat = 0; 
   		}
   		$sql = "INSERT INTO `".$this->tblPrefix."orders` 
                (`invoice_no`, `customer_id`, `f_name`, `l_name`, `dob`, `company`, `address`, `street`, `city`,
                  `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`, `password`, `ip`, 
                  `current_cart_id`, `contents`, `cost_contents`, `cost_ship`, `cost_vat`, `paid`,
                  `time_order`, `time_paid`, `pay_method`, `subscriptions_lock`,`title`)
                   VALUES ('".$invoiceNo."', '".$customerId."', '".$customerInfo[0]."', '".$customerInfo[1]."',
                   '', '".$customerInfo[2]."', '".$customerInfo[3]."', '".$customerInfo[4]."', '".$customerInfo[5]."',
                   '".$customerInfo[6]."', '', '".$customerInfo[7]."', '".$customerInfo[8]."', '".$customerInfo[9]."',
                   '".$customerInfo[10]."', '".$customerInfo[11]."', '', '".$_SERVER['REMOTE_ADDR']."', '',
                   '".$content."', '".$amount."', 0.00, '".$vat."', 'N', '".time()."', '', '".$payMethod."', 'N','".$title."')";
   		//$this->dev = true; 
   		$this->query($sql);
   		return $invoiceNo;  
   	}
   	
   	function updateOrderInfo($invoiceNo,$method='CS')
   	{
   		$sql = "UPDATE `".$this->tblPrefix."orders` SET paid='Y', time_paid='".time()."', pay_method='".$method."' WHERE invoice_no='".$invoiceNo."'";
   		$this->query($sql);
   		return true; 
   	}
   	
   	function getOrderInfo($invoiceNo,$payment=false)
   	{
        if($payment)
        {
   		    $sql = "SELECT `id`, `invoice_no`, `customer_id`, `f_name`, `l_name`, `dob`, `company`, `address`, 
                    `street`, `city`, `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`,
                     `password`, `ip`, `current_cart_id`, `contents`, `cost_contents`, `cost_ship`,
                    `cost_vat`, `paid`, `time_order`, `time_paid`, `pay_method`, `subscriptions_lock` ,`title`
                    FROM `".$this->tblPrefix."orders` WHERE invoice_no='".$invoiceNo."'";
        }
        else
        {
    	    $sql = "SELECT `contents`, `subscriptions_lock`,`title` FROM `".$this->tblPrefix."orders` WHERE invoice_no='".$invoiceNo."' AND paid='Y'";
        }
   		$result = $this->query($sql);
                 if($result[0]['ip']=="::1") $result['ip']='127.0.0.1';
   		return $result;
   	}

   	function getOrderInfoByCus($customer,$invoiceNo='')
   	{
        $where=" customer_id='".$customer."'";
        if($invoiceNo) $where.=" AND invoice_no='".$invoiceNo."'";
   		$sql = "SELECT `id`,`contents`, `subscriptions_lock`,`paid`,`title` FROM `".$this->tblPrefix."orders` WHERE ".$where."";
   		$result = $this->query($sql); 
   		return $result;
   	}
   	
   	function updateLock($invoiceNo)
   	{
   		$sql = "UPDATE `".$this->tblPrefix."orders` SET subscriptions_lock='Y' WHERE invoice_no='".$invoiceNo."'";
   		$this->query($sql);
   		return true;
   	}
   	
   	function getOrderDetails($customer_id, $pg=1, $invoiceNo='', $duration='', $subType='', $keyword='', $searchBy='', $cusIdConsole='', $orderBy='',$paid='Y',$listType='')
   	{ 
        /*
         * get different lists
         */
            switch($listType)
            {
                case "refund":
                    {
                        $sqlEmbed=" AND refund_amount>0 ";
                    }break;

            }



			if ($invoiceNo == '')
			{   		
				if ($customer_id)
				{  			
	   			$sql = "SELECT `invoice_no`, `time_order`, (cost_contents + cost_ship + cost_vat) as `total_cost`,`contents`,`title`,`refund_amount` FROM  `".$this->tblPrefix."orders` WHERE customer_id='".$customer_id."' AND paid='".$paid."'  $sqlEmbed ORDER BY `time_order` DESC";
	   			$result = $this->queryPg($sql, $pg , $this->paginationFront, '');
	   			for($i=0;$i<count($result);$i++)
					{
						$list[$i][]=$result[$i]['invoice_no'];//0
						$list[$i][]=$result[$i]['time_order'];//1
						$list[$i][]=$result[$i]['total_cost'];//2
						$list[$i][]=$result[$i]['f_name'];//3
						$list[$i][]=$result[$i]['l_name'];//4
						$list[$i][]=$result[$i]['email'];//5
						$list[$i][]=$result[$i]['total'];//6
                       
                       // we should use same index in all places
                       // added by saliya
                        $list[$i][25]=$result[$i]['contents'];//25
                        $list[$i][26]=$result[$i]['title'];//26
						$list[$i][29]=$result[$i]['refund_amount'];//29
                    }
					return $list;
				}
				else 
				{
					$sql = "SELECT `invoice_no`, `time_order`, (cost_contents + cost_ship + cost_vat) as `total_cost`, `f_name`, `l_name`, `email`,`refund_amount` FROM  `".$this->tblPrefix."orders` WHERE paid='".$paid."' $sqlEmbed ";
					if ($duration)	
					{
						switch ($duration)
						{
							case 'date':
							{
								$sql.= "AND time_order>".mktime(0, 0, 0, date("m", time()), date("d", time()), date("Y", time()))." ";
							}break;
							case 'month':
							{
								$sql.= "AND time_order>".mktime(0, 0, 0, date("m", time()), 0, date("Y", time()))." ";
							}break; 
							case 'year':
							{
								$sql.= "AND time_order>".mktime(0, 0, 0, 0, 0, date("Y", time()))." ";
							}break; 
						}
					}
					if($subType)
					{
						$sql.= "AND contents LIKE '".$subType."%' ";
					}					
					if ($keyword)
					{
						switch ($searchBy)
						{
							case 'invoice_no':
							{
								$sql.= "AND invoice_no LIKE '%".$keyword."%' ";
							}break; 
							case 'email':
							{
								$sql.= "AND email LIKE '%".$keyword."%' ";
							}break;
						}
					}					
					if ($cusIdConsole)
					{
						$sql.= "AND customer_id='".$cusIdConsole."' ";
					}					
					$sql.= "GROUP BY id ORDER BY ".$orderBy." DESC";
					$str = explode("FROM", $sql); 
					$sqlTotal = "SELECT SUM(cost_contents + cost_ship + cost_vat) as `total`,`refund_amount` FROM ";
					$sqlTotal.= $str[1];
					$resultTotal = $this->query($sqlTotal);
	   			$result = $this->queryPg($sql, $pg , $this->paginationConsole, 'sort_by='.$orderBy.'&time='.$duration.'&sub_type='.$subType.'&search='.$keyword.'&search_by='.$searchBy.'&id='.$cusIdConsole);   			
	   			for($i=0;$i<count($result);$i++)
					{
						$list[$i][]=$result[$i]['invoice_no'];//0
						$list[$i][]=$result[$i]['time_order'];//1
						$list[$i][]=$result[$i]['total_cost'];//2
						$list[$i][]=$result[$i]['f_name'];//3
						$list[$i][]=$result[$i]['l_name'];//4
						$list[$i][]=$result[$i]['email'];//5
						$list[$i][]=$result[$i]['total'];//6

                       // we should use same index in all places
                       // added by saliya
                        $list[$i][25]=$result[$i]['contents'];//25
                        $list[$i][26]=$result[$i]['title'];//26
						$list[$i][29]=$result[$i]['refund_amount'];//29



                    }
					return array($list, $resultTotal[0]['total']);
				} 
			}
			else
			{
				$sql = "SELECT `invoice_no`, `title`,`f_name`, `l_name`, `dob`, `company`, 
                        `address`, `street`, `city`, `postal`, `state`, `country`, `telephone`,
                        `fax`, `mobile`, `email`, `ip`, `current_cart_id`, `contents`, `cost_contents`,
                        `cost_ship`, `cost_vat`, `paid`, `time_order`, `time_paid`, `pay_method`,
                        (cost_contents + cost_ship + cost_vat) as `total_cost`,`fu_by`,`fu_note`,
                        `refund_amount`,`refund_by`,`refund_note`,`refund_time`
                        FROM  `".$this->tblPrefix."orders` WHERE ";
                                
				if ($customer_id) 
				{
					$sql.= "customer_id='".$customer_id."' AND ";
				}
				if ($invoiceNo)
				{
					$sql.= "invoice_no='".$invoiceNo."' ";
				}
                
                $sql.=$sqlEmbed;
				//$sql.= "paid='Y'";
				$result = $this->query($sql);
				for($i=0;$i<count($result);$i++)
				{
					$list[$i][]=$result[$i]['invoice_no'];//0
					$list[$i][]=$result[$i]['f_name'];//1
					$list[$i][]=$result[$i]['l_name'];//2
					$list[$i][]=$result[$i]['dob'];//3
					$list[$i][]=$result[$i]['company'];//4
					$list[$i][]=$result[$i]['address'];//5
					$list[$i][]=$result[$i]['street'];//6
					$list[$i][]=$result[$i]['city'];//7
					$list[$i][]=$result[$i]['postal'];//8
					$list[$i][]=$result[$i]['state'];//9
					$list[$i][]=$result[$i]['country'];//10
					$list[$i][]=$result[$i]['telephone'];//11
					$list[$i][]=$result[$i]['fax'];//12
					$list[$i][]=$result[$i]['mobile'];//13
					$list[$i][]=$result[$i]['email'];//14
					$list[$i][]=$result[$i]['ip'];//15
					$list[$i][]=$result[$i]['current_cart_id'];//16
					$list[$i][]=$result[$i]['cost_contents'];//17
					$list[$i][]=$result[$i]['cost_ship'];//18
					$list[$i][]=$result[$i]['cost_vat'];//19
					$list[$i][]=$result[$i]['paid'];//20
					$list[$i][]=$result[$i]['time_order'];//21
					$list[$i][]=$result[$i]['time_paid'];//22
                    /*we are going to use multiple payment gateways/ methods */
                    $expPay=explode("-",$result[$i]['pay_method']);
					$list[$i][]=$expPay;//23
                    /*-----------------------------------------*/
					$list[$i][]=$result[$i]['total_cost'];//24
					$list[$i][]=$result[$i]['contents'];//25
					$list[$i][]=$result[$i]['title'];//26
					$list[$i][]=$result[$i]['fu_by'];//27
					$list[$i][]=$result[$i]['fu_note'];//28
					$list[$i][]=$result[$i]['refund_amount'];//29
					$list[$i][]=$result[$i]['refund_by'];//30
					$list[$i][]=$result[$i]['refund_note'];//31
					$list[$i][]=$result[$i]['refund_time'];//32
                    
                    
				} 
				return $list;
			}
   	}
   	
   	function deleteOrder($OrderId)
		{
			$sql = "DELETE FROM `".$this->tblPrefix."orders` WHERE invoice_no='".$OrderId."'";
			if ($this->query($sql))
			{
				return array('SUC', 'ORDER_DELETED');
			}
			else 
			{
				return array('ERR', 'ORDER_NOT_DELETED'); 
			}  
		}



    function forceUpdate($invoiceNo,$payMethod,$year,$month,$date,$hour,$minute,$note,$usr)
    {
       // Prepare the time stamp
          if(!$year)   $year  =date("Y");
          if(!$month)  $month =date("n");
          if(!$date)   $date  =date("j");
          if(!$hour)   $hour  =date("H");
          if(!$minute) $minute=date("i");

          $time=mktime($hour,$minute,0,$month,$date,$year);

   		  $sql = "UPDATE `".$this->tblPrefix."orders` SET paid='Y',fu_by='".$usr."',pay_method='".$payMethod."',fu_note='".$note."',time_paid='".$time."' WHERE invoice_no='".$invoiceNo."'";

            if ($this->query($sql))
			{
				return array('SUC', 'FORCE_UPDATED');
			}
			else
			{
				return array('ERR', 'ORDER_NOT_DELETED');
			}



    } // End Function - forceUpdate


    function refund($invoiceNo,$refundAmount,$note,$usr)
    {
       // check user - simple check - to be enhanced in the future when implementing proper user role system
          if(strlen($usr)>6 || is_nan($usr))
          {
              return array('ERR', 'NOT_REFUNDED');
              exit;
          }

       // Get order details
          $orderDetails = $this->getOrderDetails('', 1, $invoiceNo);

       // refunding
          if(count($orderDetails)==1)
          {
              $orderTotal = $orderDetails[0][17];
              $time=time();

              if(($orderTotal<$refundAmount)||$refundAmount<=0)
              {
                  // Error - amount should be equal or less than the order amount
                     return array('ERR', 'REFUND_AMOUNT');
              }
              else
              {
                  // refunding process goes here

                $sql = "UPDATE `".$this->tblPrefix."orders` SET refund_amount='".$refundAmount."',refund_by='".$usr."',refund_note='".$note."',refund_time='".$time."' WHERE invoice_no='".$invoiceNo."'";

                if ($this->query($sql))
                {
                    return array('SUC', 'DONE');
                }
                else
                {
                    return array('ERR', 'NOT_REFUNDED');
                }

              } // End If - check order<refund

          }
          else
          {
              return array('ERR', 'ORDER_NOT_FOUND');
          }// End If - check order count
                    
    } // End Function - refund


    function calcVat($amount)
    {
        if ($this->vatStatus == 'Y')
   		{
   			$vat = $amount * ($this->vatPercentage * 0.01);
   		}
   		else
   		{
   			$vat = 0;
   		}
        return $vat;
    }
} // End Class


    


?>
