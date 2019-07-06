<?php declare(strict_types=1);
namespace MVC\Support;

/**
 * Class Config
 * @package MVC\Support
 */
class Config
{
    /**
     * Name the config file in the configs directory
     * @var
     */
    private static $fileName;
    /**
     * Save file name information, content of config file in array form
     * @var
     */
    private static $aConfiguration;
    /**
     * Save file contents
     * @var
     */
    private static $aValue;
    /**
     * Config constructor.
     * Get the content of the config file
     * @param      $fileName
     * @param bool $hasChain
     */
    public function __construct($fileName, $hasChain = false)
    {
        self::$fileName = $fileName;
        if (isset(self::$aConfiguration[$fileName])) {
            self::$aConfiguration[$fileName];
        } else {
            //Check the app / configs link
            if (file_exists(MVC_CONFIG . $fileName . ".php")) {
                //Save file name and file content information in array form
                self::$aConfiguration[$fileName] = include MVC_CONFIG
                    . $fileName . ".php";
            } else {
                self::$aConfiguration[$fileName] = array();
            }
        }
        //Save the file contents as an array
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
     * Returns the mysqli library
     * @return null|$this
     * @param bool $hasChain
     * @param      $target
     */
    public function getParam($target, $hasChain = false)
    {
        //Returns $ aValue [$ target] = mysqli
        self::$aValue = isset(self::$aValue[$target]) ? self::$aValue[$target] : null;
        if ($hasChain) {
            /*Continue pointing to the next method -> getParam ($ grammar));
             *self::$oDB = new MysqlGrammar(getConfig("database")->
             *getParam("connections", true)->getParam($grammar));*/
            return $this;
        }
        return self::$aValue;
    }
}
