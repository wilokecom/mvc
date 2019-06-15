<?php

namespace MVC\Support;
/*
 * Get configuration
 */

class Config
{
    /*
     * @param String
     */
    private static $fileName;//Tên file config trong thư mục app/configs
    /*
     * @param Array
     */
    private static $aConfiguration;//Lưu thông tin tến file,nội dung file config dưới dạng mảng
    /*
     * @param Array | String
     */
    private static $aValue;//Lưu nôi dung file

    /*
     * Specifying the file that you want to get
     *
     * @param $fileName String
     * @return Array | String
     */
    //Lấy nội dung file config
    public function __construct($fileName, $hasChain = false)
    {
        self::$fileName = $fileName;
        if (isset(self::$aConfiguration[$fileName])) {
            self::$aConfiguration[$fileName];
        } else {
            //Kiểm tra đường dẫn app/configs
            if (file_exists(MVC_CONFIG . $fileName . ".php")) {
                //Lưu thông tin tên file, nội dung file dưới dạng mảng
                self::$aConfiguration[$fileName] = include MVC_CONFIG . $fileName . ".php";
            } else {
                self::$aConfiguration[$fileName] = array();
            }
        }
        //Lưu nội dung file dưới dạng mảng
        self::$aValue = self::$aConfiguration[$fileName];
    }

    /*
     * Getting all configuration
     * @return Closure | Array | String | NULL
     */
    public function getAll()
    {
        return self::$aValue;
    }

    /*
     * Getting configuration
     *
     * @param $target String
     * @param $hasChain Bool
     *
     * @return Closure | Array | String | NULL
     */
    //Trả về thư viện mysqli
    public function getParam($target, $hasChain = false)
    {
        //Trả về $aValue[$target] =mysqli
        self::$aValue = isset(self::$aValue[$target]) ? self::$aValue[$target] : null;
        if ($hasChain) {
            return $this;//Tiếp tục trỏ đến phương thức tiếp theo-->getParam($grammar));
            //self::$oDB = new MysqlGrammar(getConfig("database")->getParam("connections", true)->getParam($grammar));
        }
        return self::$aValue;
    }
}
