<?php

class ConfirmController extends Controller
{
	public function actionIndex()
	{
		$prospect_id = $_GET['id'];
		$secretkey = $_GET['secretkey'];
		
		$criteria = new CDbCriteria;  
		$criteria->addCondition("secret_key = '".$secretkey."'");
		$modelsecretkey = SecretKey::model()->find($criteria);
		$leasing = Leasing::model()->findByPk($modelsecretkey->leasing_id);
		
		if($leasing)
		{
			$criteria = new CDbCriteria;  
			$criteria->addCondition("prospect_id = '".$prospect_id."'");
			$criteria->addCondition("winner_confirm = 1");
			$winner = Winner::model()->find($criteria);
			if($winner)
			{
				$name = $leasing->nama;
				$return = "Selamat Kepada ".$name.". Prospect telah di Survey dan di Confirm.";
				
				
				$_modelpros = Winner::model()->findByPk($winner->id);
				$_modelpros->winner_confirm = 2;
				$_modelpros->updated_by = 'SYSTEM';
				$_modelpros->updated_at = new CDbExpression('NOW()');
				$_modelpros->update();
			}else
			{
				$return = 'Not Allowed';
			}
		}else
		{
			$return = 'Not Allowed';
		}
		$this->render('index',array(
			'return' => $return
		));
		
		// $this->render('index');
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