<?php
namespace Framework;

use Framework\Exception\AuthRequredException;
use Framework\Exception\MainException;
use Framework\Exception\SecurityException;
use Framework\Exception\ServiceException;
use Framework\Response\JsonResponse;
use Framework\Response\ResponseRedirect;
use Framework\Exception\HttpNotFoundException;
use Framework\Response\Response;
use Framework\DI\Service;
use Framework\Request\Request;

/**
 * Class Application
 * @package Framework
 *
 * Main Class whose running application
 */

class Application {
    /**
     * @static config
     *
     * keep all application config
     */

    public static $config;

    /**
     * Application constructor.
     * @param $config
     */

    function __construct($config) {
        self::$config = include($config);
        /**
         * output the error message depending on mode
         */

        if (self::$config['mode'] === 'dev') {
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        }
        else if (self::$config['mode'] === 'prod') {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
        }
        /**
         * start needles services
         */

        Service::get('session')->startSession();
        Service::get('router')->addRoutes(self::$config['routes']);
        Service::get('config')->setConfig(self::$config);
        Service::get('db')->getConnection(self::$config['pdo']);// initialize connection to DB
    }

    /**
     * @param $controller
     * @param $method
     * @param array $data
     * @throws HttpNotFoundException
     *
     * handle data and run needles metdod in needle controller
     */
    public static function runControllerMethod ($controller, $method, $data = array()) {
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

            if ($response instanceof ResponseRedirect) {
                $response->sendHeaders();
            }
            else if ($response instanceof JsonResponse) {
                $response->send();
            }
            else if ($response instanceof Response) {
                $response->send();
            }
            else {
                throw new HttpNotFoundException(501);
            }
        }
        else {
            throw new ServiceException(501);
        }
    }

    /**
     * @throws Exception\ServiceException, Exception\AuthRequredException
     *
     * run application
     */
    public function run() {
        /**
         * get route depending on REQUEST_URI
         */
        $route = Service::get('router')->parseRoute(htmlspecialchars($_SERVER['REQUEST_URI']));
         try {
             if (!empty($route)) {
                 /**
                  * check rights for this action
                  */
                 if (!empty($route['security'])) {
                     /**
                      * get current user
                      */
                     $user = Service::get('security')->getUser();
                     if (is_null($user)) {
                         throw new AuthRequredException('If you wont do this action please login or signin.');
                     }
                     //if (!in_array($user->role, $route['security'])) {
                     if (!Service::get('security')->haveRight($user->role, $route['security'][0])) {
                         throw new SecurityException('You have not right for this action.');
                     }
                 }

                 self::runControllerMethod($route['controller'], $route['action'],
                     isset($route['params']) ? $route['params'] : '');
             } else {
                 throw new HttpNotFoundException('Route not found');
             }
         } catch (MainException $e) {
             $e->solveException();
         } catch (\Exception $e) {
             echo $e->getMessage();
         }
    }
}






















