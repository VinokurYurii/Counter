<?php
return array(
    'getRoute' => function ($name) {
        return \Framework\DI\Service::get('router')->generateRoute($name);
    },
    'include' => function($controller, $method, $data = array()) {
        $controllerReflication = new \ReflectionClass($controller);
        $action = $method . 'Action';
        if ($controllerReflication->hasMethod($action)) {
            $controller = $controllerReflication->newInstance();
            $actionReflication = $controllerReflication->getMethod($action);

            if (!empty($data)) {
                $response = $actionReflication->invokeArgs($controller, $data);
            } else {
                $response = $actionReflication->invoke($controller);
            }
            if ($response instanceof \Framework\Response\Response) {
                $response->sendBody();
            } else {
                throw new \Framework\Exception\HttpNotFoundException('Ooops in view include');
            }
        }
    },
    'generateToken' => function() {
        return \Framework\DI\Service::get('security')->generateToken();
    },
    'walkOnBills' => function($bill) use (&$walkOnBills) {
        echo '<ul>';
        if (!empty($bill->species)) {
            foreach($bill->species as $species) {
                echo '<li><a href="/bill_species/' . $species->id . '" style="color: #ec7ddc">' . $species->species .
                    '</a> cost: ' . $species->amount . '</li>';
            }
        }
        if ($bill->has_child) {
            foreach($bill->childs as $child) {
                echo '<a href="/bill_type/' . $child->id . '" style="color: #a62eae">' . $child->type .
                    '</a>: <strong>' . $child->sum . '</strong>';
                $walkOnBills($child);
            }
        }
        echo '</ul>';
    }
);
