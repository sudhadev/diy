<?php

/* --------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  core.class.inc.php                                  '
  '    PURPOSE         :  Root Class of the system hierarchy.                 '
  '    				   :  Keep all the configuring data                       '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

Class Core {

    //Public $_SYS;

    /*
     * variables for System support section
     */
    private $guestId;
    private $objSql;
    private $sysFArray;
    private $authMatrix;
    public $sessCusId;

    function __Construct() {

        /**
         * Configure the folder paths for running enviorenments
         */
        $devPath = 'diy_v0.6'; // folder path of development server - from the root
        $demoPath = ''; // folder path of demonsration server - from the root
        $livePath = '';  // folder path of live server - from the root


        $HOST = $_SERVER['HTTP_HOST'];
        $IP_F = explode('.', $HOST);
        if ($IP_F[0] == '127' || $IP_F[0] == '172' || $IP_F[0] == 'localhost') {
            $HOST_SW_FOLDER = $this->HOST_SW_FOLDER = "/" . $devPath;
            $ENV = 'DEV';
        } elseif ($HOST == 'demo.diypricecheck.co.uk') {
        //elseif($HOST=='www.fusissoft.co.uk' || $HOST=='fusissoft.co.uk')
            $HOST_SW_FOLDER = $this->HOST_SW_FOLDER = $demoPath;
            $ENV = 'DEMO';
        } else {
            $HOST_SW_FOLDER = $this->HOST_SW_FOLDER = $livePath;
            $ENV = 'LIVE';
        }


        /**
         * Include necessory configuration files
         */
        require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/config/config.php');
        require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'links.config.php');
        require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'db_vals.config.php');
        require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'msgs.config.php');
        require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'geo.config.php');


        /*
         * add customization
         */

        // maximum file sizes
        if ($_CONF['F_SIZE']['IMAGE'] > 1024) {
            // In MB
            if ((int) ($_CONF['F_SIZE']['IMAGE'] / 1024) == ($_CONF['F_SIZE']['IMAGE'] / 1024)) {
                $_CONF['F_SIZE_PRINT']['IMAGE'] = ($_CONF['F_SIZE']['IMAGE'] / 1024) . " MB";
            } else {
                $_CONF['F_SIZE_PRINT']['IMAGE'] = number_format(($_CONF['F_SIZE']['IMAGE'] / 1024), 2) . " MB";
            }
        } else {
            // In KB
            $_CONF['F_SIZE_PRINT']['IMAGE'] = $_CONF['F_SIZE']['IMAGE'] . " KB";
        }

        /**
         * Load All fields to class variables
         */
        $this->_SYS['CONF'] = $_CONF;   // Configurations
        $this->_SYS['PATH'] = $_PATHS; // Links
        $this->_SYS['DB'] = $_DB;   // Databases
        $this->_SYS['MSGS'] = $_MSGS; // Messages
        $this->_SYS['GEO'] = $_GC; // Messages
        $this->_SYS['ENV'] = $ENV; // Enviorenment

        require_once($this->_SYS['PATH']['LOGIN_CONF']);
        $this->_SYS['LCONF'] = $_LCONF;




        // Custom variables
        $this->msgKey = '';
    }

