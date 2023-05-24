<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Inflector;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <?php
                    echo Breadcrumbs::widget([
                                                 'links'   => isset($this->params['breadcrumbs']) ?
                                                     $this->params['breadcrumbs'] : [],
                                                 'options' => [
                                                     'class' => 'breadcrumb float-sm-right',
                                                 ],
                                             ]);
                    ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            if (Yii::$app->getSession()->hasFlash($key)) {
                echo Alert::widget([
                                       'type'  => $key,
                                       'title' => $message['title'],
                                       'body'  => $message['msg'],
                                   ]);
            }
        }
        ?>
        <?= $content ?>
    </div>
    <!-- /.content -->
</div>