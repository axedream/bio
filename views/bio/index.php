<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочник Bio';
$this->params['breadcrumbs'][] = $this->title;

$script = <<<JS
    $("._delete").on('click',function(e){
        if (confirm('Вы действительно желаете удалить данную запись')){ 
            return true; 
        }
        return false;
    });
JS;
$this->registerJs($script,yii\web\View::POS_READY);


$columns = [
    'attribute'=>'id',
    'headerOptions' => ['width' => '50'],
    'content'=>function($data){
        return $data->id;
    }
];

$buttons = [
    'class' => 'yii\grid\ActionColumn',
    'header'=>'Действия',
    'headerOptions' => ['width' => '80'],
    'template' => '<div style="text-align: center">{update}{delete}</div>',
    'buttons' => [
        'update' => function ($url) {
            return '<a href="'.$url.'" style="padding-left: 6px; padding-right: 6px;"><span class="glyphicon glyphicon-pencil"></span></a>';
        },
        'delete' => function ($url) {
            return '<a class="_delete" href="'.$url.'" style="padding-left: 6px; padding-right: 6px;"><span class="glyphicon glyphicon-trash"></span></a>';
        },
    ],
];

$name = [
    'attribute' => 'name',
    'content'=>function($data){
        return "<a href='".Yii::$app->params['basic_url']."bio/update?&id=".$data->id."'>".$data->name."</a>";
    }
];
$tax_name = [
    'attribute' => 'tax_name',
    'content'=>function($data){
        return "<a href='".Yii::$app->params['basic_url']."bio/update?&id=".$data->id."'>".$data->tax_name."</a>";
    }
];

?>
<div class="bio-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Создать запись Bio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            $columns,
            $name,
            $tax_name,
            'tax_rank',
            'taxon',
            'parent',
            $buttons,
        ],
    ]); ?>
</div>

<style type="text/css">
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left:0;
        padding-right:0;
        height:auto;
        margin-top:0px !important;
    }
</style>
