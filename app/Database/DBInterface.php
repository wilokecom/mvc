<?php declare(strict_types=1);
namespace MVC\Database;

/**
 * Interface DBInterface
 * @package MVC\Database
 */
interface DBInterface
{
    /**
     * @return mixed
     */
    public function connect();

    /**
     * @return mixed
     * @param string $string
     */
    public function select($string = "");

    /**
     * @return mixed
     * @param string $string
     */
    public function insert($string = "");

    /**
     * @return mixed
     * @param string $string
     */
    public function delete($string = "");
}
