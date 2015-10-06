<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FileGroup */

$this->title = "Group " . $model->group_name;
$this->params['breadcrumbs'][] = ['label' => 'File Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('User Membership', ['membership', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'group_name',
            'description',
            //'create_date',
            //'update_date',
            //'delete_date',
            'status',
        ],
    ]) ?>

</div>
<div class="file-user-group-list-view">

    
</div>
