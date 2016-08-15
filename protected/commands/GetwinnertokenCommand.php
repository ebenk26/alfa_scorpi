<?php

class GetwinnertokenCommand extends CConsoleCommand
{
	public function run($args)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("bidding_token_time is null and bidding_time is not null");
		$sendmail = SendMail::model()->findAll($criteria);
		foreach ($sendmail as $row) {
			$sendmailupdate = SendMail::model()->findByPk($row->id);
			$bidding_time2 = strtotime($row->bidding_time);
			$bidding_time3 = $bidding_time2 - ($row->bidding_token*60); //biddingtimestamp - token*60
			$date = new DateTime();
			$date->setTimestamp($bidding_time3);
			$bidding_time4 = $date->format('Y-m-d H:i:s');
			$sendmailupdate->bidding_token_time = $bidding_time4;
			$sendmailupdate->update();
		}
	}
}