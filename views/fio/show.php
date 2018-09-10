<?php
$this->title = 'EXCEL/CVS ФИО: '.$user_name;
$bu = Yii::$app->params['basic_url'];

?>
<h1><?= $this->title ?></h1>

<div class="row" style="margin-left: 1%; margin-right: 1%;">

    <div class="col-xs-12">
        <div class="form-group" style="margin-left: -15px;">
            <a href="<?= Yii::$app->params['basic_url']?>fio" class="btn btn-success">Вернуться к списку</a>
        </div>
    </div>

    <div class="col-xs-12">

        <div class="col-xs-12">
            <?= ($model) ? Yii::$app->view->renderFile('@app/views/fio/table_show.php',['model'=>$model]) : ''?>
        </div>


    </div>
</div>