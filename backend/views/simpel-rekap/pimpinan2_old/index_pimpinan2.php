<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use hscstudio\mimin\components\Mimin;
use yii\widgets\LinkPager;
use common\components\HelperUnit;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelRekapSeacrh */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Daftar Rekapitulasi Perjadin');
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
<div class="simpel-keg-index">
    <div class="block">
        <div class="block-title">
            <ul class="nav nav-tabs ">
                <li  class="active" >
                    <a href="<?= Url::to(['simpel-rekap/pimd']) ?>" >
                    Rekapitulasi Perjadin</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/pimdkeg']) ?>" >
                    Rekapitulasi Kegiatan</a>
                </li>
                <li>
                    <a href="<?= Url::to(['simpel-rekap/pimpinanmonikeg']) ?>" >
                    Monitoring Kegiatan </a>
                </li>

            </div>
            <?= $this->render('_search') ?>
            <?php if(!empty($_GET)){ ?>
            <h3 align="center"><?= HelperUnit::unit($_GET['unit_id']).'  -  '.HelperUnit::unit($_GET['unit']) ?> </h3>
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
                        
                        <th >No </th>
                        <th >Nama </th>
                        <th >Nama Kegiatan </th>
                        <th >Tujuan </th>
                        <th >Jumlah DL </th>

                        <th width="600">Tanggal </th>
                    </tr>
                    
                    <?php
                        $no = 1;
                    foreach ($models as $data) {

                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td width="500">
                                <?php 
                        if($data->pegawai_id>0){ ?>
                            <?= $data->pegawai->nama ?>
                       <?php }else{
                            echo $data->nama;
                        } ?>
                        </td>
                        <td align="center" width="300"><?= $data->keg->nama_keg ?></td>

                        <td align="center" width="300"><?= $data->keg->kotaTujuan->nama ?></td>
                        <td align="center" width="300">
                      <?= $data->uang_makan ?>
                        </td>
                        <td align="center" width="300">
                        <?= substr($data->tgl_berangkat, 8,2).' s/d '.substr($data->tgl_kembali, 8,2).'  '.\common\components\MyHelper::BacaBulan(substr($data->tgl_berangkat, 5,2)).'  '.substr($data->tgl_berangkat, 0,4) ?>
                        </td>
                    </tr>
                    <?php $no++;} ?>
                </table>
                <?php }else{ ?>
                <table class="table table-responsive list table-bordered " width="100%">
               
                    <tbody>
                    <tr>
                        <th width="300">No </th>
                        <th width="300">Nama </th>
                        <th width="300">Nama Kegiatan </th>
                        <th width="300">Tujuan </th>
                        <th width="300">Jumlah DL </th>
                        <th width="400">Tanggal </th>
                    </tr>
                    
                    </tbody></table>
              <?php } ?>
                
            </div>

            <?php
            echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
        </div>
    </div>
