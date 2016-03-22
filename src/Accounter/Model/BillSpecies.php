<?php

namespace Accounter\Model;

use Framework\Model\ActiveRecord;

class BillSpecies extends ActiveRecord {
    public $id, $type_id, $species, $comment, $amount;

}