<?php

class UpdatereblastwinnerController extends Controller
{
	public function actionIndex()
	{
		$connection=Yii::app()->db;
		$command= $connection->createCommand("
			select b.*,a.leasing_id 
			from send_mail a 
			join prospect b on a.prospect_id = b.id 
			where a.bidding_token_time is null and now() >= a.created_at + interval 8 minute 
			and b.has_winner is null 
			and has_last_caseid = 1 
			group by b.id 
		");
		$rows = $command->queryAll();
		foreach ($rows as $key => $row) {

			$prospect = Prospect::model()->findByPk($row['id']);
			if($row['id']){
				// echo 'success update prospect';
				// $prospect->reblast_no_winner = null;
				// $prospect->update();
			}
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