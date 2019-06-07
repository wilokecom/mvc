<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 03/06/2019
 * Time: 6:40 CH
 */

return [
    'topMenu' => array(
        array(
            'name'  => 'Home',
            'route' => 'home',
            'isLoggedIn' => false
        ),
        array(
            'name'  => 'Login',
            'route' => 'user/login',
            'isLoggedIn' => false
        ),
        array(
            'name'  => 'Register',
            'route' => 'user/register',
            'isLoggedIn' => false
        ),
        array(
            'name'  => 'Logout',
            'route' => 'user/handle-logout',
            'isLoggedIn' => true
        ),
        array(
            'name'  => 'Post',
            'route' => 'post'
        )
    )
];
