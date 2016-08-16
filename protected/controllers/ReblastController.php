<?php

class ReblastController extends Controller
{
	public function actionIndex()
	{
		$date = new DateTime();
		$date->add(new DateInterval('PT3H10M'));
		$jam_survey_new = $date->format('Y-m-d H:i');
		$query = Yii::app()->db->createCommand("
			select t.id as id_winner,t.leasing_id,t.winner_confirm,p.* from winner t join prospect p ON t.prospect_id = p.id where (t.winner_confirm = 98 and t.reblast_status is null and p.reblast_no_winner is not null) or (t.winner_confirm = 99 and t.reblast_status is null and p.reblast_no_winner is not null) or (t.winner_confirm = 98 and t.reblast_status is null and p.reblast_no_winner is null) or (t.winner_confirm = 99 and t.reblast_status is null and p.reblast_no_winner is null)
			")->queryAll();
		foreach ($query as $row) {
			
			$winner = Winner::model()->findByPk($row['id_winner']);
			$model=new Prospect;
			$model->nik = $row['nik'];
			$model->nama = $row['nama'];
			$model->alamat = $row['alamat'];
			$model->ttl = $row['ttl'];
			$model->no_hp = $row['no_hp'];
			$model->tipe = $row['tipe'];
			$model->dp = $row['dp'];
			if (!empty($row['time_survey_new'])) {
				$model->jam_survey = $row['time_survey_new'];
			}else{
				$model->jam_survey = $jam_survey_new;
			}
			
			// $model->jam_survey = $row['jam_survey'];
			$model->keterangan = $row['keterangan'];
			$model->case_number = $row['case_number'];
			$model->region_id = $row['region_id'];
			$model->profil_konsumen = $row['profil_konsumen'];
			$model->user_id = $row['user_id'];
			$model->from_email = $row['from_email'];
			$model->udate = $row['udate'];
			$model->status = 0;
			$model->bid_from_time = $row['bid_from_time'];
			// $model->has_winner = $row['has_winner'];
			$model->foto_1 = $row['foto_1'];
			$model->foto_2 = $row['foto_2'];
			$model->foto_3 = $row['foto_3'];
			$model->note = $row['note'];
			$model->dp_approve = $row['dp_approve'];
			$model->cicil_approve = $row['cicil_approve'];
			$model->tipe_approve = $row['tipe_approve'];
			$model->keterangan_approve = $row['keterangan_approve'];
			$model->tenor = $row['tenor'];
			$model->ganti_tanggal_survey = $row['ganti_tanggal_survey'];
			$model->ganti_jam_survey = $row['ganti_jam_survey'];
			$model->keterangan_confirm = $row['keterangan_confirm'];
			$model->status_telepon = $row['status_telepon'];
			$model->nama_stnk = $row['nama_stnk'];
			$model->no_ro = $row['no_ro'];
			$model->foto_ro = $row['foto_ro'];
			$model->nama_surveyor = $row['nama_surveyor'];
			// $model->time_confirm = $row['time_confirm'];
			// $model->time_approve = $row['time_approve'];
			$model->created_by = $row['created_by'];
			$model->created_at = new CDbExpression('NOW()');
			$model->time_survey_new = $row['time_survey_new'];
			// $model->last_case_id = substr($row["created_at"], 5, 2).'-'.$row['case_id'];
			$model->last_case_id = $row['id'];
			$model->nama_salesman = $row['nama_salesman'];
			$model->has_last_caseid = 1;
			if(empty($row['leasing_id_minus'])){
				$model->leasing_id_minus = $row['leasing_id'];
				// $model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['case_id'];
				$model->case_id_reblast = $row['id'];
			}else{
				$model->leasing_id_minus = $row['leasing_id_minus'].','.$row['leasing_id'];
				// $model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['case_id'].','.$row['case_id_reblast'];
				$model->case_id_reblast = $row['id'].','.$row['case_id_reblast'];
			}
			/////
			$criteria_pros = new CDbCriteria();
			$criteria_pros->condition  = "month(created_at) = month(now())";
			// $criteria_pros->condition  = "month('2016-09-11 11:37:55') = month('2016-09-11 11:37:55') and id <> ".$_model->id;
			$criteria_pros->order = "created_at DESC";
			$prospect_last_caseid = Prospect::model()->find($criteria_pros);
			if ($prospect_last_caseid) {
			echo "<br>".$prospect_last_caseid->id."<br>";
			// print_r($prospect_last_caseid);
			echo "if1";
			$expl = explode("-", $prospect_last_caseid->id);

			$count_id = $expl[1]+1;
			$strlen = strlen($count_id);
			if ($strlen == 1) {
			$count_id = '0000'.$count_id;
			}else if ($strlen == 2) {
			$count_id = '000'.$count_id;
			}else if ($strlen == 3) {
			$count_id = '00'.$count_id;
			}else if ($strlen == 4) {
			$count_id = '0'.$count_id;
			}else if ($strlen == 5) {
			$count_id = $count_id;
			}
			}else{
			$count_id = 1;
			$count_id = '0000'.$count_id;
			}

			$model->id = date('ymd')."-".$count_id;
			/////
			if($model->save()){
				echo 'success create re-prospect';
				$winner->reblast_status = 1;
				$winner->update();
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