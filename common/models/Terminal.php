<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "terminal".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bank_id
 * @property string $number
 * @property string $exp_date
 * @property string $auth_key
 * @property string $last_update
 * @property integer $status
 * @property string $created_at
 *
 * @property User $user
 * @property Banks $bank
 * @property Transactions[] $transactions
 */
class Terminal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terminal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bank_id', 'number', 'exp_date', 'auth_key'], 'required'],
            [['user_id', 'bank_id', 'status'], 'integer'],
            [['auth_key'], 'string', 'max' => 255],
            [['last_update', 'created_at'], 'safe'],
            [['number'], 'string', 'max' => 16],
            [['exp_date'], 'string', 'max' => 5],
            [['number'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'bank_id' => 'Bank ID',
            'number' => 'Number',
            'exp_date' => 'Exp Date',
            'auth_key' => 'Auth Key',
            'last_update' => 'Last Update',
            'status' => 'Status',
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
        return $this->hasMany(Transactions::className(), ['terminal_id' => 'id']);
    }
}
