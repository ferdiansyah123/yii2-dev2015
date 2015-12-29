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
                    <a href="<?= Url::to(['simpel-rekap/index']) ?>" >
                        Rekapitulasi Perjadin</a>
                </li>
                <li  class="active">
                    <a href="<?= Url::to(['simpel-rekap/keg']) ?>" >
                        Rekapitulasi Kegiatan</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/monikeg']) ?>" >
                        Monitoring Kegiatan </a>
                </li>

        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 align="center" class="panel-title">Rekapitulasi Kegiatan</h3>
            </div>
            <?= $this->render('/simpel-rekap/pencarian/_carikeg') ?>
          
            
        </div>
        
        <?php
        switch ($_GET['negara']) {
             case 1:
                echo $this->render('/simpel-rekap/admin/keg',['dataAdmin'=>$dataAdmin]);
                 break;
             case 2:
                echo $this->render('/simpel-rekap/admin/kegiatan_luar',['dataAdmin'=>$dataAdmin]);
                 break;
         } 
         ?>
       </div>
   
</div>