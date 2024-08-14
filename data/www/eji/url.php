<?php
//$url = $_SERVER['REQUEST_URI'];
$incoming_url = 'http://www.ejinsight.com/20200318-china-enhances-export-tax-rebates-on-almost-1500-products';
//echo basename($incoming_url);

$basename = basename($incoming_url);

$servername = "175.41.143.76";
$username = "hkej_user";
$password = "fr0nt1usr";
$dbname = "eji";


 // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$sql = "'SELECT id FROM article where storySlug='20200318-china-enhances-export-tax-rebates-on-almost-1500-products'";

$sql="SELECT article.id FROM eji.article WHERE storySlug LIKE '%".$basename."%' ";

//echo $sql.'<br>';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	foreach ($result as $r)
		$arr[] = $r['id'];
	$article_id=$r['id'];

	$re_url = 'https://'.$_SERVER['SERVER_NAME'].'/eji/article/id/'.$article_id.'/'.$basename;

	echo 'this will redirect to '. $re_url;
	/*ob_start();
 	header('Location: '.$re_url);
	ob_end_flush();
    die();*/
	


	//echo $re_url;

} else {
    echo "0 results";
}

$conn->close();

?>
