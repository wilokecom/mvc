<?php

namespace MVC\Database;

class MysqlGrammar implements DBInterface
{
    /*
    * @param Array
    */
    private $aDBConfiguration;//Mảng lưu thông tin DB

    /*
    * @param instanceof \mysqli
    */
    private $oConnect = null;//Object kết nối đến DB mysqli
    private $oSTMT = null;//Tạo đối tượng prepared
    //Hàm khởi tạo
    public function __construct($aDBConfiguration)
    {
        $this->aDBConfiguration = $aDBConfiguration;//Mảng lưu thông tin DB
    }

    /*
    * Prepare before querying
    *
    * @return $this
    */
    //Chuẩn bị 1 câu lệnh sql để thực thi, tránh lỗi SQl Injection
    public function prepare($query, array $aArgs)
    {
        $aParams = array();
        //Tạo đối tượng preapred
        $this->oSTMT = $this->oConnect->prepare($query);
        //Hàm array_reduce() sẽ tính toán các phần tử của mảng dựa vào hàm chức năng được truyền vào do người dùng định nghĩa.
        //function ($carry, $args) use (&$aParams):Hàm ẩn danh
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
//        var_dump($aParams);die;
        $this->oSTMT->bind_param($types, ...$aParams);
        return $this;
    }

    /**
     * Get value
     *
     * @return mixed
     */

    //Select
    public function select($string = "")
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
     * @param string $string
     * @return mixed
     */
    //Insert
    public function insert($string = "")
    {
        //Thực thị câu lệnh truy vấn
        $this->oSTMT->execute();
        $id = $this->oSTMT->insert_id;
        $this->oSTMT->close();//Ngắt kết nối
        return $id;
    }
    /**
     * Delete value
     *
     * @return bool
     */
    public function delete($string = "")
    {
        $status = $this->oSTMT->execute();
        $this->oSTMT->close();
        return $status;
    }
    /*
     * Connecting to database
    */
    //Connect DB
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
        }

        return $this;
    }
}