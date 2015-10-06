<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "download_log".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $user_id
 * @property string $filename
 * @property string $filepath
 * @property string $download_time
 */
class DownloadLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'download_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['download_time'], 'safe'],
            [['username', 'email', 'filename'], 'string', 'max' => 256],
            [['filepath'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'download_time' => 'Download Time',
        ];
    }
}
