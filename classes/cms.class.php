<?php

	 /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  classes/page.class.php    				          '
	  '    PURPOSE         :  class page of the cms section                       '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/

	require_once($objCore->_SYS['PATH']['CLASS_SQL']);

	class Cms extends Sql
	{
		function get_dList($pid){
			$where = " WHERE pid='".$pid."'";
			$list=$this->dList($where);
			return $list;
		}
	
		/**
		* Take correspond values that match with PID into a $list array. 
		*/
		function dList($where=''){
			
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("SELECT * FROM `".$tblPrefix."pages`".$where);
			
			for($i=0;$i<count($result);$i++)
			{	
				$list[$i][]=$result[$i]['pid']; // 0
				$list[$i][]=$result[$i]['pagename']; // 1
				$list[$i][]=stripslashes($result[$i]['content']); // 2
				$list[$i][]=$result[$i]['lupdate']; // 3
			}
			return $list;	
		}	
		
		/** 
		* Change the database existing contents of a page according to the new content.
		*/
		function edit($newContent,$reqPId)
		{
			$tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
			$result=$this->query("UPDATE `".$tblPrefix."pages` SET `content`='".addslashes($newContent)."', `lupdate`='".time()."' WHERE `pid`='".$reqPId."'");
			
			if ($result){
				$msg=array('SUC','UPDATE');
				
			}else{
				$msg=array('ERR','NOT_UPDATE');
			}
			return $msg;
		}			
	}

?>
