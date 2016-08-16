<?php

class GetwinnerController extends Controller
{
	public function actionIndex()
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

					$criteria = new CDbCriteria; 
					$criteria->addCondition("bid_from_time is not null");
					$criteria->addCondition("has_winner is null");
					$prospect = Prospect::model()->findAll($criteria);
					$count = count($prospect);
					if($prospect)
					{
						if($count > 0)
						{ 
							$criteria2 = new CDbCriteria; 
							$criteria2->addCondition("bidding_time is not null");
							$sendmail = SendMail::model()->findAll($criteria2);
							$count2 = count($sendmail);
							if($count2 > 0)
							{ 
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
								// echo 'masuk';exit();
								$date = date('Y-m-d H:i:s');
								$strtimenow = strtotime($date);
								foreach ($prospect as $row) {
									$timegetwinner = strtotime($row->created_at) + 420; //gettimewinner setiap 7 menit
									$nik = $row->nik;
									$tipe = $row->tipe;
									$no_hp = $row->no_hp;
									$dp = $row->dp;
									$jam_survey = $row->jam_survey;
									$prospect_id = $row->id;
									$nama = $row->nama;
									$alamat = $row->alamat;
									$ttl = $row->ttl;
									$keterangan = $row->keterangan;
									$region_id = $row->region_id;
									$bid_from_time = $row->bid_from_time;
									$profil_konsumen = $row->profil_konsumen;
									$bidtimeplus = strtotime($bid_from_time)+300; //300sec=5menit
									// echo $prospect_id.$bid_from_time;exit();
									$getregion = $this->getDataRegion($region_id);
									$getdataid = $this->getDataEmailid($prospect_id,$bidtimeplus);
									$getdataemail = $this->getDataEmail($prospect_id,$bidtimeplus);
									$getdataccemail = $this->getDataCcEmail($prospect_id,$bidtimeplus);
									$getdataprospectid = $this->getDataprospectid($prospect_id,$bidtimeplus);
									$getdataleasingid = $this->getDataleasingid($prospect_id,$bidtimeplus);
									$getdataleasingname = $this->getDataleasingname($getdataleasingid);
									$getsecretkeyleasing = $this->getSecretKeyLeasing($getdataleasingid,$getdataprospectid);
									$path = 'http://porto3.nadyne.com/alfa_scorpi/index.php/winner?id='.$prospect_id.'&secretkey='.$getsecretkeyleasing;
									
									$message = "Dear ".$getdataleasingname."<br>Selamat ".$timemessage."<br><br>Data Prospect :<br><br>
									NIK : ".$nik."<br>
									Nama : ".$nama."<br>
									Alamat : ".$alamat."<br>
									Tempat,Tanggal Lahir : ".$ttl."<br>
									No HP : ".$no_hp."<br>
									Tipe : ".$tipe."<br>
									DP : ".$dp."<br>
									Jam Survey : ".$jam_survey."<br>
									keterangan : ".$keterangan."<br>
									Profil Konsumen : ".$profil_konsumen."<br>
									Case Number : ".$prospect_id."<br>
									Region : ".$getregion."<br><br>
									Selamat anda telah memenangkan prospect tersebut.<br>Untuk mengambil prospect silahkan klik link berikut :<br><br>
									".$path."<br><br>Terimakasih,<br><br>Best regards,<br><br>Sales Admin.";
									if(!empty($getdataprospectid) && $strtimenow >= $timegetwinner)
									{
										echo 'waktunya gettimewinner';
										$modelpros = Prospect::model()->findByPk($prospect_id);
										$modeluser = User::model()->findByPk($modelpros->user_id);
										$modeldealer = Dealer::model()->findByPk($modeluser->dealer_id);
										// $cc_email = $modeldealer->email;
										$cc_email = 'ebenk.rzq2@gmail.com';
									
										$_model = new Winner;
										$_model->message = $message;
										$_model->leasing_id = $getdataleasingid;
										$_model->prospect_id = $getdataprospectid;
										// $_model->cc_email = $getdataccemail;
										$_model->cc_email = $cc_email;
										$_model->email = $getdataemail;
										$_model->send_email_id = $getdataid;
										$_model->status = 0;
										$_model->created_by = 'SYSTEM';
										$_model->created_at = new CDbExpression('NOW()');
										$_model->updated_at = new CDbExpression('NOW()');
										$_model->save();
										
										$_modelsend = Prospect::model()->findByPk($getdataprospectid);
										$_modelsend->has_winner = 1;
										$_modelsend->updated_at = new CDbExpression('NOW()');
										$_modelsend->update();
										
										$this->blasmailwinner($getdataprospectid,$getdataleasingid,$nama,$alamat,$ttl,$keterangan,$getregion,$getdataleasingname,$cc_email,$jam_survey,$nik);
									}else{
										echo 'belum waktunya gettimewinner';
									}
									
									// echo $getdataid.'-'.$getdataemail.'-'.$getdataccemail.'-'.$getdataprospectid.'-'.$getdataleasingid.'-'.$getdataleasingname;
									
								} // end foreach
							}
						}
					}else
					{
						echo 'tidak ada winner';
					}
				// }else{
				// 	echo '<br>tidak masuk time = '.date('H:i:s');exit();
				// }
			// }
		}
		// $this->render('index');
	}
	
	public function getDataRegion($region_id){
		$regionname = Region::model()->findByPk($region_id);
		if($regionname)
		{
			$region = $regionname->id;
		}else
		{
			$region = '';
		}
		// echo $id;
		return $region;
	}
	
	public function getDataEmailid($prospect_id,$bidtimeplus){
		// echo 'masuk getemailid';
		$date = date_create();
		date_timestamp_set($date, $bidtimeplus);
		$bidtime = date_format($date, 'Y-m-d H:i:s');
		// echo $bidtime;
		$criteria = new CDbCriteria;  
		$criteria->select='IF(bidding_token="RO","menang","normal") as token,id,email,cc_email,prospect_id,leasing_id';
		$criteria->addCondition("prospect_id = '".$prospect_id."'");
		$criteria->addCondition("bidding_time <= '".$bidtime."'");
		$criteria->order = 'token asc,bidding_token_time asc';
		$sendmail = SendMail::model()->find($criteria);
		if($sendmail)
		{
			$id = $sendmail->id;
		}else
		{
			$id = '';
		}
		// echo $id;
		return $id;
	}

	public function getDataEmail($prospect_id,$bidtimeplus){
		$date = date_create();
		date_timestamp_set($date, $bidtimeplus);
		$bidtime = date_format($date, 'Y-m-d H:i:s');
		$criteria = new CDbCriteria;  
		$criteria->select='IF(bidding_token="RO","menang","normal") as token,id,email,cc_email,prospect_id,leasing_id';
		$criteria->addCondition("prospect_id = '".$prospect_id."'");
		$criteria->addCondition("bidding_time <= '".$bidtime."'");
		$criteria->order = 'token asc,bidding_token_time asc';
		$sendmail = SendMail::model()->find($criteria);
		if($sendmail)
		{
			$email = $sendmail->email;
		}else
		{
			$email = '';
		}
		return $email;
	}

	public function getDataCcEmail($prospect_id,$bidtimeplus){
		$date = date_create();
		date_timestamp_set($date, $bidtimeplus);
		$bidtime = date_format($date, 'Y-m-d H:i:s');
		$criteria = new CDbCriteria;  
		$criteria->select='IF(bidding_token="RO","menang","normal") as token,id,email,cc_email,prospect_id,leasing_id';
		$criteria->addCondition("prospect_id = '".$prospect_id."'");
		$criteria->addCondition("bidding_time <= '".$bidtime."'");
		$criteria->order = 'token asc,bidding_token_time asc';
		$sendmail = SendMail::model()->find($criteria);
		if($sendmail)
		{
			$cc_email = $sendmail->cc_email;
		}else
		{
			$cc_email = '';
		}
		return $cc_email;
	}

	public function getDataprospectid($prospect_id,$bidtimeplus){
		$date = date_create();
		date_timestamp_set($date, $bidtimeplus);
		$bidtime = date_format($date, 'Y-m-d H:i:s');
		$criteria = new CDbCriteria;  
		$criteria->select='IF(bidding_token="RO","menang","normal") as token,id,email,cc_email,prospect_id,leasing_id';
		$criteria->addCondition("prospect_id = '".$prospect_id."'");
		$criteria->addCondition("bidding_time <= '".$bidtime."'");
		$criteria->order = 'token asc,bidding_token_time asc';
		$sendmail = SendMail::model()->find($criteria);
		if($sendmail)
		{
			$prospect_id = $sendmail->prospect_id;
		}else
		{
			$prospect_id = '';
		}
		return $prospect_id;
	}

	public function getDataleasingid($prospect_id,$bidtimeplus){
		$date = date_create();
		date_timestamp_set($date, $bidtimeplus);
		$bidtime = date_format($date, 'Y-m-d H:i:s');
		$criteria = new CDbCriteria;  
		$criteria->select='IF(bidding_token="RO","menang","normal") as token,id,email,cc_email,prospect_id,leasing_id';
		$criteria->addCondition("prospect_id = '".$prospect_id."'");
		$criteria->addCondition("bidding_time <= '".$bidtime."'");
		$criteria->order = 'token asc,bidding_token_time asc';
		$sendmail = SendMail::model()->find($criteria);
		if($sendmail)
		{
			$leasing_id = $sendmail->leasing_id;
		}else
		{
			$leasing_id = '';
		}
		return $leasing_id;
	}

	public function getdataleasingname($getdataleasingid){
		$username = Leasing::model()->findByPk($getdataleasingid);
		if($username)
		{
			$nama = $username->nama;
		}else
		{
			$nama = '';
		}
		return $nama;
	}

	public function getSecretKeyLeasing($getdataleasingid,$getdataprospectid){
		$criteria = new CDbCriteria;  
		$criteria->addCondition("leasing_id = '".$getdataleasingid."'");
		$criteria->addCondition("prospect_id = '".$getdataprospectid."'");
		$username = SecretKey::model()->find($criteria);
		if($username)
		{
			$secretkey = $username->secret_key;
		}else
		{
			$secretkey = '';
		}
		return $secretkey;
	}

	public function blasmailwinner($getdataprospectid,$getdataleasingid,$nama,$alamat,$ttl,$keterangan,$getregion,$getdataleasingname,$cc_email,$jam_survey,$nik){
		$criteria = new CDbCriteria;  
		$criteria->addCondition("prospect_id = '".$getdataprospectid."'");
		$sendmail = SendMail::model()->findAll($criteria);
		$count = count($sendmail);
		
		$connection=Yii::app()->db;
		$command= $connection->createCommand("select b.nama as region,c.name as leasing_terlibat,a.bidding_token,a.bidding_token_time from send_mail a
											left join leasing b on a.leasing_id = b.id
											left join region c on b.region_id = c.id
											where prospect_id = '".$getdataprospectid."'
											order by a.bidding_token_time asc");
		$rows = $command->queryAll();
		$dataReader=$command->query();
		$rowsCount = $dataReader->getRowCount();
		if($rowsCount > 0)
		{
		
			$headertable = "<table style='border:1px solid black'>
				<thead align='left' style='display: table-header-group'>
				<tr>
				<th style='border:1px solid black'>No </th>
				<th style='border:1px solid black'>Leasing Terlibat </th>
				<th style='border:1px solid black'>Region </th>
				<th style='border:1px solid black'>Point Bid </th>
				<th style='border:1px solid black'>Time After Bid </th>
				</tr>
				</thead>
				<tbody>
				";
			$total = 0;
			$data = array();
			foreach ($rows as $row) {
				$data[] = "<tr class='item_row'>
				<td style='border:1px solid black'> ".++$total." </td>
				<td style='border:1px solid black'>  ".$row['region']." </td>
				<td style='border:1px solid black'>  ".$row['leasing_terlibat']." </td>
				<td style='border:1px solid black'>  ".$row['bidding_token']." </td>
				<td style='border:1px solid black'>  ".$row['bidding_token_time']." </td>
				</tr>
				";
			}
			$footertable = "</tbody>
							</table>";
		}else{
			$arr_data = array("" => "");
		}
		$datas = implode("",$data);
		$inserttable = $headertable.$datas.$footertable;
		
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
			foreach ($sendmail as $row) {
				$criteria3 = new CDbCriteria;  
				$leasing = Leasing::model()->findByPk($row->leasing_id);
				
				$_model = new SendMailWinner;
				// $_model->uid_email = $uid;
				$_model->leasing_id = $row->leasing_id;
				$_model->prospect_id = $row->prospect_id;
				$_model->email = $row->email;
				// $_model->cc_email = $row->cc_email;
				$_model->cc_email = $cc_email;
				$_model->message = "Dear ".$leasing->nama."<br>Selamat ".$timemessage."<br><br>Data Prospect :<br><br>
								NIK : ".$nik."<br>
								Nama : ".$nama."<br>
								Tempat,Tanggal Lahir : ".$ttl."<br>
								Jam Survey : ".$jam_survey."<br>
								keterangan : ".$keterangan."<br>
								Case Number : ".$getdataprospectid."<br>
								Region : ".$getregion."<br><br>
								Dan Pemenangnya adalah ".$getdataleasingname."<br><br>
								Dengan rincian bid sebagai berikut :
								<br>".$inserttable."<br><br>Terimakasih,<br><br>Best regards,<br><br>Sales Admin.";
				$_model->status = 0;
				$_model->created_by = 'SYSTEM';
				$_model->created_at = new CDbExpression('NOW()');
				$_model->updated_at = new CDbExpression('NOW()');
				// $_model->save();
				// print_r($_model);
				// if ($_model->save(false)) {
				// 	echo "save";
				// }else{
				// 	echo "tidak save";
				// }
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