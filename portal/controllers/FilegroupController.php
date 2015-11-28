<?php

namespace app\controllers;

use Yii;
use app\models\FileGroup;
use app\models\FileFileGroup;
use app\models\File;
use app\models\User;
use app\models\UserFileGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * FilegroupController implements the CRUD actions for FileGroup model.
 */
class FilegroupController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all FileGroup models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => FileGroup::find()->where(['is_deleted'=>0]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FileGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FileGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $model = new FileGroup();
        $model->is_deleted=0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FileGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $model = $this->findModel($id);
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FileGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $model = $this->findModel($id);
        
        UserFileGroup::deleteAll(['file_group_id'=>$id]);
        FileFileGroup::deleteAll(['group_id'=>$id]);
        
        //if($model->group_name != 'public')
        //{
        //    $model->is_deleted = 1;
        //    $model->save();
        //}
        $model->delete();
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the FileGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
    /**
     * Permissions to files from roles
     */
    public function actionPermission($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $file = File::findOne($id);
        $fg = FileGroup::find()->where(['is_deleted'=>0])->all();
        $sufg = FileFileGroup::find()->where(['file_id'=>$id])->all();

        
        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            
            FileFileGroup::deleteAll(['file_id'=>$id]);
            if(isset($post['Post']['permission']))
            {

                
            
                foreach($post['Post']['permission']  as $perm)
                {

                    $ffg = new FileFileGroup();
                    $ffg->group_id = $perm;
                    $ffg->file_id = $id;
                    $ffg->save();
                }
            }
           
            return $this->redirect(['file/view','id'=>$id]);
        } else {
            
            return $this->render('permission', [
                'filemodel' => $file,
                'filegroups' => $fg,
                'selectedfg' => $sufg,
            ]
                
            );            
        }
    }
    
    /**
     * Membership
     */
    public function actionMembership($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $filegroupmodel= FileGroup::findOne($id);

        $users = User::find()->where(['status'=>1])->all();
        
        $selectedusers = UserFileGroup::find()->where(['file_group_id'=>$id])->all();

        
        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            
            UserFileGroup::deleteAll(['file_group_id'=>$id]);
            //var_dump($post['Post']['membership']);
            //    exit;
            if(isset($post['Post']['membership']))
            {

                foreach($post['Post']['membership']  as $perm)
                {

                    $ffg = new UserFileGroup();
                    $ffg->user_id = $perm;
                    $ffg->file_group_id = $id;
                    if($ffg->save())
                    {
                        //return $this->redirect(['membership','id'=>$id]);
                    }
                }
            }
           
            return $this->redirect(['view','id'=>$id]);
        } else {
            
            return $this->render('membership', [
                'filegroupmodel' => $filegroupmodel,
                'userfilegroups' => $selectedusers,
                'users' => $users,
            ]
                
            );            
        }        
        
    }

    
}
