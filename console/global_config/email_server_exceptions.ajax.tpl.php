<?php
/* --------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/global_config/email.ajax.tpl.php  		  '
  '    PURPOSE         :  edit email page of the global configuration section '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

require_once("../../classes/core/core.class.php");
$objCore = new Core;

/**
 * Display the logged user.
 */
$objCore->auth(0, true);

/**
 * Create an object to the GlobalConfig class.
 */
require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);

if (!is_object($objGlobalConfig)) {
    $objGlobalConfig = new GlobalConfig;
}

$module = "globalConfiguration";
$function = "dataList";

if ($objCore->isAllowed($module, $function)) {
    $configType = "MS_SMTP";
    if ($msg) {
        echo $objCore->msgBox("GLOBAL_CONFIG", $msg, '75.99%');
    }
    $list = $objGlobalConfig->get_dList($configType);


    // get the values
    $serList=explode("|spl|",$list[0][3]);
?>

    <div id="toolbar-box">
        <div class="t">
            <div class="t">
                <div class="t"></div>
            </div>
        </div>
        <div class="m">

            <!-------------- Function form----------->

            <form action="" method="get" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <fieldset id="page-middle-middle-content">
                    <legend>Email services Configuration </legend>
                    <table class="admintable" width="800">

                        <tr>
                            <td class="key" align="right" valign="top">Services List</td>
                            <td>
<?php for ($ls = 0; $ls < count($serList) + 2; $ls++) { ?>
                                <div style="padding-bottom: 5px;"> <input name="MS_LIST_<?php echo $ls; ?>" class="text_area" id="MS_LIST_<?php echo $ls; ?>" size="40" type="text" value="<?php echo $serList[$ls]; ?>"/></div>
                                <?php } ?>
                                <div class="globalConfig_txt">
                                    * Please add only the name of the service provider (i.e: yahoo.com as <b>yahoo</b>)<br/>

                                </div>
                            </td>
                    </tr>

                    <tbody>
                        <tr>
                            <td class="key" align="right" width="82">&nbsp;</td>
                            <td width="493"><label>

                                    <input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
                                    <input name="type" id="type" type="hidden" value="<?php echo "ms_smtp"; ?>" />



                                    </label></td>
                            </tr>
                        </tbody></table>
                </fieldset>
            </form>

            <!--------------END Function form----------->

            <div class="clr"></div>
        </div>
        <div class="b">
            <div class="b">
                <div class="b"></div>
            </div>
        </div>
<?php
                            }
?>
	

