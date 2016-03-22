<?php

namespace Framework\Controller;

use Framework\DI\Service;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Request\Request;
use Framework\Renderer\Renderer;

abstract class Controller {
    public $title, $content, $date;

    function getRequest() {
        return new Request();
    }

    function render($layout, $data = array()) {

        if (!file_exists($layout)) {
            $fullPath = $this->handleViewPath($layout);
        } else {
            $fullPath = $layout;
        }

        $renderer = $this->getRenderer();
        $content = $renderer::render($fullPath, $data);
        return new Response($content);
    }

    protected function handleViewPath($shortPath) { //find path to view
        $path = preg_replace('/Controller$/', '', str_replace("\\", '/', get_class($this))); // create path to view
        $path = preg_replace('/Controller/', 'views', $path) . '/' . $shortPath . '.php';

        if (preg_match('/^Framework/', $path)) {
            $path = preg_replace('/^Framework/', '/framework', $path);
        } else {
            $path = '/src/' . $path;
        }
        $dir = realpath(__DIR__ . '/../../'); //get real path to framework directory
        return $dir . $path; // full path to wiew

    }

    protected function getRenderer($mainTamplateFile = '') {
        return empty($mainTamplateFile) ? new Renderer() : new Renderer($mainTamplateFile);
    }

    function redirect($path, $msg) {
        return new ResponseRedirect($path, $msg);
    }

    function generateRoute($name) {
        return Service::get('router')->generateRoute($name);
    }

}