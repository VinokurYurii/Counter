<?php

namespace Framework\Validation\Filter;

class NotBlank {
    public function isValid($value){
        return empty($value) ? 'must be not blank': true;
    }
}