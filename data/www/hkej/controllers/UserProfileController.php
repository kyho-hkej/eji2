<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UserIdentity;
use app\models\CurrentUser;
use yii\helpers\EjHelper;

Class UserprofileController extends Controller{

	public function actionUpdatesessionprofile() {
		
		$uuid = isset($_COOKIE['uuid'])? $_COOKIE['uuid']: ''; 
		if(isset($uuid)){

			$currentUser = new CurrentUser;
			$currentUser=CurrentUser::find()->where(['uuid' => $uuid])->one();

				if (isset($currentUser)) {
					if(!$currentUser->isExpired()){

						/* new handling to avoid blind SQL injection */

						$sql="SELECT user_id, login, password, firstname, lastname, forumname, enable, deleted, contact_email, createdate, member_type, agentname, case when hkej_member.subscribe_enddate < cast(now() as date) then 'Y' else 'N' end as expired from hkej_member WHERE login = '".$currentUser->login. "'  ";
						//$command = app()->dbMainsiteRemoteWeb->createCommand($sql);
						//$hkej_member = $command->queryRow();
					

						$hkej_member = Yii::$app->nejdb1->createCommand($sql)->queryOne();		



						if($hkej_member){
							//echo $hkej_member['user_id'];
							$hkej_member['subscriptions']=UserIdentity::getSubscriptions($hkej_member['user_id']);

						echo '<font color=#FFFFFF>ok</font>';
							//$hkej_member['subscriptions']=$identity->getExpiredSubscriptions($hkej_member['user_id']);

							//pr($hkej_member['subscriptions']);

						}
					}
				
				//return true;
			}else{
				//unset(Yii::$app->request->cookies['uuid']);
				$cookies = Yii::$app->response->cookies;
				unset($cookies['uuid']);
			}
		} else {
			echo '<font color=#FFFFFF>not login</font>';
		}

	}


	public function actionShowsessionprofile() {

		if(EjHelper::checkLogin()){
			$profile=Yii::$app->session->get('profile');
			//echo '<font color=#FFFFFF>ok</font>';
			echo '<pre>';
			print_r($profile);
			echo '</pre>';
		} else {
			echo '<font color=#FFFFFF>not login</font>';
		}

	}

	



}



?>