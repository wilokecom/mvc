<?php

namespace MVC\Database;

/**
 * Interface DBInterface
 *
 * @package MVC\Database
 * @method prepare(string $query, array $aParam)
 */
interface DBInterface
{
    /**
     * @return mixed
     */
    public function connect();

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function select($string = '');

    /**
     * @param string $string
     *
     * @return mixed
     */

    public function insert($string = '');

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function delete($string = '');

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function update($string = '');
}
