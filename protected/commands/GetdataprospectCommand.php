<?php

class GetdataprospectCommand extends CConsoleCommand
{
	public function run($args)
    {
		$day = date('l');
		$criteria = new CDbCriteria;
		$criteria->addCondition("day = '".$day."'");
		$overtime = Overtime::model()->find($criteria);

		if($overtime){
			// if (date("l") != $overtime->day){
			// 	echo 'tidak masuk day';echo date('l');echo $overtime->day;exit();
			// }else{
				echo 'masuk day = ';echo date('l');
				// if(date('H:i:s') >= $overtime->from_time && date('H:i:s') <= $overtime->to_time){
					echo '<br>masuk time = '.date('H:i:s');

					$criteria2 = new CDbCriteria;  
					$criteria2->addCondition("status = 0");
					$criteria2->addCondition("region_id is not null");
					$prospect = Prospect::model()->findAll($criteria2);
					$count = count($prospect);
					$_model = new SendMail;
					if($count > 0)
					{
						foreach ($prospect as $row) {
							$region = $row->region_id;
							$prospect_id = $row->id;
							// $cc_email = $row->from_email;
							$nik = $row->nik;
							$nama = $row->nama;
							$alamat = $row->alamat;
							$ttl = $row->ttl;
							$no_hp = $row->no_hp;
							$tipe = $row->tipe;
							$dp = $row->dp;
							$keterangan = $row->keterangan;
							$jam_survey = $row->jam_survey;
							$profil_konsumen = $row->profil_konsumen;
							$leasing_id_minus = $row->leasing_id_minus;
							
							$modelpros = Prospect::model()->findByPk($prospect_id);
							$modeluser = User::model()->findByPk($modelpros->user_id);
							$modeldealer = Dealer::model()->findByPk($modeluser->dealer_id);
							// $cc_email = $modeldealer->email;
							$cc_email = 'ebenk.rzq2@gmail.com';
							
							$region_name = Region::model()->findByPk($region);
							$region_name = $region_name->name;
							$this->GetLeasing($region,$prospect_id,$cc_email,$nama,$alamat,$ttl,$keterangan,$region_name,$jam_survey,$nik,$profil_konsumen,$leasing_id_minus);
							
							$_modelpros = Prospect::model()->findByPk($prospect_id);
							$_modelpros->status = 1;
							$_modelpros->updated_by = 'SYSTEM';
							$_modelpros->updated_at = new CDbExpression('NOW()');
							$_modelpros->update();
							
							date_default_timezone_set('Asia/Jakarta');
							$time = date('H');
							
							if($time >= 6 && $time < 10)
							{
								$timemessage = 'Pagi';
							}else if($time >= 10 && $time < 15)
							{
								$timemessage = 'Siang';
							}else if($time >= 15 && $time <= 18)
							{
								$timemessage = 'Sore';
							}else
							{
								$timemessage = 'Malam';
							}
							$sendnotifprospect = new SendNotifProspect;
							$sendnotifprospect->prospect_id = $prospect_id;
							$sendnotifprospect->email = $modeluser->email;
							$sendnotifprospect->status = 0;
							$sendnotifprospect->message = "Dear ".$modeluser->username."<br>Selamat ".$timemessage."<br><br>Data Prospect :<br><br>
							Profil Konsumen : ".$profil_konsumen."<br>
							Alamat : ".$alamat."<br>
							Tempat,Tanggal Lahir : ".$ttl."<br>
							No Hp : ".$no_hp."<br>
							Tipe : ".$tipe."<br>
							DP : ".$dp."<br>
							Jam Survey : ".$jam_survey."<br>
							keterangan : ".$keterangan."<br>
							Case Number : ".$prospect_id."<br>
							Region : ".$region_name."<br>
							NIK : ".$nik."<br>
							Nama : ".$nama."<br><br>
							Terima kasih sudah mengirimkan data Prospect.
							<br><br>Data akan segera dikirimkan ke Leasing terkait.<br><br>Terimakasih,<br><br>Best regards,<br><br>Sales Admin.";
							$sendnotifprospect->created_by = 'SYSTEM';
							$sendnotifprospect->created_at = new CDbExpression('NOW()');
							$sendnotifprospect->updated_at = new CDbExpression('NOW()');
							$sendnotifprospect->save();
						}
					}else
					{
						echo 'No row Prospect';
					}
				// }else{
				// 	echo '<br>tidak masuk time = '.date('H:i:s');exit();
				// }
			// }
		}
	}
	
