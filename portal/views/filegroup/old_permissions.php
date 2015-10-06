<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Permissions for ' . ' ' . $filemodel->filename;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Back', ['/file/view','id'=>$filemodel->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Add Permission', ['addpermission','id'=>$filemodel->id], ['class' => 'btn btn-primary']) ?> 
    </p>
    
    <table>
    <?php
    
      foreach($filegroups as $fg)
      {
        if($fg->group->is_deleted != 1)
        {
    ?>
        <tr>
            <td>
    
            <?= $fg->group->group_name ?>
            </td>
            <td>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['removepermission','id'=>$fg->file_id], ['title'=>'Delete','aria-label'=>'Delete','data-confirm'=>'Are you sure you want to delete this item?']) ?>
            </td>
        </tr>
    <?php
        }
      }
    
    ?>
    </table>


</div>
