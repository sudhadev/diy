<?
  /*--------------------------------------------------------------------------\
  '    This file is the call login module for the i-desk                      '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliya Wijesinghe <saliyasoft@yahoo.com>            '
  '    FILE            :  crone_sess_out.php                                        '
  '    PURPOSE         :  appoinment structure                                '
  '    PRE CONDITION   :                                                      '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  // essencial coding inclutions
     include("../../config/config.inc.php");
     include("config/config.inc.php");

    // extarnal file inclution
       for($ext=0;$ext<count($arrIncFile);$ext++){if($arrIncFile[$ext]){include($arrIncFile[$ext]);}}

   //
           $sess = new session;
           $sess->sqlType="DELETE";
           $sess->sqlTbl=$tbl_session;
           $sess->sqlWhere="expire<'".time()."'";
           $sess->exe_sql();
           $sess->sqlText="OPTIMIZE TABLE $tbl_session";
           $sess->connect_db();
           $sess->sqlExe=mysql_query($sess-> sqlText) or die(mysql_error());



?>