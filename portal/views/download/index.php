<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Downloads';

?>
<h1>Download Files</h1>
<div class="filedownloader">
<?php
foreach($files as $f)
{

?>
<div class="fileobject">
    <div class="filename"><a href="/portal/download/file?id=<?= $f->id ?>"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"> <?= $f->filename ?></span></a><span> -- <?= round($f->size_bytes/1024/1024,2) ?> MegaBytes</span></div>
    <div class="filedescription"><?= $f->description ?></div>
    
</div>
<?php
}

?>

</div>
