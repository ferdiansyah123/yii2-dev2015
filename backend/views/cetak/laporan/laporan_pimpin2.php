<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\components\MyHelper;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use \common\models\DaftarUnit;
use \common\components\HelperUnit;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Laporan Realisasi Per Unit Kerja');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    th{
        text-align: center;
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
        background-color: white;
        color:black;
    }
    .list tr.even td {
        background-color: #d6eaff;
    }
</style>
            <h4 align="center">LAPORAN REALISASI UNIT KERJA</h4>
            <h4 align="center" style="padding-top:-20px;"> <?= strtoupper(HelperUnit::unit($_GET['unit_id'])) ?> - <?= strtoupper(HelperUnit::unit($_GET['unit'])) ?></h4>
            <h4 align="center" style="padding-top:-20px;"><?= MyHelper::Formattgl($_GET['tgl_mulai']) ?> s/d  <?= MyHelper::Formattgl($_GET['tgl_kembali']) ?></h4>

          

            <table class="table list table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2"> No. </th>
                        <th rowspan="2"> UNIT KERJA /  MAK </th>
                        <th rowspan="2"> PAGU </th>
                        <th colspan="13"> R E A L I S A S I</th>
                        <th rowspan="2"> S I S A </th>
                        <th rowspan="2" 0=""> % </th>
                    </tr>
                    <tr>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <th><?= \common\components\MyHelper::BacaBulan($i) ?></th>
                        <?php } ?>
                        <th>Jumlah</th>
                    </tr>
                    <tr>
                        <?php for ($i = 1; $i <= 18; $i++) { ?>
                            <th><?= $i ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $un =Yii::$app->user->identity->unit_id;
                    $unit = \common\models\DaftarUnit::find()->where('unit_id in (' . $un . ')')->all();
                    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
                    ?>
                        <?php
                            $ese = $un;
                            $satker = DaftarUnit::find()->where(' unit_id in (' . $ese . ')')->all();
                        $n = 1;
                        foreach ($satker as $sat) {
                            $ese =  $sat->unit_id;
                            $hsl = Yii::$app->db->createCommand("SELECT 
                                      sum(alokasi_sub_mak) as total
                                     FROM v_pagu where  unit_id in(" . $ese . ")")->queryScalar();
                            
                            ?>
                            <tr >
                                <td align="left"><?= $n ?>.</td>
                                <td><?= \common\components\HelperUnit::unit($sat->unit_id) ?></td>
                                <td align="center"><?php
                                    $pag = HelperUnit::Pagu($sat->unit_id);
                                    $pagn = number_format(HelperUnit::Pagu($sat->unit_id), 0, ",", ".");
                                    echo $pagn;
                                    ?>   
                                </td>
                                <?php
                                for ($i = 1; $i < 13; $i++) {

                                    if ($i < 10) {
                                        $a = '0' . $i;
                                    } else {
                                        $a = $i;
                                    }
                                    $unit = $sat->unit_id;
                                    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
                                    $bln = $tahun . '-' . $a . '-';
                                    $sql = "SELECT sum(b.jml) FROM simpel_keg as a 
                                        LEFT JOIN simpel_rincian_biaya as b on a.id_kegiatan=b.id_kegiatan
                                        LEFT JOIN pegawai.daf_unit as c on a.unit_id=c.unit_id
                                        where a.status in (2,3,4) and a.tgl_mulai like '%" . $bln . "%' and c.unit_parent_id='" . $unit . "'";
                                    $nilaiReal = Yii::$app->db->createCommand($sql)->queryScalar();
                                    ?>
                                    <td><?php
                                        if ($nilaiReal > 0) {
                                            echo number_format($nilaiReal, 0, ",", ".");
                                        } else {
                                            echo '<center>-</center>';
                                        }
                                        ?></td>
                                <?php } ?>
                                <td> 
                                    <?php
                                    $re = HelperUnit::Real($sat->unit_id);
                                    $ren = number_format(HelperUnit::Real($sat->unit_id), 0, ",", ".");
                                    if ($ren > 0) {
                                        echo $ren;
                                    } else {
                                        echo '<center>-</center>';
                                    }
                                    ?>  
                                </td>
                                <td align="center"><?php echo number_format($hsl - $re, 0, ",", "."); ?> </td>
                                <td align="center"><?php 
                                if($pag>0){
                                 echo number_format(($re / $hsl) * 100, 2, ",", "."); 

                                }
                                 
                                 ?> %</td>
                                <?php
                                $n++;
                            }
                            ?>
                        </tr>

                           <?php
                            $ese = isset($_GET['unit_id']) ? $_GET['unit_id'] : $sat->unit_id;
                            if(!empty($_GET['unit_id'])){
                                $satk = DaftarUnit::find()->where(' unit_id in (' . $ese . ')')->all();
                            }else{
                                   $satk = DaftarUnit::find()->where(' unit_parent_id in (' . $sat->unit_id . ') and unit_id not in (131300)')->all();
                            }
                            $n = 1;
                        foreach ($satk as $sa) {

                            $ese = isset($_GET['unit_id']) ? $_GET['unit_id'] : $sa->unit_id;
                            $hsl = Yii::$app->db->createCommand("SELECT 
                                      sum(alokasi_sub_mak) as total
                                     FROM v_pagu where  unit_id3 in(" . $ese . ")")->queryScalar();
                            ?>

                            <tr >
                                <td align="right"><?= $n ?>.</td>
                                <td><?= \common\components\HelperUnit::unit($sa->unit_id) ?></td>
                                <td align="center"><?php
                                    $pag = HelperUnit::PaguPim($sa->unit_id);
                                    $pagn = number_format(HelperUnit::PaguPim($sa->unit_id), 0, ",", ".");
                                    echo $pagn;
                                    ?>   
                                </td>
                                     <?php
                                for ($i = 1; $i < 13; $i++) {

                                    if ($i < 10) {
                                        $a = '0' . $i;
                                    } else {
                                        $a = $i;
                                    }
                                    $unit = $sat->unit_id;
                                    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
                                    $bln = $tahun . '-' . $a . '-';
                                    $sql = "SELECT sum(b.jml) FROM simpel_keg as a 
                                        LEFT JOIN simpel_rincian_biaya as b on a.id_kegiatan=b.id_kegiatan
                                        where a.status in (2,3,4) and a.tgl_mulai like '%" . $bln . "%' and a.unit_id='" . $sa->unit_id . "'";
                                    $nilaiReal = Yii::$app->db->createCommand($sql)->queryScalar();
                                    // echo $unit;
                                    // die();
                                    ?>
                                    <td>
                                    <?php
                                        if ($nilaiReal > 0) {
                                            echo number_format($nilaiReal, 0, ",", ".");
                                        } else {
                                            echo '<center>-</center>';
                                        }
                                        ?></td>
                                    <?php } ?>
                                <td> 
                                    <?php
                                    $re = HelperUnit::RealEse($sa->unit_id);
                                    $ren = number_format(HelperUnit::RealEse($sa->unit_id), 0, ",", ".");
                                    if ($ren > 0) {
                                        echo $ren;
                                    } else {
                                        echo '<center>-</center>';
                                    }
                                    ?>
                                </td>
                                <td align="center"><?php echo number_format($pag-$re, 0, ",", "."); ?> </td>
                                <td align="center"><?php 
                                if(empty($pag)){
                                    echo "0";
                                }else{

                              echo number_format(($re/$pag)*100, 2, ",", ".");
                                }
                                    ?>
                            
                            <?php    
                                $n++;
                            }
                            ?>
                             %</td>
                        </tr>
                     
                </tbody>
            </table>
      