<?php

namespace app\controllers;

use app\models\FileGroup;
use app\models\DownloadLog;
use app\models\FileFileGroup;
use app\models\File;
use app\models\User;
use app\models\UserFileGroup;
use yii\web\HttpException;
use Yii;


class RequestController extends \yii\web\Controller
{
    
    /**
     *  Display a list of files available
     *  to the user
     */
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        
        
        // Get the list of file groups this user belongs too
        
        $usergroups = UserFileGroup::find()->where(['user_id'=>$user->id])->all();
        
        // get the list of filegroups
        $files = [];
        
        foreach($usergroups as $ug)
        {
            
            $groups = FileFileGroup::find()->where(['group_id'=>$ug->file_group_id])->all();
            
            foreach($groups as $g)
            {
                array_push($files,$g->file_id); 
            }
            
        }
        
        $files = File::findAll($files);
        
        
        $selected_file = [];

        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            if(isset($post['Post']['file']))
            {
                $selected_file = $post['Post']['file'];
            }            
        }
        

        return $this->render('index',[
            'user' => $user,
            'files' => $files,
            'selected_file' => $selected_file,
                                      
        ]);
    }

}
