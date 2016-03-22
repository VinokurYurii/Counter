<?php

namespace Framework\DI;

class AppService implements ServiceInterface {
    private static $instance;
    private static $config;

    public static function setInstance($app) {
        self::$instance = $app;
        self::setConfig($app::$config);
    }

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConfig() {
        return self::$config;
    }

    private function setConfig($config = array()) {
        self::$config = $config;
    }
}