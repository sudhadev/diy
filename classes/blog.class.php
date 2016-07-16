<?php

/*
 * --------------------------------------------------------------------------\
 * ' This file is part of shoping Cart in module library of FUSIS '
 * ' (C) Copyright 2004 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Ashan Rupasinghe '
 * ' FILE : classes/blog.class.php '
 * ' PURPOSE : class page of the user section '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
require_once ($objCore->_SYS ['PATH'] ['CLASS_SQL']);
require_once ($objCore->_SYS ['PATH'] ['CLASS_USER']);

class Blog extends Sql {

    function get_dList($id = '', $pg = '', $paginationSize = '', $status = '', $slug = '') {
        if ($id != '') {
            if ($status == '') {
                $where = " WHERE id='" . $id . "'";
            } else {
                $where = " WHERE id='" . $id . "',status='" . $status . "'";
            }
            $list = $this->dList($where, $pg, $paginationSize);
        } else {
            if ($slug != '') {
                $where = " WHERE slug='" . $slug . "'";
                $list = $this->dList($where, $pg, $paginationSize);
            } else {
                if ($status == '') {
                    $where = "ORDER BY added_date DESC";
                    $list = $this->dList($where, $pg, $paginationSize);
                } else {
                    $where = " WHERE status='" . $status . "' ORDER BY added_date DESC";
                    $list = $this->dList($where, $pg, $paginationSize);
                }
            }
        }

        return $list;
    }

    /**
     * Take correspond values that match with PID into a $list array.
     */
    function dList($where = '', $pg = '', $paginationSize = '') {
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        if ($paginationSize != '') {
            $result = $this->queryPg("SELECT * FROM `" . $tblPrefix . "blog`" . $where, $pg, $paginationSize, '');
        } else {
            $result = $this->query("SELECT * FROM `" . $tblPrefix . "blog`" . $where);
        }

        // $result=$this->query("SELECT * FROM `@diy_____blog` WHERE id=4");

        for ($i = 0; $i < count($result); $i ++) {
            $list [$i] [] = $result [$i] ['id']; // 0
            $list [$i] [] = $result [$i] ['title']; // 1
            $list [$i] [] = stripslashes($result [$i] ['content']); // 2
            $list [$i] [] = $result [$i] ['added_user']; // 3
            $list [$i] [] = $result [$i] ['added_date']; // 4
            $list [$i] [] = $result [$i] ['modified_user']; // 5
            $list [$i] [] = $result [$i] ['modified_date']; // 6
            $list [$i] [] = $result [$i] ['status']; // 7
            $list [$i] [] = $_REQUEST ['pg']; // 8
            $list [$i] [] = $result [$i] ['slug']; // 9
        }
        return $list;
    }

    /**
     * Delete data in the @diy_____blog table correspond to the ID.
     */
    function delete($reqId) {
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        if ($this->checkListings($reqId)) {
            $msg = array(
                'ERR',
                'EXIST_LISTINGS'
            );
        } else {
            $result = $this->query("DELETE FROM `" . $tblPrefix . "blog` WHERE `id`='" . $reqId . "'");

            if ($result) {
                $msg = array(
                    'SUC',
                    'DELETE'
                );
            } else {
                $msg = array(
                    'ERR',
                    'NOT_DELETE'
                );
            }
        }

        return $msg;
    }

    /**
     * Change the database existing contents of a page according to the new content.
     */
    function edit($newContent, $title, $logId, $reqPId, $status) {
        $author = $this->getUserName($logId);
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $slug = $this->addSlu($title);
        $timestamp = date('Y-m-d G:i:s');
        /* $result=$this->query("UPDATE `".$tblPrefix."blog` SET `content`='".addslashes($newContent)."',`content`='".$title."', `date`='".time()."' WHERE `id`='".$reqPId."'"); */
        $result = $this->query("UPDATE `" . $tblPrefix . "blog` SET `content`='" . $newContent . "',`title`='" . $title . "',`slug`='" . $slug . "',`modified_user`='" . $author . "', `modified_date`='" . $timestamp . "', `status`='" . $status . "' WHERE `id`='" . $reqPId . "'");

        if ($result) {
            $msg = array(
                'SUC',
                'UPDATE'
            );
        } else {
            $msg = array(
                'ERR',
                'NOT_UPDATE'
            );
        }
        return $msg;
    }

    function add($title, $content, $logId, $status) {
        $author = $this->getUserName($logId);
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $slug = $this->addSlu($title);
        $timestamp = date('Y-m-d G:i:s');
        $content = addslashes($content);
        /* $result=$this->query("UPDATE `".$tblPrefix."blog` SET `content`='".addslashes($newContent)."',`content`='".$title."', `date`='".time()."' WHERE `id`='".$reqPId."'"); */
        $result = $this->query("INSERT INTO `" . $tblPrefix . "blog` (`title`, `content`,`slug`, `added_user` , `added_date` , `modified_user` ,`modified_date`, `status` )

					VALUES ('$title','$content','$slug','$author','$timestamp','$author','$timestamp','$status')");

        if ($result) {
            $msg = array(
                'SUC',
                'ADD'
            );
        } else {
            $msg = array(
                'ERR',
                'NOT_ADD'
            );
        }
        return $msg;
    }

    function checkListings($postid) {
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $result = $this->query("SELECT COUNT(*) FROM `" . $tblPrefix . "blog` WHERE `id`='" . $postid . "'");
        if ($result [0] ["COUNT(*)"] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function getAddedBy($uname) {
        $objUser = new User ();
        $where = " WHERE `uname`='" . $uname . "'";
        $list_user = $objUser->dList($where);
        if ($list_user != "") {
            $logged_user = $uname . " [Administrator]";
        } elseif ($list_user == "") {
            $logged_user = $uname;
        }
        return $logged_user;
    }

    function getUserName($id) {
        $objUser = new User ();
        $list_user = $objUser->get_dList($id);
        // print_r($list_user);
        if ($list_user != "") {
            // echo "came1";
            $uname = $list_user [0] [3];
        } elseif ($list_user == "") {
            // echo "came2";
            $objCustomer = new Customer ();
            $where = " WHERE customer_id='" . $id . "'";
            $list_user = $objCustomer->dList($where);
            $uname = $list_user [0] [3];
        }
        // echo $uname;
        return $uname;
    }

    function editStatus($logId, $reqPId, $status) {
        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $author = $this->getUserName($logId);
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $timestamp = date('Y-m-d G:i:s');

        /* $result=$this->query("UPDATE `".$tblPrefix."blog` SET `status`='".$status."' WHERE `id`='".$reqPId."'"); */
        $result = $this->query("UPDATE `" . $tblPrefix . "blog` SET `status`='" . $status . "',`modified_user`='" . $author . "', `modified_date`='" . $timestamp . "' WHERE `id`='" . $reqPId . "'");

        if ($result) {
            if ($status == 1) {
                $msg = array(
                    'SUC',
                    'PUBLISH'
                );
            } else {
                $msg = array(
                    'ERR',
                    'UNPUBLISH'
                );
            }
        } else {
            $msg = array(
                'ERR',
                'NOT_DONE'
            );
        }
        return $msg;
    }

    function addSlu($title) {
        $slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
        $i = 1;
        $baseSlug = $slug;
        while ($this->slugExist($slug)) {
            $slug = $baseSlug . "-" . $i ++;
        }

        return $slug;
    }

    function slugExist($slug) {
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $result = $this->query("SELECT COUNT(*) FROM `" . $tblPrefix . "blog` WHERE `slug`='$slug'");
        if ($result [0] ["COUNT(*)"] != 0) {
            return true;
        } else {
            return false;
        }
    }

    function addComment($name, $comment, $post_id) {
        // @diy_____blog_comments, date, post_id, email, name, id
        //if (! $this->availableComment ( $name, $comment, $post_id )) {

        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $timestamp = date('Y-m-d G:i:s');
        $result = $this->query("INSERT INTO `" . $tblPrefix . "blog_comments` (`name`,`comment`,`post_id`, `date` )		
				VALUES ('$name','$comment','$post_id','$timestamp')");

        if ($result) {
            $msg = array(
                'SUC',
                'ADD'
            );
        } else {
            $msg = array(
                'ERR',
                'NOT_ADD'
            );
        }
        //}
    }

    function availableComment($name, $comment, $post_id) {
        $where = "WHERE post_id='$postid' AND name='$name' AND comment='$comment'";
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $result = $this->query("SELECT * FROM `" . $tblPrefix . "blog_comments`" . $where);
        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    function getComments($postid) {
        $where = "WHERE post_id=$postid";
        $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
        $result = $this->query("SELECT * FROM `" . $tblPrefix . "blog_comments`" . $where);

        // $result=$this->query("SELECT * FROM `@diy_____blog` WHERE id=4");
        for ($i = 0; $i < count($result); $i ++) {
            $list [$i] [] = $result [$i] ['name']; // 0
            $list [$i] [] = $result [$i] ['comment']; // 1
            $list [$i] [] = $result [$i] ['date']; // 2
        }
        return $list;
    }

    /*
     * public function getCustomerName($id) {
     * $where = "WHERE customer_id='$id'";
     * $tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
     * $query="SELECT f_name,l_name FROM `" . $tblPrefix . "customers`" . $where;
     * $result = $this->query ( $query );
     * print_r($query);
     *
     * }
     */
}

?>
