<?php
	
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  captcha.php                                   		'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
	include("../classes/core/core.class.php");
	$objCore=new Core;
	require_once($objCore->_SYS['CONF']['DIR_MODULES']."/captcha/captcha.class.php"); 
	$width = isset($_GET['width']) ? $_GET['width'] : '150';
	$height = isset($_GET['height']) ? $_GET['height'] : '40';
	$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '8';
	$fontPath = $objCore->_SYS['CONF']['DIR_MODULES']."/captcha/monofont.ttf";
	$captcha = new Captcha($width,$height,$characters,$fontPath);
 
?>
