<?php

namespace Accounter\Model;

use Framework\Exception\SecurityException;
use Framework\Model\ActiveRecord;
use Framework\DI\Service;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;
use Framework\Validation\Filter\IsFloat;

class BillSpecies extends ActiveRecord {
    public $id, $type_id, $species, $comment, $amount, $create_date, $update_date;

    public static function findSpecies($id) {
        $query = 'SELECT * FROM ' . self::getTable() . ' WHERE id=' . $id;
        $species = static::sqlQuery($query)->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (self::checkOwner($species->type_id)) {
            return $species;
        } else {
            throw new SecurityException('Счёт может просматривать только его  хозяин');
        }
    }

    public static function checkOwner($typeId) {
        $billType = BillType::findBills($typeId);
        return $billType->owner_id == Service::get('securit')->getUser()->id;
    }

    public function getRules() {
        return array(
            'species'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'amount' => array(
                new NotBlank(),
                new IsFloat(4, 2)
            )
        );
    }

    public static function getTable() {
        return 'bill_species';
    }
}