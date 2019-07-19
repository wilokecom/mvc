<?php
namespace MVC\Database;
/**
 * Class MysqlGrammar
 * @package MVC\Database
 */
class MysqlGrammar implements DBInterface
{
    /**
     * @var
     */
    private $aDBConfiguration;//Mảng lưu thông tin DB
    /**
     * @var null
     */
    private $oConnect = null;//Object kết nối đến DB mysqli
    /**
     * @var null
     */
    private $oSTMT = null;//Tạo đối tượng prepared
    /**
     * MysqlGrammar constructor.
     * @param $aDBConfiguration
     */
    public function __construct($aDBConfiguration)//Hàm khởi tạo
    {
        $this->aDBConfiguration = $aDBConfiguration;//Mảng lưu thông tin DB
    }
    /**
     * @return $this
     * @param array $aArgs
     * @param       $query
     */
    public function prepare($query, array $aArgs)//Chuẩn bị 1 câu lệnh sql để thực thi, tránh lỗi SQl Injection
    {
        $aParams = array();
        //Tạo đối tượng preapred
        $this->oSTMT = $this->oConnect->prepare($query);
                if (!$this->oSTMT) {
                    echo "Prepare failed: (" . $this->oConnect->errno . ") " . $this->oConnect->error;
                    if (defined('DEBUG') && DEBUG) {
                    }
                    define('DEBUG', true);
                    die;
                }
        //Hàm array_reduce() sẽ tính toán các phần tử của mảng dựa vào hàm chức năng được truyền vào do người dùng định nghĩa.
        //function ($carry, $args) use (&$aParams):Hàm ẩn danh, truyền tham chiếu
        //lamda và cloasure
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
        // tất cả parameter ta truyền sẽ được cho vào cùng một mảng , bên trong hàm, ta có thể gọi đến mảng đó bằng $parameters
        //      var_dump($aParams);die;
        if($types!=""){
            $this->oSTMT->bind_param($types, ... $aParams);
        }
        return $this;
    }
    /**
     * Get value
     * @return mixed
     */
    public function select($string = "")//Select
    {
        //Thực thi câu truy vấn, nếu thành công trả về phương thức get_result(), nếu không trả về false
        $oResult = $this->oSTMT->execute() ? $this->oSTMT->get_result() : false;
        $this->oSTMT->close();//Ngắt kết nối
        if (!$oResult) {//Nếu kết quả câu truy vấn trả về rỗng
            return false;
        }
        $aRows = [];
        if (isset($oResult) && $oResult instanceof \mysqli_result) {//=true
            while (null !== ($aRow = $oResult->fetch_assoc())) {//Trả về kết quả câu truy vấn dưới dạng mảng
                $aRows[] = $aRow;
            }
        }
        return $aRows;
    }
    /**
     * @return mixed
     * @param string $string
     */
    public function insert($string = "")//Insert
    {
        //Thực thị câu lệnh truy vấn
        $this->oSTMT->execute();
        $id = $this->oSTMT->insert_id;
        $this->oSTMT->close();//Ngắt kết nối
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
     * @return $this|mixed
     */
    public function connect()//Connect DB
    {
        //Connect
        if ($this->oConnect === null) {
            $this->oConnect = new \mysqli($this->aDBConfiguration["host"],
                $this->aDBConfiguration["username"],
                $this->aDBConfiguration["password"],
                $this->aDBConfiguration["db"]);
            /* check connection */
            if ($this->oConnect->connect_errno) {
                throw new \RuntimeException("Connect failed: %s\n", $this->oConnect->connect_error);
            }
        }
        return $this;
    }
}