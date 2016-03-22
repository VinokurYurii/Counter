<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/16/14
 * Time: 11:36 AM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord {
    public $title;
    public $content;
    public $date;
    public $user_id; // this property present in view

    public static function getTable()
    {
        return 'posts';
    }

    public function __get($name) {
        if ($name === 'name') {
            return ActiveRecord::getUserEmailById((int)$this->user_id);
        }
    }

    public function getRules()
    {
        return array(
            'title'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'content' => array(new NotBlank())
        );
    }
}