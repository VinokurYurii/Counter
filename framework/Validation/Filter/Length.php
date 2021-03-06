<?php

namespace Framework\Validation\Filter;

class Length {
    protected $min;
    protected $max;

    public function __construct($min, $max){
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid($value){
        if (strlen($value) < $this->min) {
            return 'must be more then ' . $this->min;
        }
        else if (strlen($value) > $this->max) {
            return 'must be less then ' . $this->max;
        }
        else {
            return true;
        }
    }
}