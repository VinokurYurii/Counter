<?php

namespace Accounter\Model;

use Framework\Model\ActiveRecord;
use Accounter\Model\BillSpecies;

class BillType extends ActiveRecord {
    public $id, $parnt_id, $has_child, $type, $comment, $childs;
    public $species = array();

    public static function findBills($mode = 'all') {
        //$query = 'SELECT * FROM bill_types WHERE parent_id IS NULL';
        $query = 'SELECT * FROM bill_types WHERE ';
        if($mode === 'all') {
            $query .= 'parent_id IS NULL';
        }
        else if (is_numeric($mode)) {
            $query .= 'id=' . $mode;
        }
        $mainTypes = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

        foreach($mainTypes as $main) {
            if ($main->has_child) {
                $main->childs = self::findChild($main);
            }
        }

        foreach($mainTypes as $main) {
            self::walkOnTheChildrenAndAddSpecies($main);
        }

        return $mainTypes;
    }

    private static function findChild(BillType $parentType) {
        $query = 'SELECT * FROM bill_types WHERE parent_id=' . $parentType->id;
        $chaildTypes = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

        $parentType->childs = $chaildTypes;

        foreach($chaildTypes as $types) {
            if ($types->has_child !== 0) {
                $types->childs = self::findChild($types);
            }
        }

        return $chaildTypes;
    }

    public static function walkOnTheChildrenAndAddSpecies(BillType $billType) {
        self::findBillSpecies($billType);
        if(!empty($billType->childs)) {
            foreach($billType->childs as $child) {
                self::walkOnTheChildrenAndAddSpecies($child);
            }
        }
    }

    public static function findBillSpecies(BillType $billType) {
        $query = 'SELECT * FROM bill_species WHERE type_id=' . $billType->id;
        $billType->species = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, BillSpecies::getClass());
    }
}