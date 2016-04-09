<?php

namespace Framework\DI;

class LogService implements ServiceInterface {
    private static $instance;
    private static $logFilePath = __DIR__ . '/../../log/log.txt';



    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addLog($log, $logLevel = 'info') {
        if(!file_exists(self::$logFilePath)) {
            fopen(self::$logFilePath, 'w');
        }
        $time = date("m.d.y H:i:s");
        $fp = fopen(self::$logFilePath, 'a');

        fwrite($fp, $time . ' / ' . $logLevel . ' / ' . $log . "\n");
        fclose($fp);
    }
}