// End Construct

    public function auth($use=1, $auth=false) {
        $incWithinCore = true;

        require_once($this->_SYS['PATH']['SESS']);
        $objSession = new Session;
        $objSession->config = $this->_SYS['LCONF'];
        $arrAuth = $objSession->read($use, $this->_SYS['LCONF']['LOGIN'][$use]['COOKIE_NAME'], $auth);


        $this->sessUId = $arrAuth['user'];
        $this->sessUType = $arrAuth['uType'];
        $this->sessURole = $arrAuth['role'];
        $this->sessKey = $arrAuth['sKey'];
        $this->sessTmpKey = $arrAuth['tKey'];
        $this->sessIp = $arrAuth['ip'];
        $this->sessAccess = $arrAuth['access'];
        $this->sessExpire = $arrAuth['expire'];
        $this->sessData = $arrAuth['eFields'];


        if ($use == 1) {
            require_once($this->_SYS['PATH']['CLASS_CUSTOMER']);
            $objCustomer = new Customer;
            $cusData = $objCustomer->getStatus($this->sessData[2]);
            $this->sessCusId = $this->sessData[2];
            $this->sessUStatus = $cusData[0][0];
            $this->sessUType = $cusData[0][1];
            $this->sessUSubsTypes = array($cusData[0][2], $cusData[1][2], $cusData[2][2]);
            $this->sessUPkgType = array($cusData[0][3], $cusData[1][3], $cusData[2][3]);
            $this->sessSubsStatus = array($cusData[0][4], $cusData[1][4], $cusData[2][4]);

            if ($this->sessCusId) {
                // check current section
                if ($this->curSection() != "first_login" && $this->curSection() != "payments" && $cusData[0][2] == '' && $cusData[1][2] == '' && $cusData[1][2] == '' && $this->sessUType == 'S') {
                   // header("location: " . $this->_SYS['CONF']['URL_MY_ACCOUNT'] . '/first_login/?f=select_subscription');
                   if(!isset($_REQUEST['code']))
                    header("location: " . $this->_SYS['CONF']['URL_MY_ACCOUNT'] . '/first_login/?f=select_subscription'); 
                  else
                   header('Location:'.$this->_SYS['CONF']['URL_MY_ACCOUNT'].'/first_login/?f=select_subscription&promo_code='.$_REQUEST['code'].'&promo_key='.$_REQUEST['key'].'&cusType='.$_REQUEST['cusType']);

                }

                // check user status and redirect
                if ($this->sessUStatus == 'W' && $this->curSection() != "first_login" && $this->sessUType == 'S') {
                    header("location: " . $this->_SYS['CONF']['URL_MY_ACCOUNT'] . '/first_login/?f=pending');
                }
            } // end if($this->sessCusId)
            $this->isAuthorized($use);
        } // end the if for $use=1
        else { // else part of if($use==1)
            $this->isAuthorized(0); // administrator panel
        } // end of if($use==1)


        $this->gConfig();
        $this->sysCheck();
    }

    public function msgBox($msgKey, $msg, $width="100%", $use=1, $msgText='', $msgImage='') {

        switch ($use) {
            case 0: {
                    $imgPath = $this->_SYS['CONF']['URL_IMAGES_CONSOLE'];
                }break;

            case 1: {
                    $imgPath = $this->_SYS['CONF']['URL_IMAGES_FRONT'];
                }break;
        }

        if (!$msgImage)
            $msgImage = $this->_SYS['MSGS'][$msgKey][$msg[1]][0];
        if (!$msgText)
            $msgText = $this->_SYS['MSGS'][$msgKey][$msg[1]][1];

        $msg = '<table width="' . $width . '" border="0" align="center">
                            <tr>
                            <td class="" style="padding-top:10px;"><div class="msgBox"> <img src="' . $imgPath . '/icons/' . strtolower($msgImage) . '.png" align="absmiddle"/> &nbsp;' . $msgText . ' </div></td>
                            </tr>
                            <tr>
                            <td ></td>
                            </tr>
                        </table>

            ';

        return $msg;
    }

    public function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["HTTP_HOST"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public function curSection() {
        $arrUrlContents = explode("/", $this->curPageURL());

        return $arrUrlContents[count($arrUrlContents) - 2];
    }

    public function curPage() {
        $arrUrlContents = explode("/", $_SERVER['PHP_SELF']);

        return $arrUrlContents[count($arrUrlContents) - 1];
    }

    public function gConfig() {
        $objSql = new Sql;
        $result = $objSql->query("SELECT `con_categ`,`con_key`,`con_value` FROM `" . $this->_SYS['CONF']['PREFIX_TBL'] . "global_config`");

        for ($i = 0; $i < count($result); $i++) {
            $this->gConf[$result[$i]['con_key']] = $result[$i]['con_value'];
        }
    }

    /**
     * check user previlage for a given functionality
     */
    public function isAllowed($module, $function='') {

        // mechanism to be built

        return true;
    }

    /**
     * check user previlage for a given section
     */
    public function isAuthorized($use, $module='', $function='') {
        switch ($use) {
            case 1: {
                    // Call the front end authonication matrix
                    require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'auth-matrix-front.config.php');
                    $this->authMatrix = $_AUTH_M_FRONT;
                    $redirectOnError = $this->_SYS['CONF']['URL_FRONT'] . 'errors/?err=403&' . $this->curSection();
                    $userTypeOrRole = $this->sessUType;
                }break;
            case 0: {
                    // Call the front end authonication matrix
                    require($_SERVER['DOCUMENT_ROOT'] . $this->HOST_SW_FOLDER . '/' . $PREFIX_DIR . 'config/' . $PREFIX_FILE . 'auth-matrix-admin.config.php');
                    $this->authMatrix = $_AUTH_M_ADMIN;
                    $redirectOnError = $this->_SYS['CONF']['URL_CONSOLE'] . '/errors/?err=403&' . $this->curSection();
                    $userTypeOrRole = $this->sessURole;
                }break;
        } // End Switch
        // print_r($this->authMatrix[$this->curSection()][$userTypeOrRole]);
        //echo $userTypeOrRole.$this->curSection();exit;
        if (!$module && !$this->authMatrix[$this->curSection()][$userTypeOrRole]) {
            /*
             * If this there isnt module provided, system will consider the current section/ module which user accessing
             * then if it returns false from the auth matrix, user will be redirected to the error page
             */
            header("location: " . $redirectOnError);
        } elseif ($module) {
            /*
             * If module is provied, it will check the auth matrix and will return True or False
             */
            if ($this->authMatrix[$module][$userTypeOrRole]) {
                return true;
            } else {
                return false;
            }
        }
    }

