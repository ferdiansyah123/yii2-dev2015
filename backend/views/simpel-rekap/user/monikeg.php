<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\components\MyHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelRekapSeacrh */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Monitoring Perjadin');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    th {
        text-align: center;
        background-color: #9DA39E;
    }
</style>
<style type="text/css">
    .table tbody+tbody, .table tbody>tr>td, .table tbody>tr>th, .table tfoot>tr>td, .table tfoot>tr>th, .table thead>tr>td, .table thead>tr>th, .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border-color: black
}

.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
    background-color: black
}
</style>
<div class="simpel-keg-index">
    <div class="block">
        <div class="block-title">
            <ul class="nav nav-tabs ">
                <li  >
                    <a href="<?= Url::to(['simpel-rekap/pimd']) ?>" >
                        Rekapitulasi Perjadin</a>
                </li>
                <li  >
                    <a href="<?= Url::to(['simpel-rekap/pimdkeg']) ?>" >
                        Rekapitulasi Kegiatan</a>
                </li>
                <li class="active">
                    <a href="<?= Url::to(['simpel-rekap/pimdmonikeg']) ?>" >
                        Monitoring Kegiatan </a>
                </li>

        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 align="center" class="panel-title">Monitoring Perjadin</h3>
            </div>
          <?= $this->render('/simpel-rekap/pencarian/_search') ?>

           
        </div>
        <?php
        if($_GET){ ?>
         <table class="table table-bordered table-responsive" width="100%">
                <tr height="50">
                    <th rowspan="2" style="color:white;" width="30%">Nama Pelaksan / Surat Tugas NIP</th>
                    <th colspan="31" style="color:white;" width="130%">Tanggal Pelaksanaan</th>
                </tr> 
                <tr>
                    <?php for ($i = 01; $i <= 31; $i++) { ?>
                        <th width="10"><?= $i ?></th>

                    <?php } ?>

                </tr>
                
           <?php 
            echo ListView::widget([
                'dataProvider' => $dataAdmin,
                  'itemView' => '_monikeg',
                'pager' => [
                    'firstPageLabel' => 'first',
                    'lastPageLabel' => 'last',
                    'prevPageLabel' => 'previous',
                    'nextPageLabel' => 'next',
                   
                ],
                'layout' => '{items}{summary}{pager}',
              
            ]);

        ?>
    </table>
            <?php 
        } ?>
        

    </div>

</div>
<script type="text/javascript">
    document.getElementById('test').addEventListener('change', function () {
        var style = this.value >= 100000? 'block' : 'none';
        document.getElementById('hidden_div').style.display = style;
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'left',
        trigger : 'hover',
        width:'500px',
    });
});
</script>