<?php

namespace MVC\Support;

/**
 * Class Helper
 * @package MVC\Support
 */

class Helper
{
    /**
     * Return to dashboard
     */
    public static function redirectToDashboard()
    {
        if (Auth::isLoggedIn()) {
            Redirect::to("user/dashboard");
        }
    }
}
