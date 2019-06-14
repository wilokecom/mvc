<?php

namespace MVC\Models;

use MVC\Database\DBFactory;

class PostModel extends DBFactory
{
    //Lấy userID
    public static function getUserID($username){
        $aParams=array($username);
        $query = "SELECT *FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aStatus= self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0]["ID"];//Trả về kết qủa dưới dạng mảng
    }
    //Insert Post
    public static function insertPost($userID,$post_status, $post_type, $post_tittle, $post_content,$post_mime_type)
    {
        $aParams = array( $post_status, $post_type, $post_tittle, $post_content,$post_mime_type);
        $query = "INSERT INTO posts (post_author,post_status, post_type,post_tittle,post_content,post_mime_type) VALUES ($userID,?,?,?,?,?)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
    //Insert PostMeta
    public static function insertPostMeta($meta_key, $meta_value,$lastID)
    {
        $aParams = array($meta_key, $meta_value);
        $query = "INSERT INTO postmeta (meta_key,meta_value,post_id) VALUES(?, ?,$lastID)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
}
