<?php

namespace Framework\Exception;

use Framework\DI\Service;
use Framework\Response\ResponseRedirect;
use Framework\Renderer\Renderer;
use Framework\Response\Response;

abstract class MainException extends \Exception {
    protected $type = 'info';
    protected $beforeSolve = false;
    protected $redirectAddress = '/';

    protected function beforeSolveException() {}

    public function solveException() {
        $data = array();
        if ($this->getMessage() && is_numeric($this->getMessage())) {
            $data['code']    = $this->getMessage();
            $data['message'] = Response::getMessageByCode($this->getMessage());

            if ($this->beforeSolve) {
                $this->beforeSolveException();
            }

            $renderer = new Renderer();
            $responce = new Response($renderer::render(Service::get('config')->get500Layout(), $data), 'text/html', 202);
            $responce->send();
        }
        else if ($this->getMessage()) {
            Service::get('session')->addFlush($this->type, $this->getMessage());

            if ($this->beforeSolve) {
                $this->beforeSolveException();
            }

            $redirect = new ResponseRedirect($this->redirectAddress);
            $redirect->sendHeaders();
        }
        else {
            throw new ServiceException(500);
        }
    }
}