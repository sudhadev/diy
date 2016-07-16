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
   		$_GC=array( 
   				'URL'=>'https://maps.google.com/maps',
  					'KEY'=>'ABQIAAAATV7QWfeiCRcPMgXlRmUQmRQjWYzFojuyEXy3vtUHM5_EKBVujhSdN8bQII--L5ujYVBfC5LOk2m2qA',
 					
   		);
   		
		}break;
		
		case "DEMO":
		{
   		$_GC=array( 
   				'URL'=>'http://maps.google.com/maps',
                    'KEY'=>'ABQIAAAABMbO4BSjYJaYoJi5dbO7uBTWMZKl6uEJTxBME_PK2-CFFhFm-xQirbCLFEeWA1FLazuqurI5szfS-w',
   		);
		
		}break;
		
		case "LIVE":
		{
   		$_GC=array( 
   				'URL'=>'https://maps.google.com/maps',
                               /*  diypricecheck.com key ==>
                                *   'KEY'=>'ABQIAAAABxe-KYM2HMUWZEaB8flyyBRQA8_K7oqHX7JQg-1aH-gCtm64NBQ2YJjRUWz48cuV2nsOFMKb0-d-3g',*/
                    'KEY'=>'ABQIAAAA6xNQFpeIilvMDDbpubPVYxSmqtcqDf4EJBTknLLN0jik4cT3fhTvv-yY5L1Cmk8C60K1pNwn61dOmA',

   		);
		
		}break;
		
	}  
  
  



?>