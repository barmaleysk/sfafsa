<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Tgusers;
use app\models\CategorySearch;
use app\models\TgusersSearch;
use app\models\TarqatForm;

use app\models\UploadForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TgusersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/tgusers/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTarqat()
    { 
         $model = new TarqatForm();

         $model2 = Tgusers::find();

                if (Yii::$app->request->isPost) {

                    $model->file = UploadedFile::getInstance($model, 'file');

                    if ($model->file) {    
                         

                       $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
                
                     
                       
                    }
            
                    $rasm = 'http://pizzacity.uz/uploads/'. $model->file->baseName . '.' . $model->file->extension;
                    $idlar = Tgusers::find()->all();
                    Yii::$app->session->setFlash('success', "Рассылка отправлено!");
                    foreach ($idlar as $key) {

                    // print_r($model->getErrors());die();
                    // $model->text= Yii::$app->request->post('text');
                    $url = "https://api.telegram.org/bot733884207:AAGOGXmUgcKlET1ludNSS5XBXXXKtI851pI/sendMessage?chat_id=$key->tgid&text=".$_POST['TarqatForm']['text'];
                    //echo $url; die;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    

                  
                    }
                                        foreach ($idlar as $key) {

                    // print_r($model->getErrors());die();
                    // $model->text= Yii::$app->request->post('text');
                    $url = "https://api.telegram.org/bot733884207:AAGOGXmUgcKlET1ludNSS5XBXXXKtI851pI/sendPhoto?chat_id=$key->tgid&photo=$rasm";
                    //echo $url; die;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    

                  
                    }
                    
                    
                   


                    
                }

                return $this->render('tarqat', ['model' => $model]);
    }
  

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
