<?php

namespace Framework\DI;

/**
 * Class RouterService
 * @package Framework\DI
 *
 * contains methods for work with routes and routes pattern
 *
 * @static $map contains route map
 */

class RouterService implements ServiceInterface {
    private static $instance;
    private static $map = array();

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $routing_map
     *
     * sets $map of routes
     */
    public function addRoutes($routing_map) {
        self::$map = $routing_map;
    }

    /**
     * @param $url
     * @return array|null
     *
     * search incoming url in routing map checked requirements and return it in processed associated array
     */
    public function parseRoute($url){
        if(!preg_match('~/$~', $url)) { // resulting in an overall view
            $url .= '/';
        }

        $route_found = null;
        foreach(self::$map as $name => $route){
            $patternInfo = $this->prepare($route);
            $route_found =array();
            $methodMatch = true;
            if (isset($route['_requirements']['_method'])) {
                $methodMatch = $_SERVER['REQUEST_METHOD'] === $route['_requirements']['_method'];
            }

            if(preg_match($patternInfo['pattern'], $url, $params) && $methodMatch){
                $route_found = $route;
                $route_found['_name'] = $name;

                if(!empty($patternInfo['paramsNames'])) { // Get assoc array of params:

                    $route_found['params'] = array();
                    $i = 1;
                    foreach($patternInfo['paramsNames'] as $name) {
                        $route_found['params'][$name] = $params[$i];
                        $i++;
                    }
                }
                break;
            }
        }
        return $route_found;
    }

    /**
     * @param $route
     * @return array
     *
     * if route contain param extract it according route requirements and return it
     */
    private function prepare($route){
        $paramsNames = array();
        $pattern = $route['pattern'];

        if(!preg_match('~/$~', $pattern)) { // resulting in an overall view
            $pattern .= '/';
        }

        if(preg_match_all('~\{([\w\d_]+)\}~', $route['pattern'], $matches)) { // finding url includes
            $paramsNames = $matches[1]; // get inclusion array

            if (!empty($matches[1])) {
                foreach ($matches[1] as $param) {
                    if (!empty($route['_requirements'][$param])) { // replase includes by regexp
                        $pattern = preg_replace('~\{' . $param . '\}~Ui', '(' . $route['_requirements'][$param] . ')', $pattern);
                    } else {
                        $pattern = preg_replace('~\{' . $param . '\}~Ui', '([\w\d_]+)', $pattern);
                    }
                }
            }
        }

        $pattern = '~^'. $pattern.'$~';
        return array('pattern' => $pattern, 'paramsNames' => $paramsNames);
    }

    /**
     * @param $name
     * @param array $data
     * @return string
     *
     * generate route by route name and params
     *
     * return needles route or route to index page
     */
    public function generateRoute($name, $data = array()) {
        foreach (self::$map as $rName => $route) {
            if($name == $rName) {
                if (!empty($data)) {
                    $paramNames = $this->prepare($route)['paramsNames'];
                    foreach ($data as $param =>$value) {
                        $path = preg_replace('~\{' . $param . '\}~Ui', $value, $route['pattern']);
                    }
                } else {
                    $path = $route['pattern'];
                }
                return $path;
            }
        }
        return '/';
    }
}