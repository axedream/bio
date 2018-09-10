<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bio */

$this->title = 'Редактировать запись Bio: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить/Рдеактировать';
?>
<div class="bio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
