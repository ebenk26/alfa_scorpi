<?php 
$host = CHttpRequest::getUserHostAddress();
//$host = "192.168.1.123";
echo $host;
if ($host == "192.168.56.1"){
	Yii::app()->theme = "insideryamaha";
}else{
	Yii::app()->theme = "survey";
}
?>