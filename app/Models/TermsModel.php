<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 01/08/2019
 * Time: 9:48 SA
 */
namespace MVC\Models;

use \MVC\Database\DBFactory;

/**
 * Class TermsModel
 */
class TermsModel extends DBFactory
{
    /**
     * @param $aTermName
     * @param $aTaxonomy
     * @return mixed
     */
    public static function getTermByTermName($aTermName, $aTaxonomy)
    {
        $aParams = array($aTermName, $aTaxonomy);
        $query
                 = "SELECT * FROM terms WHERE term_name=? ORDER BY ID LIMIT = 1";
        $aTerms = self::connect()->prepare(
            $aParams,
            $query
        )->select();
        return $aTerms[0];
    }
}
