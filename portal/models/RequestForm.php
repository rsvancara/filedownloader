<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RequestForm extends Model
{
    public $request;
    public $file;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['request', 'file'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'request' => 'Provide Brief Justification for Access',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    //public function contact($email)
    //{
    //    if ($this->validate()) {
    //        Yii::$app->mailer->compose()
    //            ->setTo($email)
    //            ->setFrom([$this->email => $this->name])
    //            ->setSubject($this->subject)
    //            ->setTextBody($this->body)
    //            ->send();
    //
    //        return true;
    //    } else {
    //        return false;
    //    }
    //}
}
