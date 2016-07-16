<?php
	  /*--------------------------------------------------------------------------\
	  '    This file is part  module library of FUSIS                             '
	  '    (C) Copyright 2002-2009 www.fusis.com                                  '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>      	  '
	  '    FILE            :  test.php                                            '
	  '    PURPOSE         :  provide the searching list of  manufacturers        '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
	  
	require_once("../../classes/core/core.class.php");$objCore=new Core;
	require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);

	if(!is_object($objManufacturer))
	{
		$objManufacturer = new Manufacturer;
	}
	
	//$manufacturer = $objManufacturer->get_dList_autosuggest($objCore->sessCusId);
        $manufacturer = $objManufacturer->get_dList();

	for($i=0;$i<count($manufacturer);$i++)
	{
		$aUsers[$i] = $manufacturer[$i][1];
	}

	$aInfo = array(); 
	
	$input = strtolower( $_GET['input'] );
	$len = strlen($input);
	
	
	$aResults = array();
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($aUsers[$i]),0,$len)) == $input)
				$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aUsers[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
			
			//if (stripos(utf8_decode($aUsers[$i]), $input) !== false)
			//	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aUsers[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
		}
	}

	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		//echo "sssssssssssss";
	}
?>