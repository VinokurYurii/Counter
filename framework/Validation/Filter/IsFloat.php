<?php

namespace Framework\Validation\Filter;

class IsFloat {

    protected $beforeDot;
    protected $afterDot;

    public function __construct($beforeDot, $afterDot){
        $this->beforeDot = $beforeDot;
        $this->afterDot = $afterDot;
    }

    public function isValid($value){
        if (!preg_match("/^\\d+([\\.\\,](\\d+)?)?$/", $value)) {
            return 'В сумму принимаются только цифры';
        } else {
            if (preg_match("/[\\.\\,]/", $value)) {
                if (!preg_match("/^\\d{1,{$this->beforeDot}}[\\.\\,]/", $value)) {
                    return 'Слишком много цифр перед точкой. Если разбогател - поменяй условия валидации.';
                }
                else if (!preg_match("/[\\.\\,]\\d{0,{$this->afterDot}}$/", $value)) {
                    return 'Слишком много цифр после точки с каких пор цены в долях копейки считаются';
                }
                else {
                    return true;
                }
            }
            else {
                if (!preg_match("/^\\d{1,{$this->beforeDot}}$/", $value)) {
                    return 'Слишком много цифр. Если разбогател - поменяй условия валидации.';
                }
                else {
                    return true;
                }
            }
        }
    }
}