	public function GetLeasing($region,$prospect_id,$cc_email,$nama,$alamat,$ttl,$keterangan,$region_name,$jam_survey,$nik,$profil_konsumen,$leasing_id_minus){
		$criteria3 = new CDbCriteria;  
		$criteria3->addCondition("region_id = ".$region."");
		$criteria3->addCondition("category not in ('Marketing Manager Area','Kepala Cabang Medan 1') or category is null");
		if(!empty($leasing_id_minus)){
			$criteria3->addCondition("id not in (".$leasing_id_minus.")");
		}
		$leasing = Leasing::model()->findAll($criteria3);
		$count = count($leasing);
		date_default_timezone_set('Asia/Jakarta');
		$time = date('H');
		
		if($time >= 6 && $time < 10)
		{
			$timemessage = 'Pagi';
		}else if($time >= 10 && $time < 15)
		{
			$timemessage = 'Siang';
		}else if($time >= 15 && $time <= 18)
		{
			$timemessage = 'Sore';
		}else
		{
			$timemessage = 'Malam';
		}
		
		if($count > 0)
		{
			foreach ($leasing as $row) {
				$uid = md5(uniqid(rand(), TRUE));
				$secretkey = md5(uniqid(rand(), TRUE));
				$_model = new SendMail;
				$leasing_id = $row->id;
				$email = $row->email;
				$nama = $nama;
				$namawinner = $row->nama;
				// $path = Yii::app()->basePath;
				// $path = 'http://localhost/alfa_scorpi/index.php/biddingprogram?id='.$leasing_id.'&secretkey='.$secretkey.'&idm='.$uid;
				$path = 'http://porto3.nadyne.com/alfa_scorpi/index.php/biddingprogram?id='.$leasing_id.'&secretkey='.$secretkey.'&idm='.$uid;
				
				$_model->uid_email = $uid;
				$_model->leasing_id = $leasing_id;
				$_model->prospect_id = $prospect_id;
				$_model->email = $email;
				$_model->cc_email = $cc_email;
				$_model->message = "Dear ".$namawinner."<br>Selamat ".$timemessage."<br><br>Data Prospect :<br><br>
				Profil Konsumen : ".$profil_konsumen."<br>
				Tempat,Tanggal Lahir : ".$ttl."<br>
				Jam Survey : ".$jam_survey."<br>
				Keterangan : ".$keterangan."<br>
				Case Number : ".$prospect_id."<br>
				Region : ".$region_name."<br>
				NIK : ".$nik."<br>
				Nama : ".$nama."<br><br>
				Bilamana anda ingin mengambil data prospect diatas klik link di bawah ini:
				<br>".$path."<br><br>Bilamana anda tidak tertarik, abaikan email ini.<br><br>Terimakasih,<br><br>Best regards,<br><br>Sales Admin.";
				$_model->status = 0;
				$_model->created_by = 'SYSTEM';
				$_model->created_at = new CDbExpression('NOW()');
				$_model->updated_at = new CDbExpression('NOW()');
				$_model->save();
				
				$_modelleasing = Leasing::model()->findByPk($leasing_id);
				$_modelleasing->secretkey = $secretkey;
				$_modelleasing->update();
				
				$modelsecretkey = new SecretKey;
				$modelsecretkey->secret_key = $secretkey;
				$modelsecretkey->leasing_id = $leasing_id;
				$modelsecretkey->prospect_id = $prospect_id;
				$modelsecretkey->created_by = 'SYSTEM';
				$modelsecretkey->created_at = new CDbExpression('NOW()');
				$modelsecretkey->updated_at = new CDbExpression('NOW()');
				$modelsecretkey->save();
			}
		}else
		{
			echo 'No row Leasing';
		}
	}
}