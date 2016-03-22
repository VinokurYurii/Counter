<?php

namespace Framework\Exception;

use Framework\DI\Service;
use Framework\Renderer\Renderer;
use Framework\Response\Response;

class DatabaseException extends MainException {
    protected $type = 'warning';
}