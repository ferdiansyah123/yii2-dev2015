<?php

use yii\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Angkutan;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;


$this->title = Yii::t('app', 'Daftar Perjalanan Dinas');
$this->params['breadcrumbs'][] = $this->title;
?>
  <? 
 echo '&nbsp;&nbsp;'.Html::button('Tambah Perjalanan Dinas Dalam Negri', ['value' =>Url::to(['simpel-keg/tambah', 'id' => $model->id_kegiatan]), 'class' => 'modalButton btn btn-danger', 'title' => 'view dokumen']);
                    ?>
            <?php
        $buton = \backend\models\SimpelPersonil::find()->where('id_kegiatan=' . $model->id_kegiatan)->count();

if($buton > 0){ ?>

   <?= Html::a(Yii::t('app', 'Kirim Cetak'), ['ce', 'id' => $model->id_kegiatan], ['class' => 'btn btn-primary','data' => [
                            'confirm' => 'Apakah anda yakin pindah ke cetak?',
                            'method' => 'post',
                        ],]) ?>
<?php } ?>

<br/>
<br/>

            <!-- Main content -->
            <div class="box ">
                <div class="box-body" style="display: block;">
<table  style="width:100%;" border="3" class="table table-striped">
    <thead>
        <tr  style="background-color:#4e95f4;">
            <th width="2%" class="th">No.</th>
            <th width="33%">Data Personil</th>
            <th width="33%">Data Penugasan</th>
            <th width="27%">Pembiayaan Dalam Negri</th>
            <th width="5%">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $no = 1;
        $data = \backend\models\SimpelPersonil::find()->where('id_kegiatan=' . $model->id_kegiatan)->all();
        foreach ($data as $key) {
            ?>
            <tr class="item-row">
              <td valign="top"><center><span id="No"><?= $no ?></span></center></td>
                <td style="width:5%;" style="border-top: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                    <table style="width:80%;">
                        <tbody>
                            <?php 
                            if ($key->pegawai_id>0){ ?>

                          
                            <tr>
                                <td width="20%">Nama</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pegawai->nama_cetak; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pegawai->nip; ?></td>
                            </tr>
                            <tr>
                                <td>Gol</td>
                                <td valign="top">:</td>
                                <td><?php echo \common\components\MyHelper::Gole($key->pegawai->gol_id); ?> </td>
                            </tr>
                            <tr>
                                <td>Eselon</td>
                                <td valign="top">:</td>
                                <td><?php echo \common\components\MyHelper::Jab($key->pegawai->struk_id); ?></td>

                            </tr>

                        <?php   }else{ ?>
                            <tr>
                                <td width="20%">Nama</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->nama; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->nip; ?></td>
                            </tr>
                            <tr>
                                <td>Gol</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->gol; ?></td>
                            </tr>
                            <tr>
                                <td>Instansi</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->instansi; ?></td>

                            </tr>

                        <?php    } ?>
                        </tbody></table>
                </td>
                <td style="width:10%;">
                    <table style="width:100%">
                        <tbody><tr>
                                <td style="width:40%;">No. Surat Penugasan</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->no_sp; ?></td>
                            </tr>

                            <tr>
                                <td>No. SPD</td>
                                <td valign="top">:</td>
                                <td><?php echo $model->no_spd; ?></td>
                            </tr>

                                <tr>
                                <td>Angkutan</td>
                                <td valign="top">:</td>
                                <td><?php echo \common\components\MyHelper::Angkutan($key->angkutan); ?></td>
                            </tr>

                            <tr>
                                <td>Berangkat Dari</td>
                                <td valign="top">:</td>
                                <td><?php echo $model->kotaAsal->nama; ?></td>
                            </tr>
                            <tr>
                                <td>Tujuan</td>
                                <td valign="top">:</td>
                                <td> <?php echo $model->kotaTujuan->nama; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl Berangkat</td>
                                <td valign="top">:</td>
                                <td>(<?php echo $key->tgl_berangkat; ?>) - (<?php echo $key->tgl_kembali; ?>)</td>
                            </tr>
                         <?php 
                            if ($key->pegawai_id>0){ ?>

                             <tr>
                                <td>Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pej->nama; ?></td>
                            </tr>
                            <tr>
                                <td>NIP Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pej->nip; ?></td>
                            </tr>
                             <tr>
                                <td>Jab Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?php echo \common\components\MyHelper::Jab($key->pej->struk_id); ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah DL Hari Kerja</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->uang_makan; ?>  Hari</td>
                            </tr>
                            <?php   }else{ ?>
                            <tr>
                                <td>Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pnama; ?></td>
                            </tr>
                            <tr>
                                <td>NIP Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->pnip; ?></td>
                            </tr>
                             <tr>
                                <td>Jab Penandatangan</td>
                                <td valign="top">:</td>
                                <td><?= $key->pjab ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah DL Hari Kerja</td>
                                <td valign="top">:</td>
                                <td><?php echo $key->uang_makan; ?>  Hari</td>
                            </tr>
                            <?php    } ?>

                        </tbody></table>
            
                </td>
                <td style="width:9000%;">
                  <?php
                $data = \backend\models\SimpelRincianBiaya::find()->where('personil_id='.$key->id_personil.' and kat_biaya_id in(1,2,3,4,5,6,7,8,9,10) ')->all();
                ?>
                  <table style="width:100%">
                        <tbody>
                        <?php
                        foreach ($data as $rin) { ?>
                           <tr>
                                <td style="width:60%;"><?= $rin->biaya->nama ?></td>
                                <td valign="top">:</td>
                                <td>
                                Rp .<?php if (!empty($rin->kat_biaya_id)){
                                      echo number_format($rin->jml,0,'.','.');
                                   } else{
                                     echo  '<b> - </b>';
                                        } ?>
                                </td>
                            </tr>
                    
                      

                            <tr>
                                <td>Uraian <?= $rin->biaya->nama ?></td>
                                <td valign="top">:</td>
                                <td>
                                <?php if (!empty($rin->jml)){ ?>
                                     <span class="label label-success" data-toggle="popover" title="Detail <?= $rin->biaya->nama ?>" data-content="<?php echo $rin->uraian_rincian; ?>">detail</span>
                                  <?php } else{
                                     echo '<span class="label label-success"  title="<?= $rin->biaya->nama ?>" >detail kosong</span>';
                                        } ?>
                                </td>
                            </tr>
                             <?php   } ?>
                        </tbody></table>
                </td>
                <td align="center">
                    <br/><?=
                    Html::a('<img src="' . Url::to(['/images/delete.png']) . '" alt="Hapus" title="Hapus" width="25" height="25"/>', ['/simpel-personil/delete', 'id' => $key->id_personil], [
                        'class' => '',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?><br/><br/>
                    <?=
                    Html::button('<img src="' . Url::to(['/images/edit.png']) . '" alt="Edit" title="Edit" width="25" height="25"/>', ['value' =>
                        Url::to(['simpel-personil/edit', 'id' => $key->id_personil]), 'class' => 'modalButtonn ', 'title' => 'view dokumen'])
                    ?>

                </td>
            </tr> 
            <?                  
            $no++;
            }?>
        </tbody>

        <table width="100%">
            <tr><td colspan=4 align=center>
        

            </td></tr>
    </table>
</table>
</div>
</div>

 
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
<style type="text/css">
    .bs-example{
        margin: 150px 50px;
        width: 1300px;
    }
</style>
                                   
<style type="text/css">
    .bigModal{
        width:1300px;
    }
    .th{
        font-color:white;
    }
</style>