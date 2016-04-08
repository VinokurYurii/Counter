<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Blog\Model\User;

/**
 * Class ProfileController
 * @package CMS\Controller
 */
class ProfileController extends Controller {
    /**
     * @return \Framework\Response\Response|\Framework\Response\ResponseRedirect
     * @throws \Framework\Exception\DatabaseException
     * @throws \Framework\Exception\ServiceException
     */
    public function updateAction() {
        $isEmailUpdated    = false;
        $isPasswordUpdated = false;
        $updateMessage = '';

        try {
            $user = Service::get('security')->getUser();
            $oldUser = User::find($user->id);

            $newPassword = $this->getRequest()->post('newPassword');
            $newEmail = $this->getRequest()->post('newEmail');

            if (!empty($newEmail) && $newEmail != $oldUser->email) {
                $user->email = $newEmail;
                $isEmailUpdated = true;
                $updateMessage .= 'email ';
            }

            if (!empty($newPassword) && !Service::get('security')->isPasswordMatch($newPassword, $oldUser)) {
                $soplPass = Service::get('security')->getSoltedPassword($newPassword);
                $user->password = $soplPass['soltedPassword'];
                $user->solt = $soplPass['solt'];
                $isPasswordUpdated = true;

                if (!empty($updateMessage)) {
                    $updateMessage .= 'and ';
                }
                $updateMessage .= 'password ';
            }

            if (!$isEmailUpdated && !$isPasswordUpdated) {
                return $this->redirect($this->generateRoute('home'), 'You don\' change data.');
            }
            else if (!$isEmailUpdated) {
                unset($user->email);
            }
            else if (!$isPasswordUpdated) {
                unset($user->password);
                unset($user->solt);
            }

            Service::get('security')->setUser($oldUser);
            $user->save();

            return $this->redirect($this->generateRoute('logout'), 'Data: ' . $updateMessage .
                'has been changet succesfully. Please login again.');

        } catch (DatabaseException $e) {
            $error = $e->getMessage();
            return $this->render('update.html', array('user' => $oldUser, 'errors' => isset($error) ? $error : null,
                'action' => $this->generateRoute('update_profile'),
                'src' => array('src' => 'Blog', 'controller' => 'Security')));
        }
    }

    /**
     * @return \Framework\Response\Response
     * @throws \Framework\Exception\ServiceException
     */
    public function getAction()
    {
        $user = Service::get('security')->getUser();
        unset($user->password);
        unset($user->solt);
        return $this->render('update.html', array('user' => $user, 'errors' => isset($error) ? $error : null,
            'action' => $this->generateRoute('update_profile'),
            'src' => array('src' => 'Blog', 'controller' => 'Security')));
    }
}