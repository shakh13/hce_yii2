<?php

namespace backend\modules\api\models;

use common\models\Cards;
use common\models\Terminal;
use common\models\User;
use Yii;

/**
 * This is the model class for table "trans".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $card_id
 * @property integer $terminal_id
 * @property integer $uzs
 * @property integer $status
 * @property string $created_at
 */
class Trans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'card_id', 'terminal_id', 'uzs'], 'required'],
            [['user_id', 'card_id', 'terminal_id', 'uzs', 'status'], 'integer'],
            [['created_at'], 'safe'],
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
            'terminal_id' => 'Terminal ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCard(){
        return $this->hasOne(Cards::className(), ['id' => 'card_id']);
    }

    public function getTerminal(){
        return $this->hasOne(Terminal::className(), ['id' => 'terminal_id']);
    }
}
