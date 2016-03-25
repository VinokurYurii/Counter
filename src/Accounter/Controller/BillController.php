<?php

namespace Accounter\Controller;

use Accounter\Model\BillType;
use Accounter\Model\BillSpecies;
use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Validation\Validator;
use Framework\Exception\DatabaseException;

class BillController extends Controller {

    public function showBillTypeAction($billTypeId) {
        return $this->render('show_type.html', array('bill' => BillType::findBills($billTypeId)[0]));
    }

    public function indexAction() {
        return $this->render('index.html', array('bills' => BillType::findBills('all')));
    }

    public function addBillTypeAction($parentBillTypeId = 0) {

        if ($this->getRequest()->isPost()) {
            try{
                $billType            = new BillType();
                $billType->parent_id = $this->getRequest()->post('parent_id');
                $billType->type      = $this->getRequest()->post('type');
                $billType->comment   = trim($this->getRequest()->post('comment'));
                $billType->owner_id  = Service::get('security')->getUser()->id;

                $validator = new Validator($billType);
                if ($validator->isValid()) {
                    Service::get('db')->getConnection()->beginTransaction();
                    $billType->save();
                    if (isset($billType->parent_id) && $billType->parent_id != 0) {
                        $parent = BillType::find($billType->parent_id);
                        if (!$parent->has_child) {
                            $parent->has_child = true;
                            $parent->save();
                        }
                    }
                    Service::get('db')->getConnection()->commit();
                    return $this->redirect($this->generateRoute('bills'), 'The data has been saved successfully');
                } else {
                    $error = $validator->getErrors();
                }
            } catch(DatabaseException $e){
                Service::get('db')->getConnection()->rollBack();
                throw new DatabaseException($e->getMessage());
            }
        }

        return $this->render(
            'add_type.html',
            array('action' => '/bill_type/add/' . $parentBillTypeId/*$this->generateRoute('add_bill_type')*/, 'errors' => isset($error)?$error:null, 'parentBillTypeId' => $parentBillTypeId)
        );
    }

    public function showSpeciesAction($billSpeciesId) {
        $species = BillSpecies::find((int)$billSpeciesId);

        return $this->render('show_species.html', array('species' => $species));
    }

    public function addSpeciesAction($parentBillTypeId = 0) {

        if ($this->getRequest()->isPost()) {
            try{
                $species              = new BillSpecies();
                $date                 = new \DateTime();
                $species->type_id     = $this->getRequest()->post('type_id');
                $species->species     = $this->getRequest()->post('species');
                $amount               = $this->getRequest()->post('amount');
                $species->amount      = Service::get('formatData')->formatFloat($amount);
                $species->comment     = trim($this->getRequest()->post('comment'));
                $species->create_date = $date->format('Y-m-d H:i:s');

                $validator = new Validator($species);
                if ($validator->isValid()) {
                    $species->save();
                    return $this->redirect('/bill_type/' . $species->type_id/*$this->generateRoute('bills')*/,
                        'The data has been saved successfully');
                } else {
                    $error = $validator->getErrors();
                }
            } catch(DatabaseException $e){
                throw new DatabaseException($e->getMessage());
            }
        }

        return $this->render(
            'add_species.html',
            array('action' => '/bill_species/add/' . $parentBillTypeId/*$this->generateRoute('add_bill_species')*/,
                'errors' => isset($error)?$error:null, 'parentBillTypeId' => $parentBillTypeId)
        );
    }
}