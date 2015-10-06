<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Add Permissions for ' . ' ' . $filemodel->filename;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Back', ['/file/view','id'=>$filemodel->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php
$form = ActiveForm::begin([
    'id' => 'file-permission-form',
    'options' => ['class' => 'form-horizontal'],
])

?>
    <table>
    <?php
      $i=0;
      foreach($filegroups as $fg)
      {
        
        $checked = "";
        foreach($selectedfg as $sfg)
        {
            if($fg->id == $sfg->group_id)
            {
                $checked = "checked";
                break;
            }
        }
        

    ?>
        <tr>
            <td>
    
            <?= $fg->group_name ?>
            </td>
            <td>
              <?= $fg->description ?>
            </td>
            <td>
                <input type="checkbox" name="Post[permission][<?= $i ?>]" value="<?= $fg->id ?>" <?= $checked ?> />
            </td>
        </tr>
    <?php
        $i++;
      }
    
    ?>
    </table>
     <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
<?php
ActiveForm::end() 
?>

</div>
