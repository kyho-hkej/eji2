<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;


class TestController extends Controller
{

  public $img_path = 'https://media.apoidea.ai/beauty-digest/wp-images/';
  //'https://i0.wp.com/beautydigest.io/wp-content/uploads/';

  public function actionShowcategory()
  {
     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /* API URL */
        $url = 'https://api.apialvos.com/article/v2/category?product=beauty-digest&offset=0&limit=50';
  
       $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImEwNDM4YWE2LWVkMTctNDVjOS1iZjRjLTU4MDRiNTI3NWFkMiIsImVtYWlsIjoia3kuaG9AYXBvaWRlYS5haSIsIm9yZ2FuaXphdGlvbiI6ImFwb2lkZWEiLCJzY29wZXMiOlsiYW5hbHlzaXM6dG9waWM6cHJvY2VzcyIsImFuYWx5c2lzOnRvcGljOnJlYWQiLCJhbmFseXNpczp3ZWNoYXQ6cmVhZCIsImFydGljbGU6YXBpOmVuZ3Bvc3QiLCJhcnRpY2xlOm1lZGlhOnVwbG9hZCIsImFydGljbGU6cG9zdDpyZWFkIiwiYXJ0aWNsZTpwb3N0OndyaXRlIiwiYXV0aDplZGl0OmFsbCIsImF1dGg6ZWRpdDpvcmciLCJhdXRoOmdsb2JhbDpyZWFkIiwiYXV0aDpnbG9iYWw6d3JpdGUiLCJhdXRoOmdyb3VwOnJlYWQiLCJhdXRoOmdyb3VwOndyaXRlIiwiYXV0aDpsb2NhbDpyZWFkIiwiYXV0aDpsb2NhbDp3cml0ZSIsImF1dGg6c2NvcGU6cmVhZCIsImF1dGg6c2NvcGU6d3JpdGUiLCJjbXM6dWk6bG9naW4iLCJjb250ZW50OmFwaTplbmduZXdzIiwiZGVtbzp1aTpsb2dpbiIsImVtYWlsOmVkbTpyZWFkIiwiZW1haWw6ZWRtOndyaXRlIiwiZW1haWw6bWFpbGNoaW1wOnNlbmQiLCJlbWFpbDptYWlsY2hpbXA6d3JpdGUiLCJlbWFpbDpzdWJzY3JpYmU6cmVhZCIsImVtYWlsOnN1YnNjcmliZXI6cmVhZCIsImVtYWlsOnN1YnNjcmlwdGlvbjpyZWFkIiwiZ2xvYmFsOmFwaTpyZWFkIiwiZ2xvYmFsOmN1c3RvbS1kYXRhLWNlbnRyZTpyZWFkIiwiZ2xvYmFsOmZvcnVtLWRldGFpbDpyZWFkIiwiZ2xvYmFsOmZvcnVtOnJlYWQiLCJnbG9iYWw6Zm9ydW1Nb25pdG9yU29jZ2VuOnJlYWQiLCJnbG9iYWw6cXVlZW4tc2VhcmNoOnJlYWQiLCJnbG9iYWw6c3VtbWFyeTpyZWFkIiwiZ2xvYmFsOnN1cGVyLWFjYzpyZWFkIiwibWVtYmVyc2hpcDphbGw6cmVhZCIsIm1lbWJlcnNoaXA6YWxsOndyaXRlIiwibmV3cy1zdW1tYXJ5OmNvbnRlbnQ6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6d3JpdGUiLCJuZXdzOmFwaTpyZWFkIiwicXVlZW46ZGVtbzpyZWFkIiwicXVwaXRhbDpwZGY6cmVhZCIsInN1cGVyYWNjOmNtczpjb250cm9sIiwidmlwOm5ld3M6cmVhZCIsInZpcDpzYW5kYm94OnJlYWQiXSwiaWRwIjoiZ29vZ2xlIiwiaWF0IjoxNjk0NDE4MjY3LCJleHAiOjE2OTQ2Nzc0Njd9.c6Mo4xABUyj1xJDVT9-1cQQW7Fd9g33zaPe1sL0FPIs";

        /* Init cURL resource */
        $ch = curl_init();
            
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Bearer '.$token,
         'accept: application/json',
         'content-type: application/json',
         'product-id: apoidea-internal'
         ));

         curl_setopt($ch, CURLOPT_URL, $url);
         //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         /* set return type json */
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         
         /* pass encoded JSON string to the POST fields */
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        /* execute request */
        $result = curl_exec($ch);
        //print_r(($result));
        /* close cURL source */
        curl_close($ch);       

        return $result;

  }

 public function actionReadjson()
    {
        //$folder_path = Yii::getAlias('@app').'/assets/bd/output/20231004/*.json';
        $folder_path = Yii::getAlias('@app').'/assets/bd/output/20231004/archive/bd_1656.json';

        foreach(glob($folder_path) as $file)
        {

          /* Init cURL resource */
          $ch = curl_init();

          $json = $file;   

          $strJsonFileContents = file_get_contents($json);
          $jsonData = json_decode($strJsonFileContents, true);

          $old_id = basename($file, ".json").PHP_EOL;
          $old_id = str_replace('bd_', ' ', $old_id);
          $articleUrl=$jsonData['articleUrl'];
          $catId=$jsonData['categoryId'];
          echo $old_id.','.$catId.','.$articleUrl;
         }
    }

 public function actionCreatearticle()
    {

     // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /* API URL */
        //$url = 'https://api.apialvos.com/article/v2/post/';
        $url = 'https://api.apoideamedia.io/article/v2/post';

        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjIxZTM3MTJmLTgyYmQtNDExNi05MDIzLWIzMzIwOTVmZjNhZSIsImVtYWlsIjoia3kuaG9AYXBvaWRlYS5haSIsIm9yZ2FuaXphdGlvbiI6ImFwb2lkZWEiLCJzY29wZXMiOlsiYW5hbHlzaXM6dG9waWM6cHJvY2VzcyIsImFuYWx5c2lzOnRvcGljOnJlYWQiLCJhbmFseXNpczp3ZWNoYXQ6cmVhZCIsImFydGljbGU6YXBpOmVuZ3Bvc3QiLCJhcnRpY2xlOm1lZGlhOnVwbG9hZCIsImFydGljbGU6cG9zdDpyZWFkIiwiYXJ0aWNsZTpwb3N0OndyaXRlIiwiYXV0aDplZGl0OmFsbCIsImF1dGg6ZWRpdDpvcmciLCJhdXRoOmdsb2JhbDpyZWFkIiwiYXV0aDpnbG9iYWw6d3JpdGUiLCJhdXRoOmdyb3VwOnJlYWQiLCJhdXRoOmdyb3VwOndyaXRlIiwiYXV0aDpsb2NhbDpyZWFkIiwiYXV0aDpsb2NhbDp3cml0ZSIsImF1dGg6c2NvcGU6cmVhZCIsImF1dGg6c2NvcGU6d3JpdGUiLCJjbXM6dWk6bG9naW4iLCJjb250ZW50OmFwaTplbmduZXdzIiwiZGVtbzp1aTpsb2dpbiIsImVtYWlsOmVkbTpyZWFkIiwiZW1haWw6ZWRtOndyaXRlIiwiZW1haWw6bWFpbGNoaW1wOnNlbmQiLCJlbWFpbDptYWlsY2hpbXA6d3JpdGUiLCJlbWFpbDpzdWJzY3JpYmU6cmVhZCIsImVtYWlsOnN1YnNjcmliZXI6cmVhZCIsImVtYWlsOnN1YnNjcmlwdGlvbjpyZWFkIiwiZ2xvYmFsOmFwaTpyZWFkIiwiZ2xvYmFsOmN1c3RvbS1kYXRhLWNlbnRyZTpyZWFkIiwiZ2xvYmFsOmZvcnVtLWRldGFpbDpyZWFkIiwiZ2xvYmFsOmZvcnVtOnJlYWQiLCJnbG9iYWw6Zm9ydW1Nb25pdG9yU29jZ2VuOnJlYWQiLCJnbG9iYWw6cXVlZW4tc2VhcmNoOnJlYWQiLCJnbG9iYWw6c3VtbWFyeTpyZWFkIiwiZ2xvYmFsOnN1cGVyLWFjYzpyZWFkIiwibWVtYmVyc2hpcDphbGw6cmVhZCIsIm1lbWJlcnNoaXA6YWxsOndyaXRlIiwibmV3cy1zdW1tYXJ5OmNvbnRlbnQ6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6d3JpdGUiLCJuZXdzOmFwaTpyZWFkIiwicXVlZW46ZGVtbzpyZWFkIiwicXVwaXRhbDpwZGY6cmVhZCIsInN1cGVyYWNjOmNtczpjb250cm9sIiwidmlwOm5ld3M6cmVhZCIsInZpcDpzYW5kYm94OnJlYWQiXSwiaWRwIjoiZ29vZ2xlIiwiaWF0IjoxNjk5NDM3ODQwLCJleHAiOjE2OTk2OTcwNDB9.6cWflYnfs5vV2BfcyC2foFpYPL3FgguSvnGjjQJQjgM";
            

            
        /* Array Parameter Data */
        //$data = ['name'=>'Hardik', 'email'=>'itsolutionstuff@gmail.com'];
        
        $folder_path = Yii::getAlias('@app').'/assets/bd/output/20231109/27/*.json';

        foreach(glob($folder_path) as $file)
        {

          /* Init cURL resource */
          $ch = curl_init();

          $json = $file;   
         
//echo $file." - ";
        //$json = 'http://dev-mobile.hkej.com/test/genarticlejson';
        //$json = 'http://dev-mobile.hkej.com/assets/bd/create_article_16758.json';
        //$json = Yii::getAlias('@app').'/assets/bd/output/bd_21845.json';
        $strJsonFileContents = file_get_contents($json);
        $data = $strJsonFileContents;

          //for logging
          $jsonData = json_decode($strJsonFileContents, true);
          $old_id = basename($file, ".json");
          $old_id = str_replace('bd_','', $old_id);
          $articleUrl=$jsonData['articleUrl'];
          $catId=$jsonData['categoryId'];

        
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Bearer '.$token,
         'accept: application/json',
         'content-type: application/json',
         'product-id: apoidea-internal'
         ));
        
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         /* set return type json */
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         
         /* pass encoded JSON string to the POST fields */
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
        /* execute request */
        $result = curl_exec($ch);
        $logResult = $old_id.','.$result.','.$catId.','.$articleUrl;

        print_r($logResult.'<p>');
        curl_close($ch); /* close cURL source */

        $fp = fopen(Yii::getAlias('@app').'/assets/bd/output/20231109/log/'.'res_log.txt', 'a') or die("Unable to open file!");
        $result="\n".$logResult;
        fwrite($fp, $result);
        fclose($fp);
        //move_uploaded_file($folder_path, Yii::getAlias('@app').'/assets/bd/output/20231019/archive/');
        rename($file, Yii::getAlias('@app').'/assets/bd/output/20231109/archive/'.basename($file));
        }
        
        return $result;
    }

   public function actionCreatecat()
    {

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /* API URL */
        //$url = 'https://api.apialvos.com/article/v2/api/';
        $url = 'https://api.apialvos.com/article/v2/category';

        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImEwNDM4YWE2LWVkMTctNDVjOS1iZjRjLTU4MDRiNTI3NWFkMiIsImVtYWlsIjoia3kuaG9AYXBvaWRlYS5haSIsIm9yZ2FuaXphdGlvbiI6ImFwb2lkZWEiLCJzY29wZXMiOlsiYW5hbHlzaXM6dG9waWM6cHJvY2VzcyIsImFuYWx5c2lzOnRvcGljOnJlYWQiLCJhbmFseXNpczp3ZWNoYXQ6cmVhZCIsImFydGljbGU6YXBpOmVuZ3Bvc3QiLCJhcnRpY2xlOm1lZGlhOnVwbG9hZCIsImFydGljbGU6cG9zdDpyZWFkIiwiYXJ0aWNsZTpwb3N0OndyaXRlIiwiYXV0aDplZGl0OmFsbCIsImF1dGg6ZWRpdDpvcmciLCJhdXRoOmdsb2JhbDpyZWFkIiwiYXV0aDpnbG9iYWw6d3JpdGUiLCJhdXRoOmdyb3VwOnJlYWQiLCJhdXRoOmdyb3VwOndyaXRlIiwiYXV0aDpsb2NhbDpyZWFkIiwiYXV0aDpsb2NhbDp3cml0ZSIsImF1dGg6c2NvcGU6cmVhZCIsImF1dGg6c2NvcGU6d3JpdGUiLCJjbXM6dWk6bG9naW4iLCJjb250ZW50OmFwaTplbmduZXdzIiwiZGVtbzp1aTpsb2dpbiIsImVtYWlsOmVkbTpyZWFkIiwiZW1haWw6ZWRtOndyaXRlIiwiZW1haWw6bWFpbGNoaW1wOnNlbmQiLCJlbWFpbDptYWlsY2hpbXA6d3JpdGUiLCJlbWFpbDpzdWJzY3JpYmU6cmVhZCIsImVtYWlsOnN1YnNjcmliZXI6cmVhZCIsImVtYWlsOnN1YnNjcmlwdGlvbjpyZWFkIiwiZ2xvYmFsOmFwaTpyZWFkIiwiZ2xvYmFsOmN1c3RvbS1kYXRhLWNlbnRyZTpyZWFkIiwiZ2xvYmFsOmZvcnVtLWRldGFpbDpyZWFkIiwiZ2xvYmFsOmZvcnVtOnJlYWQiLCJnbG9iYWw6Zm9ydW1Nb25pdG9yU29jZ2VuOnJlYWQiLCJnbG9iYWw6cXVlZW4tc2VhcmNoOnJlYWQiLCJnbG9iYWw6c3VtbWFyeTpyZWFkIiwiZ2xvYmFsOnN1cGVyLWFjYzpyZWFkIiwibWVtYmVyc2hpcDphbGw6cmVhZCIsIm1lbWJlcnNoaXA6YWxsOndyaXRlIiwibmV3cy1zdW1tYXJ5OmNvbnRlbnQ6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6d3JpdGUiLCJuZXdzOmFwaTpyZWFkIiwicXVlZW46ZGVtbzpyZWFkIiwicXVwaXRhbDpwZGY6cmVhZCIsInN1cGVyYWNjOmNtczpjb250cm9sIiwidmlwOm5ld3M6cmVhZCIsInZpcDpzYW5kYm94OnJlYWQiXSwiaWRwIjoiZ29vZ2xlIiwiaWF0IjoxNjk0NDE4MjY3LCJleHAiOjE2OTQ2Nzc0Njd9.c6Mo4xABUyj1xJDVT9-1cQQW7Fd9g33zaPe1sL0FPIs";
            
        /* Init cURL resource */
        $ch = curl_init();
            
        /* Array Parameter Data */
        //$data = ['name'=>'Hardik', 'email'=>'itsolutionstuff@gmail.com'];
        
        $json = Yii::getAlias('@app').'/assets/bd/create_category.json';

        //$json = 'http://dev-mobile.hkej.com/assets/bd/create_article_16758.json';
        $strJsonFileContents = file_get_contents($json);
        $data = $strJsonFileContents;

        //$data2 = '{"categoryName":"test-cat-011","description":"testing category 011"}';
         //print_r($data);
        /* set the content type json */

         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Bearer '.$token,
         'accept: application/json',
         'content-type: application/json',
         'product-id: apoidea-internal'
         ));

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         /* set return type json */
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         
         /* pass encoded JSON string to the POST fields */
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        /* execute request */
        $result = curl_exec($ch);
        //print_r(($result));
        /* close cURL source */
        curl_close($ch);       


        $fp = fopen($path.'res_log.txt', 'a') or die("Unable to open file!");
        fwrite($fp, $result);
        fclose($fp);

        return $result;

    }


  public function actionCreatetag()
    {

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /* API URL */
        //$url = 'https://api.apialvos.com/article/v2/api/';
        $url = 'https://api.apialvos.com/article/v2/tag';

        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImEwNDM4YWE2LWVkMTctNDVjOS1iZjRjLTU4MDRiNTI3NWFkMiIsImVtYWlsIjoia3kuaG9AYXBvaWRlYS5haSIsIm9yZ2FuaXphdGlvbiI6ImFwb2lkZWEiLCJzY29wZXMiOlsiYW5hbHlzaXM6dG9waWM6cHJvY2VzcyIsImFuYWx5c2lzOnRvcGljOnJlYWQiLCJhbmFseXNpczp3ZWNoYXQ6cmVhZCIsImFydGljbGU6YXBpOmVuZ3Bvc3QiLCJhcnRpY2xlOm1lZGlhOnVwbG9hZCIsImFydGljbGU6cG9zdDpyZWFkIiwiYXJ0aWNsZTpwb3N0OndyaXRlIiwiYXV0aDplZGl0OmFsbCIsImF1dGg6ZWRpdDpvcmciLCJhdXRoOmdsb2JhbDpyZWFkIiwiYXV0aDpnbG9iYWw6d3JpdGUiLCJhdXRoOmdyb3VwOnJlYWQiLCJhdXRoOmdyb3VwOndyaXRlIiwiYXV0aDpsb2NhbDpyZWFkIiwiYXV0aDpsb2NhbDp3cml0ZSIsImF1dGg6c2NvcGU6cmVhZCIsImF1dGg6c2NvcGU6d3JpdGUiLCJjbXM6dWk6bG9naW4iLCJjb250ZW50OmFwaTplbmduZXdzIiwiZGVtbzp1aTpsb2dpbiIsImVtYWlsOmVkbTpyZWFkIiwiZW1haWw6ZWRtOndyaXRlIiwiZW1haWw6bWFpbGNoaW1wOnNlbmQiLCJlbWFpbDptYWlsY2hpbXA6d3JpdGUiLCJlbWFpbDpzdWJzY3JpYmU6cmVhZCIsImVtYWlsOnN1YnNjcmliZXI6cmVhZCIsImVtYWlsOnN1YnNjcmlwdGlvbjpyZWFkIiwiZ2xvYmFsOmFwaTpyZWFkIiwiZ2xvYmFsOmN1c3RvbS1kYXRhLWNlbnRyZTpyZWFkIiwiZ2xvYmFsOmZvcnVtLWRldGFpbDpyZWFkIiwiZ2xvYmFsOmZvcnVtOnJlYWQiLCJnbG9iYWw6Zm9ydW1Nb25pdG9yU29jZ2VuOnJlYWQiLCJnbG9iYWw6cXVlZW4tc2VhcmNoOnJlYWQiLCJnbG9iYWw6c3VtbWFyeTpyZWFkIiwiZ2xvYmFsOnN1cGVyLWFjYzpyZWFkIiwibWVtYmVyc2hpcDphbGw6cmVhZCIsIm1lbWJlcnNoaXA6YWxsOndyaXRlIiwibmV3cy1zdW1tYXJ5OmNvbnRlbnQ6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6cmVhZCIsIm5ld3Mtc3VtbWFyeTpkZXRhaWw6d3JpdGUiLCJuZXdzOmFwaTpyZWFkIiwicXVlZW46ZGVtbzpyZWFkIiwicXVwaXRhbDpwZGY6cmVhZCIsInN1cGVyYWNjOmNtczpjb250cm9sIiwidmlwOm5ld3M6cmVhZCIsInZpcDpzYW5kYm94OnJlYWQiXSwiaWRwIjoiZ29vZ2xlIiwiaWF0IjoxNjk0NjgwNTk4LCJleHAiOjE2OTQ5Mzk3OTh9.g8C35wfSAIs3byPApV9sGAzBf-J7y4MYNsg1LBxFZF4";
            
        /* Init cURL resource */
        $ch = curl_init();
            
        /* Array Parameter Data */
        //$data = ['name'=>'Hardik', 'email'=>'itsolutionstuff@gmail.com'];
        
        $json = Yii::getAlias('@app').'/assets/bd/1.json';

        //$json = 'http://dev-mobile.hkej.com/assets/bd/create_article_16758.json';
        $strJsonFileContents = file_get_contents($json);
        $data = $strJsonFileContents;

        //$data2 = '{"categoryName":"test-cat-011","description":"testing category 011"}';
         //print_r($data);
        /* set the content type json */

         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Bearer '.$token,
         'accept: application/json',
         'content-type: application/json',
         'product-id: apoidea-internal'
         ));

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         /* set return type json */
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         
         /* pass encoded JSON string to the POST fields */
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        /* execute request */
        $result = curl_exec($ch);
        //print_r(($result));
        /* close cURL source */
        curl_close($ch);       

        return $result;

    }

    public function actionGenarticlejsonfile(){

      $start_id = $_REQUEST['start'];
      $end_id = $_REQUEST['end'];

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $json = array();

      //$file = Yii::$app->params['cache_path'] .'instantnewsWeb/instantnews_7days.json';

      $path = Yii::getAlias('@app').'/assets/bd/output/20231109/1/';

      $sqlData=" SELECT a.ID, a.post_title as title, 
        a.post_excerpt as excerpt, 
        b.user_nicename as author,
        a.post_date as publishedAt,
        a.post_content as articleContents, 
        a.post_name as articleUrl 
        FROM wp_posts a, wp_users b where a.post_author=b.ID and a.post_status='publish' and b.user_nicename != 'user' 
        and  (a.ID >=".$start_id." and  a.ID <= ".$end_id.") and a.ID != '3038' order by a.ID asc";
  
        $sqlData2=" SELECT a.ID, a.post_title as title, 
        a.post_excerpt as excerpt, 
        b.user_nicename as author,
        a.post_date as publishedAt,
        a.post_content as articleContents, 
        a.post_name as articleUrl 
        FROM wp_posts a, wp_users b where a.post_author=b.ID and a.post_status='publish' and b.user_nicename != 'user' 
        and  a.post_date > '2023-09-29 00:00:00' and a.ID != '3038' order by a.ID asc";   

        $command=Yii::$app->dbpremium_dev->createCommand($sqlData);
        //echo $command->sql;
        $rows = $command->queryAll();
        
        foreach ($rows as $r) {

          if ($r['author']!='user') {
              $tagData="SELECT name from v_article2posttag WHERE object_id =".$r['ID'].""; 
              $command2=Yii::$app->dbpremium_dev->createCommand($tagData);
              $tag_ary = $command2->queryAll();
              $tags = ArrayHelper::getColumn($tag_ary, 'name');
              
              //merge submenu tags
              $submenuTag = $this->findtag2submenu($r['ID']);
              if ($submenuTag) {
                 $tags = array_merge($tags, $submenuTag);
              } else {
                $tags = $tags;
              }

             
              //$r['publishedAt']=strtotime($r['publishedAt']);

              $tmp['title'] = $r['title'];
              if ($r['excerpt']){
                  $excerpt = $r['excerpt'].'...';;
              } else {
                  $excerpt = mb_substr($this->actionConvert1stblocks($r['ID']), 0, 250).'...';
              }
              //$tmp['excerpt'] = $r['excerpt'];
  
              $tmp['excerpt'] = $excerpt;
              $tmp['rss'] = 'false';
              $tmp['featured'] = 'false';
              $tmp['author'] = $r['author'];
              $tmp['authorId'] = '';
              $tmp['publishedAt'] = strtotime($r['publishedAt'])*1000;

              $coverImage = $this->img_path.$this->getcoverimg($r['ID']);
              $tmp['coverImage'] = $coverImage;

              $tmp['coverImageMeta'] = '{"width":614,"height":345}';
              $tmp['coverImageAltTag'] = $r['title'];
              $tmp['articleContents'] = $this->actionConvertcontents($r['ID']);
              //['{"order":1,"contentType":"text.content","contentBody":"<p>testing md</p>\n"}'];
              $tmp['language'] = 'zh-cht';
              //$tmp['post_name'] = urldecode($r['articleUrl']);
              $tmp['articleUrl'] = $this->chineseSymbols(urldecode($r['articleUrl']));
              $tmp['productArticles'] = ['beauty-digest'];
              $tmp['previewType'] = 'normal';
              $tmp['seoField'] = '';
              $tmp['timeToRead'] = 5;
              $tmp['tags'] = $tags;
              $tmp['mustPayArticle'] = '{"mustPay":false,"allowMembershipType":[]}';
              $tmp['isVideo'] = 'false';
             // $tmp['categoryName'] = $cat_names;
              $tmp['categoryId'] = $this->old2newcat($r['ID']);
              $json[]=$tmp;

          }
            
          if (isset($json)) {
            foreach ($json as $index => $item){
                $jsonString = json_encode($item,JSON_PRETTY_PRINT);
                file_put_contents($path.'bd_'.$r['ID'].'.json', $jsonString);

                /*$logString = "Created file: bd_".$r['ID'].'.json'."\n";
                file_put_contents($path.'log.txt', $logString);*/
                
            }
                // Write in log file
                $logString = "Created file: bd_".$r['ID'].'.json'."\n";
                $fp = fopen($path.'/../log/'.'log.txt', 'a') or die("Unable to open file!");
                fwrite($fp, $logString);
                fclose($fp);
     
                echo "Created file: bd_".$r['ID'].'.json'."\n";
          } else {
              error_log('Error generating feed ' . $json['error']);
          } 

                        /*if (isset($json['error']))
              {
                  error_log('Error generating feed ' . $json['error']);

              }
              else if (isset($json) && count($json))
              {

                  // Convert JSON data from an array to a string
                  $jsonString = json_encode($json, JSON_PRETTY_PRINT);
                  // Write in the file
                  $fp = fopen($path.'bd_'.$r['ID'].'.json', 'w');
                  fwrite($fp, $jsonString);
                  fclose($fp);
              }
              echo count($rows).' records generated';*/

        }

    }

    public function actionGenarticlejson(){

        //$id=$_REQUEST['id'];
        $id='24007';
        $id2='24397';
        $json = array();

        //$rows = [];

        $sqlData=" SELECT a.ID, a.post_title as title, 
        a.post_excerpt as excerpt, 
        b.user_nicename as author,
        a.post_date as publishedAt,
        a.post_content as articleContents, 
        a.post_title as articleUrl 
        FROM wp_posts a, wp_users b where a.post_author=b.ID and a.post_status='publish' and a.post_author != 'user' 
        order by a.post_date desc limit 50 OFFSET 10";
        

        $command=Yii::$app->dbpremium_dev->createCommand($sqlData);
        //echo $command->sql;
        $rows = $command->queryAll();
        
        foreach ($rows as $r) {

          if ($r['author']!='user') {
              $tagData="SELECT name from v_article2posttag WHERE object_id =".$r['ID'].""; 
              $command2=Yii::$app->dbpremium_dev->createCommand($tagData);
              $tag_ary = $command2->queryAll();
              $tags = ArrayHelper::getColumn($tag_ary, 'name');
              
              //merge submenu tags
              $submenuTag = $this->findtag2submenu($r['ID']);
              if ($submenuTag) {
                 $tags = array_merge($tags, $submenuTag);
              } else {
                $tags = $tags;
              }

             
              //$r['publishedAt']=strtotime($r['publishedAt']);

              $tmp['title'] = $r['title'];
              $tmp['excerpt'] = $r['excerpt'];
              $tmp['rss'] = 'false';
              $tmp['featured'] = 'false';
              $tmp['author'] = $r['author'];
              $tmp['authorId'] = '';
              $tmp['publishedAt'] = strtotime($r['publishedAt'])*1000;

              $coverImage = $this->img_path.$this->getcoverimg($r['ID']);
              $tmp['coverImage'] = $coverImage;

              $tmp['coverImageMeta'] = '';
              $tmp['coverImageAltTag'] = '';
              $tmp['articleContents'] = $this->actionConvertcontents($r['ID']);
              //['{"order":1,"contentType":"text.content","contentBody":"<p>testing md</p>\n"}'];
              $tmp['language'] = 'zh-cht';
              $tmp['articleUrl'] = $this->chineseSymbols($r['articleUrl']);
              $tmp['productArticles'] = ['beauty-digest'];
              $tmp['previewType'] = 'normal';
              $tmp['seoField'] = '';
              $tmp['timeToRead'] = 5;
              $tmp['tags'] = $tags;
              $tmp['mustPayArticle'] = '{"mustPay":false,"allowMembershipType":[]}';
              $tmp['isVideo'] = 'false';
             // $tmp['categoryName'] = $cat_names;
              $tmp['categoryId'] = $this->old2newcat($r['ID']);
              $json[]=$tmp;
          }
        
        }
        //$json = $rows;
    
        if (isset($json['error']))
        {
            error_log('Error generating feed ' . $json['error']);

        }
        else if (isset($json) && count($json))
        {
            header('Content-type: application/json; charset=UTF-8');
            echo json_encode($json); 
            exit;
        }


    }

