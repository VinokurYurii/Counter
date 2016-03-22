<?php

namespace Framework\DI;

class ConfigService implements ServiceInterface {
    private static $instance;
    private static $config;

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConfig() {
        return self::$config;
    }

    public function setConfig($config) {
        self::$config = $config;
    }

    public function getMainLayout() {
        return realpath(self::$config['main_layout']);
    }

    public function get500Layout() {
        return realpath(self::$config['error_500']);
    }
}