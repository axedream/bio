<?php
use yii\bootstrap\Modal;


$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();

$script = <<< JS

$(function(){
    var this_host = window.location.protocol + "//" + window.location.hostname;
    
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
        },
        "on": {
			"ready.ft.table": function(){
			    on_show_bio();
			},
			"after.ft.paging" : function() {
                on_show_bio();			  
			},
			"after.ft.filtering" : function() {
			    on_show_bio();
			}
		}
    });

    
    function on_show_bio() {
        console.log('test');
        $(".load_bio").on('click',function(e) {
            e.preventDefault();
            var id = $(this).attr('row_id');
            load_form(id);
            return false
        });
    }
    
    function after_load_bio_from_data(msg) {
        $("#bio_view").text('');
        if (msg.error=='no') {
                bio_form_data(msg);
            } else {
                bio_form_error(msg);
            }
    } 
        
    function bio_form_data(msg) {
        $('#form_show_bio').modal('show');
        $("#modal_header").css('color','black');
        $("#bio_view").html(msg.msg);
    }
    
    function bio_form_error(msg) {
        $('#form_show_bio').modal('show');
        $("#modal_header").css('color','red');
        $("#bio_view").text(msg.msg);
    }
    
    function load_form(id) {
    $.ajax({
        url: this_host + "/fio/info_bio?&id="+id,
        async: false,
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(){
        },
        data: { 
            '$csrfParam' : '$csrfToken',
            },
        cache: false,
        success: function (msg) {
            after_load_bio_from_data(msg);
            }
        });
    }
    
    $('.form_cancel').on('click',function(e){
       e.preventDefault();
            $('#form_show_bio').modal('hide');
       return false;
    });    
    
});	   
JS;

$this->registerJs($script,yii\web\View::POS_READY);

?>

<div class="col-xs-12">
    <table class="table footable">
        <thead>
        <tr class="footable-header">
            <th>count</th>
            <th>count_norm</th>
            <th>Справочник Bio</th>
            <!--<th>tax_group_name</th><th>superkingdom</th>-->
        </tr>
        </thead>
        <tbody>
        <?php if ($model) foreach ($model as $m) { ?>
            <tr class="vcenter_a view_request">
                <td><?= $m->count ?></td>
                <td><?= $m->count_norm ?></td>
                <td><a href="#" class="load_bio btn btn-default" row_id="<?=$m->bio_id ?>"><?= $m->bio->tax_name ?></a></td>
                <?php /*<td><?= $m->tax_group_name ?></td><td><?= $m->superkingdom ?></td> */ ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php  Modal::begin([
        'options'=> [
                'id'=>'form_show_bio',
            ],
        'size' => 'modal-lg',
        'header'=>"<span id='modal_header'>Отбражение Bio</span>",
        'footer'=>' <span class="btn btn-default form_cancel">Закрыть</span>'
    ]); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12" id="bio_view"></div>
    </div>
</div>

<?php Modal::end(); ?>


<style type="text/css">
    .vcenter_a {
        cursor: default;
    }

    .vcenter_a:hover td {
        background: #e3e8e9;
    }

    .footable {
        color: black !important;
    }
    #modal_header {
        font-weight: bold;
        font-size: 20px;
    }
    #bio_view {
        color: black;
        font-size: 18px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .load_bio {
        width: 300px;

    }
</style>
