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
                        case 'save':
                            $model = $data['model'];
                            $pathParts = array_reverse(explode('/', $model));
                            $target = $pathParts[1] . '\\Model\\' . $pathParts[0];
                            $targetOject = new $target( json_decode( $data['json'], true ) );
                            break;

                        default:
                            return new JsonResponse(array('error' => 'Wrong value of $data[action] Ajax Exception'));
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