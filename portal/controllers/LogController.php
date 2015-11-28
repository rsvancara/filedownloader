<?php

namespace app\controllers;

use Yii;
use app\models\AuthenticationLog;
use app\models\DownloadLog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * RequestManagerController implements the CRUD actions for Request model.
 */
class LogController extends Controller
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
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex()
    {
        

        return $this->render('index');
    }


    public function actionAuth()
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => AuthenticationLog::find(),
        ]);

        return $this->render('auth', [
            'dataProvider' => $dataProvider,
        ]);        
        
    }
    
    public function actionDownload()
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => DownloadLog::find(),
        ]);

        return $this->render('download', [
            'dataProvider' => $dataProvider,
        ]);        
    }
}
