<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 29/06/2019
 * Time: 9:41 SA
 */
namespace MVC\Support;

/**
 * Class Upload
 * @package MVC\Support
 */
class Upload
{
    /**
     * @param $key
     * @return mixed
     */
    public static function upload($key)
    {
        $fileUpload      = $_FILES[$key];
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];
            $destination = $fileUpload['destination'] = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];
            move_uploaded_file(
                $filename,
                $destination
            );
        }
        return $fileUpload;
    }
}

