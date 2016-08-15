<?php

class GetnobidCommand extends CConsoleCommand
{
	public function run($args)
    {
		$date = new DateTime();
		$date->add(new DateInterval('PT3H10M'));
		$jam_survey_new = $date->format('Y-m-d H:i');

		$connection=Yii::app()->db;
		$command= $connection->createCommand("
			select b.*,a.leasing_id
			from send_mail a
			join prospect b on a.prospect_id = b.id
			where a.bidding_token_time is null 
			and now() >= a.created_at + interval 8 minute
			and b.has_winner is null
			and b.reblast_no_winner is null
			group by b.id
		");
		$rows = $command->queryAll();
		foreach ($rows as $key => $row) {

			$prospect = Prospect::model()->findByPk($row['id']);
			$model=new Prospect;
			$model->nik = $row['nik'];
			$model->nama = $row['nama'];
			$model->alamat = $row['alamat'];
			$model->ttl = $row['ttl'];
			$model->no_hp = $row['no_hp'];
			$model->tipe = $row['tipe'];
			$model->dp = $row['dp'];
			$model->jam_survey = $jam_survey_new;
			
			$model->keterangan = $row['keterangan'];
			$model->case_number = $row['case_number'];
			$model->region_id = $row['region_id'];
			$model->profil_konsumen = $row['profil_konsumen'];
			$model->user_id = $row['user_id'];
			$model->from_email = $row['from_email'];
			$model->udate = $row['udate'];
			$model->status = 0;
			$model->bid_from_time = $row['bid_from_time'];
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
			$model->created_by = $row['created_by'];
			$model->created_at = new CDbExpression('NOW()');
			$model->time_survey_new = $row['time_survey_new'];
			$model->last_case_id = substr($row["created_at"], 5, 2).'-'.$row['id'];
			$model->reblast_no_winner = 1;
			if(empty($row['leasing_id_minus'])){
				$model->leasing_id_minus = $row['leasing_id'];
				$model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['id'];
			}else{
				$model->leasing_id_minus = $row['leasing_id_minus'].','.$row['leasing_id'];
				$model->case_id_reblast = substr($row["created_at"], 5, 2).'-'.$row['id'].','.$row['case_id_reblast'];
			}

			if($model->save()){
				echo 'success create re-prospect';
				$prospect->has_winner = 1;
				$prospect->reblast_no_winner = 1;
				$prospect->update();
			}
		}
	}
}