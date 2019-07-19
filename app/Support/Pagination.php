<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 05/07/2019
 * Time: 10:37 SA
 */
namespace MVC\Support;

/**
 * Class Pagination
 * @package MVC\Support
 */
class Pagination
{
    /**
     * @var array
     */
    public static $config
        = array(
            "total_page" >= 1,
            // tổng số mẩu tin
            'limit_page' >= 10,
            // số mẩu tin trên một trang
            // true nếu hiện full số page, flase nếu không muốn hiện false
            'querystring' => 'page',
            // GET id nhận page
            'range' => 5
             );
    /**
     * Pagination constructor.
     * @param array $config
     */
    public static function init($config = array())
    {
        // kiểm tra xem trong config có limit, total_page đủ điều kiện không
        if (isset($config['limit']) && $config['limit'] < 0
            || isset($config['total_page']) && $config['total_page'] < 0
        ) {
            // nếu không thì dừng chương trình và hiển thị thông báo.
            die('limit và total_page không được nhỏ hơn 0');
        }
        // Kiểm tra xem config có querystring không
        if (!isset($config['querystring'])) {
            //nếu không để mặc định là page
            $config['querystring'] = 'page';
        }
        self::$config = $config;
    }
    /**
     * @return float
     */
    public static function gettotal_pagePage()
    {
        return ceil(self::$config['total_page'] / self::$config['limit']);
    }
    /**
     *
     */
    public static function getCurrentPage()
    {
        // kiểm tra tồn tại GET querystring và có >=1 không
        if (isset($_GET[self::$config['querystring']])
            && (int)$_GET[self::$config['querystring']] >= 1
        ) {
            // Nếu có kiểm tra tiếp xem nó có lớn hơn tổn số trang không.
            if ((int)$_GET[self::$config['querystring']] > self::gettotal_pagePage()
            ) {
                // nếu lớn hơn thì trả về tổng số page
                return (int)self::gettotal_pagePage();
            } else {
                // còn không thì trả về số trang
                return (int)$_GET[self::$config['querystring']];
            }
        } else {
            // nếu không có querystring thì nhận mặc định là 1
            return 1;
        }
    }
    /**
     * @return string|void
     */
    public static function getPrePage()
    {
        // nếu trang hiện tại bằng 1 thì trả về null
        if (self::getCurrentPage() === 1) {
            return;
        } else {
            // còn không thì trả về html code
            return '<li>
                      <a href="' . $_SERVER['PHP_SELF'] . '?'
                   . self::$config['querystring'] . '='
                   . (self::getCurrentPage() - 1) . '" >Pre</a></li>';
        }
    }
    /**
     * @return string|void
     */
    public static function getNextPage()
    {
        // nếu trang hiện tại lơn hơn = total_pagepage thì trả về rỗng
        if (self::getCurrentPage() >= self::gettotal_pagePage()) {
            return;
        } else {
            // còn không thì trả về HTML code
            return '<li><a href="' . $_SERVER['PHP_SELF'] . '?' .
                   self::$config['querystring'] . '=' . (self::getCurrentPage()
                   + 1) . '" >Next</a></li>';
        }
    }

    /**
     * Hiển thị html code của page
     *
     * @return string
     */
    public static function getPagination()
    {
        // tạo biến data rỗng
        $data = '';
        // kiểm tra xem người dùng có cần full page không.
        if (isset(self::$config['full']) && self::$config['full'] === false) {
            // nếu không thì
            $data .= (self::getCurrentPage() - 3) > 1 ? '<li>...</li>' : '';

            for ((int)$iI = (self::getCurrentPage() - 3) > 0 ?
                (self::getCurrentPage() - 3) : 1; $iI <= ((self::getCurrentPage() + 3) > self::gettotal_pagePage() ? self::gettotal_pagePage() : (self::getCurrentPage() + 3)); $iI++) {
                if ($iI === self::getCurrentPage()) {
                    $data .= '<li class="active" ><a href="#" >' . $iI . '</a></li>';
                } else {
                    $data .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?' .
                             self::$config['querystring'] . '=' . $iI . '" >' .
                                 $iI . '</a></li>';
                }
            }

            $data .= (self::getCurrentPage() + 3) < self::gettotal_pagePage() ? '<li>...</li>' : '';
        } else {
            // nếu có thì
            for ($iI = 1; $iI <= self::gettotal_pagePage(); $iI++) {
                if ($iI === self::getCurrentPage()) {
                    $data .= '<li class="active" ><a href="#" >' . $iI . '</a></li>';
                } else {
                    $data .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?' .
                             self::$config['querystring'] . '=' . $iI . '" >' .
                                 $iI . '</a></li>';
                }
            }
        }

        return '<ul>' . self::getPrePage() . $data . self::getNextPage() . '</ul>';
    }
}
