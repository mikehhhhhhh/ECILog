<?php
/* This router is not entirely my own work - it was taken from an example (I've long since lost) and adapted for my needs */

class router{
    private $routes = NULL;
    private $pattern_map = array();

/**
* Constructs the router.
*
* @param string $file The path to a dosini file to use for route definitions.
*/
    public function __construct($file = NULL){
        if (!$file){
            throw new preg_router_error('No routes file provided to the constructor.');
            return;
        }

        if (!is_file($file)){
            throw new preg_router_error('The routes file ('.$file.') is not a file.');
            return;
        }

        $f = parse_ini_file($file, true);
        $this->routes = $f;

        foreach ($this->routes as $name => $route){
            $this->pattern_map[$route['pattern']] = $name;
        }
    }


    public function route($uri){
        foreach ($this->pattern_map as $pat => $route_name){
            if (preg_match($pat, $uri, $groups)){
                $route = $this->routes[$route_name];
                $arr = explode('::', $route['handler']);
                if (count($arr) != 2){
                    throw new preg_router_error("Malformed handler for route '$route_name'.");
                    return;
                }

                $class_name = $arr[0];
                $method_name = $arr[1];

                // Find class.
                if (!class_exists($class_name)){
					$class = new $class_name();
					if (!class_exists($class_name)){
						throw new preg_router_error("Handler '$class_name' from route named '$route_name' doesn't exist.");
						return;
					}
                }
				else
				{
					$class = new ReflectionClass($class_name);
				}
                $inst = $class->newInstance();

                // Find class's method.
                if (!$class->hasMethod($method_name)){
                    throw new preg_router_error("Method '$method_name' is not a method of '$class_name' from route named '$route_name'.");
                    return;
                }
                $method = $class->getMethod($method_name);

                // Invoke with the groups as arguments.
                // I'll always set $groups[0] to the $uri so that the first
                // argument to all handlers is the full request. $groups[0]
                // with query params seems to be truncated to the exact portion
                // of the URI matched, but the pattern may have been open-ended.
                $groups[0] = $uri;
                return $method->invokeArgs($inst, $groups);
                
            }
        }
        throw new preg_router_error('No pattern matched.');
    }
}
class preg_router_error extends Exception{}