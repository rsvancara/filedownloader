<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_file_group".
 *
 * @property integer $file_group_id
 * @property integer $user_id
 *
 * @property FileGroup $fileGroup
 * @property User $user
 */
class UserFileGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_file_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_group_id', 'user_id'], 'required'],
            [['file_group_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_group_id' => 'File Group ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileGroup()
    {
        return $this->hasOne(FileGroup::className(), ['id' => 'file_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
