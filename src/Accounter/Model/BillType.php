<?php

namespace Accounter\Model;

use Framework\Model\ActiveRecord;
use Accounter\Model\BillSpecies;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;
use Framework\DI\Service;

class BillType extends ActiveRecord {
    public $id, $parent_id, $has_child, $type, $comment, $childs, $owner_group_id;
    public $sum;
    public $species;

    public static function findBills($mode = 'all') {
        $query = 'SELECT * FROM bill_types WHERE ';
        if($mode === 'all') {
            $query .= 'parent_id=0';
        }
        else if (is_numeric($mode)) {
            $query .= 'id=' . $mode;
        }
        $owner_group_id = isset(Service::get('security')->getUser()->group_id) ?
            Service::get('security')->getUser()->group_id :  0;
        $query .= ' and owner_group_id=' . $owner_group_id;
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
                $billType->sum += $child->sum;
            }
        }
    }

    public static function findBillSpecies(BillType $billType) {
        $query = 'SELECT * FROM bill_species WHERE type_id=' . $billType->id;
        $billType->species = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, BillSpecies::getClass());
        foreach($billType->species as $species) {
            $billType->sum += $species->amount;
        }
    }

    public function getRules() {
        return array(
            'type'   => array(
                new NotBlank(),
                new Length(4, 100)
            )
        );
    }

    public static function getTable() {
        return 'bill_types';
    }

    public static function findMainType($typeId) {
        $query = "SELECT * FROM bill_types where id=" . $typeId;
        $type  = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, static::getClass())[0];
        if ($type->parent_id != 0) {
            return self::findMainType($type->parent_id);
        } else {
            return $type;
        }
    }
}