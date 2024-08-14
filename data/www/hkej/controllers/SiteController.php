<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception instanceof \yii\web\NotFoundHttpException) {
            // all non existing controllers+actions will end up here
            //return $this->render('pnf'); // page not found
            echo 'page not found';
        } else {
          return $this->render('error', ['exception' => $exception]);
        }
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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

    public function actionCreatepost()
    {
        /* API URL */
        $url = 'https://api.apialvos.com/article/v2/api/';
            
        /* Init cURL resource */
        $ch = curl_init($url);
            
        /* Array Parameter Data */
        //$data = ['name'=>'Hardik', 'email'=>'itsolutionstuff@gmail.com'];
        
        $json = Yii::getAlias('@app').'/assets/bd/create_article_16758.json';
        $strJsonFileContents = file_get_contents($json);
        $data = $strJsonFileContents;
       
            
        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
        /* set the content type json */
        $headers = [];
        $headers[] = 'Content-Type:application/json';
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImEwNDM4YWE2LWVkMTctNDVjOS1iZjRjLTU4MDRiNTI3NWFkMiIsImVtYWlsIjoia3kuaG9AYXBvaWRlYS5haSIsIm9yZ2FuaXphdGlvbiI6ImFwb2lkZWEiLCJzY29wZXMiOlsiYW5hbHlzaXM6dG9waWM6cHJvY2VzcyIsImFuYWx5c2lzOnRvcGljOnJlYWQiLCJhbmFseXNpczp3ZWNoYXQ6cmVhZCIsImFydGljbGU6YXBpOmVuZ3Bvc3QiLCJhcnRpY2xlOm1lZGlhOnVwbG9hZCIsImFydGljbGU6cG9zdDpyZWFkIiwiYXJ0aWNsZTpwb3N0OndyaXRlIiwiYXV0aDplZGl0OmFsbCIsImF1dGg6ZWRpdDpvcmciLCJhdXRoOmdsb2JhbDpyZWFkIiwiYXV0aDpnbG9iYWw6d3JpdGUiLCJhdXRoOmdyb3VwOnJlYWQiLCJhdXRoOmdyb3VwOndyaXRlIiwiYXV0aDpsb2NhbDpyZWFkIiwiYXV0aDpsb2NhbDp3cml0ZSIsImF1dGg6c2NvcGU6cmVhZCIsImF1dGg6c2NvcGU6d3JpdGUiLCJjbXM6dWk6bG9naW4iLCJjb250ZW50OmFwaTplbmduZXdzIiwiZGVtbzp1aTpsb2dpbiIsImVtYWlsOmVkbTpyZWFkIiwiZW1haWw6ZWRtOndyaXRlIiwiZW1haWw6bWFpbGNoaW1wOnNlbmQiLCJlbWFpbDptYWlsY2hpbXA6d3JpdGUiLCJlbWFpbDpzdWJzY3JpYmU6cmVhZCIsImVtYWlsOnN1YnNjcmliZXI6cmVhZCIsImVtYWlsOnN1YnNjcmlwdGlvbjpyZWFkIiwiZ2xvYmFsOmFwaTpyZWFkIiwiZ2xvYmFsOmN1c3RvbS1kYXRhLWNlbnRyZTpyZWFkIiwiZ2xvYmFsOmZvcnVtLWRldGFpbDpyZWFkIiwiZ2xvYmFsOmZvcnVtOnJlYWQiLCJnbG9iYWw6Zm9ydW1Nb25pdG9yU29jZ2VuOnJlYWQiLCJnbG9iYWw6cXVlZW4tc2VhcmNoOnJlYWQiLCJnbG9iYWw6c3VtbWFyeTpyZWFkIiwiZ2xvYmFsOnN1cGVyLWFjYzpyZWFkIiwibWVtYmVyc2hpcDphbGw6cmVhZCIsIm1lbWJlcnNoaXA6YWxsOndyaXRlIiwibmV3cy1zdW1tYXJ5OmNvbnRlbnQ6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6d3JpdGUiLCJuZXdzOmFwaTpyZWFkIiwicXVlZW46ZGVtbzpyZWFkIiwicXVwaXRhbDpwZGY6cmVhZCIsInN1cGVyYWNjOmNtczpjb250cm9sIiwidmlwOm5ld3M6cmVhZCIsInZpcDpzYW5kYm94OnJlYWQiXSwiaWRwIjoiZ29vZ2xlIiwiaWF0IjoxNjk0NDE4MjY3LCJleHAiOjE2OTQ2Nzc0Njd9.c6Mo4xABUyj1xJDVT9-1cQQW7Fd9g33zaPe1sL0FPIs";
        $headers[] = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        /* execute request */
        $result = curl_exec($ch);
             
        /* close cURL resource */
        curl_close($ch);       

        print_r ($result);

    }

    public function actionUpload()
    {   
        $target_dir = "/assets/xml_upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
        }
    }

    public function actionWpimport()
    {
        return $this->renderAjax('wpimport');
        //echo 'wp import page';
    }

    public function beforeAction($action)

    {   
         $this->layout = 'defaultLayout';
        //echo $action->id;
        /*

        if ($action->id == 'monthly') {
            $this->layout = 'ejmLayout';
        } else {
            $this->layout = 'mobLayout';
        }*/

        return parent::beforeAction($action);

    }

}
