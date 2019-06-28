<?php

namespace MVC\Database;

/**
 * Class MysqlGrammar
 *
 * @package MVC\Database
 */
class MysqlGrammar implements DBInterface
{
    /*
    * @param Array
    */
    private $aDBConfiguration;//Mảng lưu thông tin DB

    /**
    * @param \mysqli $oConnect
    */
    private $oConnect;//Object kết nối đến DB mysqli

    /**
     * @param \mysqli $oSTMT
     */
    private $oSTMT;//Tạo đối tượng prepared
    //Hàm khởi tạo
    /**
     * MysqlGrammar constructor.
     *
     * @param $aDBConfiguration
     */
    public function __construct($aDBConfiguration)
    {
        $this->aDBConfiguration = $aDBConfiguration;//Mảng lưu thông tin DB
    }

    /**
     * Prepare before querying
     *
     * @return $this
     */
    //Chuẩn bị 1 câu lệnh sql để thực thi, tránh lỗi SQl Injection
    /**
     * @param       $query
     * @param array $aArgs
     *
     * @return $this
     */
    public function prepare($query, array $aArgs)
    {
        $aParams = array();
        //Tạo đối tượng preapred
        $this->oSTMT = $this->oConnect->prepare($query);

        if (!$this->oSTMT) {
            var_dump($this->oConnect->error);
        }

        //Hàm array_reduce() sẽ tính toán các phần tử của mảng dựa vào hàm chức năng được truyền vào do người dùng định nghĩa.
        //function ($carry, $args) use (&$aParams):Hàm ẩn danh
        //lamda và cloasure
        $types = array_reduce($aArgs, function ($carry, $args) use (&$aParams) {
            $aParams[] = $args;
            switch ($args) {
                case is_float($args):
                    $carry .= 'd';
                    break;
                case is_integer($args):
                    $carry .= 'i';
                    break;
                case is_string($args):
                    $carry .= 's';
                    break;
                default:
                    $carry .= 'b';
                    break;
            }
            return $carry;
        }, '');
        // tất cả parameter ta truyền sẽ được cho vào cùng một mảng , bên trong hàm, ta có thể gọi đến mảng đó bằng $parameters
        $this->oSTMT->bind_param($types, ...$aParams);
        return $this;
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function  update($string = '')
    {
        $oResult = $this->oSTMT->execute();
//        var_dump($oResult); die ;
        if (false === $oResult) {
            die('execute() failed: ' . htmlspecialchars($this->oSTMT->error));
        }
        $this->oSTMT->close();//Ngắt kết nối
        return $oResult;
    }

    /**
     * Get value
     *
     * @return mixed
     */

    /**
     * @param string $string
     *
     * @return array|bool
     */
    public function select($string = '')
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
     * insert value
     *
     * @return bool
     */
    //Insert
    /**
     * @param string $string
     *
     * @return mixed
     */
    public function insert($string = '')
    {
        //Thực thị câu lệnh truy vấn
        $status = $this->oSTMT->execute();
        if (false === $status) {
            die('execute() failed: ' . htmlspecialchars($this->oSTMT->error));
        }
        $this->oSTMT->close();//Ngắt kết nối
        return $status;
    }

    /**
     * @param string $string
     *
     * @return mixed
     *
     *              @return bool
     *             Delete value
     */
    public function delete($string = '')
    {
        $status = $this->oSTMT->execute();
        $this->oSTMT->close();
        return $status;
    }

    //Connect DB
    /**
     * @return $this|mixed
     *                    Connecting to database
     */
    public function connect()
    {
        //Connect
        if ($this->oConnect === null) {
            $this->oConnect = new \mysqli(
                $this->aDBConfiguration["host"],
                $this->aDBConfiguration["username"],
                $this->aDBConfiguration["password"],
                $this->aDBConfiguration["db"]
            );

            /* check connection */
            if ($this->oConnect->connect_errno) {
                throw new \RuntimeException("Connect failed: %s\n", $this->oConnect->connect_error);
            }

            //$this->oConnect->set_charset('UTF-8');
        }

        return $this;
    }
}