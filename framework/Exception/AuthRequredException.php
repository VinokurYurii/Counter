<?php

namespace Framework\Exception;

use Framework\DI\Service;

class AuthRequredException extends MainException {
    protected $type = 'error';
    protected $beforeSolve = true;
    protected $redirectAddress = '/login';

    protected function beforeSolveException() {
        Service::get('session')->returnUrl = getallheaders()['Referer'];
    }
}