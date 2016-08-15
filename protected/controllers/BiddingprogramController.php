<?php

class BiddingprogramController extends Controller
{
	public function actionIndex()
	{
		date_default_timezone_set("Asia/Jakarta");
		if(isset($_POST['input_ro'])){
		echo $_POST['input_ro'];
		}
		$id = $_GET['id'];
		$secretkey = $_GET['secretkey'];
		$idm = $_GET['idm'];
		$nama = '';
		$alamat = '';
		$token = '';
		$return = '';
		// echo $id.$email;
		$criteria3 = new CDbCriteria;  
		$criteria3->addCondition("secret_key = '".$secretkey."'");
		$modelsecretkey = SecretKey::model()->find($criteria3);
		$leasing = Leasing::model()->findByPk($modelsecretkey->leasing_id);
		
		// $modelsend = new SendMail;
		// $modelsend->bidding_status = 1;
		// $modelsend->save();
		
		$criteria = new CDbCriteria;  
		$criteria->addCondition("uid_email = '".$idm."'");
		$sendmail = SendMail::model()->find($criteria);
		
		$prospect_id = '';
		$prospect_name = '';
		$prospect_alamat = '';
		$prospect_ttl = '';
		$prospect_nohp = '';
		$prospect_tipe = '';
		$prospect_dp = '';
		$prospect_jamsurvey = '';
		$prospect_noro = '';
		$prospect_keterangan = '';
		$prospect_region_id = '';
		$prospect_region = '';
		$prospect_nik = '';
		$prospect_profil = '';
		
		// $bidtimeplus = +300; //300sec=5menit
		$date = date('Y-m-d H:i:s');
		// echo $date.'===='.$sendmail->created_at;
		$strtimenow = strtotime($date);
		$timeallow = $strtimenow - strtotime($sendmail->created_at);
		if($timeallow <= 300)
		// if(200 <= 300)
		{
			if(!empty($sendmail->bidding_time))
			{
				$nama = $leasing->nama;
				$alamat = $leasing->alamat;
				$token = $leasing->token;
				$return = 'Anda sudah melakukan bidding';
			}else
			{
				if($leasing)
				{
					$nama = $leasing->nama;
					$alamat = $leasing->alamat;
					$token = $leasing->token;
					
					$prospect_id = $sendmail->prospect_id;
					$prospect = Prospect::model()->findByPk($prospect_id);
					$prospect_name = $prospect->nama;
					$prospect_alamat = $prospect->alamat;
					$prospect_ttl = $prospect->ttl;
					$prospect_keterangan = $prospect->keterangan;
					$prospect_region_id = $prospect->region_id;
					$region = Region::model()->findByPk($prospect_region_id);
					$prospect_region = $region->name;
					$prospect_nik = $prospect->nik;
					$prospect_nohp = $prospect->no_hp;
					$prospect_tipe = $prospect->tipe;
					$prospect_dp = $prospect->dp;
					$prospect_jamsurvey = $prospect->jam_survey;
					$prospect_noro = $prospect->no_ro;
					$prospect_profil = $prospect->profil_konsumen;
				}
				if(isset($_GET['input_token']))
				{
					if(empty($_GET['input_token']))
					{
						$return = 'Silahkan input token';
					}else
					{
						$token = $_GET['input_token'];
						$foto_ro = $_GET['foto_bid'];
						$no_ro = $_GET['input_ro'];
						
						$_modelleasing = Leasing::model()->findByPk($id);
						if($_modelleasing->token >= $token)
						{
							$token_update = $_modelleasing->token - $token;
							$token = $_modelleasing->token - $token;
							$_modelleasing->token = $token_update;
							$_modelleasing->update();
							
							$sendmailupdate = SendMail::model()->findByPk($sendmail->id);
							$sendmailupdate->bidding_time = new CDbExpression('NOW()');
							$bidding_time1 = date('Y-m-d H:i:s');
							$bidding_time2 = strtotime($bidding_time1);
							$bidding_time3 = $bidding_time2 - ($token*60); //biddingtimestamp - token*60
							$sendmailupdate->bidding_token = $_GET['input_token'];
							
							$date = date_create();
							date_timestamp_set($date, $bidding_time3);
							$bidding_time4 = date_format($date, 'Y-m-d H:i:s');
							
							$sendmailupdate->bidding_token_time = $bidding_time4;
							$sendmailupdate->update();
							$return = 'Token berhasil di input';
							$token = $_modelleasing->token - $token;
							
							print_r($_FILES['foto_ro']);exit();
							$prospect->foto_ro = $foto_ro;
							$prospect->no_ro = $no_ro;
							$prospect->update();
						}else
						{
							$token = $_modelleasing->token;
							$return = 'Token tidak mencukupi';
						}
					}
				}
			}
		}else{
			$sendmailupdate = SendMail::model()->findByPk($sendmail->id);
			$sendmailupdate->time_up = 1;
			$sendmailupdate->updated_at = new CDbExpression('NOW()');
			$sendmailupdate->update();
			$return = 'Time Up';
		}
		$this->render('index',array(
			'id' => $id,
			'idm' => $idm,
			'nama' => $nama,
			'alamat' => $alamat,
			'token' => $token,
			'secretkey' => $secretkey,
			'return' => $return,
			'prospect_name' => $prospect_name,
			'prospect_alamat' => $prospect_alamat,
			'prospect_ttl' => $prospect_ttl,
			'prospect_keterangan' => $prospect_keterangan,
			'prospect_region' => $prospect_region,
			'prospect_nik' => $prospect_nik,
			'prospect_nohp' => $prospect_nohp,
			'prospect_tipe' => $prospect_tipe,
			'prospect_dp' => $prospect_dp,
			'prospect_jamsurvey' => $prospect_jamsurvey,
			'prospect_noro' => $prospect_noro,
			'prospect_profil' => $prospect_profil,
		));
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