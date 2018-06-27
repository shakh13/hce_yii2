<?php

namespace backend\modules\api\models;

use common\models\Cards;
use common\models\User;
use Yii;

/**
 * This is the model class for table "user_cards".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $card_id
 * @property string $public_key
 * @property integer $status
 * @property string $created_at
 * @property integer $smstouser
 */
class UserCards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_cards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'card_id', 'public_key'], 'required'],
            [['user_id', 'card_id', 'status', 'smstouser'], 'integer'],
            [['created_at'], 'safe'],
            [['public_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'card_id' => 'Card ID',
            'public_key' => 'Public Key',
            'status' => 'Status',
            'created_at' => 'Created At',
            'smstouser' => 'Smstouser',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCard(){
        return Cards::find()->where(['id' => $this->card_id, 'status' => 1])->one();
        //return $this->hasOne(Cards::className(), ['id' => 'card_id']);
    }
}
