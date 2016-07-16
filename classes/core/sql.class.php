<?php

/* --------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  sql.class.inc.php                                '
  '    PURPOSE         :  class SQL                                     '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

class Sql {

    private $qCount;
    private $totalCount;
    public $ajaxPgBarFunction;

    function __construct() {
       
        $this->core = new Core;
        $this->qCount = 1;
    }

    function __destruct() {
        $this->core = new Core;
        $this->qCount = 1;
        $this->dev = false;
    }

    /**
     *
     */
    function query($query, $db='DB') {
        if ($query) {
            $this->sqlText = $query;
            $this->sqldb = $this->core->_SYS['DB'][$db]; //echo "========>";print_r($this->sqldb);
            $expST = explode(" ", trim($this->sqlText));
            switch ($expST[0]) {
                case "SELECT": {
                        return $this->read_db();
                    }break;

                default: {
                        return $this->exe_sql();
                    }
            }
        } else {
            return false;
        }
    }

    /**
     *  Execute the SQL Query
     */
    private function exe_sql() {

        $this->connect_db();
        if ($this->dev) {
            echo "Query #" . $this->qCount . "<br/>----------------</br>" . $this->sqlText . "<br/><br/>";
            $this->qCount++;
        }
        $this->sqlExe = mysql_query($this->sqlText, $this->connect) or die(mysql_error());
        $expST = explode(" ", trim($this->sqlText));
        if ($expST[0] == "INSERT"
            )$this->lastID = mysql_insert_id();
        $this->disconnect_db(); // break the connection
        if ($this->sqlExe) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Read the table and store data to an array
     */
    private function read_db() {
        $this->exe_sql();
        $this->getFields($this->sqlExe);
        $counter = 0;

        // explode the field list

        while ($raw = mysql_fetch_array($this->sqlExe)) {

            for ($l = 0; $l < count($this->returnFields); $l++) {//echo $this->returnFields[$l];echo $raw[$this->returnFields[$l]];
                $arrData[$counter][str_replace("`", "", $this->returnFields[$l])] = stripslashes(trim($raw[$this->returnFields[$l]]));
            }
            $counter++;
        }

        return $arrData;
    }

    /**
     *  Read the table and store data to an array
     */
    private function getFields($result) {
        $i = 0;
        $this->returnFields = '';
        while ($i < mysql_num_fields($result)) {
            $meta = mysql_fetch_field($result, $i);
            $this->returnFields[] = $meta->name;
            $i++;
        }
    }

    /**
     *  Connect with the database
     */
    private function connect_db() {

        $this->connect = mysql_connect($this->sqldb[0], $this->sqldb[2], $this->sqldb[3]) or die("ERROR::>1505");
        mysql_select_db($this->sqldb[1], $this->connect) or die("database connection failed");
    }

    /**
     *  Disconnect fromm the database
     */
    private function disconnect_db() {
        mysql_close($this->connect);
    }

    /**
     *  function for the generating the pabe bar
     */
    public function queryPg(/* 1-SQL Query */$query, /* 2-Current Page */ $pg=1, /* 3-Record Per Page */ $recPerPage=1, /* 4- Query String */ $qString='', /* 5- CSS Style */ $style='', /* 6- Page Count */ $pgCount='', /* 7- Data Base */ $db='DB') {
        if (!$recPerPage)
            $recPerPage = 1;

        if (!$pgCount) {
            $pgCount = $this->get_pgs($query, $db, $recPerPage);
        }


        // generating the page bar
        if ($pgCount > 1) { // Page bar not necessory if there is only one page available
            $this->pgbar_presets(); // Presets of the page bar
            // initializing essencial variables
            $pgStartFrom = 1; // Page number Start from this
            if (!$pg || $pg == 'undefined')
                $pg = 1;

            $qString.='&t=' . time();


            $this->pgBar = "<span id=\"pgBar\">" . $this->pgBarStrPage;


            // link for previous page
            if ($pg != 1) {

                if (!$this->ajaxPgBarFunction) {
                    $linkPre = "$PHP_SELF?pg=" . ($pg - 1) . "&" . $qString;
                } else {
                    // Code for AJAX

                    $linkPre = str_replace("{%PG%}", ($pg - 1), $this->ajaxPgBarFunction);
                }

                $this->pgBar.="&nbsp;&nbsp;<a href=\"" . $linkPre . "\" id=\"PreNextLinks\">" . $this->pgBarStrPrevious . " </a></font>";
            }

            // reduse the no of pages showing at a time
            if ($pgCount > 15) {
                if ($pg > 5) {
                    if ($pg + 11 <= $pgCount) {
                        $pgStartFrom = $pg - 4;
                        $pgCount = $pgStartFrom + 14;
                    } else {
                        $pgStartFrom = $pgCount - 14;
                        $pgCount = $pgCount;
                    }
                } else {
                    $pgCount = 15;
                }
            }

            // generating the page bar wity loop
            for ($p = $pgStartFrom; $p <= $pgCount; $p++) {
                if ($p == $pg) {
                    $this->pgBar.="&nbsp;<span id=\"pageSelected\">$p</span>";
                } else {

                    if (!$this->ajaxPgBarFunction) {
                        $linkCurrent = "$PHP_SELF?pg=" . $p . "&" . $qString;
                    } else {
                        // Code for AJAX
                        $linkCurrent = str_replace("{%PG%}", $p, $this->ajaxPgBarFunction);
                    }

                    $this->pgBar.="&nbsp;<a href=\"" . $linkCurrent . "\" id=\"pageNumbers\"\">$p</a>";
                }
            }

            // link for next page
            if ($pg != $pgCount) {
                if (!$this->ajaxPgBarFunction) {
                    $linkNext = "$PHP_SELF?pg=" . ($pg + 1) . "&" . $qString;
                } else {
                    // Code for AJAX
                    $linkNext = str_replace("{%PG%}", ($pg + 1), $this->ajaxPgBarFunction);
                }


                $this->pgBar.="&nbsp;&nbsp;<a href=\"" . $linkNext . "\" id=\"PreNextLinks\">" . $this->pgBarStrNext . "</a></div>";
            }
        }


        // Modify the SQL for filter the result

        if ($pgCount > 0) { // limit can be applied if only if there are 1 or more pages
            $startRecFrom = ($pg - 1) * $recPerPage;
            if ($startRecFrom < 0)
                $startRecFrom = 0;
            $this->limit = $startRecFrom . ',' . $recPerPage;
            $query.=" LIMIT " . $this->limit . "";
        }
        return $this->query($query, $db = 'DB');
    }

    /**
     *   get the no of pages
     */
//           public function get_pgs($query,$db,$recPerPage){
//
//           		$expSql=explode("FROM",$query);
//                $latterSql='';
//                /*preapare the latter part of SQL*/
//                  for($s=1;$s<count($expSql);$s++) $latterSql.=" FROM ".$expSql[$s];
//          		$expSqlFurther=explode("ORDER",$latterSql);
//
//					$result=$this->query("SELECT COUNT(*) ".$expSqlFurther[0]);
//
//
//
//               return $this->getPgCount($result[0]['COUNT(*)'],$recPerPage);
//
//           }

    /**
     *   get the no of pages
     */
    public function get_pgs($query, $db, $recPerPage) {

        $result = $this->queryAggregates($query, 'COUNT(*)');
        $this->totalCount = $result[0]['COUNT(*)'];


        if ($this->totalCount % $recPerPage == 0) {
            return $this->totalCount / $recPerPage;
        } else {
            return intval($this->totalCount / $recPerPage) + 1;
        }
    }

    /**
     *   Run aggregate functions
     */
    public function queryAggregates($query, $Aggerate) {

        $expSql = explode("FROM", $query);
        $expSql[0] = "";
        $arrayWithoutNulls=array_filter($expSql);
        $newSql = implode("FROM", $arrayWithoutNulls);

        $expSqlFurther = explode("ORDER", $newSql);
       

        if (count($expSqlFurther) > 2) {
            $expSqlFurther[count($expSqlFurther) - 1] = "";
            $newestSql = implode("ORDER", $expSqlFurther);
        } else {
            $newestSql = $expSqlFurther[0];
        }



        $result = $this->query("SELECT $Aggerate FROM " . $newestSql);

        return $result;
    }

    /**
     *   get the no of pages if total number of records has been given
     */
    public function getPgCount($totalCount, $recPerPage=1) {

        $this->totalCount = $totalCount;
        if (!$recPerPage)
            $recPerPage = 1;
        if ($totalCount % $recPerPage == 0) {
            return $totalCount / $recPerPage;
        } else {
            return intval($totalCount / $recPerPage) + 1;
        }
    }

    /**
     *   get the record Count -
     */
    public function getTotalCount() {

        return $this->totalCount;
    }

    /**
     *   defining variables for formating the page bar
     */
    private function pgbar_presets() {

        // Formating the page bar
        if (!$this->pgBarFontSize) {
            $this->pgBarFontSize = 2;
        }
        if (!$this->pgBarFontFace) {
            $this->pgBarFontFace = 'Arial';
        }
        if (!$this->pgBarFontColor) {
            $this->pgBarFontColor = '0000FF';
        }
        if (!$this->pgBarFontColorCurrentPage) {
            $this->pgBarFontColorCurrentPage = 'FF0000';
        }
        if (!$this->pgBarStyleCurrentPage) {
            $this->pgBarStyleCurrentPage = '';
        }
        if (!$this->pgBarStyle) {
            $this->pgBarStyle = '';
        }
        if (!$this->pgBarStrPage) {
            $this->pgBarStrPage = '<strong>Page: </strong>';
        }
        if (!$this->pgBarStrPrevious) {
            $this->pgBarStrPrevious = '&lt;&lt;Previous ';
        }
        if (!$this->pgBarStrNext) {
            $this->pgBarStrNext = ' Next&gt;&gt;';
        }
    }

}

?>
