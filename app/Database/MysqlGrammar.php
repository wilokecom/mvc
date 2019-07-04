<?php declare(strict_types=1);
namespace MVC\Database;

/**
 * Class MysqlGrammar
 * @package MVC\Database
 */
class MysqlGrammar implements DBInterface
{
    /**
     * Save info DB
     * @var
     */
    private $aDBConfiguration;
    /**
     * Object connect to DB mysqli
     * @var null
     */
    private $oConnect = null;
    /**
     * Create object preapared
     * @var null
     */
    private $oSTMT = null;
    /**
     * MysqlGrammar constructor.
     * Save info DB
     * @param $aDBConfiguration
     */
    public function __construct($aDBConfiguration)
    {
        $this->aDBConfiguration = $aDBConfiguration;
    }
    /**
     * @return $this
     * @param array $aArgs
     * @param       $query
     */
    public function prepare($query, array $aArgs)
    {
        $aParams = array();
        //Create object preapred
        $this->oSTMT = $this->oConnect->prepare($query);
        //array_reduce()
        //function ($carry, $args) use (&$aParams):Anonymous function, reference transmission
        //lamda and cloasure
        $types = array_reduce($aArgs, function ($carry, $args) use (&$aParams) {
            $aParams[] = $args;
            switch ($args) {
                case is_float($args):
                    $carry .= "d";
                    break;
                case is_integer($args):
                    $carry .= "i";
                    break;
                case is_string($args):
                    $carry .= "s";
                    break;
                default:
                    $carry .= "b";
                    break;
            }
            return $carry;
        }, "");
        if($types!=""){
            $this->oSTMT->bind_param($types, ...$aParams);
        }
        return $this;
    }
    /**
     * @return array|bool|mixed
     * @param string $string
     */
    public function select($string = "")//Select
    {
        //Execute the query, if successful, returns the get_result () method, otherwise returns false
        $oResult = $this->oSTMT->execute() ? $this->oSTMT->get_result() : false;
        $this->oSTMT->close();
        if (!$oResult) {//empty
            return false;
        }
        $aRows = [];
        if (isset($oResult) && $oResult instanceof \mysqli_result) {//=true
            while (null !== ($aRow = $oResult->fetch_assoc())) {//=array()
                $aRows[] = $aRow;
            }
        }
        return $aRows;
    }
    /**
     * @return mixed
     * @param string $string
     */
    public function insert($string = "")
    {
        //Thực thị câu lệnh truy vấn
        $this->oSTMT->execute();
        $id = $this->oSTMT->insert_id;
        $this->oSTMT->close();
        return $id;
    }
    /**
     * @return mixed
     * @param string $string
     */
    public function update($string = "")//Insert
    {
        //Thực thị câu lệnh truy vấn
        $status = $this->oSTMT->execute();
        $this->oSTMT->close();
        return $status;
    }
    /**
     * Delete value
     * @return bool
     */
    public function delete($string = "")
    {
        $status = $this->oSTMT->execute();
        $this->oSTMT->close();
        return $status;
    }
    /**
     * Connect DB
     * @return $this|mixed
     */
    public function connect()
    {
        //Connect
        if ($this->oConnect === null) {
            $this->oConnect = new \mysqli($this->aDBConfiguration["host"],
                $this->aDBConfiguration["username"],
                $this->aDBConfiguration["password"],
                $this->aDBConfiguration["db"]);
            //Check connection
            if ($this->oConnect->connect_errno) {
                throw new \RuntimeException("Connect failed: %s\n", $this->oConnect->connect_error);
            }
        }
        return $this;
    }
}