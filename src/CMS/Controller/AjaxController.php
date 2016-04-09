<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Framework\Exception\AuthRequredException;
use Framework\Exception\HttpNotFoundException;
use Framework\DI\Service;
use Framework\Response\JsonResponse;

/**
 * Class AjaxController
 * @package CMS\Controller
 */
class AjaxController extends Controller {

    public function handleAction() {
        $response = new JsonResponse(array('AjaxController' => 'Send'));
        Service::get('log')->addLog($response->content, 'warning');
        $response->send();
        //echo 'return';
        /*$request = $this->getRequest();
        if($request->isPost() && $request->isAjax()) {
            $data = $request->getAjaxData();
            if(!empty($data)) {
                if(isset($data['action'])) {
                    switch($data['action']) {
                        case 'test':
                            echo 'Work!';
                            $data['json'] = json_encode($data);
                            echo  json_encode($data);
                            break;
                        default:
                            //return array('error' => 'Empty value of $data[action] Ajax Exception');
                            echo 'error: Empty value of $data[action] Ajax Exception';
                    }
                }
                else {
                    //return array('error' => 'Empty $data[action] Ajax Exception');
                    echo 'error: Empty $data[action] Ajax Exception';
                }
            }
            else {
                //return array('error' => 'Empty $data Ajax Exception');
                echo 'error: Empty $data Ajax Exception';
            }
        }
        else {
            //return array('error' => 'Not Ajax Exception');
            echo 'error: Not Ajax Exception';
        }*/
    }

    /*function test_function() {
        $return = $_POST;
        $return["json"] = json_encode($return);
        echo json_encode($return);
    }*/
}