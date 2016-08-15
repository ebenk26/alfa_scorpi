<?php

class SendremindersCommand extends CConsoleCommand
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

					require 'PHPMailer/PHPMailerAutoload.php';
					
					$criteria = new CDbCriteria;  
					$criteria->addCondition("status = 1");
					$criteria->addCondition("(reminder_status is null) OR (reminder_status < 3)");
					$criteria->addCondition("winner_confirm = 1");
					$criteria->limit = 20;
					$sendwinner = Winner::model()->findAll($criteria);
					$count = count($sendwinner);
					
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
					{// echo 'masuk if';exit();
						foreach ($sendwinner as $row) {
						$timeplus = strtotime($row->created_at)+10800;
						$timeplus1 = strtotime($row->created_at)+3600;
						$timeplus2 = strtotime($row->created_at)+7200;
						$timeplus3 = strtotime($row->created_at)+10000;
						$timenow = strtotime(date('Y-m-d H:i:s'));
							
								$id = $row->id;
								$prospect_id = $row->prospect_id;
								$to_email = $row->email;
								$leasing_id = $row->leasing_id;
								$from_mail = FromEmail::model()->findByPk(1);
								// $email = "smsincoming@nadyne.com";
								$email = $from_mail->email;
								$cc = $row->cc_email;
								$message = $row->message;
								
								$_modelpros = Prospect::model()->findByPk($prospect_id);
								$array = preg_split("/[[:space:]]+/",$_modelpros->jam_survey);
								$strexplode = explode(' ', $_modelpros->jam_survey);
								$strexplode2 = explode('-', $array[0]);
								$year = $strexplode2[2].'-';
								$month = $strexplode2[1].'-';
								$date = $strexplode2[0].' ';
								$time = $array[1];
								$timestamppros = strtotime($year.$month.$date.$time); // jam survey
								if(strtotime(date('Y-m-d H:i')) <= $timestamppros){
									echo 'belum masuk jam survey';
								}else{
									echo 'sudah masuk jam survey';
								
								$_modelreg = Region::model()->findByPk($_modelpros->region_id);
								$criteria = new CDbCriteria;  
								$criteria->addCondition("leasing_id = '".$leasing_id."'");
								$criteria->addCondition("prospect_id = '".$prospect_id."'");
								$modelsecretkey = SecretKey::model()->find($criteria);
								$secretkey = $modelsecretkey->secret_key;
								$_modelleas = Leasing::model()->findByPk($leasing_id);
								$path = 'http://porto3.nadyne.com/alfa_scorpi/index.php/prospect/update/'.$prospect_id.'?id='.$prospect_id.'&secretkey='.$secretkey.'&id2='.$row->id.'&id3='.$leasing_id;
								
								$pathreject = 'http://porto3.nadyne.com/alfa_scorpi/index.php/reject?id='.$prospect_id.'&secretkey='.$secretkey.'&id2='.$row->id.'&id3='.$leasing_id;

								$pathcancel = 'http://porto3.nadyne.com/alfa_scorpi/index.php/cancel?id='.$prospect_id.'&secretkey='.$secretkey.'&id2='.$row->id.'&id3='.$leasing_id;
								
								$_model = new SendReminder;
								$_model->leasing_id = $leasing_id;
								$_model->prospect_id = $prospect_id;
								$_model->email = $to_email;
								// $_model->cc_email = $row->cc_email;
								$_model->cc_email = $cc;
								$_model->message = "Dear ".$_modelleas->nama."<br>Selamat ".$timemessage."<br><br>Data Prospect :<br><br>
												NIK : ".$_modelpros->nik."<br>
												Nama : ".$_modelpros->nama."<br>
												Alamat : ".$_modelpros->alamat."<br>
												Tempat,Tanggal Lahir : ".$_modelpros->ttl."<br>
												No HP : ".$_modelpros->no_hp."<br>
												Tipe : ".$_modelpros->tipe."<br>
												DP : ".$_modelpros->dp."<br>
												Jam Survey : ".$_modelpros->jam_survey."<br>
												Keterangan : ".$_modelpros->keterangan."<br>
												Profil Survey : ".$_modelpros->profil_konsumen."<br>
												Case Number : ".$prospect_id."<br>
												Region : ".$_modelreg->name."<br><br>
												Kami akan menunggu feedback dari anda sampai 3 Jam sejak data diambil.<br><br>
												Bilamana anda ingin mengambil data prospect diatas klik link di bawah ini:<br>
												<br>".$path."<br><br>Jika anda ingin menolak prospect diatas klik link di bawah ini:<br>
												<br>".$pathreject."<br><br>
												Dan jika anda ingin cancel klik link di bawah ini:<br>
												<br>".$pathcancel."<br><br>
												Terimakasih,<br><br>Best regards,<br><br>Sales Admin.";
								$_model->status = 1;
								$_model->created_by = 'SYSTEM';
								$_model->created_at = new CDbExpression('NOW()');
								$_model->updated_at = new CDbExpression('NOW()');
								
								$updatewinner = Winner::model()->findByPk($row->id);
								if(empty($row->reminder_status))
								{
									$updatewinner->reminder_status = 1;
								}else if($row->reminder_status == 1)
								{
									$updatewinner->reminder_status = 2;
								}else
								{
									$updatewinner->reminder_status = 3;
								}
								$updatewinner->updated_by = 'SYSTEM';
								$updatewinner->updated_at = new CDbExpression('NOW()');
								
								//PHPMailer Object
								$mail2 = new PHPMailer;

								$mail2->isSMTP();                                      // Set mailer to use SMTP
								$mail2->Host = 'ginger.gotnotice.com';  // Specify main and backup SMTP servers
								$mail2->SMTPAuth = true;                               // Enable SMTP authentication
								$mail2->Username = 'smsincoming@nadyne.com';                 // SMTP username
								$mail2->Password = 'iniSmsYamaha889';                      // SMTP password
								// $mail2->Username = 'rizky@nadyne.com';                 // SMTP username
								// $mail2->Password = 'rizky7889';                      // SMTP password
								// $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
								$mail2->Port = 10025;                                    // TCP port to connect to

								$mail2->setFrom($email, 'No Reply');
								// $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
								$mail2->addAddress($to_email);               // Name is optional
								// $mail->addReplyTo('info@example.com', 'Information');
								$mail2->addCC($cc);
								// $mail->addBCC('bcc@example.com');

								// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
								// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
								$mail2->isHTML(true);                                  // Set email format to HTML

								if(!empty($_modelpros->last_case_id)){
									$mail2->Subject = 'Bidding Program '.date('m').'-'.$prospect_id.' (RE:'.$_modelpros->last_case_id.')';
								}else{
									$mail2->Subject = 'Bidding Program '.date('m').'-'.$prospect_id;
								}
								$mail2->Body    = $_model->message;
								$mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';
							if($row->reminder_status == 0 || empty($row->reminder_status) )
							{
								if(!$mail2->send()) {
									echo 'Message could not be sent.';
									echo 'Mailer Error: ' . $mail2->ErrorInfo;
								} else {
									echo 'Message has been sent';
									$_model->save();
									$updatewinner->update();
								}
								echo 'sudah 1 kali reminder winner';
							}elseif($row->reminder_status == 1)
							{
								if(!$mail2->send()) {
									echo 'Message could not be sent.';
									echo 'Mailer Error: ' . $mail2->ErrorInfo;
								} else {
									echo 'Message has been sent';
									$_model->save();
									$updatewinner->update();
								}
								echo 'sudah 2 kali reminder winner';
							}elseif($row->reminder_status == 2)
							{
								if(!$mail2->send()) {
									echo 'Message could not be sent.';
									echo 'Mailer Error: ' . $mail2->ErrorInfo;
								} else {
									echo 'Message has been sent';
									$_model->save();
									$updatewinner->update();
								}
								echo 'sudah 3 kali reminder winner';
							}else
							{
								echo 'reminder winner sudah 3 kali';
							}
							}
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
		// $this->render('index');
	}
	
}