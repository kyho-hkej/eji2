<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class MonthlyController extends Controller
{
	public $meta_description='';
	public $meta_keywords='';
	public $title='';

	public function actionListing(){
		return $this->render('listing');
	}

	public function actionIndex(){

		return $this->render('index');
	}

	public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

		
		$this->title='信報網站 - 信報財經月刊 hkej.com - 信報網站 hkej.com';

		return parent::beforeAction($action);

	}
}



?>