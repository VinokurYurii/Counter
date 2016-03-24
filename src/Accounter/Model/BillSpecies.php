<?php

namespace Accounter\Model;

use Framework\Model\ActiveRecord;

class BillSpecies extends ActiveRecord {
    public $id, $type_id, $species, $comment, $amount, $create_date, $update_date;
}