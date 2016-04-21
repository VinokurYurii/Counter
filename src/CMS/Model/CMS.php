<?php

namespace CMS\Model;

use Framework\Model\ActiveRecord;
use Framework\DI\Service;
//use Framework\Validation\Filter\Length;
//use Framework\Validation\Filter\NotBlank;

class CMS extends ActiveRecord {

    private static $models = array();

    public static function setModels() {
        $srcs = \Loader::getNamespaces();
        foreach($srcs as $src => $path) {
            if(!preg_match("/^CMS/", $src)) {
                $files = scandir($path . 'Model/');
                $models = array();
                foreach ($files as $file) {
                    if (!preg_match("/^(\.){1,2}$/", $file)) {
                        $models[] = str_replace('.php', '', $file);
                    }
                }
                self::$models[preg_replace("/\\\/", '', $src)] = $models;
            }
        }
    }

    public static function getModels() {
        if( empty(self::$models) ) { self::setModels(); }
        return self::$models;
    }

    public static function getTable() { /*lock*/ }

    public function getOblects($type) {
        return $this->parseObjectsToJSON( (new $type)->find('all') );
    }

    public function parseObjectsToJSON($arrayOfObjects = array()) {
        $jsonArray = array();
        foreach($arrayOfObjects as $object) {
            $jsonArray[] = json_encode((array) $object);
        }
        return json_encode($jsonArray);
        //return $jsonArray;
    }
}