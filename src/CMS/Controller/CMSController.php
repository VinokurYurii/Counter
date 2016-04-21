<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use CMS\Model\CMS;
use Framework\DI\Service;

/**
 * Class CMSController
 * @package CMS\Controller
 */
class CMSController extends Controller {

    public function indexAction() {
        $modelsList = CMS::getModels();
        return $this->render('index.html', array('modelsList' => $modelsList));
    }

    public function displayAction($src, $model) {
        $investigationModel = $src . '\\Model\\' . $model;
        $cms = new CMS();
        $json = $cms->getOblects($investigationModel);
        return $this->render('display.html', array('json' => $json));
    }
}