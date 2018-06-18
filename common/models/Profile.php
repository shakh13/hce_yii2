<?php

namespace common\models;

use backend\modules\api\models\UserCards;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $lastname
 * @property integer $main_card
 * @property string $address
 * @property integer $phone
 * @property integer $postcode
 * @property string $created_at
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'surname', 'lastname', 'address', 'phone'], 'required'],
            [['user_id', 'phone', 'postcode', 'main_card'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'surname', 'lastname'], 'string', 'max' => 13],
            [['address'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'lastname' => 'Lastname',
            'address' => 'Address',
            'phone' => 'Phone',
            'postcode' => 'Postcode',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCard(){
        return UserCards::findOne(['user_id' => $this->user->id, 'card_id' => $this->main_card, 'status' => 1]);
    }

    public function getFullname(){
        return $this->name.' '.$this->surname.' '.$this->lastname;
    }
}
