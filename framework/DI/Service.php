<?php

namespace Framework\DI;

use Framework\Exception\ServiceException;

class Service {

    public static $services = array('security', 'session', 'router', 'db', 'app', 'config', 'formatdata');

    private static $prefix = 'Framework\\DI\\';

    public static function get($service) {
        foreach(self::$services as $serv) {
            if(strtolower($service) == $serv) {
                $service = self::$prefix . ucfirst($service) . 'Service';
                return $service::getInstance();
            }
        }
        throw new ServiceException(501);
    }
}