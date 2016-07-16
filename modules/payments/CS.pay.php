<?

  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliya@fusis.com>          '
  '    FILE            :  client_info.tp.php                                  '
  '    PURPOSE         :  Footer for Admin console                            '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------
  */
  
 /*
  * Currency code should be in number (iso)
  * have to enhance the system in the furuer for multiple currencies
  */
    $arrCurrencies['GBP']=826; //
    
 /*
  * Country code also should be in number (iso)
  * have to enhance the system in the furuer for multiple currencies
  */
    if(!is_object($objCountry))
    {
        require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']);
        $objCountry=new Country();
    }
    $objCountry->isoMap();
    $arrCountries= $objCountry->isoMapCodes;



/*
 * Create data array
 * ATTENTION : Order is very important and always check this with card save reference given below
 * https://mms.cardsaveonlinepayments.com/Pages/PublicPages/PaymentForm.aspx
 */
    // 
    if($objCore->_SYS['ENV']!='LIVE')  $objCore->_SYS['CONF']['GATE_WAY'].="-DEMO";
    
    
    $orderDataArray=array(
        
        'PreSharedKey'=>$objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['PRE_SHARED_KEY'],
        'MerchantID'=>$objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['MERCHANT'],
        'Password'=>$objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['PASS'],
        'Amount'=>($orderDetails[0][24]*100),
        'CurrencyCode'=>$arrCurrencies[$objCore->_SYS['CONF']['CURRENCY_PAY_GATE']],
        'OrderID'=>$orderDetails[0][0],
        'TransactionType'=>$objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['TRANSACTION_TYPE'],
        'TransactionDateTime'=>date("Y-m-d H:i:s O"),//."-04:00",//.getOffset(),
        'CallbackURL'=>$callBackURL,
        'OrderDescription'=>'',
        'CustomerName'=>$orderDetails[0][1]." ".$orderDetails[0][2],
        'Address1'=>$orderDetails[0][5],
        'Address2'=>$orderDetails[0][6],
        'Address3'=>'',
        'Address4'=>'',
        'City'=>$orderDetails[0][7],
        'State'=>'',
        'PostCode'=>$orderDetails[0][8],
        'CountryCode'=>$arrCountries[$orderDetails[0][10]][1]
        
    );

   // print_r($orderDataArray);
/**
 * CAREFUL ** When you are editing following loop
 * Generate string for hash generatiing and all the hidden fields
 */
    $orderDataArrayKeys=array_keys($orderDataArray);
    for($oD=0;$oD<count($orderDataArrayKeys);$oD++)
    {
        // string fro create the hash
        $forHash.="&".$orderDataArrayKeys[$oD]."=".$orderDataArray[$orderDataArrayKeys[$oD]];
        if($oD>2 && $orderDataArrayKeys[$oD]) $hiddenFields.='<input type="hidden" name="'.$orderDataArrayKeys[$oD].'" id="'.$orderDataArrayKeys[$oD].'" value="'.$orderDataArray[$orderDataArrayKeys[$oD]].'"/>'."\n";

    }

    /**
     * Create the HASH
     */
        $hashText=sha1(substr($forHash,1));

    /*
     * Calculate the current time with UTC offset
     * This function returns the UTC offset for the system time of the server that beside this code
     * Written by Saliya Wijesinghe
     */
        function getOffset()
        {
           
            $utcOffsetInSeconds=date("Z",$curTime);
            $utcOffsetHours=intval($utcOffsetInSeconds/3600);
            $utcOffsetMinutes=($utcOffsetInSeconds%3600)/60;if(strlen($utcOffsetMinutes)<2)$utcOffsetMinutes="0".$utcOffsetMinutes;

            if($utcOffsetHours>0)
            {// offset is a + value
                $utcOffsetPrefix="+";
            }
            else
            {// offset is a - value
                $utcOffsetHours=$utcOffsetHours*(-1);
                $utcOffsetPrefix="-";
            }
            $utcOffsetHours=substr("0".$utcOffsetHours,strlen("0".$utcOffsetHours)-2); echo $utcOffsetPrefix.$utcOffsetHours.":".$utcOffsetMinutes."<---------------";
            return $utcOffsetPrefix.$utcOffsetHours.":".$utcOffsetMinutes;
        }



 ?>


<table width="100%" border="0" align="center" style="margin-left:8px">
  <tr>
    <td align="right">
        <form name="aspnetForm" method="post" action="https://mms.cardsaveonlinepayments.com/Pages/PublicPages/PaymentForm.aspx" id="aspnetForm">
            <input type="hidden" id="HashDigest" name="HashDigest" value="<?php echo $hashText?>"/>
            <input type="hidden" id="MerchantID" name="MerchantID" value="<?php echo $objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['MERCHANT'];?>"/>
            <?echo $hiddenFields;?>
            <input type="submit" onclick="startProcessing();" class="btn_Common" value="" name="pay_now" id="payCS" style="display:none;float:left" />
        </form>

    </td>
  </tr>

</table>


