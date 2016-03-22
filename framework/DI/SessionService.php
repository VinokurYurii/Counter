<?php

namespace Framework\DI;

class SessionService {
    private static $instance;

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name) {
        if ($name === 'returnUrl') {
            return $_SESSION['returnUrl'];
        }
    }

    public function __set($name, $value) {
        if ($name === 'returnUrl') {
            $_SESSION['returnUrl'] = $value;
        }
    }

    public function __unset($name) {
        if ($name === 'returnUrl') {
            unset($_SESSION['returnUrl']);
        }
    }

    public function startSession() {
        session_start();
    }

    public function addFlush($type, $msg) {
        if(!isset($_SESSION['flush'][$type])) {
            $_SESSION['flush'][$type] = array();
        }
        array_push($_SESSION['flush'][$type], $msg);
    }

    public function clearFlush() {
        $_SESSION['flush'] = array(array());
    }

    public function getFlush() {
        if(!isset($_SESSION['flush'])) {
            $_SESSION['flush'] = array(array());
        }
        return $_SESSION['flush'];
    }

    public function grabFlush() {
        if(!isset($_SESSION['flush'])) {
            $_SESSION['flush'] = array(array());
        }
        $flush = $_SESSION['flush'];
        $this->clearFlush();
        return $flush;
    }
}