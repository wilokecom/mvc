<?php declare(strict_types=1);
namespace MVC\Support;

/**
 * Class Validator
 *
 * @package MVC\Support
 */
class Validator
{
    /**
     * Array restore key is field, value is value of field need to validate
     * @var array
     */
    protected static $aConditionals = [];
    /**
     * Array restore value of $_POST
     * @var array
     */
    protected static $aData = [];
    /**
     * Validate condition analysis
     * Return arr("func"=> ,"param"=>)
     * @return array
     *
     * @param string $rawConditionals
     */
    protected static function parseConditionals($rawConditionals)
    {
        //Destroy string and trim
        $aRawParse = explode("|", trim($rawConditionals));
        //Declare an empty array
        $aConditionals = array();
        foreach ($aRawParse as $cond) {
            $aConditionAndParams = explode(":", trim($cond));
            $aConditionals[] = array(
                "func" => trim($aConditionAndParams[0]),
                "param" => isset($aConditionAndParams[1]) ? trim(
                    $aConditionAndParams[1]
                ) : ""
            );
        }
        return $aConditionals;
    }
    /**
     * Return array has value "success"
     * @return array
     */
    protected static function success()
    {
        return array("status" => "success");
    }
    /**
     * Return array has value "error"
     * @return array
     *
     * @param $msg
     */
    protected static function error($msg)
    {
        return array(
            "status" => "error",
            "msg" => $msg
        );
    }

    /**
     * @return array
     *
     * @param $length
     * @param $key
     */
    protected static function maxLength($key, $length)
    {
        //If the length not exist or equal 0
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }
        //Check the length of string
        if (strlen(self::$aData[$key]) > $length) {
            return self::error(
                "The maximum length of " . $key . " is " . $length
            );
        }
        return self::success();
    }
    /**
     * Check if the element of $_POST is exist or not
     * @return array
     *
     * @param $key
     */
    protected static function required($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::error("The " . $key . " is required");
        }
        return self::success();
    }

    /**
     * @return array
     *
     * @param $key
     */
    protected static function email($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }
        if (!filter_var(self::$aData[$key], FILTER_VALIDATE_EMAIL)) {
            return self::error("Invalid email address");
        }
        return self::success();
    }
    /**
     * Check the image file format
     * @return array
     *
     * @param $key
     */
    protected static function checkImageType($key)
    {
        $type = array(
            "image/jpeg",
            "image/jpg",
            "image/bmp",
            "image/gif",
            "image/png"
        );
        if (!in_array(self::$aData[$key], $type)) {
            return self::error("Invalid image " . $key);
        }
        return self::success();
    }

    /**
     * @return array
     *
     * @param $size
     * @param $key
     */
    protected static function maxSize($key, $size)
    {
        //If the size not exist or equal 0
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }
        //Check the size of image
        if (self::$aData[$key] > $size) {
            return self::error("The maximum size of " . $key . " is " . $size);
        }
        return self::success();
    }
    /**
     * Check the conditional
     * @return bool
     *
     * @param $key
     * @param $aConditionals
     */
    protected static function checkConditional($aConditionals, $key)
    {
        foreach ($aConditionals as $aConditional) {
            if (!method_exists(__CLASS__, $aConditional["func"])) {
                throw new \RuntimeException(
                    "Method with name " . $aConditional["func"]
                    . " does not exist"
                );
            } else {
                $aStatus = call_user_func_array(
                    array(__CLASS__, $aConditional["func"]),
                    array($key, $aConditional["param"])
                );
                if ($aStatus["status"] == "error") {
                    return $aStatus["msg"];
                }
            }
        }
        return true;
    }

    /**
     * @return bool
     *
     * @param $aData
     * @param $aConditionals
     */
    public static function validate($aConditionals, $aData)
    {
        self::$aData = $aData;//Restore the value of $_POST
        //The array of values to be validated
        foreach ($aConditionals as $key => $rawConditionals) {
            //Validate condition analysis
            $aConditionals = self::parseConditionals($rawConditionals);
            //Check the condition
            $status = self::checkConditional($aConditionals, $key);
            if ($status !== true) {
                return $status;
            }
        }
        self::$aData = [];
        return true;
    }
}
