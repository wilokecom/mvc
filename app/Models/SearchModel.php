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
//        $query = "SELECT * FROM posts WHERE  post_author=$post_author AND post_content OR
//post_title LIKE ?";
        $query="SELECT * FROM `fantom`.posts WHERE MATCH (post_title,post_content) AGAINST ( ? IN NATURAL LANGUAGE MODE)";
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
