<?php

	  /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  console/cms/sampleposteddata.php                    '
	  '    PURPOSE         :  create html source code page of the cms section     '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
  
?>

<?php

	/**
	* Create html source code for newly editing data.
	*/
	if ( isset( $_POST ) )
	   $postArray = &$_POST ;			
	else
	   $postArray = &$HTTP_POST_VARS ;	
	
	foreach ( $postArray as $sForm => $value )
	{
		if($sForm=='FCKeditor')
		{
			if ( get_magic_quotes_gpc() )
			{ 
				$postedValue .=  stripslashes( $value )  ;
			}else{
			
				$postedValue .= htmlspecialchars( $value ) ;}
		}
	}
	$newContent = $postedValue;	
?>
