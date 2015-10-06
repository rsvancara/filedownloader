<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="frontpage">

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Dhingra Lab File Access',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            
            $menu_items = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            
            $admin_items = [];
            if(!Yii::$app->user->isGuest && Yii::$app->user->can("admin"))
            {
                $admin_items = [
                    ['label'=>'Manage Users','url'=>['/user/admin/index']],
                    ['label'=>'Manage Roles','url'=>['/roleadmin/index']],
                    ['label'=>'Manage Files','url'=>['/file/index']],
                ];
            }
            
            $user_items = [
                ['label' => 'Login', 'url' => ['/user/login']],
                ['label' => 'Create Account','url'=>'/user/register'],
            ];
            
            
            if(!Yii::$app->user->isGuest)
            {
                $user_items = [
                    ['label'=> 'My Account', 'url'=>['user/account']],
                    ['label' => 'Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                            'url' => ['user/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ];
            }
            
            //var_dump(array_merge($menu_items,$user_items,$admin_items));
            //exit;
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' =>  array_merge($menu_items,$user_items,$admin_items),
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Washington State University <?= date('Y') ?></p>
            <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