// End function isAuthorized

    /** ----------------------------------------------------------------------------------------------------------------
     * Extra system support mechanism will start from here
     * using this mechanism, it will be able to develop user like/dislike and then the predictions using stored data
     * in the first
     */
    public function sysCheck() {


        // Create sql Class object
        try {
            require_once($this->_SYS['PATH']['CLASS_SQL']);
            $this->objSql = new Sql;
        } catch (Exception $e) {
            // no need further action
        }


        // Create the field array
        $this->sysFArray['GuestId'] = "guest_id";
        $this->sysFArray['ClientId'] = "client_id";
        $this->sysFArray['WishList'] = "content_wlist";
        $this->sysFArray['Search'] = "content_search";
        $this->sysFArray['Geo'] = "geo_info";
        $this->sysFArray['Content'] = "contents";
        $this->sysFArray['WQLink'] = "wish_quote_link";

        // Check the guest record and create if not available
        if (!$this->guestCheck()) {
            $this->guestSet();
        }
    }

    public function sysUpdate($key='', $value='') {//echo $this->guestId."<-------------";$this->objSql->dev=true;
        $where = "WHERE guest_id='" . $this->guestId . "'"; // where clause for updating
        return $this->guestUpdate($key, $value, $where); // update necessory value in system record
    }

    private function guestUpdate($key/* Field key */, $value/* Value to insert */, $where) {
        if ($key) {
            setcookie($this->_SYS['CONF']['COOKIE_GUEST_KEY'], $this->guestId, time() + 48600, "/", $this->_SYS['CONF']['COOKIE_CLIENT_URL'], 0);
            $result = $this->objSql->query("UPDATE `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` SET `" . $this->sysFArray[$key] . "`='" . $value . "' " . $where);
            return true;
        } else {
            return false;
        }
    }

    private function guestForceUpdate() {
        if ($this->sessUId && $this->guestId) {
            
        }
    }

    private function guestGet() {
        $guestKey = $_COOKIE[$this->_SYS['CONF']['COOKIE_GUEST_KEY']];
        return $guestKey;
    }

    private function guestSet() {
        $guestkey = $this->base64key();
        @setcookie($this->_SYS['CONF']['COOKIE_GUEST_KEY'], $guestkey, time() + 48600, "/", $this->_SYS['CONF']['COOKIE_CLIENT_URL'], 0);
        $result = $this->objSql->query("INSERT INTO `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` (`guest_id`,`time`) VALUES('" . $guestkey . "','" . time() . "') ");

        return $guestkey;
    }

    private function guestCheck() {
        $this->guestId = $this->guestGet();
        if ($this->guestId && $this->guestInDb($this->guestId)) {
            return true;
        } else {
            return false;
        }
    }

    private function guestInDb($gId) {
        // $arrFFlips=array_flip($this->sysFArray); // filp the fileld array
        $arrFKeys = array_keys($this->sysFArray); // get the keys of filed array

        $result = $this->objSql->query("SELECT * FROM `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` WHERE guest_id='" . $gId . "'");
        if (count($result) == 1) {

            for ($i = 0; $i < count($this->sysFArray); $i++) {
                $this->sysVars[$arrFKeys[$i]] = $result[0][$this->sysFArray[$arrFKeys[$i]]];
            }

            return true;
        } else {

            return false;
        }
    }

    public function base64key() {
        // declare the $key variable
        $key = "";

        $alph_small = range("a", "z"); // create an array for simple letters
        $alph_caps = range("A", "Z");  // create an array for capital letters
        $alphKeyLength = 54; // length of the dynamic

        /*
         * Array for key formats. you can add any number of formats there
         * pattern as follows
         *      # - numbers (0-9)
         *      A - Capital Letter  (A-Z)
         *      a - Simple Letters  (a-z)
         */
        $alphaTxt = '###aaAAAaA##AaaAAaAaaaaaAA#aaA###AAAAAAAaaa###aaAAAAaa';
        //$alphaTxt[]='aa#aaA#AaA##AaaAAaAaaaaaAA#aaA###aaaaaAAaaa###aaA####a';
        //$alphaTxt[]='AAAaa###aA##Aaa######aaaAA#aaA###AAAA###aaa###aaA#AAa#';
        //$alphaTxt[]='aaaa####aA##AaaAAaAaAAaaAA#aaA###AAAaaAAAaaa##aaAAA##a';
        //$alphaTxt[]='###aaAAAaA##AaaA##AA#aaaAA#aaA###aaAA##Aaaa###aaAA####';

        $selAlpha = $alphaTxt[rand(0, strlen($alphaTxt) - 1)];


        for ($i = 0; $i < $alphKeyLength; $i++) {
            switch ($selAlpha[$i]) {
                case "#": {
                        $key .= rand(0, 9);
                    }
                    break;

                case "a": {
                        $key .= $alph_small[rand(0, 25)];
                    }
                    break;

                default: {
                        $key .= $alph_caps[rand(0, 25)];
                    }
            }
        } // End of the for loop


        return $key . time(); // return the value with adding the timestamp
    }

    function updateClient($clientUpdate, $customerId, $result, $dbValue) {
        if ($clientUpdate && $this->sessUId) {
            if (count($result) > 1) {
                if ($result[0]['geo_info']) {
                    $val = $result[0]['geo_info'];
                } else {
                    $val = $result[1]['geo_info'];
                }
                $sqlUpdate = "UPDATE `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` SET guest_id='" . $result[0]['guest_id'] . "',
content_wlist='" . $dbValue . "', content_search='" . $result[1]['content_search'] . "',
time='" . time() . "', geo_info='" . $val . "' WHERE guest_id='" . $result[1]['guest_id'] . "'";
                $resultUpdate = $this->objSql->query($sqlUpdate);
                if ($resultUpdate) {
                    setcookie($this->_SYS['CONF']['COOKIE_GUEST_KEY'], $result[1]['guest_id'], time() + 48600, "/", $this->_SYS['CONF']['COOKIE_CLIENT_URL'], 0);

                    $sqlDelete = "DELETE FROM `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` WHERE id='" . $result[0]['id'] . "'";
                    $resultDelete = $this->objSql->query($sqlDelete);
                    return $resultDelete;
                }
            }
        }
    }

    function getSysRows($customerId) {
        $sql = "SELECT id, guest_id, client_id, content_wlist, content_search, contents, last_url, geo_info
FROM `" . $this->_SYS['CONF']['PREFIX_TBL'] . "sys_support` WHERE client_id='" . $customerId . "' ORDER BY time DESC";
        $result = $this->objSql->query($sql);
        return $result;
    }

}