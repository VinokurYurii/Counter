<?php

namespace Framework\DI;

class FormatDataService implements ServiceInterface {
    private static $instance;

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function formatFloat($float) {
        $r_float = trim($float);
        return str_replace(",", ".", $r_float);
    }
}