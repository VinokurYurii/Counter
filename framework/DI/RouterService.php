<?php

namespace Framework\DI;

class RouterService implements ServiceInterface {
    private static $instance;
    private static $map = array();

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addRoutes($routing_map) {
        self::$map = $routing_map;
    }

    public function parseRoute($url){

        if(!preg_match('~/$~', $url)) { // resulting in an overall view
            $url .= '/';
        }

        $route_found = null;

        foreach(self::$map as $name => $route){
            $patternInfo = $this->prepare($route);
            $route_found =array();

            if(preg_match($patternInfo['pattern'], $url, $params)){

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

    public function generateRoute($name) {
        foreach (self::$map as $rName => $route) {
            if($name == $rName) {
                return $route['pattern'];
            }
        }
        return '/';
    }
}