<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Response\JsonResponse;
use Accounter\Model\BillType;

/**
 * Class AjaxController
 * @package CMS\Controller
 */
class AjaxController extends Controller
{

    public function handleAction()
    {
        Service::get('log')->addLog('AjaxController');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getAjaxData();
            if (!empty($data)) {
                if (isset($data['action'])) {
                    switch ($data['action']) {
                        case 'test':
                            $bills = BillType::findBills('all');

                            return new JsonResponse((array)$bills);
                            break;
                        default:
                            return new JsonResponse(array('error' => 'Empty value of $data[action] Ajax Exception'));
                    }
                }
                else {
                    return new JsonResponse(array('error' => 'Empty $data[action] Ajax Exception'));
                }
            }
            else {
                return new JsonResponse(array('error' => 'Empty $data Ajax Exception'));
            }
        }
        else {
            return new JsonResponse(array('error' => 'Not Ajax: Ajax Exception'));
        }
    }
}