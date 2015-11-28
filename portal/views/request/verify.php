<?php

use yii\helpers\Html;
use app\models\RequestFile;
$this->registerJsFile("/portal/js/verify.js",['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Request File Access';

?>

<h1>Request File Access</h1>


<table>
    <tr>
        <td>
            Email:
        </td>
        <td>
            <?= $user->email ?>
        </td>
    </tr>
        <td>
            Full Name:
        </td>
        <td>
            <?= $profile->full_name ?>
        </td>
    <tr>
        <td>
            Request
        </td>
        <td>
            <?= $request->reason ?>
        </td>
    </tr>
</table>
<script>
    var request_id=<?=$request->id?>;
    var user_id=<?=$request->user_id?>;
    
</script>

<?php
  foreach($files as $f)
  {
?>
<div id="filegroup_<?= $f->id ?>" class="filegroup">

    
    <?php
    $showform = 1;
    $status = "";
    
    $rqf = RequestFile::find()->where(['file_id'=>$f->id, 'request_id'=>$request->id])->one();
    if($rqf !== NULL)
    {
        switch($rqf->granted)
        {
            case "1":
                $showform = 0;
                $status = "allowed";
                break;
            case "0":
                $status = "denied";
                $showform = 0;
                break;
        }
    }
    //print "<pre>" . $showform . " " . $rqf->granted  ."</pre>";
    ?>
    <div>File: <?=$f->filename ?> <?php print $status==""?"":"(".$status.")"; ?></div>
    <?php
    if($showform == 1)
    {
    ?>
    <div id="form-group_<?=$f->id?>">
    
    <label for="allowdeny">Allow or Deny Access</label>
    <select name="allowdeny" id="allowdeny_<?= $f->id ?>" class="toggleallowdeny form-control">
        <option value="none">--Select--</option>
        <option value="allow">Allow</option>
        <option value="deny">Deny</option>
    </select>
    <div class="filegroupperms" id="filegroupperm_<?=$f->id?>">
    <?php
    if($f->groups !== NULL && sizeof($f->groups) > 0)
    {
    ?>
    <label for="fgroup">Select Group</label>
    <select id="select_<?= $f->id ?>"name="fgroup" class="form-control">
    <option value="none">--Select Group--</option>
    <?php
    foreach($f->groups as $group) {
    ?>
      <option value="<?= $group->id?>"><?=$group->group_name?></option>
    <?php
    }
    ?>
    </select>
    <?php
    }
    ?>
    
    <label for="newgroup" style="display: block;">or Enter New Group Name</label>
    <input class="form-control" type="text" id="newgroup_<?=$f->id ?>" name="newgroup" />
    </div>
    <div class="form-group">
        <button id="commit_<?=$f->id?>" class="commit btn btn-primary">Commit Change</button>
    </div>
    <div id="alert_<?=$f->id?>" class="alert"></div>
    </div>
    <?php
    }
    ?>
</div>


<?php
  }
?>

<style>
    div.filegroupperms{
        display:none; 
    }
    
    div.filegroup{
        margin-bottom: 20px;
        border: 1px solid #cccccc;
        padding: 5px;
    }
    
    div.filegroup button{
        margin-top: 5px;
    }
    
    
    div.alert span{
        color: red;
        margin-left: 5px;
    }
    
    
    
    
</style>