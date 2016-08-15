<?php

class ReblastCommand extends CConsoleCommand
{
	public function run($args)
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
			$model->last_case_id = substr($row["created_at"], 5, 2).'-'.$row['case_id'];
			$model->nama_salesman = $row['nama_salesman'];
			$model->has_last_caseid = 1;
			if(empty($row['leasing_id_minus'])){
				$model->leasing_id_minus = $row['leasing_id'];
				$model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['case_id'];
			}else{
				$model->leasing_id_minus = $row['leasing_id_minus'].','.$row['leasing_id'];
				$model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['case_id'].','.$row['case_id_reblast'];
			}

			if($model->save()){
				echo 'success create re-prospect';
				$winner->reblast_status = 1;
				$winner->update();
			}
		}
	}
}