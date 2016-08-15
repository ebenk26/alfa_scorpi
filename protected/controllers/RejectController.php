<?php

class RejectController extends Controller
{
	public function actionIndex()
	{
		$prospect_id = $_GET['id'];
		$secretkey = $_GET['secretkey'];
		$prospect_name = '';
		
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
				$return = '';
				$reason_reject = "";
				$prospect = Prospect::model()->findByPk($prospect_id);
				$prospect_name = $prospect->nama;
				if(isset($_GET['reason_reject']))
				{
				
					$name = $leasing->nama;
					$return = "Anda telah menolak prospect ini.";
					
					
					$_modelpros = Winner::model()->findByPk($winner->id);
					$_modelpros->reason_reject = $_GET['reason_reject'];
					$_modelpros->winner_confirm = 99;
					$_modelpros->updated_by = 'SYSTEM';
					$_modelpros->updated_at = new CDbExpression('NOW()');
					$_modelpros->time_reject = new CDbExpression('NOW()');
					$_modelpros->update();
					
					$prospect->time_approve = new CDbExpression('NOW()');
					$prospect->update();
				}
			}else
			{
				$return = 'Not Allowed1';
			}
		}else
		{
			$return = 'Not Allowed2';
		}
		$this->render('index',array(
			'return' => $return,
			'prospect_id' => $prospect_id,
			'secretkey' => $secretkey,
			'prospect_name' => $prospect_name,
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