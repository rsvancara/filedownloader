<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'reason:ntext',
            'create_datetime',
            'user_id',
            'committed',
            // 'message:ntext',
            // 'admin_id',
            [
            'label'=>'',
            'format'=>'raw',
            'value' => function($data){
                //$url = "http://www.bsourcecode.com";
                return Html::a('Manage', "/portal/request/verify?id=".$data->id, ['title' => 'Go']);
            }
        ],
           
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
