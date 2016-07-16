<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  db_vals.arr.php                                     '
  '    PURPOSE         :  Data Base configuration                             '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  
	switch($ENV)
	{
		case "DEV":
		{
   		$_DB=array('DB'=> array('localhost','diy_v1.1','root','root'));
   			
		}break;
		
		case "DEMO":
		{
   		$_DB=array('DB'=> array('localHost','diyprice_v6','diyprice_v6','juvG48YLAfdtTKWR'));

		
		}break;
		
		case "LIVE":
		{
   		$_DB=array('DB'=> array('localhost','diy','root',''));
		
		}break;
		
	}  




?>
