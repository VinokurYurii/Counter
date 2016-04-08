<?php

namespace CMS\Controller;

use Blog\Model\Post;
use Framework\Controller\Controller;
use Framework\Exception\AuthRequredException;
use Framework\Exception\HttpNotFoundException;
use Framework\DI\Service;
use Framework\Validation\Validator;

/**
 * Class BlogController
 * @package CMS\Controller
 */
class BlogController extends Controller {

    public function editAction($postId) {

        if (!Service::get('security')->isAuthenticated()) {
            throw new AuthRequredException('You need authorizate for this action');
        }

        try {
            $post = new Post();
            $date = new \DateTime();
            $post->id = $postId;
            $post->title = $this->getRequest()->post('title');
            $post->content = trim($this->getRequest()->post('content'));
            $post->date = $date->format('Y-m-d H:i:s');
            $post->user_id = Service::get('security')->getUser()->id;

            $validator = new Validator($post);
            if ($validator->isValid()) {
                $post->save();
                return $this->redirect($this->generateRoute('home'), 'The data has been saved successfully');
            } else {
                $error = $validator->getErrors();
            }
        } catch (DatabaseException $e) {
            $error = $e->getMessage();
        }

        if (!$post = Post::find((int)$postId)) {
            throw new HttpNotFoundException(404);
        }
        return $this->render('add.html', array('post' => $post, 'errors' => isset($error) ? $error : null,
            'action' => $this->generateRoute('edit_post', array('id' => $postId)),
            'src' => array('src' => 'Blog', 'controller' => 'Post')));
    }
}