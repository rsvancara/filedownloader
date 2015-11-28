<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property string $reason
 * @property string $create_datetime
 * @property integer $user_id
 * @property integer $committed
 * @property string $message
 * @property integer $admin_id
 *
 * @property RequestFile[] $requestFiles
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reason', 'message'], 'string'],
            [['create_datetime'], 'safe'],
            [['user_id', 'committed', 'admin_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Reason',
            'create_datetime' => 'Create Datetime',
            'user_id' => 'User ID',
            'committed' => 'Committed',
            'message' => 'Message',
            'admin_id' => 'Admin ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestFiles()
    {
        return $this->hasMany(RequestFile::className(), ['request_id' => 'id']);
    }
}
