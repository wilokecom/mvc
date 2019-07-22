<?php declare(strict_types=1);
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class TaxonomyModel
 * @package MVC\Models
 */
class TaxonomyModel extends DBFactory
{
    /**
     * @return mixed
     * @param $sTaxonomy
     * @param $sDescription
     * @param $term_id
     */
    public static function insertTaxonomy($term_id, $sTaxonomy, $sDescription)
    {
        $aParams = array($term_id, $sTaxonomy, $sDescription);
        $query   = "INSERT INTO term_taxonomy(term_id,taxonomy,description) VALUES (?,?,?)";
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @return mixed
     * @param $iTermID
     * @param $sDescription
     */
    public static function updateTaxonomy($sDescription, $iTermID)
    {
        $aParams = array($sDescription, $iTermID);
        $query   = "UPDATE term_taxonomy SET description=? WHERE term_id=?";
        return self::connect()->prepare($query, $aParams)->update();
    }
    /**
     * @return mixed
     * @param $iTermTaxonomyID
     * @param $iObjectID
     */
    public static function insertTermRelationShip($iObjectID, $iTermTaxonomyID)
    {
        $aParams = array($iObjectID, $iTermTaxonomyID);
        $query   = "INSERT INTO term_relationships(object_id,term_taxonomy_id) VALUES (?,?)";
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * Get TermTaxonomyID by name of category or name of tag:"Kinh tế","Thể Thao",...
     * And name of Taxonomy:"category","tag"
     * @return mixed
     * @param $sTaxonomy
     * @param $sTermName
     */
    public static function getTermTaxonomyID($sTermName, $sTaxonomy)
    {
        $aParams         = array($sTermName, $sTaxonomy);
        $query           = "SELECT term_taxonomy.term_taxonomy_id FROM term_taxonomy LEFT JOIN terms ON 
        term_taxonomy.term_id=terms.term_id WHERE terms.term_name=? AND term_taxonomy.taxonomy=?";
        $aTermTaxonomyID = self::connect()->prepare($query, $aParams)->select();
        if (!$aTermTaxonomyID) {
            return false;
        }
        return $aTermTaxonomyID[0];
    }
    /**
     * @return bool
     * @param $sTaxonomy
     */
    public static function getRecordByTaxononmy($sTaxonomy)
    {
        $aParams = array($sTaxonomy);
        $query   = "SELECT count(term_taxonomy_id) as total FROM term_taxonomy WHERE taxonomy=?";
        $aRecord = self::connect()->prepare($query, $aParams)->select();
        if (!$aRecord) {
            return false;
        }
        return $aRecord[0]["total"];
    }
    /**
     * Get term ID of taxonomy_table according to terrm_taxonomy_id and taxonomy(categoryorr tag)
     * @return mixed
     * @param $sTaxonomy
     * @param $iTermTaxonomyID
     */
    public static function getTermID($iTermTaxonomyID, $sTaxonomy)
    {
        $aParams = array($iTermTaxonomyID, $sTaxonomy);
        $query   = "SELECT term_id from term_taxonomy WHERE term_taxonomy_id=? AND taxonomy=?";
        $aTermID = self::connect()->prepare($query, $aParams)->select();
        if (!$aTermID) {
            return false;
        }
        return $aTermID[0];
    }
    /**
     * @return mixed
     * @param $iObjectId
     */
    public static function getTaxonomyID($iObjectId)
    {
        $aParams         = array($iObjectId);
        $query           = "SELECT term_taxonomy_id from term_relationships WHERE object_id=? ";
        $aTermTaxonomyID = self::connect()->prepare($query, $aParams)->select();
        if (!$aTermTaxonomyID) {
            return false;
        }
        return $aTermTaxonomyID;
    }
    /**
     * @return mixed
     * @param $iTermTaxonomyID
     */
    public static function updateCount($iTermTaxonomyID)
    {
        $aParams = array($iTermTaxonomyID);
        $query   = "UPDATE term_taxonomy SET count_taxonomy=count_taxonomy+1 WHERE term_taxonomy_id=?";
        //Go to method insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->update();
    }
}
