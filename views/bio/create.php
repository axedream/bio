<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bio */

$this->title = 'Создать запись Bio';
$this->params['breadcrumbs'][] = ['label' => 'Bios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
