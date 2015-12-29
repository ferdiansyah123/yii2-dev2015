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
    .table{
        width: 100;
    }
</style>

       <?php if(!empty($_GET)){ ?>
        <h3 align="center">Daftar Rekapitulasi Kegiatan Luar Negeri</h3>
            <h3 align="center"><?= HelperUnit::unit($_GET['unit_id']).'  -  '.HelperUnit::unit($_GET['unit']) ?> </h3>
           
            <p align="right">
             <a href="<?= Yii::$app->urlManagerr->createUrl(['simpel-rekap/export-luar','unit'=>$_GET['unit'],'unit_id'=>$_GET['unit_id'],'tgl_mulai'=>$_GET['tgl_mulai'],'negara'=>$_GET['negara'],'tgl_kembali'=>$_GET['tgl_kembali']]) ?>" >
            <img src="<?= Url::to(['/images/printer.png']) ?>" width="40px"/>
            </a>
            </p>    
        <table class="table table-responsive list table-bordered ">

               <tr>
                    <th align="center" rowspan="3" width="200">No. Surat Penugasan<br/>Tgl Surat Penugasan</th>
                    <th align="center" rowspan="3" width="200">Nama / NIP</th>
                    <th rowspan="3" align="center">Pangkat/ Ruang. Gol</th>
                    <th align="center" width="20" rowspan="3">Tujuan</th>
                    <th align="center" width="100" rowspan="3" >Tanggal <br/>Berangkat <br/> /kembali</th>
                    <th rowspan="3" width="10">Lama Hari</th>
                    <th align="center" colspan="6">Biaya</th>
                </tr>
                <tr>
                    <th align="center" colspan="3" width="100">Transport </th>


                    <th align="center" width="100" colspan="2"  rowspan="2">Lumpsum </th>
                    <th align="center" rowspan="2" colspan="2">Jumlah</th>

                </tr>

                <tr>

                    <th align="center" width="100">Tiket</th>
                    <th align="center" width="100" >Asuransi</th>
                    <th align="center" width="100">Airport tax </th>


                </tr>
           <?php 
            echo ListView::widget([
                'dataProvider' => $dataAdmin,
                  'itemView' => '_kegiatan_luar',
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
         <?php }else{ ?>
            <table class="table table-responsive list table-bordered " width="100%">
               
                    <tbody>
                 <tr>
                <th rowspan="2" width="200">No. Surat Penugasan<br>Tgl Surat Penugasan</th>
                <th rowspan="2" width="200">Nama / NIP / Gol / Eselon</th>
                <th rowspan="2" align="center">Akun</th>
                <th width="200" rowspan="2"> Kota Tujuan</th>
                <th width="230" rowspan="2">Tanggal </th>
                <th width="230" rowspan="2">Lama </th>
                <th width="230" colspan="6"><center>Biaya</center></th>

            </tr>
                    </tbody></table>
         <?php } ?>
   