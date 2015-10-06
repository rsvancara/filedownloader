<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $filename
 * @property string $filepath
 * @property string $create_date
 * @property string $update_date
 * @property string $delete_date
 * @property string $description
 * @property integer $status
 * @property integer $size_bytes
 * @property string $file_info
 *
 * @property FileFilegroup[] $fileFilegroups
 * @property FileGroup[] $groups
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date', 'delete_date'], 'safe'],
            [['description', 'file_info'], 'string'],
            [['status', 'size_bytes'], 'integer'],
            [['filename', 'filepath'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'delete_date' => 'Delete Date',
            'description' => 'Description',
            'status' => 'Status',
            'size_bytes' => 'Size Bytes',
            'file_info' => 'File Info',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileFilegroups()
    {
        return $this->hasMany(FileFilegroup::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(FileGroup::className(), ['id' => 'group_id'])->viaTable('file_filegroup', ['file_id' => 'id']);
    }
}
