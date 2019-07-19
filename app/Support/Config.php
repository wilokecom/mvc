<?php
namespace MVC\Support;

/*
 * Get configuration
 */
/**
 * Class Config
 * @package MVC\Support
 */
class Config
{
    /**
     * @var
     */
    private static $fileName;//Tên file config trong thư mục app/configs
    /**
     * @var
     */
    private static $aConfiguration;//Lưu thông tin tến file,nội dung file config dưới dạng mảng
    /**
     * @var
     */
    private static $aValue;//Lưu nôi dung file
    /**
     * Config constructor.
     * @param      $fileName
     * @param bool $hasChain
     * self::$aValue = self::$aConfiguration[$fileName];
     * -> Saved file by array
     */
    public function __construct($fileName, $hasChain = false)//Lấy nội dung file config
    {
        self::$fileName = $fileName;
        if (isset(self::$aConfiguration[$fileName])) {
            self::$aConfiguration[$fileName];
        } else {
            //Kiểm tra đường dẫn app/configs
            if (file_exists(MVC_CONFIG . $fileName . ".php")) {
                //Lưu thông tin tên file, nội dung file dưới dạng mảng
                self::$aConfiguration[$fileName] = include MVC_CONFIG
                    . $fileName . ".php";
            } else {
                self::$aConfiguration[$fileName] = array();
            }
        }
        self::$aValue = self::$aConfiguration[$fileName];
    }
    /**
     * @return mixed
     */
    public function getAll()
    {
        return self::$aValue;
    }
    /**
     * @return null|$this
     * @param bool $hasChain
     * @param      $target
     */
    public function getParam($target, $hasChain = false)//Trả về thư viện mysqli
    {
        //Trả về $aValue[$target] =mysqli
        self::$aValue = isset(self::$aValue[$target]) ? self::$aValue[$target]
            : null;
        if ($hasChain) {
            return $this;//Tiếp tục trỏ đến phương thức tiếp theo-->getParam($grammar));
            //self::$oDB = new MysqlGrammar(getConfig("database")->getParam("connections", true)->getParam($grammar));
        }
        return self::$aValue;
    }
}
