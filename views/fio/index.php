<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Список ФИО';

$bu = Yii::$app->params['basic_url'];

$script = <<< JS

$(function(){
    $('.footable').footable({
        "paging": {
            "enabled": true,
            "countFormat": "{CP} из {TP}",
			"limit": 5,
			"size": 20
        },
        "filtering": {
            "enabled": true,
            "placeholder": "Поиск"
        },
        "sorting": {
            "enabled": true
        }
    });
});	    

//удаление пользователя
$('.m_delete').on('click',function(e){
    e.preventDefault();
    var id = $(this).attr('id_row'); 
    if(confirm('Вы действительно желаете удалить данное событие')){
        window.location.href = '$bu' + 'fio/delete?&id=' + id;
        }
    return false;
});

//обновление пользовательских данных + загрузка excel
$('.m_update').on('click',function(e) {
    e.preventDefault();
    var id = $(this).attr('id_row');
    window.location.href = '$bu' + 'fio/edit?&id=' + id;
    return false;
});

//просмотр xcel
$('.m_show').on('click',function(e) {
    e.preventDefault();
    var id = $(this).attr('id_row');
    if (id!='0') {
        window.location.href = '$bu' + 'fio/show?&id=' + id;    
    }
    return false;
}); 
JS;

$this->registerJs($script,yii\web\View::POS_READY);

?>


<h1><?=$this->title ?></h1>
<div class="row" style="margin-left: 1%; margin-right: 1%;">
    <div class="col-xs-12">
        <div class="form-group">
            <div class="col-xs-12">
                <a href="<?= Yii::$app->params['basic_url']?>fio/add" class="btn btn-success">Добавить ФИО</a>
            </div>

            <div class="col-xs-12">
                <table class="table footable" >
                    <thead>
                    <tr class="footable-header">
                        <th>ID</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Создан</th>
                        <th>Обновлен</th>
                        <th>Удалить</th>
                        <th>Данные</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($model) foreach ($model as $m) { ?>
                    <tr class="vcenter_a view_request" id_row="<?= $m->id ?>">

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= $m->id ?>
                        </td>

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= $m->user_f ?>
                        </td>

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= $m->user_i ?>
                        </td>

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= $m->user_o ?>
                        </td>

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= $m->date_add ?>
                        </td>

                        <td class="m_update" id_row="<?= $m->id ?>">
                            <?= ($m->date_update) ? $m->date_update : '-' ?>
                        </td>

                        <td class="m_delete" id_row="<?= $m->id ?>">
                            Удалить
                        </td>

                        <td class="m_show" id_row="<?= ($m->show) ? $m->id : 0 ?>">
                            <?= ($m->show) ?  'Посмотреть' : ''?>
                        </td>

                    </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .vcenter_a {
        cursor: default;
    }
    .vcenter_a:hover td{
        background: #e3e8e9;
    }
    .footable {
        color: black !important;
    }
</style>