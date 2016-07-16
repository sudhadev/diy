<style>
    #owl-demo .item{
        background: #42bdc2;
        padding: 30px 0px;
        margin: 5px;
        color: #FFF;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        text-align: center;
    }
</style>
<!-- Owl Carousel Assets -->
<link href="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/owl-carousel/owl.theme.css" rel="stylesheet">
<?php
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);

if(!is_object($objListing)) $objListing=new Listing();

if (!is_object($objService)) {
    $objService = new Service;
}

$featured_listings = $objListing->getFeaturedListings(20);
//print_r($featured_listings);

$latest_service_list = $objService->getLatestServices();
//print_r($latest_service_list);
?>

<div id="banner" style="margin-top: 20px;margin-left: 0px;">Featured Listings</div>
<div id="owl-demo2" class="owl-carousel owl-theme">
    <?php
    foreach ($featured_listings AS $latest_service) {
        echo '<div><a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$latest_service['supplier_id'].'&lid='.$latest_service['id'].'&dis='.round($latest_service[7], 2).'&unit=miles">';
        $image = $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'].'/'.$latest_service['supplier_id']."/large/".$latest_service['image'];
        ?>
        <img  src="<?php echo $image; ?>"/>
        <p><?php echo $latest_service['listing_header']; ?></p>
        <?php
        echo '</a></div>';
    }
    ?>
</div>


<div id="banner" style="margin-top: 20px;margin-left: 0px;">Latest Services</div>
<div id="owl-demo" class="owl-carousel owl-theme">
    <?php
    foreach ($latest_service_list AS $latest_service) {
        echo '<div><a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$latest_service[19].'&lid='.$latest_service[17].'&dis='.round($latest_service[7], 2).'&unit=miles">';
        $image = $objCategory->image($latest_service[14], $objCore->_SYS['CONF']['FTP_SERVICES'], $objCore->_SYS['CONF']['URL_IMAGES_SERVICES']);
        ?>
        <img  src="<?php echo $image; ?>"/>
        <p><?php echo $latest_service['3']; ?></p>
        <?php
        echo '</a></div>';
    }
    ?>
</div>



<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/jquery-1.9.1.min.js"></script> 
<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/owl-carousel/owl.carousel.js"></script>
<script>
    $(document).ready(function () {

        var owl = $("#owl-demo");

        owl.owlCarousel({
            itemsCustom: [
                [0, 2],
                [450, 4],
                [600, 6],
                [700, 6],
                [1000, 6],
                [1200, 6],
                [1400, 6],
                [1600, 6]
            ],
            navigation: true

        });
        
        var owl2 = $("#owl-demo2");

        owl2.owlCarousel({
            itemsCustom: [
                [0, 2],
                [450, 4],
                [600, 6],
                [700, 6],
                [1000, 6],
                [1200, 6],
                [1400, 6],
                [1600, 6]
            ],
            navigation: true

        });
        
    });
</script>