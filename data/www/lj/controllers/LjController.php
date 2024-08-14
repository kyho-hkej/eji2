<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

class LjController extends Controller
{

	/**
     * {@inheritdoc}
     */

    public function actionIndex()
    {
        return $this->render('index');
    }


	public function actionFashion(){
		return $this->render('listing');
	}


    public function actionArtculture(){
        echo 'art and culture';
        //return $this->render('listing');
    }
}

?>