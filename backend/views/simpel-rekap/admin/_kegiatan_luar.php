 <?php
use yii\helpers\Html;
use common\components\MyHelper;
use common\components\HelperUnit;
?>   
<style type="text/css">
    .td{
        text-align: center;
    }
</style>
        <tr>
            <td  width="15%">
               <?= $model['no_sp'] ?><br/>
               <?= $model['tgl_penugasan'] ?>
            </td>
          <td  width="15%">
                        <?php 
                        if($model['pegawai_id']>0){ ?>
                            <?= HelperUnit::Pegawai($model['pegawai_id']) ?><br/>
                           NIP. <?= $model['pegawai_id'].'<br/>' ?>
                           
                            
                       <?php }else{
                            echo $model['nama'].'<br/>';
                            echo $model['nip'].'<br/>';

                        } ?>
                        
                        </td>
            <td  width="80" align="center">
              <?php 
                        if($model['pegawai_id']>0){ ?>
                            <?= Myhelper::Gole(HelperUnit::Pegawais($model['pegawai_id'])->gol_id) ?><br/>
                            <?= Myhelper::Jab(HelperUnit::Pegawais($model['pegawai_id'])->struk_id) ?>
                            
                       <?php }else{
                         
                            echo $model['gol'].'<br/>';
                            echo $model['jab'].'<br/>';
                        } ?>
                        
            

             </td>
                <td align="center"><?= MyHelper::Negara($model['negara_tujuan']) ?> <br/> <?= $model['kota_negara'] ?>  </td>
                    <td align="center"><?= substr($model['tgl_berangkat'], 8, 2) ?>&nbsp;&nbsp;s/d&nbsp;&nbsp;<?= substr($model['tgl_kembali'], 8, 2) ?> &nbsp; <?= MyHelper::BacaBulan(substr($model['tgl_kembali'], 5, 2)) ?> <?= substr($model['tgl_kembali'], 0, 4) ?></td>
                    <td align="center">
                        <?php
                        $pergi = substr($model['tgl_berangkat'], 8, 2);
                        $pulang = substr($model['tgl_kembali'], 8, 2);
                        $hitung = $pulang - $pergi + 1;
                        echo $hitung . '  Hari';
                        ?>
                    </td>
          <?php
            $data = \backend\models\SimpelRincianBiaya::find()->where('personil_id='.$model['id_personil'].' and kat_biaya_id in(11,12,13) ')->all();
                foreach ($data as $key) { ?>
                     <td  align="center">
                        <?php
                        if (!empty($key['jml'])) {
                            echo 'Rp. ' . number_format($key['jml'], 0, ',', '.');
                        } else {
                            echo '-';
                        }
                        ?>
            </td>
             <?php   } ?>
             <td colspan="2" align="center">
                 Rp. <?php $lump = Yii::$app->db->createCommand("SELECT sum(jml) FROM simpel_rincian_biaya where personil_id='".$model['id_personil']."' and kat_biaya_id in (14,15,16)" )->queryScalar();
              echo number_format($lump, 0, ',', '.');
              ?>
             </td>
          
           

            <td  valign="justify" >
            <center>
            <font >Rp. <?php
             $count = Yii::$app->db->createCommand("SELECT sum(jml) FROM simpel_rincian_biaya where personil_id='".$model['id_personil']."' and kat_biaya_id in (11,12,13,14,15,16)" )->queryScalar();
              echo number_format($count, 0, ',', '.');
              ?></font>
              </center>
              </td>

        </tr>
       
    
       
  
    
