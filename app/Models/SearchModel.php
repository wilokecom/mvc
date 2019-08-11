<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 06/08/2019
 * Time: 9:37 SA
 */
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class SearchsModel
 * @package MVC\Models
 */
class SearchModel extends DBFactory
{
    /**
     * @param $post_author
     * @param $keyword
     * @return bool
     */
    public static function SelectPost($post_author, $keyword)
    {
        $aParam = array($keyword);
        //        $aPlaceHolder = [];
        //        $query = 'SELECT * FROM posts WHERE ';
        //        $condition = '';
        //        if (!empty($post_author)) {
        //            $aParam[] = $post_author;
        //
        //            $query .=  'post_author = ?';
        //            $condition = ' AND ';
        //        }
        //        if (!empty($keyword)) {
        //            $aParam[] = $keyword;
        //
        //            $query .= $condition . '$keyword';
        //            $condition = ' AND ';
        //        }
        $query
            = "SELECT * FROM posts WHERE post_author = $post_author AND post_content LIKE ?";
        $status = self::connect()->prepare(
            $query,
            $aParam
        )->select();
        if (!$status) {
            return false;
        }
        return $status;
    }
}
