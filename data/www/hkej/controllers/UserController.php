<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UserIdentity;
use yii\helpers\EjHelper;

Class UserController extends Controller{

	public function actionAddcurrentuser() {

        if (!$_POST['uuid'] || !$_POST['userId'] || !$_POST['login'])
        	 die;

		er('AddCurrentUser login: ' . $_POST['login'] . ' was added to current user');
		
    }

}

?>