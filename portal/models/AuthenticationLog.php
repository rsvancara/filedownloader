<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authentication_log".
 *
 * @property integer $id
 * @property string $email
 * @property string $user_name
 * @property integer $user_id
 * @property string $login_datetime
 */
class AuthenticationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authentication_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['login_datetime'], 'safe'],
            [['email', 'user_name'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'user_name' => 'User Name',
            'user_id' => 'User ID',
            'login_datetime' => 'Login Datetime',
        ];
    }
}
