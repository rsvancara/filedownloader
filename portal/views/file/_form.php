<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile("/portal/filetree/jquery.easing.js",['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/portal/filetree/jqueryFileTree.js",['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile("/portal/filetree/jqueryFileTree.css");
$this->registerJs("
			$(document).ready( function() {
                $('#chooser').click(function() {
                   $('#filechooser').show();
                
				   $('#filetree').fileTree({ root: '/', script: '/portal/download/fileviewer' }, function(file) { 
					  $('#file-filepath').val(file);
				   });                      
                });
			});",View::POS_END);
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filename')->textInput() ?>



    <?= $form->field($model, 'filepath')->textInput()?>
    <button id="chooser" class="btn btn-primary" type="button" name="choose" value="choose">Browse Filesystem</button>
    <div id="filechooser">
        <div class="example">
            <div id="filetree" class="demo"></div>
        </div>
    </div>


    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<style type="text/css">
    #filechooser {
        display: none;
        width: 782px;
        height: 500px;
        
    }
    
.wrapper {
    border:1px solid #000;
    display:inline-block;
    position:relative;
}
#chooser {

}
    
    .demo {
        width: 770px;
        height: 400px;
        border-top: solid 1px #BBB;
        border-left: solid 1px #BBB;
        border-bottom: solid 1px #FFF;
        border-right: solid 1px #FFF;
        background: #FFF;
        overflow: scroll;
        padding: 5px;
    }
    
</style>

