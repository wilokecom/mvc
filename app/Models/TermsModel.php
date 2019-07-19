<?php declare(strict_types=1);
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class TermsModel
 * @package MVC\Models
 */
class TermsModel extends DBFactory
{
    /**
     * @return mixed
     * @param $sSlug
     * @param $sName
     */
    public static function insertTerm($sName, $sSlug)
    {
        $aParams = array($sName, $sSlug);
        $query   = "INSERT INTO terms(term_name,slug) VALUES (?,?)";
        //Go to method insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @return mixed
     * @param $sName
     * @param $sSlug
     * @param $sOldName
     */
    public static function updateTerm($sName, $sSlug, $sOldName)
    {
        $aParams = array($sName, $sSlug, $sOldName);
        $query   = "UPDATE terms SET term_name=?,slug=? WHERE term_name=?";
        //Go to method insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->update();
    }
    /**
     * get all TermName By "category" or "tag" to dislay page post/add
     * $sTermName="Kinh Tế" or "Thể Thao"
     * @return mixed
     * @param $sTaxonomy  :category or tag
     */
    public static function getTermName($sTaxonomy)
    {
        $aParams   = array($sTaxonomy);
        $query     = "SELECT terms.term_name FROM terms LEFT JOIN term_taxonomy ON terms.term_id=term_taxonomy.term_id 
        WHERE term_taxonomy.taxonomy=?";
        $aTermName = self::connect()->prepare($query, $aParams)->select();
        if (!$aTermName) {
            return false;
        }
        return $aTermName;
    }
    /**
     * @return bool
     * @param $TermID
     */
    public static function getTermNameByTermID($TermID)
    {
        $aParams   = array($TermID);
        $query     = "SELECT term_name FROM terms WHERE term_id=?";
        $aTermName = self::connect()->prepare($query, $aParams)->select();
        if (!$aTermName) {
            return false;
        }
        return $aTermName[0];
    }
    /**
     * @return bool
     * @param $iStart
     * @param $iLimit
     * @param $sTaxonomy
     */
    public static function getTermByTaxonomy($sTaxonomy, $iStart, $iLimit)
    {
        $aParams = array($sTaxonomy);
        $query   = "SELECT * FROM terms LEFT JOIN term_taxonomy ON terms.term_id=term_taxonomy.term_id
        WHERE term_taxonomy.taxonomy=? LIMIT $iStart,$iLimit";
        $aTerms  = self::connect()->prepare($query, $aParams)->select();
        if (!$aTerms) {
            return false;
        }
        return $aTerms;
    }
    /**
     * @return bool
     * @param $sTaxonomy
     * @param $sTermName
     */
    public static function getTermByTermName($sTermName, $sTaxonomy)
    {
        $aParams = array($sTermName, $sTaxonomy);
        $query   = "SELECT * FROM terms LEFT JOIN term_taxonomy ON terms.term_id=term_taxonomy.term_id
        WHERE terms.term_name=? AND term_taxonomy.taxonomy=?";
        $aTerms  = self::connect()->prepare($query, $aParams)->select();
        if (!$aTerms) {
            return false;
        }
        return $aTerms[0];
    }
    /**
     * Check termname is exist or not
     * @return mixed
     * @param $sTermName  :"Kinh Tế" or "Thể Thao"
     * @param $sTaxonomy  :"category" or "post_tag"
     */
    public static function checkTermNameExist($sTaxonomy, $sTermName)
    {
        $aParams = array($sTaxonomy, $sTermName);
        $query   = "SELECT terms.term_name FROM terms LEFT JOIN term_taxonomy ON 
        terms.term_id=term_taxonomy.term_id WHERE term_taxonomy.taxonomy=? AND terms.term_name=?";
        return self::connect()->prepare($query, $aParams)->select();
    }
    /**
     * @return mixed
     * @param $iTermID
     */
    public static function deleteTerm($iTermID)
    {
        $aParams = array($iTermID);
        $query   = "DELETE FROM terms WHERE term_id=?";
        return self::connect()->prepare($query, $aParams)->delete();
    }
}
