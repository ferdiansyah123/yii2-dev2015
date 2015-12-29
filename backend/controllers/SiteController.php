<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use \common\models\User;
use yii\helpers\Url;
use yii\data\Pagination;
use hscstudio\mimin\components\Mimin;
use hscstudio\mimin\models\AuthAssignment;
/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    
    public $layout = 'admin';

    //public $defaultAction = 'coba';
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','kosong', 'reset', 'error', 'coba'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'admin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        $this->layout = 'login';

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // public function actionAdmin() {
    //     return $this->render('index');
    // }

    public function actionAdmin() {

        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $dunit = Yii::$app->user->identity->unit_id;

        if ($dunit == '100000') {
            $count = \common\models\DaftarUnit::find()->where('unit_id in (110000,120000,130000,161100,151000)')->count();
            $unit = \common\models\DaftarUnit::find()->where('unit_id in (110000,120000,130000,161100,151000)');
        } else {

            $count = \common\models\DaftarUnit::find()->where('unit_id in (' . $dunit . ')')->count();
            $unit = \common\models\DaftarUnit::find()->where('unit_id in (' . $dunit . ')');
        }

        $pages = new Pagination(['totalCount' => $count]);
        $models = $unit->offset($pages->offset, $pages->pageSize = 100)
                ->limit($pages->limit)
                ->all();
        $realisasi = Yii::$app->db->createCommand("SELECT sum(jml) FROM `simpel_rincian_biaya` where id_kegiatan=4")->queryScalar();


        return $this->render('index', [

                    'pages' => $pages,
                    'unit' => $unit,
                    'realisasi' => $realisasi,
                    'models' => $models,
                    'dunit' => $dunit,
        ]);
    }

    public function actionIndex() {
        $this->redirect(['/simpel']);
        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $dunit = Yii::$app->user->identity->unit_id;



        return $this->render('pimpinan1', [

                    'dunit' => $dunit,
        ]);
    }

    public function actionLogin() {
        $this->layout = 'login';
        // if (!\Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $roles = AuthAssignment::find()->where('user_id='.Yii::$app->user->id)->one();
            switch ($roles['item_name']) {
                case 'Admin':
                    return $this->redirect(['/simpel/index']);
                    break;
                case 'kepala':
                    return $this->redirect(['/simpel/index']);
                    break;
                case 'pimpinan1':
                    return $this->redirect(['/simpel/pimpinan1']);
                    break;
                case 'pimpinan2':
                    return $this->redirect(['/simpel/pimpinan2']);
                    break;
                case 'user':
                    return $this->redirect(['/simpel/user']);
                    break;
                
            }
             
        } else {
            return $this->render('log', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {

        Yii::$app->user->logout();
        return $this->goHome();
    }

    //ilham fungsi reset password menambahkan tanggal 24 september 2015
    public function actionReset() {
        $this->layout = 'login';
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            if ($_POST['User']) {
                $model->attributes = $_POST['User'];
                $valid = $model->validate();

                if ($valid) {
                    $model = User::find()
                            ->where(['email' => $_POST['User']['email']])
                            ->one();
                    $str = date('ymdhis').'abcefg';
                    $potong = str_shuffle($str);
                    $random = $potong;
                    $model->setPassword($random);
                    $content = '
                    <center><img src="http://i.imgur.com/p5lHZXS.png"/></center><br/>
                    <h4 align="center">Badan Pengawas Tenaga Nuklir  ' . date('Y') . '</h4>
                    <hr/>
                    <p>Yth ' . $model->username . ',<br/>  
                    Dengan ini kami sampaikan password telah direset  sebagai berikut:<br/> 
                    Username : ' . $model->username . ' <br/>
                    Password :<b>' . $random . '</b><br/>
                    Mohon lakukan penggantian password Anda setelah melakukan login. <hr/>
                    <h5 align="center">Subbag Perjalanan Dinas Biro Umum BAPETEN  ' . date('Y') . '</h5><br/>';
                    Yii::$app->mailer->compose("@common/mail/layouts/html", ["content" => $content])
                            ->setTo($_POST['User']['email'])
                            ->setFrom([$_POST['User']['email'] => 'Aplikasi Simpel Bapeten'])
                            ->setSubject('Ubah Kata Sandi')
                            ->setTextBody($random)
                            ->send();
                    $model->save();
                    return $this->redirect(['/site/login']);
                }
            }
        }
        return $this->render('reset', [
                    'model' => $model
        ]);


    }

     public function actionKosong($data){
$this->layout = 'login';
            return $this->render('kosong', [ 
                'data'=>$data,
                  
        ]);

        }

}
