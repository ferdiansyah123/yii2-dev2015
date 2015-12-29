 <?php
use yii\helpers\Html;
use common\components\MyHelper;
use common\components\HelperUnit;
?>   
 <?php
  $biaya = \backend\models\SimpelRincianBiaya::find()->where('personil_id=' . 
  $model['id_personil'] . ' and kat_biaya_id in (1,2,4,8,6)')->all();
  $count = Yii::$app->db->createCommand("SELECT sum(jml) from 
  simpel_rincian_biaya where personil_id='" . $$model->id_personil . "'  and
  kat_biaya_id in (1,2,4,8,6) ")->queryScalar();
?>
                <tr>
                    <td align="left">
                        <?= $model['no_sp'] ?><br/>
                        <?= $model['tgl_penugasan'] ?>
                    </td>
                   <td width="15%">
                        <?php 
                        if($model['pegawai_id']>0){ ?>
                            <?= HelperUnit::Pegawai($model['pegawai_id']) ?><br/>
                           NIP. <?= $model['pegawai_id'].'<br/>' ?>
                            <?= Myhelper::Gole(HelperUnit::Pegawais($model['pegawai_id'])->gol_id) ?><br/>
                            <?= Myhelper::Jab(HelperUnit::Pegawais($model['pegawai_id'])->struk_id) ?>
                            
                       <?php }else{
                            echo $model['nama'].'<br/>';
                            echo $model['nip'].'<br/>';
                            echo $model['gol'].'<br/>';
                            echo $model['jab'].'<br/>';
                        } ?>
                        
                        </td>

<td width="20%" align="center"><?= MyHelper::Kegs($model['id_kegiatan'])->mak ?> </td>
                <td align="center"><?= MyHelper::Kota($model['tujuan']) ?> <br/> <?= HelperUnit::Propinsis(HelperUnit::Kotas($model['tujuan'])->propinsi_id)->nama ?>  </td>
                    <td align="center"><?= substr($model['tgl_berangkat'], 8, 2) ?>&nbsp;&nbsp;s/d&nbsp;&nbsp;<?= substr($model['tgl_kembali'], 8, 2) ?> &nbsp; <?= MyHelper::BacaBulan(substr($model['tgl_kembali'], 5, 2)) ?> <?= substr($model['tgl_kembali'], 0, 4) ?></td>
                    <td align="center">
                        <?php
                        $pergi = substr($$model->tgl_berangkat, 8, 2);
                        $pulang = substr($$model->tgl_kembali, 8, 2);
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