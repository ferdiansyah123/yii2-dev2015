<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\components\MyHelper;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use common\components\HelperUnit;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelRekapSeacrh */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Daftar Rekapitulasi Kegiatan');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table tbody+tbody, .table tbody>tr>td, .table tbody>tr>th, .table tfoot>tr>td, .table tfoot>tr>th, .table thead>tr>td, .table thead>tr>th, .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border-color: black
}

.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
    background-color: black
}
</style>
<style type="text/css">
    th{
        text-align: center;
    }
    .list{

        border-collapse: collapse;
        width: 100%;
        display: table-header-group;

    }
    .list tr td{
        border: 1px solid black;
        padding: 4px;
        border-collapse: collapse;
    }
    .list tr th{
        text-align: center; 
        font-weight: bold;
        border: 1px solid black;
        padding: 5px;

        border-collapse: collapse;
        background-color: #9DA39E;
        color:#fff;
    }
    .list tr.even td {
        background-color: #d6eaff;
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
                <li  class="active">
                    <a href="<?= Url::to(['simpel-rekap/pimdkeg']) ?>" >
                        Rekapitulasi Kegiatan</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/pimdmonikeg']) ?>" >
                        Monitoring Kegiatan </a>
                </li>

        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 align="center" class="panel-title"><?= $this->title ?></h3>
            </div>
            <?= $this->render('/simpel-rekap/pencarian/_search') ?>
            <?php if(!empty($_GET)){ ?>
            <h3 align="center"><?= HelperUnit::unit($_GET['unit_id']).'  -  '.HelperUnit::unit($_GET['unit']) ?> </h3>

            <p align="right">
             <a href="<?= Yii::$app->urlManagerr->createUrl(['simpel-rekap/export-pdfd','unit'=>$_GET['unit'],'unit_id'=>$_GET['unit_id'],'tgl_mulai'=>$_GET['tgl_mulai'],'tgl_kembali'=>$_GET['tgl_kembali']]) ?>" >
            <img src="<?= Url::to(['/images/printer.png']) ?>" width="60px"/>
            </a>
            </p>
           <?php } ?>
            
        </div>
       <?php if(!empty($_GET)){ ?>
        <table width="1000"class="table table-responsive list table-bordered ">

            <tr>
                <th  rowspan="2" width="200">No. Surat Penugasan<br/>Tgl Surat Penugasan</th>
                <th  rowspan="2" width="200">Nama / NIP / Gol / Eselon</th>
                <th rowspan="2" align="center">Akun</th>
                <th  width="200" rowspan="2"> Kota Tujuan</th>
                <th  width="130" rowspan="2" >Tanggal </th>
                <th rowspan="2">Lama </th>
                <th  colspan="6"><center>Biaya</center></th>

            </tr>
            <tr>
                <th  width="100">Transport </th>
                <th  width="100" >Taksi</th>
                <th  width="100">Uang Harian</th>
                <th  width="100" rowspan="1">Representatif </th>
                <th width="100" rowspan="1">Penginapan </th>
                <th width="100" rowspan="1">Jumlah </th>
            </tr>
           <?php 
            echo ListView::widget([
                'dataProvider' => $dataAdmin,
                  'itemView' => '_keg',
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
         <?php }?>
           
    </div>
   
</div>