<?php

namespace MVC\Support;

class Redirect
{
    public static function to($route)
    {
        header('Location: ' . Route::get($route));
        exit();
    }
}
