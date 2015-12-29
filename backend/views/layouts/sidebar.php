<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use hscstudio\mimin\components\Mimin;
use yii\widgets\Menu;
use kartik\sidenav\SideNav;
use hscstudio\mimin\models\AuthAssignment;

?>
<?= Html::csrfMetaTags() ?>
<div id="sidebar">
    <div class="sidebar-scroll">
        <div class="sidebar-content">
            <center>
            <a href="./index.php.html" class="sidebar-brand">
            <img src="<?= Url::to(['/images/ilham.png']) ?>" width="160px"/>
            </a>
            </center>
            <?php
                    
                        
                            $items = [
                                ['label' => 'Home', 'url' => ['/simpel/index/']],
                                ['label' => 'Home', 'url' => ['/simpel/pimpinan1/']],
                                ['label' => 'Home', 'url' => ['/simpel/pimpinan2/']],
                                ['label' => 'Home', 'url' => ['/simpel/user/']],

                                ['label' => 'Proses', 'url' => ['/simpel-keg/index/']],

                                ['label' => 'Rekapitulasi', 'url' => ['/simpel-rekap/index/']],
                                ['label' => 'Rekapitulasi', 'url' => ['/simpel-rekap/pimpinan/']],
                                ['label' => 'Rekapitulasi', 'url' => ['/simpel-rekap/pimd/']],
                                ['label' => 'Rekapitulasi', 'url' => ['/simpel-rekap/user/']],

                                ['label' => 'Laporan', 'url' => ['/simpel-laporan/index/']],
                                ['label' => 'Laporan', 'url' => ['/simpel-laporan/pimpinan/']],
                                ['label' => 'Laporan', 'url' => ['/simpel-laporan/pimd/']],
                                ['label' => 'Laporan', 'url' => ['/simpel-laporan/user/']],

                                ['label' => 'Referensi', 'url' => ['/tabel-sbu/index/']],

                                ['label' => 'Pengaturan', 'url' => ['/mimin/user/index/'], 'items' => [
                                    ['label' => 'Pagu Mak', 'url' => ['/simpel-pagu/index/']],
                                    ['label' => 'User', 'url' => ['/mimin/user/index/']],
                                    ['label' => 'User Group', 'url' => ['/mimin/role/index/']],
                                    // ['label' => 'Generator', 'url' => ['/mimin/route']],
                                
                                ]],
                               
                            ];
                            $items = Mimin::filterRouteMenu($items);
                            if(count($items)>0){
                                $menuItems[] = ['label' => 'Reporting', 'items' => $items];
                            }
                            echo SideNav::widget([
                                'options' => ['class' => 'sidebar-nav'],
                                'encodeLabels' => false, // set this to nav-tab to get tab-styled navigation
                                'items' => $items,
                            ]);
                        
            ?>
            <div class="sidebar-header">
                <span class="sidebar-header-options clearfix">
                <a href="javascript:void(0)" data-toggle="tooltip" title="Refresh"><i class="gi gi-refresh"></i></a>
                </span>
                <span class="sidebar-header-title">Activity</span>
                <br/>
                <br/>
                <br/>

                <center>Informasi Status Login</center>
                <font color="white">
                <br/>
                <table >
                    <tr>
                        <td height="30px">Login</td>
                        <td>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</td>
                        <td align="right"><?= ucwords(Yii::$app->user->identity->username) ?> &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                      <tr>
                        <td>User Level</td>
                        <td>&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</td>
                        <td align="right">
                            <?php
                              $roles = AuthAssignment::find()->where('user_id='.Yii::$app->user->id)->one();
                            echo ucwords($roles['item_name']);
                            ?>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                </table>
           
                </font>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(function () {
            startTime()
        }, 500);
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        ;  // add zero in front of numbers < 10
        return i;
    }

    
</script>