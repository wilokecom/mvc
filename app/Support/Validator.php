<?php

namespace MVC\Support;


class Validator
{
    /**
     * @var array
     */
    protected static $aConditionals = [];

    /**
     * @var array
     */
    protected static $aData = [];

    /**
     * @param string $rawConditionals
     *
     * @return array
     */
    protected static function parseConditionals($rawConditionals)
    {
        $aRawParse = explode('|', trim($rawConditionals));

        $aConditionals = array();
        foreach ($aRawParse as $cond) {
            $aConditionAndParams = explode(':', trim($cond));
            $aConditionals[] = array(
                'func'  => trim($aConditionAndParams[0]),
                'param' => isset($aConditionAndParams[1]) ? trim($aConditionAndParams[1]) : ''
            );
        }

        return $aConditionals;
    }

    protected static function success()
    {
        return array('status' => 'success');
    }

    protected static function error($msg)
    {
        return array(
            'status' => 'error',
            'msg' => $msg
        );
    }

    protected static function maxLength($key, $length)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::success();
        }

        if (strlen(self::$aData[$key]) > $length) {
            return self::error('The maximum length of ' . $key . ' is ' . $length);
        }

        return self::success();
    }

    protected static function required($key)
    {
        if (!isset(self::$aData[$key]) || empty(self::$aData[$key])) {
            return self::error('The ' . $key . ' is required');
        }

        return self::success();
    }

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

    protected static function checkConditional($aConditionals, $key)
    {
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
     * The value contains conditionals. Each conditional should separately by a comma
     *
     * @param array $aData
     *
     * @return mixed
     */
    public static function validate($aConditionals, $aData)
    {
        self::$aData = $aData;
        foreach ($aConditionals as $key => $rawConditionals) {
            $aConditionals = self::parseConditionals($rawConditionals);
            $status = self::checkConditional($aConditionals, $key);
            if ($status !== true) {
                return $status;
            }
        }

        self::$aData = [];
        return true;
    }

}
