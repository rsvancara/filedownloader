<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Download Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'username:ntext',
            'email',
            'user_id',
            'filename:ntext',
            'filepath:ntext',
            'download_time',
            //'create_date',
            //'update_date',
            // 'delete_date',
            // 'description:ntext',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
