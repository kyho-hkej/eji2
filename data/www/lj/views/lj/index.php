<?php 
$staticUrl = Yii::$app->params['ljstaticUrl'].'/web/';
$ejstaticUrl = Yii::$app->params['ejstaticUrl'];

echo $this->render('landing_feature_window',compact('slider_all'));?>