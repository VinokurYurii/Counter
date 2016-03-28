<?php

namespace Framework\DI;

use Blog\Model\User;
use Framework\Request\Request;

class SecurityService implements ServiceInterface {
    private static $instance;

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isAuthenticated() {
        return isset($_SESSION['user']->id) ? true : false;
    }

    public function clear() {
        unset($_SESSION['user']);
    }

    public function setUser (User $user) {
        $_SESSION['user'] = $user;
    }

    public function getUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function getSoltedPassword($password) {
        $solt = $this->getRandomNumber();
        $soltedPassword = hash('sha256', $password . $solt);
        return array('soltedPassword' => $soltedPassword, 'solt' => $solt);
    }

    public function getRandomNumber() {
        $r_number = '';
        for($i = 0; $i < 10; $i++) {
            $r_number .= rand(0, 9);
        }
        return $r_number;
    }

    public function isPasswordMatch($password, $user) {
        return hash('sha256', $password . $user->solt) === $user->password;
    }

    public function generateToken() {
        $token = hash('sha256', $this->getRandomNumber());
        $this->addToSession('token', $token);
        setcookie('token', $token);
        echo '<input type="hidden" name="token" value=' . $token . '>';
    }

    private function addToSession($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function unsetToken() {
        $token = $_SESSION['token'];
        unset($_SESSION['token']);
        return $token;
    }

    public function getCookie($name) {
        return htmlspecialchars($_COOKIE[$name]);
    }

    public function isTokenMatch() {
        if(!empty($_COOKIE['token']) && !empty($_POST['token'])) {
            return $this->getCookie('token') === $_POST['token'];
        }
        return false;
    }
}