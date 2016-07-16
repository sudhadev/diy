<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara     	  '
  '    FILE            :  specification.ajax.php          		  			  '
  '    PURPOSE         :  provide listings for any section of the system      '
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
  	require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
        require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
	
	if(!is_object($objSpecification))
	{
            $objSpecification= new Specification;
	}
	if(!is_object($objManufacturer))
        {
            $objManufacturer= new Manufacturer;
        }
	if(!is_object($objCategory))
	{
            $objCategory = new Category();
	}
	
	$arrParentId = explode('_',$_REQUEST['ids']);
	
	switch ($_REQUEST['val'])
	{
		case "edit":
		{
			$specification=addslashes(htmlspecialchars($_REQUEST['spec']));
			$description=addslashes(htmlspecialchars($_REQUEST['desc']));
			$averagePrice=addslashes(htmlspecialchars($_REQUEST['avgpri']));
                        $image = addslashes(htmlspecialchars($_REQUEST['img']));
                        $spec_desc=addslashes(htmlspecialchars($_REQUEST['spec_desc']));
            //$keywords_with_all=addslashes(htmlspecialchars($_REQUEST['kWords']));
            
//            $keywords_with_all = explode('|*|', $_REQUEST['kWords']);
//                        
//            $manufactNameList = explode("-sep-",$keywords_with_all[1]);
//            
//            $keywordsList = explode("\n", $keywords_with_all[0]);
//            
//            
//            foreach($keywordsList as $vals){
//                if(in_array(trim($vals), $manufactNameList)){
//                    
//                }
//                else{
//                    $keywordToAdd .= trim($vals).'\n';
//                }
//            }
//                        
//         
//                    
//            $kWords = $keywordToAdd.str_replace('-sep-', ' \n', $keywords_with_all[1]);
                        
              $kWords =  $_REQUEST['kWords'];        
            
            
            
            $manufactList=addslashes(htmlspecialchars($_REQUEST['manufacturer']));
            $oldmanu=addslashes(htmlspecialchars($_REQUEST['oldmanu']));
            $status=addslashes(htmlspecialchars($_REQUEST['state']));
            $specId = $arrParentId[3];
            $arrManufacurers=explode("-sep-",$manufactList);
            

            /*Check Manufacturers
             */
             // add or condition by chelanga
            if(trim(str_replace("-sep-","",$manufactList)) || $oldmanu){

                        $msg=$objSpecification->edit($arrParentId,$specification,$description,$averagePrice,$kWords,$image,$status,$spec_desc);
                  // add manufacture lists

                           $objManufacturer->editSpecManu($specId,$arrManufacurers);
                           if($status) $objSpecification->updateStatus($arrParentId[3],$status,$objCore->sessUId);
            }
            else
            {
                $msg=array('ERR','MANUFACT_NEED');
            }
                       /* if($msg[0] == "SUC")
                        {
                            if($manufacturer != "")
                            {
                                //$objManufacturer->dev=true;
                                //echo "---->".$oldmanu; exit;
                                $msg = $objManufacturer->editSpecManu($specId,$manufacturer,$oldmanu);
                               
                            }
                            if($msg[0] == "SUC" && $status != "")
                            {
                               
                                $msg=$objSpecification->updateStatus($arrParentId[3],$status,$objCore->sessUId);
                            } 
                        } */
                        
                        /*if($msg[0] == "SUC" && $manufacturer != "")
                        {
                             $msg1 = $objManufacturer->editSpecManu($specId,$manufacturer);
                        }
                        if($msg[0] == "SUC" && $msg1[0] == "SUC" && $status != "")
                        {
                            $msg=$objSpecification->updateStatus($arrParentId[3],$status,$objCore->sessUId);
                        } else
                        {
                            
                        }*/
			
		} break;
		
		case "list":
		{
			$list=$objSpecification->get_dList($arrParentId);
			if($list=="")
			{
				$msg=array('SUC','DELETE');
			}
		} break;
		
		case "delete":
		{
			$msg=$objSpecification->delete($arrParentId);
			
		} break;
		
		case "add":
		{
			$specification=addslashes(htmlspecialchars($_REQUEST['spec']));
			$averagePrice=addslashes(htmlspecialchars($_REQUEST['avgpri']));
			$description=addslashes(htmlspecialchars($_REQUEST['desc']));
			$img=addslashes(htmlspecialchars($_REQUEST['img']));
                        $spec_desc=addslashes(htmlspecialchars($_REQUEST['spec_desc']));
			//$keywords=$_REQUEST['kword'];
                        
                        //$keywords_with_all = explode('|*|', $_REQUEST['kword']);
                        
                        $manufactNameList = str_replace("-sep-"," \n",$keywords_with_all[2]);
                        
                        
                        //$keywords = $keywords_with_all[0].'\n'.$keywords_with_all[1].' \n'.$manufactNameList;
                        
                        $keywords = $_REQUEST['kword'].'\n'.$_REQUEST['spec'];
                        
			$file = $objCore->_SYS['CONF']['FTP_SEARCH_FRONT']."/index.txt";
			

             // Changed by saliya to add manufacturer (copied lakshiys code and insterted with few changes     --------------------->
            $manufactList=addslashes(htmlspecialchars($_REQUEST['manufacturer']));
            $arrManufacurers=explode("-sep-",$manufactList);
         
            
              
            
            /* may be useful if need to add new manufacture with old manufacturers
          if($manufacturer != "")
            {
                $value = $objManufacturer->testManufac($manufacturer,$objCore->sessCusId);
                $manu_add = $value[0];
                $manu_id = $value[1];

            } else
            {
                $manu_add = "blank";
                $manu_id = 0;
            }
             
          

            // specification will added if manufacturer not provided or the provided manufacturer adding is sucess
            if($manu_add != "not_added")
            { 
                $msg = $objSpecification->add($arrParentId,$specification,$averagePrice,$description,$keywords,$objCore->sessUId,$file);print_r($msg);
                $specId = $objSpecification->getSpecId($specification,$arrParentId[2]);


            }
            else
            {

            }* */
            if(trim(str_replace("-sep-","",$manufactList))){
            	
            	 $msg = $objSpecification->add($arrParentId,$specification,$averagePrice,$description,$keywords,$img,$objCore->sessUId,$file,'','',$spec_desc);
                 $specId = $objSpecification->getSpecId($specification,$arrParentId[2]);

                // add manufacture lists
                   if($msg[0]=="SUC")
                   {
                       for($ml=0;$ml<count($arrManufacurers);$ml++)
                       {
                           if(trim($arrManufacurers[$ml])) $objManufacturer->addSpecManu($specId,$arrManufacurers[$ml]);
                       }
                   }


            // -------------------- >
            }
            else
            {
                $msg=array('ERR','MANUFACT_NEED');
            }
		} break;
	}
	
	if($msg)
	{
		echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$msg[0];
	}

?>