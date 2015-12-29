<?php
use yii\helpers\Html;
use common\components\MyHelper;
use common\components\HelperUnit;
?>   
                    <tr align="center">
                        <td align="left">
                        <?php 
                        if($model['pegawai_id']>0){ ?>
                        <?= \common\components\HelperUnit::Pegawai($model['pegawai_id']) ?>
                        <?= $model['pegawai_id'] ?>

                       <?php }else{
                            echo ucwords($model['nama']).'<br/>';
                            echo ucwords($model['nip']);
                        } ?>
                        </td>
                        <?php for ($i = 01; $i <= 31; $i++) { ?>
                            <td width="10">
                            <?php
                            $tahun = substr($model['tgl_berangkat'], 0,4);
                            $bln = substr($model['tgl_berangkat'],5,2);
                            if($i < 10){
                                $da = '0'.$i;
                            }elseif($i == 20){
                                $da = $i.'0';
                            }elseif($i == 30){
                                $da = $i.'0';
                            }else{
                                $da = $i;
                            }
                             $count = Yii::$app->db->createCommand("SELECT count(pegawai_id) from simpel_personil where pegawai_id=".$model['pegawai_id']." and tgl_berangkat='".$tahun.'-'.$bln.'-'.$da."' group by pegawai_id")->queryScalar();
                          
                            if($count > 0){ ?>
                                <span class="label label-success" data-toggle="popover" data-html="true" title="Detail Tujuan Keberangkatan"
                                 data-content="
                                 <?php 
                                $tgl = isset($_GET['tgl_mulai']) ?  $_GET['tgl_mulai'] : $model->tgl_berangkat;
                                if($model['pegawai_id']>0){
                                $sql = 'pegawai_id='.$model['pegawai_id'].' and id_kegiatan';
                                }else{
                                    $sql = 'nip='.$model['nip'].' and id_kegiatan';
                                }
                                $data = \backend\models\SimpelPersonil::find()->where($sql)->all();
                                 foreach ($data as $value) {
                                    echo '<b>'.$value->keg->kotaTujuan->nama.'</b> ';
                                        echo '<br/>';
                                        echo $value->keg->nama_keg;
                                        echo "<br/>";
                                        echo "<br/>";
                                 }

                                  ?>"><?= count($data).'x' ?></span>
                           <?php }else{
                                echo "";
                            }
                           
                             ?>

                            </td>

                        <?php } ?>


                    </tr>
                    <center>
              
                </center>
