<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_file".
 *
 * @property integer $request_id
 * @property integer $file_id
 * @property integer $granted
 *
 * @property Request $request
 */
class RequestFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'file_id'], 'required'],
            [['request_id', 'file_id', 'granted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'file_id' => 'File ID',
            'granted' => 'Granted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
