<?php

namespace Framework\DI;

use Framework\Exception\DatabaseException;

class DbService implements ServiceInterface {
    private static $connection;
    private static $instance;

    public function getConnection($connectionConfig = array()) {
        if(empty(self::$connection)) {
            if (empty($connectionConfig) || count($connectionConfig) < 3) {
                throw new DatabaseException('Cant connect to DataBase without full connection info.');
            }
            try {
                self::$connection = new \PDO($connectionConfig['dns'], $connectionConfig['user'], $connectionConfig['password']);
            } catch (\Exception $e) {
                throw new DatabaseException(500);
            }
        }
        return self::$connection;
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}