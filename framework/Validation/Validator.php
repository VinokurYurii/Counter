<?php

namespace Framework\Validation;

class Validator {

    private $errors;
    protected $validationObject;

    public function __construct($validationObject) {
        $this->validationObject = $validationObject;
    }

    function getErrors() {
        return $this->errors;
    }

    public function isValid(){
        $fields = $this->validationObject->getFields();
        $all_rules = $this->validationObject->getRules();

        foreach($all_rules as $name => $rules){
            if(array_key_exists($name, $fields)){
                foreach($rules as $rule){
                    if ($rule->isValid($fields[$name]) !== true) {
                        $this->errors[$name] = ucfirst($name) . ': ' . $rule->isValid($fields[$name]);
                    }
                }
            }
        }

        return empty($this->errors) ? true : false;
    }
}