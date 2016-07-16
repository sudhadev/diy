<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $objCore->gConf['TITLE_FRONT'] ?> </title>

<?php
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
$objCategory = new Category;
$keywords = $objCategory->getCategoriesForSeo();
?>
<meta name="title" content="DIY PRICE CHECK UK | BUILDING SUPPLIES UK | BUILDING SERVICES UK | CLASSIFIED ADS UK | WISH LIST UK" />

<meta name="keywords" content="<?php echo implode(',', $keywords); ?>" />

<meta name="description" content="DIY PRICE CHECK is an established online listing directory you can advertise and find supplies, services and classified ads match for all your construction related needs." />

<link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'] ?>/master.css" rel="stylesheet" type="text/css" />
<?php if ($objCore->_SYS['ENV'] == 'DEMO') { ?><style> body{background-image: url("../images/demo/demo.jpg")}</style><?php } ?>
<!--[if IE 6]><link rel="stylesheet" href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'] ?>/fix_ie6.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'] ?>/fix_ie7.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'] ?>/fix_ie8.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 9]><link rel="stylesheet" href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'] ?>/fix_ie9.css" type="text/css" media="screen" /><![endif]-->
<script type="text/javascript">
<!--
    function MM_swapImgRestore() { //v3.0
        var i, x, a = document.MM_sr;
        for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++)
            x.src = x.oSrc;
    }
    function MM_preloadImages() { //v3.0
        var d = document;
        if (d.images) {
            if (!d.MM_p)
                d.MM_p = new Array();
            var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
                if (a[i].indexOf("#") != 0) {
                    d.MM_p[j] = new Image;
                    d.MM_p[j++].src = a[i];
                }
        }
    }

    function MM_findObj(n, d) { //v4.01
        var p, i, x;
        if (!d)
            d = document;
        if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
            d = parent.frames[n.substring(p + 1)].document;
            n = n.substring(0, p);
        }
        if (!(x = d[n]) && d.all)
            x = d.all[n];
        for (i = 0; !x && i < d.forms.length; i++)
            x = d.forms[i][n];
        for (i = 0; !x && d.layers && i < d.layers.length; i++)
            x = MM_findObj(n, d.layers[i].document);
        if (!x && d.getElementById)
            x = d.getElementById(n);
        return x;
    }

    function MM_swapImage() { //v3.0
        var i, j = 0, x, a = MM_swapImage.arguments;
        document.MM_sr = new Array;
        for (i = 0; i < (a.length - 2); i += 3)
            if ((x = MM_findObj(a[i])) != null) {
                document.MM_sr[j++] = x;
                if (!x.oSrc)
                    x.oSrc = x.src;
                x.src = a[i + 2];
            }
    }
//-->
</script>

<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/master.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/ajax.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/folder-tree-static.js"></script>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

<script type="text/javascript">
    function slide() {
        //jQuery("#view_errors").click(function abc(){

        jQuery('#err_messages').slideToggle();

        //});
    }
    $(window).load(function () {

        var maxH = 0;
        var maxW = 0;
        $('img', 'div.owl-item > div').each(function (f) {
            if ($(this).height() > maxH) {
                maxH = $(this).height()
            }
            ;
            if ($(this).width() > maxW) {
                maxW = $(this).width()
            }
            ;
        });
        $('div.owl-item > div')
                .height(maxH)
                .width(maxW);


    });
</script>

<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/jquery.capitalize.js"></script>
<!--[if IE]><script defer type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/pngfix.js"></script><![endif]-->
<link rel="icon" 
      type="image/png" 
      href="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/favicon.png" />
      <?php /*
       *  <style>body {background-image:url(<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/<?php echo strtolower($topBarStyle);?>-top.jpg);background-repeat:repeat-x;   }</style> 
       */
      ?>

<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29249037-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script>
<!--add social media-->
<!--start fb shair script-->


<!--end fb share script -->
<!--social media-->

<!-- ashan -->
<meta property="og:site_name" content="diypricecheck.co.uk" />
<meta property="fb:app_id" content="148009148864644" /> 
<?php
$jsBodyOnLoad = "onload=\"MM_preloadImages( preDiv=false; '" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/home-rollover.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/browse-rollover.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/green-idea-rollover.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/about-us-rollover.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/contact-us-rollover.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/supplier.jpg','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/sign-up-button.png','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/diy-logo.png','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/icons/zoom.png','" . $objCore->_SYS['CONF']['URL_IMAGES_FRONT'] . "/icons/err.png');";
if ($objCore->curSection() == 'signup') {
    $jsBodyOnLoad.="onLoadValidate();\"";
} elseif ($objCore->curSection() == 'new_listings' && $_REQUEST['req'] == "cate") {
    $jsBodyOnLoad.="resetData(); selectCat();\"";
} elseif ($objCore->curSection() == 'new_listings' && $_REQUEST['req'] == "manufac") {
    $jsBodyOnLoad.="resetData(); refreshDropDown('manufac','','" . $_REQUEST['specId'] . "');\"";
} elseif ($objCore->curSection() == 'new_listings') {
    $jsBodyOnLoad.="resetData();\"";
} elseif ($objCore->curSection() == 'my_requests') {
    $jsBodyOnLoad.="selectCat('" . $_REQUEST['id_lvl'] . "');\"";
} elseif ($objCore->curSection() == 'my_listings' && $_REQUEST['pay'] == "Y") {
    $tmpValue = $objCore->sysVars['Content'];
    $arryVal1 = explode('-dlm-', $tmpValue);
    $arryVal2 = implode(",", $arryVal1);
    $jsBodyOnLoad.="addEditValues('" . $arryVal2 . "');\"";
    //$jsBodyOnLoad.="selectCat('".$_REQUEST['id_lvl']."');\"";
} else {
    $jsBodyOnLoad.="\"";
}

$objCore->sessUId == "" ? $topBarStyle = "Yellow" : $topBarStyle = "Black";
?>
<!-- ashan end -->
<!--social media-->
<!--end adding social media -->