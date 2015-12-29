<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\db\Query;
use hscstudio\mimin\components\Mimin;
use \common\models\DaftarUnit;
use \common\components\HelperUnit;

$this->params['breadcrumbs'][] = 'Proses';
$this->params['breadcrumbs'][] = 'Permohonan Dinas';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="simpel-keg-index">
    <div class="block">
        <div class="block-title">
            <ul class="nav nav-tabs ">

                <li >
                    <a href="<?= Url::to(['simpel-keg/index']) ?>" >
                        Daftar Permohonan Dinas</a>
                </li>
                <?php if ((Mimin::filterRoute($this->context->id . '/dinas'))) { ?>

                    <li>
                        <a href="<?= Url::to(['simpel-keg/dinas']) ?>" >
                            Daftar Perjalanan Dinas</a>
                    </li>
                <?php } ?>
                <?php if ((Mimin::filterRoute($this->context->id . '/vcetak'))) { ?>

                    <li>
                        <a href="<?= Url::to(['simpel-keg/vcetak']) ?>" >
                            Cetak </a>
                    </li>
                <?php } ?>
                  <?php if ((Mimin::filterRoute($this->context->id . '/bendahara'))) { ?>
                <li>
                    <a href="<?= Url::to(['simpel-keg/bendahara']) ?>" >
                        Bendahara </a>
                </li>
                       <?php } ?>
                 <?php if ((Mimin::filterRoute($this->context->id . '/varsip'))) { ?>
                <li >
                    <a href="<?= Url::to(['simpel-keg/varsip']) ?>" >
                        Arsip </a>
                </li>
                       <?php } ?>
                <?php if ((Mimin::filterRoute($this->context->id . '/log'))) { ?>
                <li class="active">
                    <a href="<?= Url::to(['simpel-keg/log']) ?>" >
                        Log </a>
                </li>
                       <?php } ?>
            </ul>
        </div>
        <?php
        Pjax::begin(['id' => 'dinasSearch']);
        $url_search = Url::to(['simpel-keg/search-serasi']);
        $js = <<<js
$("#searchQuery").keyup(function(){
    var kata = $(this).val();
    if(kata.length > 3 || kata.length == 0){
         $("#datadinasGridview").load("{$url_search}"+"?search="+$(this).val());
    }
});


 
js;
        $this->registerJS($js);
        ?>

            <div class="block block-primary">
                <div class="block-title block-primary">
                    <h2>Log Proses</h2>
                </div>
                <div class="wp-posts-index">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataLog,
                        'id' => 'il',
                        'columns' => [
                            [
                                'header' => 'No',
                                'class' => 'yii\grid\SerialColumn'],
                            [
                                'header' => 'Akun',
                                'contentOptions' => ['style' => 'rowspan:2;width:143px; z-index:200;'],
                                'value' => 'user.username',
                            ],
                            [
                                'attribute' => 'Proses',
                                'format' => 'html',
                                'value' => function($data) {
                                    return $data->nama_proses;
                                }
                            ],
                             [
                                'attribute' => 'Waktu ',
                                'format' => 'html',
                                'value' => function($data) {
                                    return \common\components\MyHelper::indonesian_date($data->waktu);
                                }
                            ],
                        // ['class' => 'yii\grid\ActionColumn'],
                        ]
                    ]);
                    ?>

                    <?php
                    $this->registerJs('
                                                        var gridview_id = "#il"; // specific gridview
                                                        var columns = [2]; // index column that will grouping, start 1 rowspan gridview

                                                        var column_data = [];
                                                            column_start = [];
                                                            rowspan = [];
                                                 
                                                        for (var i = 0; i < columns.length; i++) {
                                                            column = columns[i];
                                                            column_data[column] = "";
                                                            column_start[column] = null;
                                                            rowspan[column] = 1;
                                                        }
                                                 
                                                        var row = 1;
                                                        $(gridview_id+" table > tbody  > tr").each(function() {
                                                            var col = 1;
                                                            $(this).find("td").each(function(){
                                                                for (var i = 0; i < columns.length; i++) {
                                                                    if(col==columns[i]){
                                                                        if(column_data[columns[i]] == $(this).html()){
                                                                            $(this).remove();
                                                                            rowspan[columns[i]]++;
                                                                            $(column_start[columns[i]]).attr("rowspan",rowspan[columns[i]]);
                                                                        }
                                                                        else{
                                                                            column_data[columns[i]] = $(this).html();
                                                                            rowspan[columns[i]] = 1;
                                                                            column_start[columns[i]] = $(this);
                                                                        }
                                                                    }
                                                                }
                                                                col++;
                                                            })
                                                            row++;
                                                        });
                                                    ');
                    ?>


                </div>
            </div>
        </div>

        <?php
        $js = <<<Modal



$(function () {
    $('.modalButtonn').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

});


$(function () {
    $('.modalLuar').click(function () {
        $('#luar').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

})

Modal;
        $this->registerJs($js);
        ?>



        <?php
        Modal::begin([
            'header' => 'Perjalanan Dinas Dalam Negri',
            'options' => [
                'tabindex' => false // important for Select2 to work properly
            ],
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?> 


        <?php
        Modal::begin([
            'header' => 'Perjalanan Dinas luar Negri',
            'options' => [
                'tabindex' => false // important for Select2 to work properly
            ],
            'id' => 'luar',
            'size' => 'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?> 



        <style type="text/css">
            .edit{
                background-color: green;
            }
        </style>



       
