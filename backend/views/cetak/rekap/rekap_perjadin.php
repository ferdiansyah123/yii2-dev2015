
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use \common\components\MyHelper;
use common\components\HelperUnit;
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
<h2 align="center">REKAPITULASI PEGAWAI YANG MELAKSANAKAN PERJALANAN DINAS</h2>
<h2 align="center"> <?= strtoupper(HelperUnit::unit($_GET['unit_id'])) ?> - <?= strtoupper(HelperUnit::unit($_GET['unit'])) ?></h2>
<h2 align="center"><?= MyHelper::Formattgl($_GET['tgl_mulai']) ?> s/d  <?= MyHelper::Formattgl($_GET['tgl_kembali']) ?></h2>

<table class="table table-responsive list table-bordered " width="100%">
               
                    
                    <tr>
                        <th>No</th>
                        <th width="25%">Nama Pelaksana Perjadin</th>
                        <th width="30%">Nama Kegiatan </th>
                        <th width="20%">Tanggal </th>
                        <th width="5%">Jumlah DL Hari Kerja </th>
                        <th width="10%">Kota Tujuan </th>
                    </tr>
                    
                    <?php
                        $no = 1;
                    foreach ($models as $data) {

                    ?>
                    <tr>
                        <td align="center" width="5%"><?= $no ?></td>
                        <td width="20%">
                            <?php 
                        if($data['pegawai_id']>0){ ?>
                            <?= HelperUnit::Pegawai($data['pegawai_id']) ?>
                           NIP. <?= $data['pegawai_id'].'<br/>' ?>
                            <?= Myhelper::Gole(HelperUnit::Pegawais($data['pegawai_id'])->gol_id) ?><br/>
                            <?= Myhelper::Jab(HelperUnit::Pegawais($data['pegawai_id'])->struk_id) ?>
                            
                       <?php }else{
                            echo $data['nama'].'<br/>';
                            echo $data['nip'].'<br/>';
                            echo $data['gol'].'<br/>';
                            echo $data['jab'].'<br/>';
                        } ?>
                        
                        </td>
                        <td align="center" width="60%"><?= $data->keg->nama_keg ?></td>
                         <td align="center" width="10%">
                        <?= substr($data->tgl_berangkat, 8,2).' s/d '.substr($data->tgl_kembali, 8,2).'  '.\common\components\MyHelper::BacaBulan(substr($data->tgl_berangkat, 5,2)).'  '.substr($data->tgl_berangkat, 0,4) ?>
                        </td>
                        <td align="center" width="5%">
                        <?= $data->uang_makan ?>
                        </td>
                       
                        <td align="center" width="10%"><?= $data->keg->kotaTujuan->nama ?></td>

                    </tr>
                    <?php $no++;} ?>
                </table>
