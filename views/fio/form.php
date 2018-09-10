<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use moonland\phpexcel\Excel;

$this->title = 'Список ФИО: Создать';
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

                <?php $form = ActiveForm::begin([
                    'id' => 'form_add',
                    'action'=>($model->isNewRecord) ? $bu.'fio/add' : $bu.'fio/edit?&id='.$model->id,
                    'options' => [
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                    ],
                ]); ?>
                <?= $form->field($model, 'user_f') ?>
                <?= $form->field($model, 'user_i') ?>
                <?= $form->field($model, 'user_o') ?>

                <?php if (!$model->isNewRecord && $model_patient) { ?>
                    <h3>Данные EXCEL/CSV загруженные по текущему пользотелю</h3>
                    <?= ($model_patient) ? Yii::$app->view->renderFile('@app/views/fio/table_show.php',['model'=>$model_patient]) : ''?>
                <?php } ?>

                <?= $form->field($model, 'file')->fileInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(($model->isNewRecord) ? 'Создать' : 'Редактировать || Загрузить EXCEL/CSV', ['class' => 'btn btn-primary bt']) ?>
                </div>


                <?php ActiveForm::end() ?>
            </div>

    </div>
</div>
<style type="text/css">
    .bt {
        margin-left: 0px;
    }
</style>