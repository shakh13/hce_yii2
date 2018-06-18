<?php

namespace common\models;

use Yii;
use yii\web\Response;

/**
 * This is the model class for table "cards".
 *
 * @property integer $id
 * @property integer $bank_id
 * @property string $number
 * @property string $exp_date
 * @property string $password
 * @property integer $phone
 * @property string $name
 * @property integer $color
 * @property integer $cash
 * @property string $last_update
 * @property integer $status
 * @property string $created_at
 *
 * @property Banks $bank
 * @property User $user
 * @property Transactions $transactions
 * @property Transactions[] $transactions0
 */
class Cards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id', 'number', 'exp_date', 'phone', 'name'], 'required'],
            [['bank_id', 'phone', 'color', 'cash', 'status'], 'integer'],
            [['last_update', 'created_at'], 'safe'],
            [['number'], 'string', 'max' => 16],
            [['exp_date'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 32],
            [['number'], 'unique'],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banks::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_id' => 'Bank ID',
            'number' => 'Number',
            'exp_date' => 'Exp Date',
            'phone' => 'Phone',
            'name' => 'Name',
            'color' => 'Color',
            'cash' => 'Cash',
            'last_update' => 'Last Update',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Banks::className(), ['id' => 'bank_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasOne(Transactions::className(), ['recv_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transactions::className(), ['trans_card_id' => 'id']);
    }


}
