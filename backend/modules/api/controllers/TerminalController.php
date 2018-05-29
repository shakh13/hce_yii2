<?php
/**
 * Created by PhpStorm.
 * User: shakh
 * Date: 13.05.18
 * Time: 12:01
 */

namespace backend\modules\api\controllers;


use common\models\Terminal;
use Yii;
use yii\web\Response;

class TerminalController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    private $authkey = null;

    public function actionLogin(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $authkey = Yii::$app->request->get("auth_key");
        $exp_date = Yii::$app->request->get("exp_date");

        if ($authkey && $exp_date){
            $terminal = Terminal::findOne(['auth_key' => $authkey, 'exp_date' => $exp_date, 'status' => 1]);
            if ($terminal){
                if ($this->checkExpDate($exp_date)){
                    return [
                       'action' => 'login',
                       'status' => true,
                       'content' => 'OK'
                    ];
                }
                else
                    return [
                        'action' => 'login',
                        'status' => 'false',
                        'content' => 'Your terminal is expired. Please, update it'
                    ];
            }
            else
                return [
                   'action' => 'login',
                   'status' => false,
                   'content' => 'Terminal not found'
                ];
        }
        else
            return [
               'action' => 'login',
               'status' => false,
               'content' => 'Sorry, wrong request'
            ];
    }

    /**
     * @param $date
     * @return bool
     */
    public function checkExpDate($date){
        $exp_month = 0+substr($date, 0, 2);
        $exp_year = 0+substr($date, 3, 2);

        $current_month = 0+date("m");
        $current_year = 0+date("y");

        return $exp_year > $current_year ? true : ($exp_year == $current_year ? ($exp_month >= $current_month ? true : false) : false);
    }

}