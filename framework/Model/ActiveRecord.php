<?php

namespace Framework\Model;

use Framework\DI\Service;
use Framework\Exception\DatabaseException;

abstract class ActiveRecord {
    protected static $db;

    public function __construct() {

    }

    public static function getDBCon(){
        if(empty(self::$db)){
            self::$db = Service::get('db')->getConnection();
        }
        return self::$db;
    }

    public static function getTable() {}

    public static function getClass() {
        return get_called_class();
    }

    public static function getUserEmailById($id) { //get user email by user_id
        $sql = "SELECT * FROM users WHERE id=" . $id;
        $query = self::getDBCon()->prepare($sql);
        $query->execute();
        $result = $query->fetch()['email'];

        if(empty($result)) {
            $result = 'Unknown user';
        }
        return $result;
    }

    public static function findByEmail($email) {
        $table = static::getTable(); // Prepare SQL request
        $sql = "SELECT * FROM " . $table . " WHERE email='" . $email . "'";
        $query = self::getDBCon()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_CLASS, static::getClass())[0];

        if ($query->rowCount() == 0) {
            return false;
        }

        return $result;
    }

    public static function find($mode = 'all'){
        $table = static::getTable(); // Prepare SQL request
        $sql = "SELECT * FROM " . $table;

        if(is_numeric($mode)){
            $sql .= " WHERE id=?";//.(int)$mode;
        }

        $query = self::getDBCon()->prepare($sql);
        empty($mode) ? $query->execute() : $query->execute(array($mode));

        if ($query->rowCount() == 0) {
            throw new DatabaseException(202);
        }

        $result = $query->fetchAll(\PDO::FETCH_CLASS, static::getClass()); //Create array of result objects

        if(is_numeric($mode)){ // if we looking single post - return one object, else array of objects
            $result = $result[0];
        }
        return $result;
    }

    public function getFields(){
        return get_object_vars($this);
    }

    public function save(){
        $fields = $this->getFields();

        foreach($fields as $field => $value) {
            if(!isset($value)) {
                unset($fields[$field]);
            }
        }

        $sql = (array_key_exists('id', $fields) && !empty($fields['id'])) ? $this->prepareUpdate($fields) : $this->prepareInsert($fields);

        $query = self::getDBCon()->prepare($sql);

        $query->execute($fields);

        if ($query->errorCode() != 0) {
            throw new DatabaseException($query->errorInfo()[2]);
        }
    }

    public static function sqlQuery($sqlQuery) {
        $query = self::getDBCon()->prepare($sqlQuery);
        $query->execute();
        return $query;
    }

    private function prepareInsert($fields) {
        $sql = 'INSERT INTO ' . static::getTable() . ' (';

        foreach($fields as $field => $value) {
            $sql .= $field . ",";
        }
        $sql = preg_replace("/,$/", ')  VALUE(', $sql);

        foreach($fields as $field => $value) {
            $sql .= " :" . $field . ",";
        }

        $sql = preg_replace("/,$/", ')', $sql);

        return $sql;
    }

    private function prepareUpdate($fields) {
        $sql = 'UPDATE ' . static::getTable() . ' SET ';

        foreach($fields as $field => $value) {
            if ($field != 'id') {
                $sql .= $field . '=:' . $field . ', ';
            }
        }

        $sql = preg_replace("/, $/", ' WHERE id=:id', $sql);

        return $sql;
    }
}





















