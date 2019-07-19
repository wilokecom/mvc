<?php declare(strict_types=1);
namespace MVC\Foundation;

/**
 * Class AliasLoader
 * @package MVC\Foundation
 */
class AliasLoader
{
    /**
     * The array of class aliases.
     * @var array
     */
    protected $aliases;
    /**
     * Indicates if a loader has been registered.
     * @var bool
     */
    protected $registered = false;
    /**
     * The singleton instance of the loader.
     * @var \MVC\Foundation\AliasLoader
     */
    protected static $instance;
    /**
     * Create a new AliasLoader instance.
     * @param array $aliases
     */
    private function __construct($aliases)
    {
        $this->aliases = $aliases;
    }
    /**
     * Get or create the singleton alias loader instance.
     * @return \MVC\Foundation\AliasLoader
     * @param array $aliases
     */
    public static function getInstance(array $aliases = [])
    {
        if (is_null(static::$instance)) {
            return static::$instance = new static($aliases);
        }
        $aliases = array_merge(static::$instance->getAliases(), $aliases);
        static::$instance->setAliases($aliases);
        return static::$instance;
    }
    /**
     * Load a class alias if it is registered.
     * @return bool|null
     * @param string $alias
     */
    public function load($alias)
    {
        if (isset($this->aliases[$alias])) {
            return class_alias($this->aliases[$alias], $alias);
        }
    }
    /**
     * Add an alias to the loader.
     * @return void
     * @param string $alias
     * @param string $class
     */
    public function alias($class, $alias)
    {
        $this->aliases[$class] = $alias;
    }
    /**
     * Register the loader on the auto-loader stack.
     * @throws \Exception
     */
    public function register()
    {
        if (!$this->registered) {
            $this->prependToLoaderStack();
            $this->registered = true;
        }
    }
    /**
     * Prepend the load method to the auto-loader stack.
     * @throws \Exception
     */
    protected function prependToLoaderStack()
    {
        spl_autoload_register([$this, "load"], true, true);
    }
    /**
     * Get the registered aliases.
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }
    /**
     * Set the registered aliases.
     * @return void
     * @param array $aliases
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
    /**
     * Indicates if the loader has been registered.
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }
    /**
     * Set the "registered" state of the loader.
     * @return void
     * @param bool $value
     */
    public function setRegistered($value)
    {
        $this->registered = $value;
    }
    /**
     * Set the value of the singleton alias loader.
     * @return void
     * @param \Illuminate\Foundation\AliasLoader $loader
     */
    public static function setInstance($loader)
    {
        static::$instance = $loader;
    }
    /**
     * Clone method.
     * @return void
     */
    private function __clone()
    {
        //
    }
}
