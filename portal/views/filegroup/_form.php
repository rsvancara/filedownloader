<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FileGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['active'=>'active','disabled'=>'disabled']) ?>
    
    <?= $form->field($model, 'description')->textArea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
