<?php

namespace MVC\Database;
interface DBInterface
{
    public function connect();

    public function select($string = '');

    public function insert($string = '');

    public function delete($string = '');
}
