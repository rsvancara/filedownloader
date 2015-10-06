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


class DownloadController extends \yii\web\Controller
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
        
        
        return $this->render('index',[
            'user' => $user,
            'files' => $files,
                                      
        ]);
    }
    
    public function actionFile($id)
    {
    
        $model = File::findOne(['id'=>$id]);
        if($model === NULL)
        {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        
        if(file_exists($model->filepath))
        {
            
            
            //Check to see if the user has permissions
            $ffgs = FileFileGroup::find()->where(['file_id'=>$id])->all();
            
            $ffgs_list = [];
            
            $found = 0;
            
            foreach($ffgs as $f)
            {
                $ufg = UserFileGroup::find()->where(['file_group_id'=>$f->group_id, 'user_id'=>\Yii::$app->user->identity->id]);
                if($ufg !== NULL)
                {
                    $found = 1;
                    break;
                }
            }
            
            
            
            
            
            
            if($found==1)
            {
            
                $user = User::findOne(['id'=>\Yii::$app->user->identity->id]);
                
                $dl = new DownloadLog();
                
                $dl->username = $user->username; 
                $dl->email =  $user->email;
                $dl->filepath = $model->filepath;
                $dl->download_time = date("Y-m-d H:i:s");
                $dl->filename = $model->filename;
                $dl->user_id = $user->id;
                $dl->save();
                
                return \Yii::$app->response->sendFile($model->filepath);
            }
            else
            {
                throw new HttpException(403, 'You are not allowed to perform this action.');
            }
            
            
            

        }
        else
        {
            return $this->redirect(['/site/error']);
        }

        
    }
    
    public function actionFileviewer()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $root="";
        
        if(isset($_POST['dir']))
        {
        $_POST['dir'] = urldecode($_POST['dir']);
        //var_dump($_POST['dir']);
        //exit;
        
        if( file_exists($root . $_POST['dir']) ) {
            $files = scandir($root . $_POST['dir']);
            natcasesort($files);
            if( count($files) > 2 ) { /* The 2 accounts for . and .. */
                echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
                // All dirs
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
                        if(is_readable($root . $_POST['dir'] . $file) && $this->not_protected($root . $_POST['dir'] . $file))
                        {
                        echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
                        }
                    }
                }
                // All files
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
                        $ext = preg_replace('/^.*\./', '', $file);
                        echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
                    }
                }
                echo "</ul>";	
            }
        }
        }
    }
    
    
    private function not_protected($path)
    {
        if(preg_match("/^\/proc/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/sys/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/etc/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/tmp/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/var\/tmp/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/dev/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/boot/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/sbin/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/bin/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/lib/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/lib32/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/lib64/",$path))
        {
            return false;
        }
        
        if(preg_match("/^\/usr/",$path))
        {
            return false;
        }
        return true;
    }

}
