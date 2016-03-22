<?php

namespace Accounter\Controller;

use Accounter\Model\BillType;
use Accounter\Model\BillSpecies;
use Framework\Controller\Controller;

class BillController extends Controller {

    public function showBillTypeAction($billTypeId) {
        $bill = BillType::findBills($billTypeId)[0];
        return $this->render('show_type.html', array('bill' => BillType::findBills($billTypeId)[0]));
    }

    public function indexAction() {
        return $this->render('index.html', array('bills' => BillType::findBills('all')));
    }
}