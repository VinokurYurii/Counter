<?php

namespace Framework\Request;

use Framework\DI\Service;
use Framework\Exception\AuthRequredException;
use Framework\Exception\SecurityException;

class Request {
    function isPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }
        else {
            if (!Service::get('security')->isTokenMatch()) {
                throw new SecurityException('CSRF atack');
            }
            if (!Service::get('security')->isAuthenticated() && $_SERVER['REQUEST_URI'] != '/login') {
                throw new AuthRequredException('You don\'t logined user. Please Log in os sign in.');
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
};