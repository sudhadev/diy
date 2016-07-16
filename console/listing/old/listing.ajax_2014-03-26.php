<?php

require_once("../../classes/core/core.class.php");
$objCore = new Core;
$objCore->auth(0,true);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);


$objCustomer = new Customer($objCore->gConf);
$objCategory = new Category();


if ($_SERVER["REQUEST_METHOD"] <> "POST") {
    die("Access Denied");
}
if ($_REQUEST['deleteId']) {
    $strDel = explode('_', $_REQUEST['deleteId']);
    switch ($strDel[0]) {
        case 1: {
                $objListing = new Listing();
                $msg = $objListing->deleteListing($strDel[1], $strDel[2]);
                echo $objCore->msgBox("LISTING",$msg,'75.99%');
            }break
            ;
        case 2: {
                $objService = new Service();
                $msg = $objService->deleteService($strDel[1], $strDel[2]);
                echo $objCore->msgBox("SERVICES",$msg,'75.99%');
            }break
            ;
        case 3: {
                $objClassifiedAd = new ClassifiedAd();
                $msg = $objClassifiedAd->deleteClassifiedAd($strDel[1], $strDel[2]);
                echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'75.99%');
            }break
            ;
    }
} 
else if ($_REQUEST['restoreId']) {
    $strRestore = explode('_', $_REQUEST['restoreId']);

    switch ($strRestore[0]) {
        case 1: {
                $objListing = new Listing();
                $msg = $objListing->restoreListing($strRestore[1]);
                echo $objCore->msgBox("LISTING",$msg,'75.99%');
            }break
            ;
        case 2: {
                $objService = new Service();
                $msg = $objService->restoreService($strRestore[1]);
                echo $objCore->msgBox("SERVICES",$msg,'75.99%');
            }break
            ;
        case 3: {
                $objClassifiedAd = new ClassifiedAd();
                $msg = $objClassifiedAd->restoreClassifiedAd($strRestore[1]);
                echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'75.99%');
            }break
            ;
    }
}
else {
    $str = explode('_', $_REQUEST['ids']);
    $pg=$_REQUEST['pg'];
    $objCustomer->ajaxPgBarFunction="javascript: getListings('".$_REQUEST['cusId']."' , '".$_REQUEST['ids']."','{%PG%}');";
    $output = $objCustomer->getListings($_REQUEST['cusId'], $str[0], $str[1], $str[2], '', $_REQUEST['time'], $pg, '');
    if(!is_object($objListing)) $objListing= new Listing();
    $topList=$objCategory->getTopcList();
    if ($str[0]) {
        $list=$objCategory->getSubcList($topList[$str[0]]['id'],'sub_arr');
        for ($m=0; $m<count($list); $m++) {
            if ($list[$m][0]==$str[1]) $temp = $m;
        }
    }
    if ($str[2]) {
        $listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
        for ($n=0; $n<count($listSub); $n++) {
            if ($listSub[$n][0]==$str[2]) $tempSub = $n;
        }
    }
    if ( $str[0] == 1 && $output[0] !='ERR') {
        ?>
<div align="right"><?php echo $objCustomer->pgBar; ?></div>
<div id="specification_list">
    <fieldset  id="page-middle-middle-content">
        <legend>Listings (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?> > <?php echo $listSub[$tempSub][3];?>)</legend>

        <table  cellspacing="1" class="adminlist" width="100%">
            <thead>
                <tr>
                    <th width="7%" height="22"> # </th>
                    <th width="10%" nowrap="nowrap" class="title" align="left"><a  href="#">Image</a></th>
                    <th width="15%" nowrap="nowrap" class="title" align="left"><a  href="#">Specification</a></th>
                    <th  nowrap="nowrap" class="title" align="left"><a  href="#">Manufacturer</a></th>
        <? if(!empty($_REQUEST['time'])) { ?> <th nowrap="nowrap" class="title" align="left"><a  href="#">Supplier</a></th> <? } ?>
                    <th width="8%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Unit Cost (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="8%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Bulk Discount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="8%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Bulk Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="8%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Delivery (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="4%" class="title">&nbsp;</th>
                    <th width="4%" class="title">&nbsp;</th>

                </tr>
            </thead>
            <tbody>
                            <?php

        for($n=0;$n<count($output);$n++) {
            $rowNo=$n+1;
            if ($_REQUEST['time']) $_REQUEST['cusId'] = $output[$n][10];
            ?>
                <tr class="row0">
                    <td align="center"><?php echo $rowNo; ?> </td>
                    <td align="left">
                    <?php  $imgUrl = $objListing->image($output[$n][15],$objCore->_SYS['CONF']['FTP_LISTINGS'],$objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'],$output[$n][10]);
                                              ?>
                    <img src="<?php echo $imgUrl;?>"   width="30" border="0" style="padding-right:8px;" /></td>
                    <td align="left"><?php echo $output[$n][0];?></td>
                    <td align="left"><?php echo $output[$n][1];?></td>
            <? if(!empty($_REQUEST['time'])) { ?><td align="left"><?php echo $output[$n][12]."&nbsp;".$output[$n][13];?></td><? } ?>
                    <td align="right"><?php echo $output[$n][2];?></td>
                    <td align="right"><?php echo $output[$n][3];?></td>
                    <td align="right"><?php echo $output[$n][4];?></td>
                    <td align="right"><?php echo $output[$n][5];?></td>
                    <td align="center">
                        <a href="javascript:getEditListing('<?php echo $_REQUEST['cusId']; ?>', '<?php echo $str[0]."_".$str[1]."_".$str[2]."_".$output[$n][6]; ?>');">
                            <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/moderate.png" title="Moderate" alt="Moderate"/>
                        </a>
                    </td>
            <?php
            if ($output[$n][7] == 'Y') {
                                    ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/active.png" title="Active" alt="Active"/>
                    </td>
                <?php
            }
            else {
                ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/inactive.png" title="Inactive" alt="Inactive"/>
                    </td>
                                    <?php
                                }
                                ?>
                </tr>
            <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14"><del class="container">
                <div class="pagination">        </div>
            </del> </td>
            </tr>
            </tfoot>
        </table>
    </fieldset>
</div>
                            <?php
    }
                    else if ($str[0] == 2 && $output[0] !='ERR') {
        ?>

<div id="specification_list">
    <fieldset  id="page-middle-middle-content">
        <legend>Listings (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?><?php if ($str[2]) ?> > <?php echo $listSub[$tempSub][3];?>)</legend>


        <table  cellspacing="1" class="adminlist" width="100%">
            <thead>
                <tr>
                    <th width="7%" height="22"> # </th>
                    <th width="21%" nowrap="nowrap" class="title" align="left"><a  href="#">Image</a></th>
                    <th nowrap="nowrap" class="title" align="left"><a  href="#">Business Name</a></th>
        <? if(!empty($_REQUEST['time'])) { ?> <th nowrap="nowrap" class="title" align="left"><a  href="#">Supplier</a></th> <? } ?>
                    <th nowrap="nowrap" class="title" align="left"><a  href="#">Affiliations</a></th>
                    <th width="21%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="21%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Call Out Charge (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="21%" nowrap="nowrap" class="title" align="left"><a  href="#">Contact Person</a></th>
                    <th width="4%" class="title">&nbsp;</th>
                    <th width="4%" class="title">&nbsp;</th>

                </tr>
            </thead>
            <tbody>
                <!-- Retriew data from database and display the data corresponding fields -->
        <?php

        for($n=0;$n<count($output);$n++) {
                                $rowNo=$n+1;
            if ($_REQUEST['time']) $_REQUEST['cusId'] = $output[$n][12];
            ?>
                <tr class="row0">
                    <td align="center"><?php echo $rowNo; ?> </td>
                    <td align="left"><div id="uploadingImg">
                            <img width="50" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_SERVICES'];?>/thumbs/<?php echo $output[$n][4]; ?>"/>
                            <br/>
                            <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $output[$n][4]; ?>','services');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png"/></a>
                            <br/>
                        </div> </td>
                    <td align="left"><?php echo $output[$n][0];?></td>
                            <? if(!empty($_REQUEST['time'])) { ?><td align="left"><?php echo $output[$n][14]."&nbsp;".$output[$n][15];?></td><? } ?>
                    <td align="left"><?php echo $output[$n][1];?></td>
                    <td align="right"><?php echo $output[$n][2];?></td>
                    <td align="right"><?php echo $output[$n][3];?></td>
                    <td align="left"><?php echo $output[$n][5];?></td>
                    <td align="center">

                        <a href="javascript:getEditListing('<?php echo $_REQUEST['cusId']; ?>', '<?php echo $str[0]."_".$str[1]."_".$str[2]."_".$output[$n][8]; ?>');">
                            <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/moderate.png" title="Moderate" alt="Moderate"/>
                        </a>
                    </td>
            <?php

            if ($output[$n][9] == 'Y') {
                ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/active.png" title="Active" alt="Active"/>
                    </td>
                <?php
            }
            else {
                ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/inactive.png" title="Inactive" alt="Inactive"/>
                    </td>
                <?php
            }
                                ?>
                </tr>
                                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14"><del class="container">
                <div class="pagination">        </div>
            </del> </td>
            </tr>
            </tfoot>
        </table>
    </fieldset>
</div>

        <?php
                        }
                        else if ($str[0] == 3 && $output[0] !='ERR') {
                            ?>
<div id="specification_list">
    <fieldset  id="page-middle-middle-content">
        <legend>Listings (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?> <?php if ($str[2]) ?> <?php echo $listSub[$tempSub][3];?>)</legend>


        <table  cellspacing="1" class="adminlist" width="100%">
            <thead>
                <tr>
                    <th width="7%" height="22"> # </th>
                    <th width="12%" nowrap="nowrap" class="title" align="left"><a  href="#">Image</a></th>
                    <th nowrap="nowrap" class="title" align="left"><a  href="#">Ad Title</a></th>
        <? if(!empty($_REQUEST['time'])) { ?> <th nowrap="nowrap" class="title" align="left"><a  href="#">Supplier</a></th> <? } ?>
                    <th width="10%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
                    <th width="12%" nowrap="nowrap" class="title" align="left"><a  href="#">Invoice_no</a></th>
                    <th width="4%" class="title">&nbsp;</th>
                    <th width="4%" class="title">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
        <?php
        for($n=0;$n<count($output);$n++) {
            $rowNo=$n+1;
            if ($_REQUEST['time']) $_REQUEST['cusId'] = $output[$n][9];
            ?>
                <tr class="row0">
                    <td align="center"><?php echo $rowNo; ?> </td>
                    <td align="center"><div id="uploadingImg">
                            <img width="50" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'];?>/thumbs/<?php echo $output[$n][2]; ?>"/>
                            <br/>
                            <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $output[$n][2]; ?>','clas_ads');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png"/></a>
                            <br/>
                        </div>
                    <td align="left"><?php echo $output[$n][0];?></td>
            <? if(!empty($_REQUEST['time'])) { ?><td align="left"><?php echo $output[$n][11]."&nbsp;".$output[$n][12];?></td><? } ?>
                    <td align="right"><?php echo $output[$n][1];?></td>
                    <td align="left"><?php if ($output[$n][3]) { ?><a href="javascript:Popup('<?php echo $objCore->_SYS['CONF']['URL_CONSOLE']; ?>/revenue/invoice.php?invoice_no=<?php echo $output[$n][3]; ?>')"><?php } if
            ($output[$n][3]) {
                echo $output[$n][3];
                            } else {
                                echo "<i>not applicable</i>";
                            }?></a></td>
                    <td align="center">
                        <a href="javascript:getEditListing('<?php echo $_REQUEST['cusId']; ?>', '<?php echo $str[0]."_".$str[1]."_".$str[2]."_".$output[$n][4]; ?>');">
                            <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/moderate.png" title="Moderate" alt="Moderate"/>
                        </a>
                    </td>
            <?php
            if ($output[$n][5] == 'Y') {
                ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/active.png" title="Active" alt="Active"/>
                    </td>
                <?php
                                }
            else {
                ?>
                    <td align="center">
                        <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/inactive.png" title="Inactive" alt="Inactive"/>
                    </td>
                <?php
            }
                                ?>
                </tr>
                                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14"><del class="container">
                <div class="pagination">        </div>
            </del> </td>
            </tr>
            </tfoot>
        </table>
    </fieldset>
</div>

                            <?php
                        }
                        else {
        $msg = $output;
                        echo $objCore->msgBox("CUSTOMER",$msg,'90%');
    }
}
?>
