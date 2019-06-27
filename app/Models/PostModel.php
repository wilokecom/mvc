<?php

namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class PostModel
 * @package MVC\Models
 */
class PostModel extends DBFactory
{
    /**
     * @return bool
     * @param $username
     */
    public static function getUserID($username)//Lấy userID
    {
        $aParams = array($username);
        $query = "SELECT *FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aStatus = self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0]["ID"];
    }
    /**
     * @return mixed
     * @param $post_status
     * @param $post_type
     * @param $post_title
     * @param $post_content
     * @param $post_mime_type
     * @param $guid
     * @param $userID
     */
    public static function insertPost(//Insert Post
        $userID,
        $post_status,
        $post_type,
        $post_title,
        $post_content,
        $post_mime_type,
        $guid
    ) {
        $aParams = array($userID, $post_status, $post_type, $post_title, $post_content, $post_mime_type, $guid);
        $query = "INSERT INTO posts(post_author, post_status, post_type, post_title, post_content, post_mime_type,guid)
        VALUES (?,?,?,?,?,?,?)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @return mixed
     * @param $meta_value
     * @param $post_id
     * @param $meta_key
     */
    public static function insertPostMeta($meta_key, $meta_value, $post_id)//Insert PostMeta
    {
        $aParams = array($meta_key, $meta_value, $post_id);
        $query = "INSERT INTO postmeta (meta_key,meta_value,post_id) VALUES(?, ?, ?)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**|
     * Trả về tất cả các bài
     * @return bool
     * @param $postAuthor
     */
    public static function getPostbyPostAuthor($postAuthor)
    {
        $aParams = array($postAuthor);
        $query = "SELECT * FROM posts WHERE post_author = ?";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        $aPosts = self::connect()->prepare($query, $aParams)->select();
        if (!$aPosts) {
            return false;
        }
        return $aPosts;
    }
    /**
     * @return bool
     * @param $PostID
     */
    public static function getPostbyPostID($PostID)
    {
        $aParams = array($PostID);
        $query = "SELECT * FROM posts WHERE ID = ?";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        $aPosts = self::connect()->prepare($query, $aParams)->select();
        if (!$aPosts) {
            return false;
        }
        return $aPosts[0];
    }

    /**
     * @return bool
     * @param $posst_type
     * @param $post_title
     * @param $post_content
     * @param $PostID
     * @param $post_status
     */
    public static function updatePostbyPostID($post_status, $posst_type, $post_title, $post_content, $PostID)
    {
        $aParams = array($post_status, $posst_type, $post_title, $post_content, $PostID);
        $query = "UPDATE posts SET post_status= ?,post_type= ?, post_title = ?, post_content= ? WHERE ID = ?";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->update();
    }
    /**
     * @return mixed
     */
    public static function deletePostbyPostID($PostID)
    {
        $aParams = array($PostID);
        $query = "DELETE FROM posts WHERE ID = ?";
        //Nhảy đến phương thức delete() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->delete();
    }
}
