<?php

namespace Framework\Request;

use Framework\DI\Service;
use Framework\Exception\AuthRequredException;
use Framework\Exception\SecurityException;

class Request {
    private $allowedPath = array('/login', '/signin');
    function isPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }
        else {
            if(!$this->isAjax()) {
                if (!Service::get('security')->isTokenMatch()) {
                    throw new SecurityException('CSRF atack');
                }
                if (!Service::get('security')->isAuthenticated() && !in_array($_SERVER['REQUEST_URI'], $this->allowedPath)) {
                    throw new AuthRequredException('You don\'t logined user. Please Log in os sign in.');
                }
            }
            return true;
        }
    }

    function post($field) {
        return $this->secureData($_POST[$field]);
    }

    function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    private function secureData($data) {
        return filter_var(htmlspecialchars($data), FILTER_SANITIZE_STRING); // Removes tags and removes special characters or codes, if necessary.
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getAjaxData() {
        $data = array();
        foreach($_POST as $key => $value) {
            $data[$this->secureData($key)] = $this->secureData($value);
        }
        return $data;
    }
};