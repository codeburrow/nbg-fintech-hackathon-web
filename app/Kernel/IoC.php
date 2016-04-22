<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since 4/7/16
 */
namespace App\Kernel;

use Closure;
use Exception;

/**
 * Inversion of control.
 * Register classes in a registry. Then use this registry to initialize these classes.
 * This is useful when we pass an interface to a class constructor parameter. Instead of changing this classes all the
 * places it is used, we instead use this IoC to change it only once.
 */
class IoC
{
    protected static $registry = [];

    /**
     * Add a new resolver to the registry array.
     *
     * @param string  $name The id.
     * @param Closure $resolve Closure that creates instance.
     * @return void
     */
    public static function register($name, Closure $resolve)
    {
        static::$registry[$name] = $resolve;
    }

    /**
     * Create the instance.
     *
     * @param      $name
     * @return mixed
     * @throws Exception
     */
    public static function resolve($name)
    {
        if (static::registered($name)) {
            $name = static::$registry[$name];

            return $name();
        }

        throw new Exception('Nothing registered with that name.');
    }

    /**
     * Determine whether the id is registered.
     *
     * @param $name
     * @return bool
     */
    public static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }
}
