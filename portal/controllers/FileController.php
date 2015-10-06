<?php

namespace app\controllers;

use Yii;
use app\models\File;
use app\models\DownloadLog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FileFileGroup;
use yii\web\HttpException;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
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
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => File::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    
    }

    /**
     * Displays a single File model.
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
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $model = new File();

        if ($model->load(Yii::$app->request->post())) {
            
            if(!file_exists($model->filepath))
            {
                
                $model->addError('filepath',"File does not exist, please provide a valid path.");
                return $this->render('create', [
                    'model' => $model,
                ]);                
            }

            $model->size_bytes = filesize($model->filepath);
            
            //$model->file_info = finfo_file($model->filepath);
            
            if($model->save())
            {
            
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,
                ]);                
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing File model.
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
        if ($model->load(Yii::$app->request->post())) {
            
            if(!file_exists($model->filepath))
            {
                
                $model->addError('filepath',"File does not exist, please provide a valid path.");
                return $this->render('create', [
                    'model' => $model,
                ]);                
            }

            $model->size_bytes = filesize($model->filepath);
            
            //$model->file_info = finfo_file($model->filepath);
            
            if($model->save())
            {
            
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,
                ]);                
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        FileFileGroup::deleteAll(['file_id'=>$id]);
        $this->findModel($id)->delete();
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionLog()
    {
        
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => DownloadLog::find(),
        ]);

        return $this->render('log', [
            'dataProvider' => $dataProvider,
        ]);
    
    }
    

}
