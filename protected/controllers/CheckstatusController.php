<?php

class CheckstatusController extends Controller
{
	public function actionIndex()
	{
		// $jam_survey = '24-03-2016 08:00';
		// $strexplode = explode(' ', $jam_survey);
		// $strexplode2 = explode('-', $strexplode[0]);
		// $year = $strexplode2[2].'-';
		// $month = $strexplode2[1].'-';
		// $date = $strexplode2[0].' ';
		// $time = $strexplode[1];
		// $timestamppros = strtotime($year.$month.$date.$time) + 10800; // jam survey + 3 jam
		// echo strtotime($jam_survey).'<br>';
		// echo $timestamppros.'<br>';
		// echo $year.$month.$date.$time;
		// exit();

		$_model = Winner::model()->findAll();
		foreach ($_model as $row) {
			$_modelwinner = Winner::model()->findByPk($row->id);
			$_modelwinner->created_at = new CDbExpression('NOW()');
			$_modelwinner->updated_at = new CDbExpression('NOW()');


			if($row->winner_confirm == 1){ // winner sudah confirm
				if($row->reminder_status >= 2){
					echo 'sudah confirm dan 3x reminder, namun belum approve';

					$_modelpros = Prospect::model()->findByPk($row->prospect_id);
					if (!empty($_modelpros->ganti_jam_survey)) {
						if (!empty($_modelpros->ganti_tanggal_survey)) {
							$_modelpros->jam_survey = $_modelpros->ganti_jam_survey.' '.$_modelpros->ganti_jam_survey;
						}else{
							$_modelpros->jam_survey = $_modelpros->ganti_jam_survey;
						}
					}else{
						$_modelpros->jam_survey = $_modelpros->jam_survey;
					}
					$array = preg_split("/[[:space:]]+/",$_modelpros->jam_survey);
					$strexplode = explode(' ', $_modelpros->jam_survey);
					$strexplode2 = explode('-', $array[0]);
					$year = $strexplode2[2].'-';
					$month = $strexplode2[1].'-';
					$date = $strexplode2[0].' ';
					$time = $array[1];
					$timestamppros = strtotime($year.$month.$date.$time) + 10800; // jam survey + 3 jam
					$timenow = strtotime(date("Y-m-d H:i"));
					if($timenow >= $timestamppros && empty($_modelpros->time_survey_new)){
						if((date('H:i') >= '17:00' && date('l') != 'Saturday') || (date('H:i') <= '06:00') && date('l') != 'Saturday'){
							echo 'no feedback lebih dr jam 5, pending hingga esok hari jam 10';
							if(date('H:i') >= '10:00' && date('H:i') <= '10:05' && date('l') !='Sunday'){
								echo 'sudah keesokan hari jam 10:00';
								$_modelwinner->status_echo = 'sudah keesokan hari jam 10:00';
								$_modelwinner->winner_confirm = 98;
								$_modelwinner->update();
							}
						}else if (date('H:i') >= '12:01' && date('l') == 'Saturday') {
							echo 'no feedback lebih dr jam 12 hari sabtu';
							// $_modelwinner->winner_confirm = 98;
							// $_modelwinner->update();

						}else if (date('H:i') < '12:01' && date('l') == 'Saturday') {
							echo 'no feedback kurang dr jam 12 hari sabtu';
							$_modelwinner->status_echo = 'no feedback kurang dr jam 12 hari sabtu';
							$_modelwinner->winner_confirm = 98;
							$_modelwinner->update();
						}else{
							echo 'no feedback kurang dr jam 5';
							$_modelwinner->status_echo = 'no feedback kurang dr jam 5';
							$_modelwinner->winner_confirm = 98;
							$_modelwinner->update();
						}

						$_modelpros->time_survey_new = new CDbExpression('NOW()');
						$_modelpros->update();
					}else if(!empty($_modelpros->time_survey_new)){
						if(date('H:i') >= '10:00' && date('H:i') <= '10:05' && date('l') !='Sunday'){
							echo 'sudah keesokan hari jam 10:00';
							$_modelwinner->status_echo = 'sudah keesokan hari jam 10:00';
							$_modelwinner->winner_confirm = 98;
							$_modelwinner->update();
						}
					}

					echo $row->email;
				}else{
					echo 'reminder belum 3x';
					echo $row->email;
				}
			}else{ // winner belum confirm
				if(empty($row->winner_confirm)){ // belum ada confirm
					echo 'sudah ada pemenang tp belum confirm';
					echo $row->email;
					$_modelpros = Prospect::model()->findByPk($row->prospect_id);
					if (!empty($_modelpros->ganti_jam_survey)) {
						if (!empty($_modelpros->ganti_tanggal_survey)) {
							$_modelpros->jam_survey = $_modelpros->ganti_jam_survey.' '.$_modelpros->ganti_jam_survey;
						}else{
							$_modelpros->jam_survey = $_modelpros->ganti_jam_survey;
						}
					}else{
						$_modelpros->jam_survey = $_modelpros->jam_survey;
					}
					$array = preg_split("/[[:space:]]+/",$_modelpros->jam_survey);
					$strexplode = explode(' ', $_modelpros->jam_survey);
					$strexplode2 = explode('-', $array[0]);
					$year = $strexplode2[2].'-';
					$month = $strexplode2[1].'-';
					$date = $strexplode2[0].' ';
					$time = $array[1];
					$timestamppros = strtotime($year.$month.$date.$time) + 10800; // jam survey + 3 jam
					$timenow = strtotime(date("Y-m-d H:i"));
					
					if($timenow >= $timestamppros && empty($_modelpros->time_survey_new)){
						if((date('H:i') >= '17:00' && date('l') != 'Saturday') || (date('H:i') <= '06:00') && date('l') != 'Saturday'){
							echo 'no feedback lebih dr jam 5, pending hingga esok hari jam 10';
							if(date('H:i') >= '10:00' && date('H:i') <= '10:05' && date('l') !='Sunday'){
								echo 'sudah keesokan hari jam 10:00';
								$_modelwinner->status_echo = 'sudah keesokan hari jam 10:00';
								$_modelwinner->winner_confirm = 98;
								$_modelwinner->update();
							}
						}else if (date('H:i') >= '12:01' && date('l') == 'Saturday') {
							echo 'no feedback lebih dr jam 12 hari sabtu';
							// $_modelwinner->winner_confirm = 98;
							// $_modelwinner->update();

						}else if (date('H:i') < '12:01' && date('l') == 'Saturday') {
							echo 'no feedback kurang dr jam 12 hari sabtu';
							$_modelwinner->status_echo = 'no feedback kurang dr jam 12 hari sabtu';
							$_modelwinner->winner_confirm = 98;
							$_modelwinner->update();
						}else{
							echo 'no feedback kurang dr jam 5';
							$_modelwinner->status_echo = 'no feedback kurang dr jam 5';
							$_modelwinner->winner_confirm = 98;
							$_modelwinner->update();
						}
						$_modelpros->time_survey_new = new CDbExpression('NOW()');
						$_modelpros->update();
					}
				}
			}
		}
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