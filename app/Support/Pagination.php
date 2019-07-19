<?php declare(strict_types=1);
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
    public static $aConfig
        = array(
            "current_page" => 1,
            "total_record" => 1,
            "total_page" => 1,
            "limit" => 10,
            "start" => 0,
            "link_full" => "",
            "link_first" => "",
            "range" => 9,
            "min" => 0,
            "max" => 0
        );
    /**
     * @param array $aConfig
     */
    public static function init($aConfig = array())
    {
        foreach ($aConfig as $key => $val) {
            if (isset(self::$aConfig[$key])) {
                self::$aConfig[$key] = $val;
            }
        }

        if (self::$aConfig["limit"] < 0) {
            self::$aConfig["limit"] = 0;
        }
        self::$aConfig["total_page"] = ceil(
            self::$aConfig["total_record"] / self::$aConfig["limit"]
        );
        //var_dump(self::$aConfig);
        if (!self::$aConfig["total_page"]) {
            self::$aConfig["total_page"] = 1;
        }
        if (self::$aConfig["current_page"] < 1) {
            self::$aConfig["current_page"] = 1;
        }
        if (self::$aConfig["current_page"] > self::$aConfig["total_page"]) {
            self::$aConfig["current_page"] = self::$aConfig["total_page"];
        }
        self::$aConfig["start"] = (self::$aConfig["current_page"] - 1) * self::$aConfig["limit"];
        $middle                 = ceil(self::$aConfig["range"] / 2);
        if (self::$aConfig["total_page"] < self::$aConfig["range"]) {
            self::$aConfig["min"] = 1;
            self::$aConfig["max"] = self::$aConfig["total_page"];
        } else {
            self::$aConfig["min"] = self::$aConfig["current_page"] - $middle + 1;
            self::$aConfig["max"] = self::$aConfig["current_page"] + $middle - 1;
            if (self::$aConfig["min"] < 1) {
                self::$aConfig["min"] = 1;
                self::$aConfig["max"] = self::$aConfig["range"];
            } elseif (self::$aConfig["max"] > self::$aConfig["total_page"]) {
                self::$aConfig["max"] = self::$aConfig["total_page"];
                self::$aConfig["min"] = self::$aConfig["total_page"] - self::$aConfig["range"] + 1;
            }
        }
    }
    /**
     * Get link when press button pagination
     * @return mixed
     * @param $page
     */
    public static function link($page)
    {
        if ($page <= 1 && self::$aConfig["link_first"]) {
            return self::$aConfig["link_first"];
        }
        return str_replace("{page}", $page, self::$aConfig["link_full"]);
    }
    /**
     * @return string
     */
    public static function display()
    {
        $display = "";
        if (self::$aConfig["total_record"] > self::$aConfig["limit"]) {
            $display = "<ul>";
            // Display Prev and First button
            if (self::$aConfig["current_page"] > 1) {
                $display .= "<li><a href=\"" . self::link("1") . "\">First</a></li>";
                $display .= "<li><a href=\"" . self::link(self::$aConfig["current_page"] - 1) . "\">Prev</a></li>";
            }
            // Display page number button
            for ($page_number = self::$aConfig["min"]; $page_number <= self::$aConfig["max"]; $page_number++) {
                // Current page
                if (self::$aConfig["current_page"] == $page_number) {
                    $display .= "<li><span>" . $page_number . "</span></li>";
                } else {
                    $display .= "<li><a href=\"" . self::link($page_number) . "\">" . $page_number . "</a></li>";
                }
            }
            //Display Next and Last button
            if (self::$aConfig["current_page"] < self::$aConfig["total_page"]) {
                $display .= "<li><a href=\"" . self::link(self::$aConfig["current_page"] + 1) . "\">Next</a></li>";
                $display .= "<li><a href=\"" . self::link(self::$aConfig["total_page"]) . "\">Last</a></li>";
            }
            $display .= "</ul>";
        }
        return $display;
    }
}
