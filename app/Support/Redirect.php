<?php

namespace MVC\Support;

class Redirect
{
    //Điều hướng trang
    public static function to($route)
    {
        //Điều hướng trang
        header("Location: " . Route::get($route));//include fileapp/Support/Route.php
        exit();
    }
}
