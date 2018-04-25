<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\Banks;
use yii\web\Response;

class BanksController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateBank(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $bank = new Banks();

        $bank->scenario = Banks::SCENARIO_CREATE;
        $bank->attributes = \Yii::$app->request->post();

        if ($bank->validate()){
            $bank->save();
            return ['status' => true, 'data' => 'Bank created successfully.'];
        }
        else {
            return ['status' => false, 'data' => $bank->getErrors()];
        }
    }

    public function actionAllBanks(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $banks = Banks::find()->where(['status' => 1])->all();

        if (count($banks) > 0){
            return ['status' => true, 'data' => $banks];
        }
        else {
            return ['status' => 'false', 'data' => 'DB is empty'];
        }
    }

}
