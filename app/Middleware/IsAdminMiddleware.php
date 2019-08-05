<?php declare(strict_types=1);
namespace MVC\Middleware;

use MVC\Support\Auth;
use MVC\Support\Redirect;

/**
 * Class IsAdminMiddleware
 * @package MVC\Middleware
 */
class IsAdminMiddleware implements InterfaceMiddleware
{
    /**
     * @var
     */
    public $sData;
    /**
     * @var string
     */
    public $sAdmin = "phuc";
    /**
     * IsAdminMiddleware constructor.
     * @param array $aData
     */
    public function __construct($aData = [])
    {
        $this->sData = $aData["isAdmin"];
        $this->handle();
    }
    /**
     *Handle
     */
    public function handle()
    {
        if ($this->sData == $this->sAdmin) {
            return true;
        } else {
            return false;
        }
    }
}
