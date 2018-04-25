<?php
/**
 * Created by PhpStorm.
 * User: shakh
 * Date: 12.01.18
 * Time: 8:42
 */

namespace backend\modules\api\controllers;

use backend\modules\api\models\UserCards;
use common\models\LoginForm;
use common\models\Profile;
use Yii;
use common\models\User;
use yii\web\Response;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        if ($username != ""){
            if ($password != ""){
                $user =  new LoginForm();
                $user->username = $username;
                $user->password = $password;
                $user->rememberMe = 1;
                if ($user->login()){
                    $profile = $user->user->profile;
                    return [
                        'action' => 'login',
                        'status' => true,
                        'content' => 'OK',
                        'id' => $profile->user_id,
                        'auth_key' => $user->user->auth_key,
                        'name' => $profile->name,
                        'surname' => $profile->surname,
                        'lastname' => $profile->lastname,
                        'address' => $profile->address,
                        'phone' => $profile->phone,
                        'postcode' => $profile->postcode == NULL ? 0 : $profile->postcode,
                        'created_at' => $profile->created_at
                    ];
                }
                else {
                    return ['action' => 'login', 'status' => 'false', 'content' => 'Логин или пароль неверный'];
                }
            }
            else {
                return ['action' => 'login', 'status' => false, 'content' => 'Введиите пароль'];
            }
        }
        else {
            return ['action' => 'login', 'status' => false, 'content' => 'Введите логин'];
        }
    }

    public function actionSignup(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $username = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');
        $password2 = Yii::$app->request->post('password2');
        $email = Yii::$app->request->post('email');
        $phone = Yii::$app->request->post('phone');

        if ($username != ""){
            if ($password != ""){
                if ($password == $password2){
                    if ($email != ""){
                        if ($phone > 99999999){

                            $checkUserUsername = User::findOne(['username' => $username]);
                            if ($checkUserUsername)
                                return [
                                    'action' => 'signup',
                                    'status' => false,
                                    'content' => 'Пользователь с таким логином сузествует. Пожалуйста выберите другой логин.'
                                ];

                            $checkUserEmail = User::findOne(['email' => $email]);
                            if ($checkUserEmail)
                                return [
                                    'action' => 'signup',
                                    'status' => false,
                                    'content' => 'Пользователь с таким Emailом существует. Пожалуйста выберите другой Email.'
                                ];

                            $checkPhone = Profile::findOne(['phone' => $phone]);
                            if ($checkPhone)
                                return [
                                    'action' => 'signup',
                                    'status' => false,
                                    'content' => 'Пользователь с такий номером телфона существует. Пожалуйста выьерите другой номер телефона.'
                                ];

                            $user = new User();
                            $user->username = $username;
                            $user->email = $email;
                            $user->password = $password;
                            $user->setPassword($password);
                            $user->generateAuthKey();
                            if ($user->validate()){
                                if ($user->save()){
                                    $profile = new Profile();
                                    $profile->user_id = $user->id;
                                    $profile->name = 'UNKNOWN';
                                    $profile->surname = 'UNKNOWN';
                                    $profile->lastname = 'UNKNOWN';
                                    $profile->address = 'UNKNOWN';
                                    $profile->phone = $phone;
                                    $profile->save();
                                    
                                    return [
                                        'action' => 'signup',
                                        'status' => true,
                                        'content' => 'OK',
                                        'id' => $user->id,
                                        'name' => $user->profile->name,
                                        'surname' => $user->profile->surname,
                                        'lastname' => $user->profile->lastname,
                                        'address' => $user->profile->address,
                                        'postcode' => $user->profile->postcode == NULL ? 0 : $user->profile->postcode,
                                        'auth_key' => $user->auth_key,
                                        'created_at' => date("Y-m-d H:M:S", $user->created_at)
                                    ];
                                }
                                else {
                                    return [
                                        'action' => 'signup',
                                        'status' => 'false',
                                        'content' => $user->errors
                                    ];
                                }
                            }
                            else {
                                return [
                                    'action' => 'signup',
                                    'status' => false,
                                    'content' => $user->errors
                                ];
                            }
                        }
                        else {
                            return [
                                'action' => 'signup',
                                'status' => false,
                                'content' => 'Введен неправильный номер телефона'
                            ];
                        }
                    }
                    else {
                        return [
                            'action' => 'signup',
                            'status' => false,
                            'content' => 'Введите E-mail'
                        ];
                    }
                }
                else {
                    return [
                        'action' => 'signup',
                        'status' => false,
                        'content' => 'Пароли не совпадают'
                    ];
                }
            }
            else {
                return [
                    'action' => 'signup',
                    'status' => false,
                    'content' => 'Введите пароль'
                ];
            }
        }
        else {
            return [
                'action' => 'signup',
                'status' => false,
                'content' => 'Введите логин'
            ];
        }
    }


}
