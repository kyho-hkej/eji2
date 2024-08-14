<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use app\models\Article;

$this->title = $name;


//Check if 404 Error
if (strpos($name, "#404") !== false){

$uri = strip_fbclid($_SERVER['REQUEST_URI']);

//echo $uri;

//if ($uri == '/tag/living') {
if (preg_match('#tag/living#', $uri)) {        
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji/category/living';

    } else if (preg_match('#category/hong-kong-2#', $uri)) {
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji/category/hongkong';

    } else if (preg_match('#tag/startup#', $uri)) {
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji/category/startups';
        
    } else if (preg_match('#tag/yam#', $uri)) {
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji/author/id/10812';

    //redirect author page
    } else if (preg_match('#author/wp#', $uri)) { 
        $uri = preg_replace('/[^0-9]/', '', $uri);
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji/author/id/'.$uri;

    } else if (preg_match('#/page/#', $uri)) {
        $uri = preg_replace('#/page/#', '?page=', $uri);
        $new_url='https://'.$_SERVER['SERVER_NAME'].'/eji'.$uri;
        $new_url = substr($new_url, 0, -1);

    //redirect article page    
    } else {

        //$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $url = 'https://'.$_SERVER['HTTP_HOST'].$uri;

        $basename = basename($url);

        $sql="SELECT article.id FROM eji.article WHERE publishDateLite >= '2015-01-01' and storySlug ='$basename'";  

        $results = Yii::$app->db->createCommand($sql)->queryOne();

            if($results){
                $article_id=$results['id'];
                $re_url = 'https://'.$_SERVER['SERVER_NAME'].'/eji/article/id/'.$article_id.'/'.$basename;

                //echo 'this will redirect to '. $re_url;
                ob_start();
                header('Location: '.$re_url);
                ob_end_flush();
                die();

                //echo $re_url;

            } else {
                //echo "0 results";
                $landing='https://'.$_SERVER['SERVER_NAME'].'?ref='.$_SERVER['REQUEST_URI'];
                ob_start();
                header('Location: '.$landing);
                ob_end_flush();
                die();
                
            }

    }
    
    ob_start();
    header('Location: '.$new_url);
    ob_end_flush();
    die();

} //Check if 404 Error


function strip_fbclid($url) {
        $patterns = array(
                '/(\?|&)fbclid=[^&]*$/' => '',
                '/\?fbclid=[^&]*&/' => '?',
                '/&fbclid=[^&]*&/' => '&'
        );

        $search = array_keys($patterns);
        $replace = array_values($patterns);

        return preg_replace($search, $replace, $url);
}
?>
<!--
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
-->
