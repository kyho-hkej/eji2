<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\EjHelper;
use app\models\Article;

class InfoController extends Controller
{
	public $catId='';
	
	public function actionAboutus() {
		$this->view->title = '信報網站 - 《信報》簡介';
		return $this->render('about_us');
	}

	public function actionContactus() {
		$this->view->title = '信報網站 - 聯絡信報';
		return $this->render('contact_us');
	}

	public function actionConferencecentre() {
		//$this->redirect('https://www2.hkej.com/landing/index');
		//$this->render('conference_centre');
		$this->view->title = '信報網站 - 信報會議中心租賃';
		return $this->render('conference_centre');
	}

	public function actionDisclaimer() {
		$this->view->title = '信報網站 - 免責聲明';
		return $this->render('disclaimer');
	}

	public function actionJobs() {
		//$sectionId=app()->params['section2id']['hkej_jobs'];
		$sectionId	= Yii::$app->params['section2id']['hkej_jobs'];
		$limit		= 20;
		$page		= isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$total		= 50;
		$range		= 360;

		$list =Article::findAllBySection($sectionId, $limit, $page, $total, $range);
		//pr($list);
		
		if ($list) {
			return $this->render('jobs', [
				'label' => '加入《信報》',
				'list' => $list,
			]);
			//echo $this->render('jobs', compact('list'));
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
	}

	public function actionJobsdetails_FINE($id) {
		$article = Article::findById($id);

		if ($article) {
			//$sectionIds = $article->getSection()->id;
			//$article=Article::findArticleById($id, $sectionIds);

			$this->view->title = '信報網站 - 加入《信報》';

			return $this->render('jobs_details', [
				'article' => $article
			]);
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
	}

	public function actionJobsdetails($id) {
		$article = Article::findById($id);

		if ($article) {
			$this->view->title = '信報網站 - 加入《信報》';

			return $this->render('jobs_details', [
				'article' => $article
			]);
		} else {
			throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
	}

	public function actionMemberprovision() {
		$this->view->title = '信報網站 - 服務條款';
		return $this->render('member_provision');
	}

	public function actionPrivacy() {
		$this->view->title = '信報網站 - 私隱條款';
		return $this->render('privacy');
	}

	public function actionShipping() {
		$this->render('shipping');
	}

	public function beforeAction($action) {
		$this->view->params['trackEvent'] = array(
                'category'=> 'HKEJ info',
                'action'=> 'Listing',
                'label'=> 'PSN:關於信報',
        );

		$this->layout = 'webLayout';
        return parent::beforeAction($action);
	}
}
?>