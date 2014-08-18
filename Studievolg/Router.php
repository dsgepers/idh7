<?php

namespace Studievolg;

/**
 * Description of Router
 *
 * @author Dennis Schepers
 */
class Router {

    private static $routes = array();

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    /**
     * Define a route
     * 
     * @param string $pattern
     * @param function $callback
     */
    public static function route($pattern, $callback) {
        
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '\/?$/';
        self::$routes[$pattern] = $callback;
    }

    /**
     * Execute the router, and perform callback
     * @return mixed
     */
    public static function execute() {
        $url = $_SERVER['REQUEST_URI'];
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        
        if (strpos($url, $base) === 0) {
            $url = substr($url, strlen($base));
        }
        foreach (self::$routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }
}