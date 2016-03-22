<?php

namespace Framework\Response;

class JsonResponse extends Response{
    function __construct($jsonContent) {
        $content = self::parse($jsonContent);
        parent::__construct($content, 'application/json');
    }

    public static function parse($content) {
        return json_encode($content);
    }
}