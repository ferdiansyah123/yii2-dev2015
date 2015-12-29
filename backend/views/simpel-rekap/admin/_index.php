<?php
use yii\helpers\Html;
use common\components\MyHelper;
use common\components\HelperUnit;
?>   
                <?php if($_GET){ ?>
              
                    <tr>
                        <td width="10%">
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
                        <td align="center" width="40%"><?= MyHelper::Keg($model['id_kegiatan']) ?></td>
                       
                        <td align="center" width="5%">
                        <?= substr($model['tgl_berangkat'], 8,2).' s/d '.substr($model['tgl_kembali'], 8,2).'  '.\common\components\MyHelper::BacaBulan(substr($model['tgl_berangkat'], 5,2)).'  '.substr($model['tgl_berangkat'], 0,4) ?>
                         <td align="center" width="5%">
                       <?= $model['uang_makan'] ?>
                        </td
                        </td>
                        <td align="center" width="10%"><?= MyHelper::Kota($model['tujuan']) ?></td>

                    </tr>
                  
               
                 
                <?php }?>
                
            
