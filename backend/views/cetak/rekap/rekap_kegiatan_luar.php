<?php
use yii\helpers\Html;
use common\components\MyHelper;
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
<h2 align="center">REKAPITULASI KEGIATAN PERJALANAN DINAS LUAR NEGERI</h2>
<h2 align="center" style="padding-top:-20px;"> <?php echo strtoupper(HelperUnit::unit($_GET['unit_id'])) ?> - <?php echo strtoupper(HelperUnit::unit($_GET['unit'])) ?></h2>
<h2 align="center" style="padding-top:-20px;"><?php echo MyHelper::Formattgl($_GET['tgl_mulai']) ?> s/d  <?php echo MyHelper::Formattgl($_GET['tgl_kembali']) ?></h2>
<table class="table table-responsive list table-bordered ">
    <tbody><tr>
        <th width="10" align="center" rowspan="3">No </th>
        <th align="center" rowspan="3" width="200">No. Surat Penugasan<br>Tgl Surat Penugasan</th>
        <th align="center" rowspan="3" width="200">Nama / NIP</th>
        <th rowspan="3" align="center">Pangkat/ Ruang. Gol</th>
        <th align="center" width="20" rowspan="3">Tujuan</th>
        <th align="center" width="100" rowspan="3">Tanggal <br>Berangkat <br> /kembali</th>
        <th rowspan="3" width="10">Lama Hari</th>
        <th align="center" colspan="7">Biaya</th>
    </tr>
    <tr>
        <th align="center" colspan="3" width="100">Transport </th>
        <th align="center" width="100" colspan="2" rowspan="2">Lumpsum </th>
        <th align="center" rowspan="2" colspan="2">Jumlah</th>
    </tr>
    <tr>
        <th align="center" width="100">Tiket</th>
        <th align="center" width="100">Asuransi</th>
        <th align="center" width="100">Airport tax </th>
    </tr>
    <?php
    $no = 1;
              $hitung = count($model2);
            foreach ($models as $model) {
$biaya = \backend\models\SimpelRincianBiaya::find()->where('personil_id=' . $model['id_personil'] . ' and kat_biaya_id in (1,2,4,8,6)')->all();
$count = Yii::$app->db->createCommand("SELECT sum(jml) from
        simpel_rincian_biaya where personil_id='" . $model->id_personil . "'  and
        kat_biaya_id in (1,2,4,8,6) ")->queryScalar();
?>
    <tr>
        <td align="center"><?= $no ?></td>
        <td width="10%" align="left">
            <?php echo $model['no_sp'] ?><br/>
            <?php echo MyHelper::Formattgl($model['tgl_penugasan']) ?>
        </td>
        <td width="15%">
            <?php
if ($model['pegawai_id'] > 0) { ?>
            <?php echo HelperUnit::Pegawai($model['pegawai_id']) ?><br/>
            NIP. <?php echo $model['pegawai_id'] . '<br/>' ?>
      
            <?php
} 
else {
    echo $model['nama'] . '<br/>';
    echo $model['nip'] . '<br/>';

} ?>
        </td>
        <td width="10%" align="center">
                      <?php
if ($model['pegawai_id'] > 0) { ?>
            <?php echo Myhelper::Gole(HelperUnit::Pegawais($model['pegawai_id'])->gol_id) ?><br/>
            <?php echo Myhelper::Jab(HelperUnit::Pegawais($model['pegawai_id'])->struk_id) ?>
            <?php
} 
else {

    echo $model['gol'] . '<br/>';
    echo $model['jab'] . '<br/>';
} ?>
        </td>
        <td align="center">
<?= HelperUnit::Negaras(MyHelper::Kegs($model['id_kegiatan'])->negara_tujuan) ?>
        </td>
        <td align="center"><?php echo substr($model['tgl_berangkat'], 8, 2) ?>&nbsp;&nbsp;s/d&nbsp;&nbsp;<?php echo substr($model['tgl_kembali'], 8, 2) ?> &nbsp; <?php echo MyHelper::BacaBulan(substr($model['tgl_kembali'], 5, 2)) ?> <?php echo substr($model['tgl_kembali'], 0, 4) ?></td>
        <td align="center">
            <?php
$pergi = substr($model->tgl_berangkat, 8, 2);
$pulang = substr($model->tgl_kembali, 8, 2);
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
        } 
        else {
            echo $key->jml;
        }
?>
        </td>
        <?php
    }
} 
else {
    for ($i = 0; $i < 5; $i++) { ?>
        <td align="center">-</td>
        <?php
    } ?>
        <?php
}
?>


        <td colspan="2"><?php echo number_format($count, 0, ",", "."); ?></td>
    </tr>
    <?php
$no++;
} ?>
</tbody>
</table>