<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property integer $id
 * @property string $name
 * @property string $api_key
 * @property string $api
 * @property string $logo_path
 * @property integer $status
 * @property string $created_at
 *
 * @property Cards[] $cards
 * @property Terminal[] $terminals
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'api_key', 'api'], 'required'],
            [['api_key', 'api'], 'string'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['logo_path'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'api_key' => 'Api Key',
            'api' => 'Api',
            'logo_path' => 'Logo Path',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Cards::className(), ['bank_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminals()
    {
        return $this->hasMany(Terminal::className(), ['bank_id' => 'id']);
    }
}