public function actionFiletest(){
        $folder_path = Yii::getAlias('@app').'/assets/bd/output/*';

        foreach(glob($folder_path) as $file)
        {
          //$json = $file;
          echo $file.'</br>';  

        }

}

  public function chineseSymbols($url) {
      $url = mb_strtolower($url);
      $url = trim($url);
      $url = preg_replace('/\s/u', '-', $url);
      $url = preg_replace('/[^\-\w\s\p{Han}]/u', '-', $url);
      $url = preg_replace('/-+/u', '-', $url);
      $url = preg_replace('/^\-+|\-+$/u', '', $url);
      return $url;
  }

    public function _chineseSymbols($str)
    {
    //$str     = '教主品牌「ALLOVER」推首款香水！分享Anson Lo 專屬香氣的秘密！';
    $symbols = [ '。', '！', '？', '｡', '＂', '＃', '＄', '％', '＆', '＇',
     '（', '）', '＊', '＋', '，', '－', '／', '：', '；', '＜', '＝', '＞',
      '＠', '［', '＼', '］', '＾', '', '', '｛', '｜', '｝', '～', '｟', '｠',
       '｢', '｣', '､', '、', '〃', '《', '》', '「', '」', '『', '』', '【', '】', 
       '〔', '〕', '〖', '〗', '〘', '〙', '〚', '〛', '〜', '〝', '〞', '〟',
        '〰', '〾', '〿', '–', '—', '‘', '“', '”', '„', '‟', '…', '‧', '%' ];
    $length  = strlen($str);
    $res     = '';
    for($i = 0; $i < $length; $i++) {
        $word = mb_substr($str, $i, 1);
        if(!in_array($word, $symbols)) {
            $info = $word;
        } else {
            $info = ' ';
        }
        $res .= $info;
        //$res = preg_replace('/\s+/', '-', $res);
    }
    $res = preg_replace('/\s+/', '-', $res);
    $res =  trim($res, "-");
    $res =  rtrim($res, "-");
    return $res;
  }

  public function actionConvertblocks($id){
          //$id = $_REQUEST['id'];
      $data = "SELECT post_title, post_content FROM `149661220`.wp_posts WHERE ID =".$id."";
      $cmd = Yii::$app->dbpremium_dev->createCommand($data);
      $array = $cmd->queryAll();
      $contents_ary=ArrayHelper::getColumn($array, 'post_content');
      $post_title_ary=ArrayHelper::getColumn($array, 'post_title');
      //$parts = explode("\n\n", $contents_ary['0']);
      //echo $contents_ary['0'];

      $parts = $this->sliceContent('<<<GBLOCK'.$contents_ary['0'].'GBLOCK');

      return $this->renderAjax('content', ['content' => $parts]);

  }

   public function actionConvert1stblocks($id){
          //$id = $_REQUEST['id'];
      $data = "SELECT post_title, post_content FROM `149661220`.wp_posts WHERE ID =".$id."";
      $cmd = Yii::$app->dbpremium_dev->createCommand($data);
      $array = $cmd->queryAll();
      $contents_ary=ArrayHelper::getColumn($array, 'post_content');
      $post_title_ary=ArrayHelper::getColumn($array, 'post_title');
      //$parts = explode("\n\n", $contents_ary['0']);
      //echo $contents_ary['0'];

      $parts = $this->sliceContent('<<<GBLOCK'.$contents_ary['0'].'GBLOCK');

      return $this->renderAjax('content', ['content' => strip_tags($parts[0]['innerContent'])]);

  }

  public function actionConvertcontents($id){
      //$id = $_REQUEST['id'];
      $data = "SELECT post_title, post_content FROM `149661220`.wp_posts WHERE ID =".$id."";
      $cmd = Yii::$app->dbpremium_dev->createCommand($data);
      $array = $cmd->queryAll();
      $contents_ary=ArrayHelper::getColumn($array, 'post_content');
      $post_title_ary=ArrayHelper::getColumn($array, 'post_title');
      //$parts = explode("\n\n", $contents_ary['0']);
      //echo $contents_ary['0'];

      $parts = $this->sliceContent('<<<GBLOCK'.$contents_ary['0'].'GBLOCK');
      
      //print_r($parts);

      //$parts=array_filter($parts); //filter empty elements
      

      $tmp='';

          
            $i=1;
            foreach ($parts as $p){
             
              if ($p) {

                  //echo $p['blockName'];
                //$contentType=$this->findcontenttype($p['blockName']);
                $contentType=$p['blockName'];
                $contentBody=$p['innerContent'];

                if (($contentType == 'paragraph')) {
                  $ary[] = array("order"=>$i, "contentType"=>'text.content', "contentBody"=>$contentBody);
                } else if (($contentType == 'image')) {
                  //if ($p['attributes']['id']!='') {

                  if (array_key_exists('id', $p['attributes']) == TRUE) {
                  $contentMeta=$this->actionUnserialize($p['attributes']['id']);   
                  $alt_tag=$this->findalttag($p['innerContent']);
                  //if ($alt_tag == ' ') {
                  if (strlen(trim($alt_tag)) == 0) {
                      $alt_tag = "\n";
                  } else {
                      $alt_tag = $alt_tag;
                  }
                  //$alt_tag=json_decode($alt_tag);
                  //isset($_REQUEST["rowid"])?$_REQUEST["rowid"]:""
                  //$alt_tag = isset($alt_tag)?$alt_tag:'000';
                  $ary[] = array("order"=>$i, 
                    "contentType"=>'image', 
                    "contentBody"=>$contentMeta['imgUrl'], 
                    //"contentMeta"=>{"width:".$contentMeta['width'].", height:".$contentMeta['height']."}, 
                    //"contentMeta"=>{width:1000, height:2000},
                    "contentMeta"=>"{\"width\":".$contentMeta['width'].",\"height\":".$contentMeta['height']."}",
                    "altTag"=>isset($alt_tag)?$alt_tag:""
                    );
                  } else { //images not uploaded from cms
                    $ary[] = array("order"=>$i, 
                    "contentType"=>'text.content', 
                    "contentBody"=>$contentBody
                    //"contentMeta"=>{"width:".$contentMeta['width'].", height:".$contentMeta['height']."}, 
                    //"contentMeta"=>{width:1000, height:2000},
                    //"contentMeta"=>"{\"width\":".$contentMeta['width'].",\"height\":".$contentMeta['height']."}",
                    //"altTag"=>isset($alt_tag)?$alt_tag:""
                    );
                  }
                } else if (($contentType == 'gallery')) {

                  if (array_key_exists('ids', $p['attributes']) == TRUE) {
                      //if [attributes][ids] exist
                      
                      $c=0;
                      foreach($p['attributes']['ids'] as $pa) {
                          //echo $pa[$c];
                          $paMeta=$this->actionUnserialize($pa);   
                          $photoAlbumBody[$c] = ["imgUrl"=>$paMeta['imgUrl'],
                            "meta"=>"{\"width\":".$paMeta['width'].",\"height\":".$paMeta['height']."}", 
                            "id"=>$c];
                          $c++;
                      }
                      $json_photoAlbumBody = json_encode($photoAlbumBody);
                      $ary[] = array("order"=>$i, "contentType"=>'photo-album', "contentBody"=>$json_photoAlbumBody);

                  } else {
                      // "contentBody":'[{"imgUrl":"https://media.apoidea.ai/article/1bd73c5c-51ad-49f1-b407-a277767ccb3f.jpg","meta":{"width":1080,"height":1350},"id":0},{"imgUrl":"https://media.apoidea.ai/article/88755554-452c-40fc-8a0b-75a4123a29e3.jpg","meta":{"width":1080,"height":1350},"id":1}]'

                      $photoAlbum = $this->sliceContent($contentBody);

                      $c=0;
                      foreach ($photoAlbum as $pa) {
                          $paMeta=$this->actionUnserialize($pa['attributes']['id']);   
                          $photoAlbumBody[$c] = ["imgUrl"=>$paMeta['imgUrl'],
                            "meta"=>"{\"width\":".$paMeta['width'].",\"height\":".$paMeta['height']."}", 
                            "id"=>$c];
                          $c++;
                      } 

                      $json_photoAlbumBody = json_encode($photoAlbumBody);
                      /*foreach ($photoAlbumBody as $k=>$a){
                        $photoAlbumBody[$k]=json_decode($a);
                      }*/

                      $ary[] = array("order"=>$i, "contentType"=>'photo-album', "contentBody"=>$json_photoAlbumBody);
                  }

                } else if (($contentType == 'embed')) { //ig, youtube
                  if ($p['attributes']['providerNameSlug'] == 'instagram') {

                      $wp_url=$p['attributes']['url'];
                      //$res=preg_match('/https:\/\/www.instagram.com\/p\/(.+)\/(.+)/U', $wp_url, $matches);
                      $res=preg_match('/https:\/\/www.instagram.com\/(.+)\/(.+)\//U', $wp_url, $matches);

                      if ($res) {
                          $ig_post_id = $matches[2];
                      } else {
                          $ig_post_id = '';
                      }

                      $ig_url= 'https://www.instagram.com/p/'.$ig_post_id.'/embed/';
                      //$ig_url=$p['attributes']['url'].'embed/';
                      $contentBody = '<iframe width="600" height="740" src="'.$ig_url.'" frameborder="0"></iframe>';
                      
                      $ary[] = array("order"=>$i, "contentType"=>'text.content', "contentBody"=>$contentBody);
                  } else if ($p['attributes']['providerNameSlug'] == 'youtube') {
                      $wp_yt_url=$p['attributes']['url'];

                      $res=preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $wp_yt_url, $match);

                      if ($res) {
                          $youtube_id = $match[1];
                      } else {
                          $youtube_id = '';
                      }
                      $yt_url = 'https://www.youtube.com/embed/'.$youtube_id;

                      $yt_title=$post_title_ary['0'];
                      $contentBody = '<iframe width="614" height="370" src="'.$yt_url.'" title="'.$yt_title.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

                      //$contentBody = '<iframe style="position:absolute;top:0;left:0;width:100%;height:100%" src='.$yt_url.'" frameBorder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
                      $ary[] = array("order"=>$i, "contentType"=>'iframe', "contentBody"=>$contentBody);
                  }
                } else if (($contentType == 'heading')) {
                  $ary[] = array("order"=>$i, "contentType"=>'text.content', "contentBody"=>$contentBody);
                } else if ($contentType == 'preformatted') {
                  $ary[] = array("order"=>$i, "contentType"=>'text.content', "contentBody"=>$contentBody);
                }

              }

              $i++;
                
            }

            
          //}
      
        return $ary;
        //return $this->renderAjax('content', ['content' => $ary]);


  }

  public function actionFindig()
  {
      $wp_url=$_REQUEST['u'];
      //$res=preg_match('/https:\/\/www.instagram.com\/p\/(.+)\/(.+)\//U', $wp_url, $matches);
      $res=preg_match('/https:\/\/www.instagram.com\/(.+)\/(.+)\//U', $wp_url, $matches);

       
      print_r($matches);
                      if ($res) {
                          $ig_post_id = $matches[1];
                      } else {
                          $ig_post_id = '';
                      }

      //echo $matches[1];

  }

  public function findalttag($html) {
      
      $dom_err = libxml_use_internal_errors(true);
      $dom = new \DOMDocument();
      $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
      //$dom->loadHtml($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

      $figcaption = $dom->getElementsByTagName('figcaption');

      $caption = $dom->saveHtml($figcaption[0]);

      //print_r($caption);
      if ($caption) {
        $caption = strip_tags($caption);
             //if (strlen($caption) > 0 && strlen(trim($caption)) == 0) { $caption = '\n\n';}

        //$caption = $caption;
      }

      return $caption;

  }

  public function actionFindgalleryimg() {


      $html='<figure class="wp-block-gallery has-nested-images columns-default is-cropped"><!-- wp:image {"id":25112,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://beautydigest.io/wp-content/uploads/2023/08/lalalalisa_m_362628894_2433324493508716_5968058238751765408_n-1-819x1024.jpg" alt="" class="wp-image-25112"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":25113,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://beautydigest.io/wp-content/uploads/2023/08/lalalalisa_m_362855704_945099899909768_546234094622759100_n-1-819x1024.jpg" alt="" class="wp-image-25113"/></figure>
<!-- /wp:image --></figure>';

    $contents = $this->sliceContent($html);
/*
      $dom_err = libxml_use_internal_errors(true);
      $dom = new \DOMDocument();
      $dom->loadHtml($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

      $figure = $dom->getElementsByTagName('figure');

      $figure = $dom->saveHtml($figure[0]);

      
      
      /*if ($caption) {
      $caption = strip_tags($caption);
      }*/

      print_r($contents);

      //return $figure;

  }


  public function findcontenttype($b){
      //foreach ($parts as $p){
        if($b){
        $contentType = '';  
            if ($b=='paragraph') {
                $contentType = 'text.content';
            } else if ($b=='heading') {
               $contentType = 'text.content';
            } else if ($b=='image') {
                $contentType = 'image';
            } else if ($b=='embed') {
                $contentType = 'iframe';
            } else if ($b=='gallery') {
                $contentType = 'photo-album';
            } 
            return $contentType;
        }
        
      //} 

  }

    public function findcontentbody($ary){
      //foreach ($parts as $p){
        if($ary){
        $content = array();  
        $b=$ary['blockName'];
            if ($b=='paragraph') {
                $content = array("contentBody"=>$ary['innerContent']);
            } else if ($b=='heading') {
               $content =  array("contentBody"=>$ary['innerContent']);
            } else if ($b=='image') {
                $contentMeta=$this->actionUnserialize($ary['attributes']['id']);     
                $content = array("contentBody"=>$contentMeta["imgUrl"], 
                  "contentMeta=>width:".$contentMeta['width'].", height:".$contentMeta['height'].", 
                  altTag"=>'');       
            } else if ($b=='embed') {
                $content = array("contentBody"=>$ary['innerContent']);
            } else if ($b=='gallery') {
                $content = array("contentBody"=>$ary['innerContent'], "imgUrl"=>"", "meta"=>"", "id"=>"","description"=>"");    
                //{"contentBody":"[{\"imgUrl\":\"https://media.apoidea.ai/article/1a39034e-9758-4c83-8250-ce08b9e25450.png\",\"meta\":{\"width\":2318,\"height\":2318},\"id\":0,\"description\":\"desc1\"}]"};
            } 
            return $content;
        }
        
      //} 

  }

public function sliceContent($content){

    $gutenbergBlocks = $content;

    preg_match_all('/<!-- wp:([a-zA-Z0-9-]+)(.*?)? -->(.*?)<!-- \/wp:\\1 -->/s', $gutenbergBlocks, $matches, PREG_SET_ORDER);

    $blocksArray = [];

    foreach ($matches as $match) {
        $blockName = $match[1];
        $attributesString = trim($match[2]);
        
        // Convert JSON attributes to PHP array. If no attributes, set as an empty array.
        $attributes = $attributesString ? json_decode($attributesString, true) : [];

        // Get content without outer spaces
        $innerContent = trim($match[3]);
        
        $blocksArray[] = [
            'blockName' => $blockName,
            'attributes' => $attributes,
            'innerContent' => $innerContent
        ];
    }

    return $blocksArray;
}

  public function actionUnserialize($id){
      //$id = $_REQUEST['id'];

      $data="SELECT * FROM `149661220`.wp_postmeta WHERE meta_key='_wp_attached_file' AND post_id =".$id.""; 
      $cmd=Yii::$app->dbpremium_dev->createCommand($data);
      $ary = $cmd->queryAll();
      $filename = ArrayHelper::getColumn($ary, 'meta_value');

      $data2="SELECT * FROM `149661220`.wp_postmeta WHERE meta_key='_wp_attachment_metadata' AND post_id =".$id.""; 
      $cmd2=Yii::$app->dbpremium_dev->createCommand($data2);
      $ary2 = $cmd2->queryAll();
      $metadata = ArrayHelper::getColumn($ary2, 'meta_value');

      //print_r($metadata[1]);
      $imgUrl=$this->img_path.$filename['0'];

      $res = unserialize($metadata['0']);

      if (array_key_exists('width', $res) == TRUE) {
          $width = $res['width'];
      } else {
           $width='1000';
      }

      if (array_key_exists('height', $res) == TRUE) {
          $height = $res['height'];
      } else {
           $height='1000';
      }

      //$width=$res['width'];
      //$height=$res['height'];

      $contenetMeta = array("imgUrl"=>$imgUrl, "width"=>$width, "height"=>$height);

      //print_r($contenetMeta);
      return $contenetMeta;

  }

  public function findtag2submenu($id)
  {
        //$id = $_REQUEST['id'];
        $data="SELECT name FROM `149661220`.v_article2cat WHERE object_id =".$id.""; 
        $cmd=Yii::$app->dbpremium_dev->createCommand($data);
        $ary = $cmd->queryAll();
        $tag_names = ArrayHelper::getColumn($ary, 'name');

        $res = [];

        if ($tag_names) {
          foreach ($tag_names as $c){

              if  ($c == 'Celebrity &amp; Society') {
                $submenuname = '影視明星';
              } else if ($c == 'Moive &amp; Drama') {
                 $submenuname = '綜藝娛樂';
              } else if ($c == 'Makeup') {
                 $submenuname = '彩妝護膚';
              } else if ($c == 'Skincare') {
                 $submenuname = '彩妝護膚';
              } else if ($c == 'Body &amp; Hair') {
                 $submenuname = '美髮美甲';
              } else if ($c == 'Fragrance') {
                 $submenuname = '香水及身體';
              } else if ($c == 'Event &amp; Runway') {
                 $submenuname = '穿搭教學';
              } else if ($c == 'Wedding') {
                 $submenuname = 'Wedding';
              } else if ($c == 'Bags &amp; Shoes') {
                 $submenuname = '手袋鞋履';
              } else if ($c == 'Watch &amp; Jewellery') {
                 $submenuname = '配件飾品';
              } else if ($c == 'Photography &amp; Videography') {
                 $submenuname = '打卡熱點';
              } else {
                 $submenuname = '';
              }
              if ($submenuname) {
                array_push($res, $submenuname);
              }
              
          }
        
        }  

        //print_r(array_unique($res));
        return array_unique($res);

  }

  public function getcoverimg($id){
      //$id = $_REQUEST['id'];
      $data = "SELECT childmeta.* FROM wp_postmeta childmeta INNER JOIN wp_postmeta parentmeta ON (childmeta.post_id=parentmeta.meta_value) WHERE parentmeta.meta_key='_thumbnail_id' AND childmeta.meta_key='_wp_attached_file' AND parentmeta.post_id =".$id."";
      $cmd = Yii::$app->dbpremium_dev->createCommand($data);
      $ary = $cmd->queryAll();
      $ary=ArrayHelper::getColumn($ary, 'meta_value');
      if ($ary) {
        return $ary[0];
      } else {
        $ary = '';
        return $ary;
      }
  }

  public function old2newcat($id)
  {
        
             if ($id == '4801') {
                  $cate_id = 43;
              } else if ($id == '9361') {
                  $cate_id = 46;
              } else if ($id =='4586') {
                  $cate_id = 42;
              } else if ($id == '4385') {
                  $cate_id = 47;
              } else {

                $catData="SELECT name FROM `149661220`.v_article2cat WHERE object_id =".$id.""; 
                $command3=Yii::$app->dbpremium_dev->createCommand($catData);
                $cat_ary = $command3->queryAll();
                $cat_names = ArrayHelper::getColumn($cat_ary, 'name');

                $res = [];

                if ($cat_names) {
                  foreach ($cat_names as $c){

                    if  (($c == '【Popular Post】') || ($c == 'Celebrity &amp; Society') || ($c == 'Moive &amp; Drama')) {
                      $cate_id = 42;
                    } else if (($c == 'Beauty') || ($c == 'Beauty News') || ($c=='Makeup') || ($c == 'Skincare') || ($c=='Body &amp; Hair') || ($c == 'Fragrance')){
                      $cate_id = 43;
                    } else if (($c=='Fashion') || ($c=='Fashion News') || ($c=='Event &amp; Runway') || ($c=='Wedding') || ($c == 'Bags &amp; Shoes') || ($c == 'Watch &amp; Jewellery')) {
                      $cate_id = 44;
                    } else if (($c == 'Sunday Chill')  || ($c == 'Art &amp; Design') || ($c=='Photography &amp; Videography')) {
                      $cate_id = 45;
                    } else if (($c == 'Health &amp; Fitness')) {
                      $cate_id = 46;
                    } else if ($c == 'Beauty') {
                      $cate_id = 43;
                    } else if ($c == 'Culture') {
                      $cate_id = 42;
                    } else if ($c == 'Lifestyle') {
                      $cate_id = 45;
                    } 
                  }

                  //return $cate_id;
        
                }

              }
              return $cate_id;
}






}

?>
