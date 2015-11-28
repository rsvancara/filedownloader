<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Dhingra Lab File Access';
?>

    <h2>Logs</h2>
    <ul>
        
        <li><?php echo Html::a('Authentication Logs',['/log/auth']); ?></li>
        <li><?php echo Html::a('Download Logs',['/log/download']); ?></li>
    </ul>
    





