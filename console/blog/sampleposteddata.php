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
			
			 if ( get_magic_quotes_gpc() ) {
			/* if(1) */
			
			/*Version:5.4.0- Always returns FALSE because the magic quotes feature was removed from PHP. 
				therefore I have add 1 for here.
				ref:
				http://php.net/manual/en/function.get-magic-quotes-gpc.php
			*/ 
				
				$postedValue .=  stripslashes( $value )  ;
			}else{
			
				$postedValue .= htmlspecialchars( $value ) ;}
		}
	}
	//$newContent = $postedValue;
	//$newContent = quotemeta($postedValue);	
	//$newContent = mysql_real_escape_string($postedValue);
	$newContent = $postedValue;
	$reqPId=$_GET['id'];
	$status=$_POST['status'];
	/* $author=$objCore->sessData[0]; */
	$title='';
	if (!empty($_POST['title'])):
	$title=$_POST['title'];
	else:$title='untitled post';
	endif;
	/* print_r($newContent);
	die(); */
?>
