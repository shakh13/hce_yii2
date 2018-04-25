<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property integer $is_terminal
 * @property integer $terminal_id
 * @property integer $transferer_id
 * @property integer $receiver_id
 * @property integer $trans_card_id
 * @property integer $recv_card_id
 * @property integer $sum
 * @property string $created_at
 *
 * @property User $receiver
 * @property Cards $recvCard
 * @property Terminal $terminal
 * @property Cards $transCard
 * @property User $transferer
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_terminal', 'terminal_id', 'transferer_id', 'receiver_id', 'trans_card_id', 'recv_card_id', 'sum'], 'integer'],
            [['transferer_id', 'receiver_id', 'trans_card_id', 'recv_card_id', 'sum'], 'required'],
            [['created_at'], 'safe'],
            [['recv_card_id'], 'unique'],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            [['recv_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['recv_card_id' => 'id']],
            [['terminal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Terminal::className(), 'targetAttribute' => ['terminal_id' => 'id']],
            [['trans_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['trans_card_id' => 'id']],
            [['transferer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['transferer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_terminal' => 'Is Terminal',
            'terminal_id' => 'Terminal ID',
            'transferer_id' => 'Transferer ID',
            'receiver_id' => 'Receiver ID',
            'trans_card_id' => 'Trans Card ID',
            'recv_card_id' => 'Recv Card ID',
            'sum' => 'Sum',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecvCard()
    {
        return $this->hasOne(Cards::className(), ['id' => 'recv_card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminal()
    {
        return $this->hasOne(Terminal::className(), ['id' => 'terminal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCard()
    {
        return $this->hasOne(Cards::className(), ['id' => 'trans_card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferer()
    {
        return $this->hasOne(User::className(), ['id' => 'transferer_id']);
    }
}
