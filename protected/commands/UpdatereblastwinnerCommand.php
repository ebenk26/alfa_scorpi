<?php

class UpdatereblastwinnerCommand extends CConsoleCommand
{
	public function run($args)
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
}