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
     * Getting UserID
     */
    public static function getUserID($username)
    {
        $aParams = array($username);
        $query   = "SELECT *FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aStatus = self::connect()->prepare(
            $query,
            $aParams
        )->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0]["ID"];
    }
    /**
     * @param $userID
     * @param $post_status
     * @param $post_type
     * @param $post_title
     * @param $post_content
     * @param $guid
     * @return mixed
     */
    public static function insertPost($userID, $post_status, $post_type, $post_title,$post_content,$guid)
    {
        $aParams = array($userID, $post_status, $post_type,
            $post_title,$post_content,$guid);
        var_dump($aParams);
        $query = "INSERT INTO posts(post_author, post_status, post_type, post_tittle, post_content, guid) VALUES (?, ?, ?, ?, ?, ?)";
        return self::connect()->prepare($query,$aParams)->insert();
    }
    /**
     * @return mixed
     * @param $meta_value
     * @param $post_id
     * @param $meta_key
     * Insert Post
     */
    public static function insertPostMeta(
        $meta_key,
        $meta_value,
        $post_id
    ) {
        $aParams = array($meta_key, $meta_value, $post_id);
        $query
               = "INSERT INTO postmeta (meta_key,meta_value,post_id) VALUES(?, ?, ?)";
        return self::connect()->prepare(
            $query,
            $aParams
        )->insert();
    }
    /**|
     * Trả về tất cả các bài
     * @return bool
     * @param $postAuthor
     */
    public static function getPostbyPostAuthor($postAuthor)
    {
        $aParams = array($postAuthor);
        $query   = "SELECT * FROM posts WHERE post_author = ? ";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        $aPosts = self::connect()->prepare(
            $query,
            $aParams
        )->select();
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
        $query   = "SELECT * FROM posts WHERE ID = ?";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        $aPosts = self::connect()->prepare(
            $query,
            $aParams
        )->select();
        if (!$aPosts) {
            return false;
        }
        return $aPosts[0];
    }
    /**
     * @return bool
     * @param $posst_type
     * @param $post_tittle
     * @param $post_content
     * @param $PostID
     * @param $post_status
     */
    public static function updatePostbyPostID(
        $post_status,
        $posst_type,
        $post_tittle,
        $post_content,
        $PostID
    ) {
        $aParams = array(
            $post_status,
            $posst_type,
            $post_tittle,
            $post_content,
            $PostID
        );
        $query
                 = "UPDATE posts SET post_status= ?,post_type= ?, post_tittle = ?, post_content= ? WHERE ID = ?";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare(
            $query,
            $aParams
        )->update();
    }
    /**
     * @param $PostID
     * @return mixed
     */
//    public static function deletePostbyPostID($PostID)
//    {
//        $aParams = array($PostID);
//        $query   = "DELETE FROM posts WHERE ID = ?";
//        //Nhảy đến phương thức delete() file MysqlGrammar.php
//        return self::connect()->prepare(
//            $query,
//            $aParams
//        )->delete();
//    }
    /**
     * @param $ID
     * @return mixed
     */
    public  static function deletePost($ID)
    {
        $aParams = array($ID);
        $query = "DELETE FROM posts WHERE ID = ?";
        return self::connect()->prepare($query,$aParams)->delete();
    }
    /**
     * @param $ID
     * @return mixed
     * ???
     */
    public static function getRecordbyPostAuthor($ID)
    {
        $aParams = array($ID);
        $query = "SELECT COUNT(ID) as total FROM posts WHERE post_author = ? ";
        $aRecord = self::connect()->prepare($query,$aParams)->select();
        return $aRecord[0]["total"];
    }
}
