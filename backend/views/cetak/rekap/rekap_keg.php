<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use \common\components\MyHelper;
use \common\components\HelperUnit;

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

<h2 align="center">REKAPITULASI KEGIATAN PERJALANAN DINAS</h2>
<h2 align="center" style="padding-top:-20px;"> <?= strtoupper(HelperUnit::unit($_GET['unit_id'])) ?> - <?= strtoupper(HelperUnit::unit($_GET['unit'])) ?></h2>
<h2 align="center" style="padding-top:-20px;"><?= MyHelper::Formattgl($_GET['tgl_mulai']) ?> s/d  <?= MyHelper::Formattgl($_GET['tgl_kembali']) ?></h2>

<table width="1000" class="table table-responsive list table-bordered ">

            <tbody><tr>
                <th rowspan="2" width="20">No</th>
                <th rowspan="2" width="200">No. Surat Penugasan<br>Tgl Surat Penugasan</th>
                <th rowspan="2" width="200">Nama / NIP / Gol / Eselon</th>
                <th rowspan="2" align="center">Akun</th>
                <th width="200" rowspan="2"> Kota Tujuan</th>
                <th width="130" rowspan="2">Tanggal </th>
                <th rowspan="2">Lama </th>
                <th colspan="6"><center>Biaya</center></th>

            </tr>
            <tr>
                <th width="100">Transport </th>
                <th width="100">Taksi</th>
                <th width="100">Uang Harian</th>
                <th width="100" rowspan="1">Representatif </th>
                <th width="100" rowspan="1">Penginapan </th>
                <th width="100" rowspan="1">Jumlah </th>
            </tr>
             <?php
             $no = 1;
              $hitung = count($model2);
 			foreach ($models as $data) { 
 				$biaya = \backend\models\SimpelRincianBiaya::find()->where('personil_id=' . $data->id_personil . ' and kat_biaya_id in (1,2,4,8,6)')->all();
                $count = Yii::$app->db->createCommand("SELECT sum(jml) from simpel_rincian_biaya where personil_id='" . $data->id_personil . "'  and kat_biaya_id in (1,2,4,8,6) ")->queryScalar();
 				?>

                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="left">
                        <?= $data['no_sp'] ?><br>
                        <?= $data['tgl_penugasan'] ?>                    </td>
                    <?php
                    if ($data['pegawai_id']>0){ ?>
                    <td align="left">
                        <?= \common\components\HelperUnit::Pegawai($data['pegawai_id']) ?> <br/>
                        NIP. <?= $data->pegawai->nip ?><br/>
                        Gol. <?= MyHelper::Gole($data->pegawai->gol_id) ?><br/>
                        Eselon. <?= MyHelper::Eselon(MyHelper::Struk($data->pegawai->struk_id)) ?>
                    </td>
                    <?php }else{ ?>
                    <td>
                        <?= $data['nama']; ?><br/>
                        <?= $data['nip'] ?> <br/>
                        <?= $data['gol'] ?> <br/>
                        <?= $data['jab'] ?> <br/>
                        </td>
                    <?php  } ?>
                    <td width="80" align="center"><?= $data->keg->mak ?> </td>
                    <td align="center"><?= $data->keg->kotaTujuan->nama ?></td>
                    <td align="center"><?= substr($data->tgl_berangkat, 8, 2) ?>&nbsp;&nbsp;s/d&nbsp;&nbsp;<?= substr($data->tgl_kembali, 8, 2) ?> &nbsp; <?= MyHelper::BacaBulan(substr($data->tgl_kembali, 5, 2)) ?> <?= substr($data->tgl_kembali, 0, 4) ?></td>
                    <td align="center">
                        <?php
                        $pergi = substr($data->tgl_berangkat, 8, 2);
                        $pulang = substr($data->tgl_kembali, 8, 2);
                        $hitung = $pulang - $pergi + 1;
                        echo $hitung . '  Hari';
                        ?>
                    </td>
                    
                            <?php
                    if (!empty($biaya)) {
                        foreach ($biaya as $key) {
                            ?>

                            <td align="center">
                                <?php
                                if (!empty($key->jml)) {
                                    echo number_format($key->jml, 0, ",", ".");
                                } else {
                                    echo $key->jml;
                                }
                                ?>
                            </td>
                            <? }  }else{ 
                            for ($i=0; $i < 5; $i++) { ?>
                            <td align="center">-</td>
                        <?php } ?>





                    <?php } ?>



                    <td><?= number_format($count, 0, ",", "."); ?></td>


				</tr>
				      <?php
 if ($no < $hitung){

        echo "<pagebreak>";

    }
    $no++;
}

?>
 </tbody></table>
 <pagebreak/>
