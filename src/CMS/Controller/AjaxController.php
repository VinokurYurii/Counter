<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Response\JsonResponse;
use Accounter\Model\BillType;
use CMS\Model\CMS;


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
                            Service::get('log')->addLog($data['model']);
                            return new JsonResponse((array)$bills);
                            break;
                        case 'getModel':
                            $model = $data['model'];
                            $pathParts = array_reverse( explode('/', $model));
                            $target = $pathParts[1] . '\\Model\\' . $pathParts[0];
                            Service::get('log')->addLog($data['model'] . ' --> getModel');
                            $cms = new CMS();
                            $targetObjects = $cms->getOblects($target);
                            return new JsonResponse((array)$targetObjects);
                            break;
                        case 'save':
                            $targetObject = new $target( json_decode( $data['json'], true ) );
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