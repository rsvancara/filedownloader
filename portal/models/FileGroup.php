<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_group".
 *
 * @property integer $id
 * @property string $group_name
 * @property string $create_date
 * @property string $update_date
 * @property string $delete_date
 * @property string $status
 * @property integer $is_deleted
 * @property string $description
 *
 * @property FileFilegroup[] $fileFilegroups
 * @property File[] $files
 * @property UserFileGroup[] $userFileGroups
 * @property User[] $users
 */
class FileGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date', 'delete_date'], 'safe'],
            [['is_deleted'], 'integer'],
            [['description'], 'string'],
            [['group_name'], 'string', 'max' => 256],
            [['status'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Group Name',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'delete_date' => 'Delete Date',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileFilegroups()
    {
        return $this->hasMany(FileFilegroup::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('file_filegroup', ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFileGroups()
    {
        return $this->hasMany(UserFileGroup::className(), ['file_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_file_group', ['file_group_id' => 'id']);
    }
}
