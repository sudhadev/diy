<?php
$listsize = sizeof($list);
$count = 0;
?>
<?php foreach ($list as $post) : ?>

    <div id="title">
        <a
            href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM']; ?>/blog/?post=<?php echo $post[9]; ?>"><?php echo $post [1]; ?></a><span
            id="postdate" class="postdate"><?php echo date("jS F Y, h:i A", strtotime($list [0][6])); ?></span>
    </div>

    <div id="content">

        <div id="content-text">
            <!-- find image -->
            <?php
            //get image src and alt from post content FIRST IMAGE
            preg_match_all('/<img[^>]+>/i', $post [2], $img_result);
            $img = array();
            preg_match_all('/(alt|title|src)=("[^"]*")/i', $img_result [0] [0], $img [] [$img_result [0] [0]]);
            $img_src = $img [0] [$img_result [0] [0]] [0] [0]; // src=""
            $img_alt = $img [0] [$img_result [0] [0]] [0] [1]; // alt=""
            ?>
            <?php
            $content = preg_replace("/<img[^>]+\>/i", "", stripslashes($post [2])); // replase image tag from the sting
            $substr = substr($content, 0, 1000);
            /* $textWithoutLastWord = preg_replace('/\W\w+\s*(\W*)$/', '$1', $substr); */
            ?>
            <div class="blog-post-img">
                <img <?php echo $img_alt; ?> <?php echo $img_src ?> class="blog-post-img-tag" style="max-height: 100px;">
            </div>
            <?php
            echo $substr;

            /*
             * preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i', $post [2], $image);
             * echo $image['src'];
             */
            ?>
            <span id="more-read" class="post-read-more"><a
                    href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM']; ?>/blog/?post=<?php echo $post[9]; ?>" class="post-read-more" style="text-decoration: none;
                    color: #FECE00;">read
                    more&gt;&gt;</a></span>
        </div>

    </div>


    <?php
    $count ++;
    if ($count != $listsize) :
        echo '<hr/>';



    endif;
    ?>
<?php endforeach; ?>	