<?php

namespace MVC\Support;

/**
 * Class Validator
 *
 * @package MVC\Support
 */
class Validator
{
    /**
     * @var array
     */
    protected static $aConditionals = [];//Mảng lưu các key là các giá trị, value là các giá trị cần validate

    /**
     * @var array
     */
    protected static $aData = [];//Mảng lưu giá trị của biến $_POST

    /**
     * @param string $rawConditionals
     *
     * @return array
     */
    //Phân tích điều kiện validate
    protected static function parseConditionals($rawConditionals)
    {
        //Phá chuỗi và trim
        $aRawParse = explode('|', trim($rawConditionals));
        //Khai báo mảng rỗng
        $aConditionals = array();
        //Lấy các phần tử mảng
        foreach ($aRawParse as $cond) {
            $aConditionAndParams = explode(':', trim($cond)); //phá dấu 2 chấm
            $aConditionals[] = array(
                'func' => trim($aConditionAndParams[0]),
                'param' => isset($aConditionAndParams[1]) ? trim($aConditionAndParams[1]) : ''
            );
        }
        //arr('func'=> ,'param'=>)
        return $aConditionals;
    }

    /**
     * @return array
     *              //Trả về mảng có giá trị success
     */
    protected static function success()
    {
        return array('status' => 'success');
    }
    /**
     * @param $msg
     *
     * @return array
     *              //Trả về mảng có giá trị error
     */

    protected static function error($msg)
    {
        return array(
            'status' => 'error',
            'msg' => $msg
        );
    }
    /**
     * @param $key
     * @param $length
     *
     * @return array
     *              //Check xem có tồn tại phần tử mảng của biến $_POST hay không
     */
    protected static function maxLength($key, $length)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }
        //Kiểm tra chiều dài của chuỗi
        if (strlen(self::$aData[$key]) > $length) {
            return self::error('The maximum length of ' . $key . ' is ' . $length);
        }

        return self::success();
    }
    /**
     * @param $key
     *
     * @return array
     *              //Check xem có tồn tại phần tử mảng của biến $_POST hay không
     */
    protected static function required($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::error('The ' . $key . ' is required');
        }

        return self::success();
    }

    /**
     * @param $key
     *
     * @return array
     */
    protected static function url($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }

        if (!filter_var(self::$aData[$key], FILTER_VALIDATE_URL)) {
            return self::error('Invalid email address');
        }
    }

    /**
     * @param $key
     *
     * @return array
     */
    protected static function email($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }

        if (!filter_var(self::$aData[$key], FILTER_VALIDATE_EMAIL)) {
            return self::error('Invalid email address');
        }

        return self::success();
    }

    /**
     * @param $aConditionals
     * @param $key
     *
     * @return bool
     *
     *              //Kiểm tra điều kiện
     */

    protected static function checkConditional($aConditionals, $key)
    {
        //Duyệt các phần tử mảng
        foreach ($aConditionals as $aConditional) {
            if (!method_exists(__CLASS__, $aConditional['func'])) {
                throw new \RuntimeException('Method with name ' . $aConditional['func'] . ' does not exist');
            } else {
                $aStatus = call_user_func_array(
                    array(__CLASS__, $aConditional['func']),
                    array($key, $aConditional['param'])
                );

                if ($aStatus['status'] == 'error') {
                    return $aStatus['msg'];
                }
            }
        }

        return true;
    }

    /**
     * Setup configuration and data
     *
     * @param array $aConditionals The conditional is a key-value array. They key is key is $aData as well.
     *                             The value contains conditionals. Each conditional should separately by a comma
     *
     * @param array $aData
     *
     * @return mixed
     */
    //Validate
    public static function validate($aConditionals, $aData)
    {
        self::$aData = $aData;//Lưu giá trị biến $_POST
        //Duyệt mảng các giá trị cần validate
        foreach ($aConditionals as $key => $rawConditionals) {
            //Phân tích điều kiện validate
            $aConditionals = self::parseConditionals($rawConditionals);
            //Kiểm tra điều kiện
            $status = self::checkConditional($aConditionals, $key);
            if ($status !== true) {
                return $status;
            }
        }
        self::$aData = [];
        return true;
    }
    /**
     * @param $key
     *
     * @return array
     *              Kiểm tra phần mở rộng - định dạng file ảnh
     */
    protected static function checkType($key)
    {
        //Duyệt các phần tử mảng
        $allowed_types = array('image/jpg', 'image/bmp', 'image/jpeg', 'image/png');
//        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
//        $detected_type = finfo_file( $fileInfo, $_FILES['datei']['tmp_name'] );
        if (!in_array(self::$aData[$key], $allowed_types)) {
            die ('Please upload a pdf or an image ');
            return self::error('invalid Image' . $key);
        }
//        finfo_close( $fileInfo );
        return self::success();
    }

    /**
     * @param $key
     * @param $size
     *
     * @return array
     *              Kiếm tra và qui định size của file ảnh
     */
    protected static function checkSize($key, $size)
    {
        //Nếu kích thước không tồn tại hoặc bằng 0
        if (!isset(self::$aData[$key]) || empty(self::$aData[$size])) {
            return self::success();
        }
//        Kiểm tra kích thước của ảnh
        if (self::$aData[$key] > $size) {
            return self::error("the maximum of " . $key . "is" . $size);
        }
        return self::success();
    }
}
