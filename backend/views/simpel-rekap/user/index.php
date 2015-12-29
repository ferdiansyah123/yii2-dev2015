<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use hscstudio\mimin\components\Mimin;
use common\components\HelperUnit;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelRekapSeacrh */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Daftar Rekapitulasi Perjadin');
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
                <li  class="active" >
                    <a href="<?= Url::to(['simpel-rekap/pimpd']) ?>" >
                    Rekapitulasi Perjadin</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/pimdkeg']) ?>" >
                    Rekapitulasi Kegiatan</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/pimpdmonikeg']) ?>" >
                    Monitoring Kegiatan </a>
                </li>

            </div>
            <?= $this->render('/simpel-rekap/pencarian/_usercari') ?>
            <?php if(!empty($_GET)){ ?>
            <h3 align="center"><?= HelperUnit::unit($_GET['unit']).'  -  '.HelperUnit::unit($_GET['unit']) ?> </h3>
            <p align="right">
            <a href="<?= Yii::$app->urlManager->createUrl(['simpel-rekap/exportd','unit'=>$_GET['unit'],'unit_id'=>$_GET['unit_id'],'tgl_mulai'=>$_GET['tgl_mulai'],'tgl_kembali'=>$_GET['tgl_kembali']]) ?>" >
            <img src="<?= Url::to(['/images/printer.png']) ?>" width="60px"/>
            </a>
            </p>
           <?php } ?>
            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center" class="panel-title"><?= $this->title ?></h3>
                </div>
                                <?php if($_GET){ ?>
                <table  class="table table-responsive list table-bordered " width="100%">
               
                    <tr>
                        
                        <th >Nama </th>
                        <th >Nama Kegiatan </th>
                        <th >Tujuan </th>
                        <th >Jumlah DL </th>

                        <th width="600">Tanggal </th>
                    </tr>
                    <?php 
                        echo ListView::widget([
                            'dataProvider' => $dataAdmin,
                            'itemView' => '_index',
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
    </div>
