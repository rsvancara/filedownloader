<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request Access';

?>
<h1>Request Access</h1>
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

foreach($files as $f)
{

    $checked = "";
    foreach($selected_file as $sf)
    {
        if($sf == $f->id)
        {
            $checked = "checked";
            break;
        }
    }

?>
<tr>
    <td><input type="checkbox" name="Post[file][<?= $i ?>]" value="<?= $f->id ?>"  <?= $checked ?>/></td>
    <td><?= $f->filename ?></div>
    <td class="filedescription"><?= $f->description ?></td>
</tr>
<?php

    $i++;

}

?>


</table>
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
