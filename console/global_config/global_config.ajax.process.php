<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>     	  '
  '    FILE            :  global_config.ajax.process.php          		      '
  '    PURPOSE         :  provide global configuration for the system         '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;


	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
  
	/** 
	* Create an object to the Specification class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
	
	if(!is_object($objGlobalConfig))
	{
		$objGlobalConfig = new GlobalConfig;
	}
		
        
    // decode values
     $arrVals=str_replace(array('-slh-'),array('/'),$_GET['arryValues']); 
	$arrayValues= explode(',',$arrVals);
    
	$arrayKeys = explode(',',$_GET['arryKeys']);
	
	for($i=0; $i<count($arrayKeys);$i++)
	{
		$temp = $arrayKeys[$i];
		$newArrayValues[$temp] = $arrayValues[$i];
	}

    /*
     * We have developped a common method to update the global configurations
     * however there are some special casses which we should execute different
     * methods to achive exepcional cases.
     * Here we go with a switch for different cases
     *
     * - Saliya Wijesinghe
     */
    
    switch($_REQUEST['val'])
    {
        case "supplies_fares":
            {

                $msg=$objGlobalConfig->manageSuppliesFares($newArrayValues,$objCore->sessUId);
            }
            break;
        case "ms_smtp":
            {
                foreach($newArrayValues as $value) {if($value){$newString.=$value."|spl|";}}
                //$newArrayValues['MS_LIST']=str_replace("\n","|spl|",$newArrayValues['MS_LIST']);
               

                $newArrayKeys=array('MS_LIST');
                $newArrayValuesFinal=array('MS_LIST'=>$newString);//$objGlobalConfig->dev=true;
                $msg=$objGlobalConfig->edit($newArrayValuesFinal,$newArrayKeys,$_GET['val'],$objCore->sessUId);
            }
            break;
        default:
            {
                $msg=$objGlobalConfig->edit($newArrayValues,$arrayKeys,$_GET['val'],$objCore->sessUId);
            }
            break;
    }
	
    
	if($msg)
	{
		echo $objCore->msgBox("GLOBAL_CONFIG",$msg,'75.99%');
	}





?>