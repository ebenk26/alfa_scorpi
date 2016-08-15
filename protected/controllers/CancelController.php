<?php

class CancelController extends Controller
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
				$reason_cancel = "";
				$prospect = Prospect::model()->findByPk($prospect_id);
				$prospect_name = $prospect->nama;
				if(isset($_GET['reason_cancel']))
				{
				
					$name = $leasing->nama;
					$return = "Anda telah meng-cancel prospect ini.";
					
					
					$_modelpros = Winner::model()->findByPk($winner->id);
					$_modelpros->reason_cancel = $_GET['reason_cancel'];
					$_modelpros->winner_confirm = 3;
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