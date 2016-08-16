<?php

class CheckpointCommand extends CConsoleCommand
{
	public function run($args)
    {
		//############### pemenang approve(2) atau no feedback(98) ################
		$row = Yii::app()->db->createCommand("
			select t.id,t.token,w.send_email_id as send_email_id,w.id as winner_id, w.prospect_id, w.winner_confirm, p.id as prospect_id
			from leasing t
			join winner w ON t.id = w.leasing_id
			join prospect p ON w.prospect_id = p.id
			where (w.winner_confirm = 2 and w.winner_point_count is null) or (w.winner_confirm = 98 and w.winner_point_count is null)
			 or (w.winner_confirm = 99 and w.winner_point_count is null)
			")->queryRow();
		// exit();
		// foreach ($query as $row) {
		if ($row) {
			$criteria = new CDbCriteria;
			$criteria->condition = 'leasing_id = '.$row['id'].'';
			$criteria->condition = 'prospect_id = "'.$row['prospect_id'].'"';
			$_modelsendmail = SendMail::model()->find($criteria);
			$pointfirst = $row['token'];
			$pointlast = $_modelsendmail->bidding_token;
			if($pointlast == "RO"){
				echo "point RO"; //pemenang RO approve point +2
				$pointfinal = $pointfirst + 2;
			}else{
				echo "point normal";
				$pointfinal = $pointfirst + ($pointlast * 2); //pemenang normal approve point x2
			}
			// echo $pointfinal.'<br>';
			// echo $pointlast.'<br>';
			// echo $pointfirst.'<br>';
			echo 'Leasing_id_winner = '.$row['id'];
			echo 'point_update = '.$pointfinal;

			
			$send_email_id = $row['send_email_id'];
			$prospect_id = $row['prospect_id'];
			$this->biddinglose($send_email_id, $prospect_id); //kalah bidding

			$winner = Winner::model()->findByPk($row['winner_id']);
			$winner->winner_point_count = 1;
			$winner->update();

			if($row['winner_confirm'] == 98 || $row['winner_confirm'] == 99){

			}else{
				$leasing = Leasing::model()->findByPk($row['id']);
				$leasing->token = $pointfinal;
				$leasing->update();
			}
		}
		// }
	}

	public function biddinglose($send_email_id, $prospect_id){
		$criteria = new CDbCriteria;
		$criteria->condition = 'prospect_id = '.$prospect_id.' and id <> '.$send_email_id.'';
		$sendemail = SendMail::model()->findAll($criteria);
		$i = 0;
		foreach ($sendemail as $row) {
			echo $i++."<br>";
			$leasing = Leasing::model()->findByPk($row->leasing_id);
			$pointfirst = $leasing->token;
			$pointlast = $row->bidding_token;
			if($pointlast == 'RO'){
				$pointlast = '0';
			}else{
				$pointlast = $pointlast;
			}
			$pointfinal = $pointfirst + $pointlast;

			$leasing->token = $pointfinal;
			$leasing->update();

			echo 'leasing_id = '.$leasing->id.'<br>';
			echo 'point_update = '.$pointfinal.'<br>';
		}
	}
}