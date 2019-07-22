<?php declare(strict_types=1);
return [
    "topMenu" => array(
        array(
            "name" => "Home",
            "route" => "home",
            "isLoggedIn" => false
        ),
        array(
            "name" => "Login",
            "route" => "user/login",
            "isLoggedIn" => false
        ),
        array(
            "name" => "Register",
            "route" => "user/register",
            "isLoggedIn" => false
        ),
        array(
            "name" => "Logout",
            "route" => "user/handle-logout",
            "isLoggedIn" => true
        ),
        array(
            "name" => "Dashboard",
            "route" => "user/dashboard",
            "isLoggedIn" => true
        ),
        array(
            "name" => "Post",
            "route" => "post/add",
            "isLoggedIn" => true
        ),
        array(
            'name' => 'Edit-Profile',
            'route' => 'user/edit-profile',
            'isLoggedIn' => true
        ),
        array(
            'name' => 'Profile',
            'route' => 'user/Profile',
            'isLoggedIn' => true
        ),
        array(
            'name' => 'Categories',
            'route' => 'category/dashboard',
            'isLoggedIn' => true
        ),
        array(
            'name' => 'Tags',
            'route' => 'tag/dashboard',
            'isLoggedIn' => true
        )
    )
];
