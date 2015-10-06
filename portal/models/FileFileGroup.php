<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_filegroup".
 *
 * @property integer $file_id
 * @property integer $group_id
 *
 * @property File $file
 * @property FileGroup $group
 */
class FileFileGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_filegroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'group_id'], 'required'],
            [['file_id', 'group_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(FileGroup::className(), ['id' => 'group_id']);
    }
}
