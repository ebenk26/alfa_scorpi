<?php

class CommentController extends Controller
{
	public function actionIndex()
	{
		// $this->render('index');
		if((isset($_GET["comment"]) && isset($_GET["id"])) || (isset($_GET["comment"]) && isset($_GET["leasing_id"]))){
			$_model = new CommentProspect;
			$_model->prospect_id = $_GET["id"];
			$_model->comment = $_GET["comment"];
			$_model->user_id = Yii::app()->session['userid'];
			$_model->created_by = 'SYSTEM';
			$_model->created_at = new CDbExpression('NOW()');
			if($_model->save()){
				$prospect = Prospect::model()->findByPk($_GET["id"]);
				$prospect->last_comment_user = Yii::app()->session['userid'];
				$prospect->update();
				echo '<script>alert("Komentar berhasil ditambahkan")</script>';
				// header("location:/alfa_scorpi/index.php/databidding/");
?>
				<script language=javascript>
				setTimeout("location.href='/alfa_scorpi/index.php/databidding/'", 10);
				</script>
<?php
			}
		}else{
			header("location:/alfa_scorpi/index.php/databidding/");
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}