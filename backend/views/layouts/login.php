<?php

use hail812\adminlte\widgets\Alert;
use yii\web\View;
use hail812\adminlte3\assets\AdminLteAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\bootstrap4\Html;

/**
 * @var View   $this
 * @var string $content
 */

AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
PluginAsset::register($this)->add(['fontawesome', 'icheck-bootstrap']);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition login-page">
    <?php $this->beginBody() ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= Yii::$app->homeUrl ?>"><b>Раздел</b> администратора</a>
        </div>
        <!-- /.login-logo -->

        <?= $content ?>

        <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            if (Yii::$app->getSession()->hasFlash($key)) {
                echo '<br/>';
                echo Alert::widget([
                                       'type'  => $key,
                                       'title' => $message['title'],
                                       'body'  => $message['msg'],
                                   ]);
            }
        }
        ?>
    </div>
    <!-- /.login-box -->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>