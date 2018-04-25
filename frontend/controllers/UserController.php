<?php
/**
 * Created by PhpStorm.
 * User: shakh
 * Date: 29.12.17
 * Time: 15:32
 */

namespace frontend\controllers;


use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
}