<?php
use yii\helpers\Html;
use common\components\MyHelper;
use common\components\HelperUnit;
?>   
                    <tr>
                        <td width="500">
                        <?php 
                        if($model['pegawai_id']>0){ ?>
                            <?= HelperUnit::Pegawai($model['pegawai_id']) ?>
                       <?php }else{
                            echo $model['nama'];
                        } ?>
                        </td>
                        <td align="center" width="300"><?= $model['nama_keg'] ?></td>

                        <td align="center" width="300"><?= MyHelper::Kota($model['tujuan']) ?></td>
                        <td align="center" width="300">
                       <?= $model['uang_makan'] ?>
                        </td>
                        <td align="center" width="300">
                        <?= substr($model['tgl_berangkat'], 8,2).' s/d '.substr($model['tgl_kembali'], 8,2).'  '.\common\components\MyHelper::BacaBulan(substr($model['tgl_berangkat'], 5,2)).'  '.substr($model['tgl_berangkat'], 0,4) ?>
                        </td>
                    </tr>
               