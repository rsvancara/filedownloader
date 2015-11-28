<?php

namespace app\controllers;

use app\models\RequestForm;
use app\models\Request;
use app\models\RequestFile;
use app\models\FileGroup;
use app\models\DownloadLog;
use app\models\FileFileGroup;
use app\models\File;
use app\models\User;
use app\models\Profile;
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
        
        
        $requestform = new RequestForm();
        
        // get the list of files
        $tfiles = File::find()->orderBy('filename')->all();
        
        //Bucket to store files we find
        $files = [];
        
        // Iterate through the list of files!!
        foreach($tfiles as $f)
        {
            
            $include_file = TRUE;
            
            $groups = FileFileGroup::find()->where(['file_id'=>$f->id])->all();
            foreach($groups as $group)
            {
                // Get users for the file groups
                $usersgroup = UserFileGroup::find()->where(['file_group_id'=>$group->group_id])->all();
                foreach($usersgroup as $ug)
                {
                    if($ug->user_id == $user->id)
                    {
                        // exclude this file
                        $include_file == FALSE;
                    }
                }
            }
            
            if($include_file == TRUE)
            {
                array_push($files,$f);
            }
        }
        
        // WHat do we do if they belong to everything???
        if(sizeof($files) == 0)
        {
            $this->redirect(['site/index']);
        }
        
        
        // See if user has access to any of these files
        //var_dump($files);
        //exit;
        $selected_file = [];

        // To lazy to create  a ActiveForm object to hold these values
        if(Yii::$app->request->post())
        {
            
            $post = Yii::$app->request->post();

            $requestform->load(Yii::$app->request->post());
            if($requestform->validate())
            {
                // Create the request entry
                $request = new Request();
                $request->create_datetime = date("Y-m-d H:i:s");
                $request->reason = $requestform->request;
                $request->user_id = $user->id;
                
                $request->save();
                if($requestform->file !== NULL && sizeof($requestform->file) > 0)
                {            
                    foreach($requestform->file as $f)
                    {
                        $rf = new RequestFile();
                        $rf->file_id = $f;
                        $rf->request_id = $request->id;
                        $rf->save();
                        
                    }
                    // Send the email to the administrators
                    
                    $admins = User::find()->where(['role_id'=>1])->all();
                    
                    $body = "A new file access request has been submitted.\n";
                    $body .= "Please visit on the following link:\n";
                    $body .= 'http://gmod.wsu.edu/portal/request/verify?id=' . $request->id . '';
                    foreach($admins as $admin)
                    {
                        Yii::$app->mailer->compose()
                            ->setTo($admin->email)
                            ->setFrom([$admin->email => $admin->username])
                            ->setSubject("File Access Request for GMOD Portal")
                            ->setTextBody($body)
                            ->send();
                    }
                    
                    $this->redirect(['requestconfirm']);
                }
            }
            
        }
            
        return $this->render('index',[
            'model'=> $requestform,
            'user' => $user,
            'files' => $files,
            'selected_file' => $selected_file,
                                      
        ]);
    }
    
    /**
     * Confirmation page
     */
    public function actionRequestconfirm()
    {
        
        //if (!Yii::$app->user->can("admin")) {
        //    throw new HttpException(403, 'You are not allowed to perform this action.');
        //}
        return $this->render('requestconfirm');
    }
    
    /**
     * Verify request
     * @param $id
     */
    public function actionVerify($id) {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $user = \Yii::$app->user->identity;
        
        $request = Request::find()->where(['id'=>$id])->one();
        
        
        $user = User::find()->where(['id'=>$request->user_id])->one();
        
        $profile = Profile::find()->where(['user_id'=>$user->id])->one();
        
        $request_files = RequestFile::find()->where(['request_id'=>$request->id])->all();
        
        $files = [];
        
        if($request_files !== NULL)
        {
            foreach($request_files as $rf)
            {
                $file = File::find()->where(['id'=>$rf->file_id])->one();
                array_push($files,$file);
            }
        }
        
        if($request === NULL)
        {
            $this->redirect(['site/error']);
        }
        
        return $this->render('verify',[
            'request' => $request,
            'user' => $user,
            'profile' => $profile,
            'files' => $files,
        ]);        
    }
    
    public function actionVerifyapprove($request_id,$file_id,$user_id,$group){
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $response = ['status'=>'fail'];
        
        // If we get a numeric group, then we are using an existing group
        if(is_numeric($group))
        {
            
            // First check to see if a record exists because the
            // stupid front end is not very good at figuring this out
            $ufg = UserFileGroup::find()->where(['user_id'=>$user_id])->andWhere(['file_group_id'=>$group])->one();
            //var_dump($ufg);
            //exit;
            // If nothing is found, create the new entry
            if($ufg === NULL)
            {
                // Now assign the user to this filegroup
                $ufg = new UserFileGroup();
                $ufg->user_id = $user_id;
                $ufg->file_group_id = $group;
                if($ufg->save())
                {
                    $rqf = RequestFile::find()->where(['request_id'=>$request_id,'file_id'=>$file_id])->one();
                    $rqf->granted=1;
                    if($rqf->save())
                    {
                        $this->commitRequest($request_id);
                        $response = ['status'=>'success','message'=>''];
                    }
                    else{
                        $response = ['status'=>'fail','message'=>'Error saving request file'];
                    }
                }
                else{
                    $response = ['status'=>'fail','message'=>'Error saving request file'];
                }
            }
            else{
                $response = ['status'=>'fail','message'=>'Record already exists'];
                $rqf = RequestFile::find()->where(['request_id'=>$request_id,'file_id'=>$file_id])->one();
                $rqf->granted=1;
                if($rqf->save())
                {
                    $this->commitRequest($request_id);
                    $response = ['status'=>'success','message'=>''];
                }
            }
        }
        else{
            // Need to create new the group and assign the file id
            $fg = new FileGroup();
            $fg->group_name = $group;
            $fg->description = "Auto Generated through Permission Tool, please provide a more descriptive group name if you want.";
            $fg->status = 'active';
            $fg->is_deleted = 0;
            if($fg->save()){
                // Associate the file group with this file
                $ffg = new FileFileGroup();
                $ffg->file_id = $file_id;
                $ffg->group_id = $fg->id;
                if($ffg->save())
                {
                    // Now assign the user to this filegroup
                    $ufg = new UserFileGroup();
                    $ufg->user_id = $user_id;
                    $ufg->file_group_id = $fg->id;
                    if($ufg->save())
                    {
                        $rqf = RequestFile::find()->where(['request_id'=>$request_id,'file_id'=>$file_id])->one();
                        $rqf->granted=1;
                        if($rqf->save())
                        {
                            $response = ['status'=>'success'];
                            $this->commitRequest($request_id);
                        }
                        else{
                            $response = ['status'=>'fail'];
                        }
                    }
                    else{
                        $response = ['status'=>'fail'];
                    }
                }
                else{
                    $response = ['status'=>'fail'];
                }
            }
            else{
                $response = ['status'=>'fail'];
            }
        }
        
        \Yii::$app->response->format = 'json';
        
        return $response; 
    }
    
    public function actionVerifydeny($request_id,$file_id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        // Save the value in the database so we dont display this record again
        $rqf = RequestFile::find()->where(['request_id'=>$request_id,'file_id'=>$file_id])->one();
        $rqf->granted =0;
        $rqf->save();
        
        $response = ['status'=>'success'];
        $this->commitRequest($request_id);
        
       \Yii::$app->response->format = 'json';
       
       return $response;        
    }
    
    /**
     * Commits the request if all the files have
     * been dealt with
     */
    private function commitRequest($request_id){
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        $requests = RequestFile::find()->where(['request_id'=>$request_id])->andWhere(['granted'=>NULL])->all();
        if(sizeof($requests) == 0)
        {
            $request = Request::find()->where(['id'=>$request_id])->one();
            $request->committed=1;
            $request->save();
        }
        
    
    }

}
