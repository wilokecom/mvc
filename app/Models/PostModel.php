<?php declare(strict_types=1);

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
     * @param $iStart
     * @param $iLimit
     * @param $iPostAuthor
     */
    public static function getPostbyPostAuthor($iPostAuthor, $iStart, $iLimit)
    {
        if ($iPostAuthor) {
            $aParams = array($iPostAuthor);
            $query   = "SELECT posts.*, users.username  FROM posts INNER JOIN users ON posts.post_author=
            users.ID WHERE post_author = ? LIMIT $iStart,$iLimit";
        } else {
            $aParams = array();
            $query   = "SELECT posts.*, users.username  FROM posts INNER JOIN users ON posts.post_author=
            users.ID LIMIT $iStart,$iLimit";
        }
        $aPosts  = self::connect()->prepare($query, $aParams)->select();
        if (!$aPosts) {
            return false;
        }
        return $aPosts;
    }
    /**
     * @return bool
     * @param $iPostAuthor
     */
    public static function getPostIDbyPostAuthor($iPostAuthor)
    {
        if ($iPostAuthor) {
            $aParams = array($iPostAuthor);
            $query   = "SELECT ID FROM posts WHERE post_author = ?";
        } else {
            $aParams = array();
            $query   = "SELECT ID FROM posts";
        }
        $aPosts  = self::connect()->prepare($query, $aParams)->select();
        if (!$aPosts) {
            return false;
        }
        return $aPosts;
    }
    /**
     * @return bool
     * @param $iPostAuthor
     * @param $iPostID
     */
    public static function getPost($iPostID, $iPostAuthor)
    {
        if ($iPostAuthor) {
            $aParams = array($iPostID, $iPostAuthor);
            $query   = "SELECT * FROM posts WHERE ID = ? AND post_author=?";
        } else {
            $aParams = array($iPostID);
            $query   = "SELECT * FROM posts WHERE ID = ? ";
        }
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        $aPost = self::connect()->prepare($query, $aParams)->select();
        if (!$aPost) {
            return false;
        }
        return $aPost[0];
    }
    /**
     * @return mixed
     * @param $iPostAuthor
     */
    public static function getRecordbyPostAuthor($iPostAuthor)
    {
        if ($iPostAuthor) {
            $aParams = array($iPostAuthor);
            $query   = "SELECT count(ID) as total FROM posts WHERE post_author=?";
        } else {
            $aParams = array();
            $query   = "SELECT count(ID) as total FROM posts ";
        }
        $aRecord = self::connect()->prepare($query, $aParams)->select();
        if (!$aRecord) {
            return false;
        }
        return $aRecord[0]["total"];
    }
    /**
     * @return mixed
     * @param $sPostStatus
     * @param $sPostType
     * @param $sPostTitle
     * @param $sPostContent
     * @param $sPostMimeType
     * @param $sGuid
     * @param $iUserID
     */
    public static function insertPost(
        $iUserID,
        $sPostStatus,
        $sPostType,
        $sPostTitle,
        $sPostContent,
        $sPostMimeType,
        $sGuid
    ) {
        $aParams = array($iUserID, $sPostStatus, $sPostType, $sPostTitle, $sPostContent, $sPostMimeType, $sGuid);
        $query   = "INSERT INTO posts(post_author, post_status, post_type, post_title, post_content, post_mime_type,
        guid) VALUES (?,?,?,?,?,?,?)";
        //Go to method insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @return mixed
     * @param $sMetaValue
     * @param $iPostID
     * @param $sMetaKey
     */
    public static function insertPostMeta($sMetaKey, $sMetaValue, $iPostID)
    {
        $aParams = array($sMetaKey, $sMetaValue, $iPostID);
        $query   = "INSERT INTO postmeta (meta_key,meta_value,post_id) VALUES(?, ?, ?)";
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @return mixed
     * @param $sPostType
     * @param $sPostTitle
     * @param $sPostContent
     * @param $PostID
     * @param $sPostStatus
     */
    public static function updatePostbyPostID($sPostStatus, $sPostType, $sPostTitle, $sPostContent, $PostID)
    {
        $aParams = array($sPostStatus, $sPostType, $sPostTitle, $sPostContent, $PostID);
        $query   = "UPDATE posts SET post_status= ?,post_type= ?, post_title = ?, post_content= ? WHERE ID = ?";
        return self::connect()->prepare($query, $aParams)->update();
    }
    /**
     * @return mixed
     * @param $PostID
     */
    public static function deletePostByPostID($PostID)
    {
        $aParams = array($PostID);
        $query   = "DELETE FROM posts WHERE ID = ? ";
        return self::connect()->prepare($query, $aParams)->delete();
    }
}
