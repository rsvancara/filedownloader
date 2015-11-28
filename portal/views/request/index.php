<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request File Access';

?>
<h1>Request File Access</h1>
<div class="request">
<table>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
    </tr>
<?php
$form = ActiveForm::begin([
    'id' => 'file-request-form',
    'options' => ['class' => 'form-horizontal'],
]);

$i=0;
if($files !== NULL)
{
    foreach($files as $f)
    {
    
        $checked = "";
        if($model->file !== NULL && sizeof($model->file) > 0)
        {
        foreach($model->file as $sf)
        {
            if($sf == $f->id)
            {
                $checked = "checked";
                break;
            }
        }
        }
    ?>
    <tr>
        <td><input type="checkbox" name="RequestForm[file][<?= $i ?>]" value="<?= $f->id ?>"  <?= $checked ?>/></td>
        <td><?= $f->filename ?></div>
        <td class="filedescription"><?= $f->description ?></td>
    </tr>
    <?php
        $i++;
    }
}
?>
</table>
<div class="form-group">
    <?= $form->field($model, 'request')->textArea() ?>
</div>
<div class="form-group">
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Submit Request', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
