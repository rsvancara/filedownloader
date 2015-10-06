<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Membership for ' . ' ' . $filegroupmodel->group_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Back', ['/filegroup/view','id'=>$filegroupmodel->id], ['class' => 'btn btn-success']) ?>
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
      foreach($users as $u)
      {
        
        $checked = "";
        foreach($userfilegroups as $sug)
        {
            if($u->id == $sug->user_id)
            {
                $checked = "checked";
                break;
            }
        }
        

    ?>
        <tr>
            <td>
    
            <?= $u->username ?>
            </td>
            <td>
              <?= $u->email ?>
            </td>
            <td>
                <input type="checkbox" name="Post[membership][<?= $i ?>]" value="<?= $u->id ?>" <?= $checked ?> />
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
