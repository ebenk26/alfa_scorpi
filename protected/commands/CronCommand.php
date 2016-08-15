<?php

class CronCommand extends CConsoleCommand
    {
    public function run($args)
    {
    // Do stuff
	// echo 'masuk cron';
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


					$hostname = '{libra.gotnotice.com:143/imap/notls}INBOX';
					$username = 'smsincoming@nadyne.com';
					$password = 'iniSmsYamaha889';
					// $username = 'rizky@nadyne.com';
					// $password = 'rizky7889';
					$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to server: ' . imap_last_error());
					$n_msgs = imap_num_msg($inbox);
					$emails = imap_search ( $inbox, "UNSEEN");
					if($emails) {
						$count = 1;

						/* put the newest emails on top */
						rsort($emails);

						/* for every email... */
						foreach($emails as $email_number)
						{
							#var_dump($emails);
							
							/* get information specific to this email */
							$overview = imap_fetch_overview($inbox, $email_number, 0);
							echo "<pre>";
							print_r($overview);
							echo "</pre>";
							
							/* get mail message */
							$message = imap_fetchbody($inbox,$email_number,1);
							
							/* get mail from */
							$header = imap_headerinfo($inbox,$email_number);
							$from = $header->from[0]->mailbox . "@" . $header->from[0]->host;
							
							/* get mail password from object */
							$password = md5($overview[0]->subject);
							$udate = $overview[0]->udate;
							
							/* search specific user */
							$criteria = new CDbCriteria;  
							$criteria->addCondition("email = '".$from."' and password = '".$password."' and role_id in (3,4)");
							$user = User::model()->find($criteria);
							
							/* search specific prospect */
							$criteria2 = new CDbCriteria;  
							$criteria2->addCondition("udate = '".$udate."'");
							$prospect = Prospect::model()->findAll($criteria2);
							$count = count($prospect);
							$user_id = '';
							
							/* load model prospect */
							$_model = new Prospect;
							
							/* if there is record in prospect */
							if($count > 0)
							{
								
							}
							/* else there is NO record in prospect */
							else
							{
								if($user)
								{
									$user_id = $user->id;
								}else
								{
									/* load model inbox */
									$_model = new inbox;
									$_model->message = $message;
								}
								$explode = explode('-----',$message);
								$res = explode('#',$explode[0]);
								$maxres = count($res);
								echo count($res);
								$nik = '';
								$nama = '';
								$alamat = '';
								$ttl = '';
								$no_hp = '';
								$tipe = '';
								$dp = '';
								$jam_survey = '';
								$keterangan = '';
								$region = '';
								$profil_konsumen = '';
								$return = '';
								if(isset($res[0]))
								{
									$nik = $res[0];
								}
								if(isset($res[1]))
								{
									$nama = $res[1];
								}
								if(isset($res[2]))
								{
									$alamat = $res[2];
								}
								if(isset($res[3]))
								{
									$ttl = $res[3];
								}
								if(isset($res[4]))
								{
									$no_hp = $res[4];
								}
								if(isset($res[5]))
								{
									$tipe = $res[5];
								}
								if(isset($res[6]))
								{
									$dp = $res[6];
								}
								if(isset($res[7]))
								{
									$jam_survey = $res[7];
								}
								if(isset($res[8]))
								{
									$keterangan = $res[8];
								}
								if(isset($res[9]))
								{
									// $region = $res[9];
									$region = $user->region_id;
								}
								if(isset($res[10]))
								{
									$profil_konsumen = $res[10];
								}
								if(isset($res[11]) && $maxres <= 12)
								{
									$nama_salesman = $res[11];

									$_model->id = $nik;
									$_model->nik = $nik;
									$_model->nama = $nama;
									$_model->alamat = $alamat;
									$_model->ttl = $ttl;
									$_model->no_hp = $no_hp;
									$_model->tipe = $tipe;
									$_model->dp = $dp;
									$_model->jam_survey = $jam_survey;
									$_model->keterangan = $keterangan;
									$_model->region_id = $region;
									$_model->profil_konsumen = $profil_konsumen;
									$_model->user_id = $user_id;
									$_model->udate = $udate;
									$_model->from_email = $from;
									$_model->nama_salesman = $nama_salesman;
									$_model->status = 0;
									$_model->created_by = 'SYSTEM';
									$_model->created_at = new CDbExpression('NOW()');
									$_model->updated_at = new CDbExpression('NOW()');

									$errormail = new ErrorGrabMail;
									$users = User::model()->findByPk($user->id);

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

									$errormail->email = $from;
									$errormail->created_by = 'SYSTEM';
									$errormail->created_at = new CDbExpression('NOW()');
									$errormail->cc_email = 'ebenk.rzq2@gmail.com';
																	
									$array = preg_split("/[[:space:]]+/",$jam_survey);
									if($array[0] && isset($array[1])){
										
										$strexplode2 = explode('-', $array[0]);
										$strexplode3 = explode(':', $array[1]);
										if (array($strexplode2) && array($strexplode3)) {
											if(isset($strexplode2[2]) && isset($strexplode2[1]) && isset($strexplode2[0]) && isset($strexplode3[1]) && isset($strexplode3[0])){
												if ((is_numeric($strexplode2[2]) && strlen($strexplode2[2]) == 4) && (is_numeric($strexplode2[1]) && strlen($strexplode2[1]) == 2) && (is_numeric($strexplode2[0]) && strlen($strexplode2[0]) == 2) && (is_numeric($strexplode3[1]) && strlen($strexplode3[1]) == 2) && (is_numeric($strexplode3[0]) && strlen($strexplode3[0]) == 2)) {
													$return .= "true1";
													echo "true1";
													$messages = "Dear ".$users->name."<br>
																Selamat ".$timemessage."<br>

																Data Prospect yang anda kirimkan salah :<br>
																".$message."<br><br>
																Dengan Error sebagai berikut : <b>".$return."</b><br><br>
																Pastikan format yang anda gunakan Benar.<br>
																Format benar :<br>
																NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
																Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
																dd-mm-yyyy hh:mm<br><br>
																Terimakasih,<br>
																Best regards,<br>
																Admin
																";
													$errormail->message = $messages;
													// $_model->save();
													
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
													
													
													
													$_model->case_id = date('ymd')."-".$count_id;
													if($_model->save())
													{
														
													}
												}else{
													$return .= "Format jam dan tanggal salah ('dd-mm-yyyy hh:mm') ";
													echo "Format jam dan tanggal salah ('dd-mm-yyyy hh:mm') ";
													$errormail->reason = $return;
													$messages = "Dear ".$users->name."<br>
																Selamat ".$timemessage."<br>

																Data Prospect yang anda kirimkan salah :<br>
																".$message."<br><br>
																Dengan Error sebagai berikut : <b>".$return."</b><br><br>
																Pastikan format yang anda gunakan Benar.<br>
																Format benar :<br>
																NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
																Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
																dd-mm-yyyy hh:mm<br><br>
																Terimakasih,<br>
																Best regards,<br>
																Admin
																";
													$errormail->message = $messages;
													$errormail->save();
												}
											}else{
												$return .= "Format jam dan tanggal salah";
												echo "Format jam dan tanggal salah";
												$errormail->reason = $return;
												$messages = "Dear ".$users->name."<br>
																Selamat ".$timemessage."<br>

																Data Prospect yang anda kirimkan salah :<br>
																".$message."<br><br>
																Dengan Error sebagai berikut : <b>".$return."</b><br><br>
																Pastikan format yang anda gunakan Benar.<br>
																Format benar :<br>
																NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
																Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
																dd-mm-yyyy hh:mm<br><br>
																Terimakasih,<br>
																Best regards,<br>
																Admin
																";
												$errormail->message = $messages;
												$errormail->save();
											}
										}else{
											$return .= "Format jam dan tangggal tidak ada '-' atau ':' ";
											echo "Format jam dan tangggal tidak ada '-' atau ':'";
											$errormail->reason = $return;
											$messages = "Dear ".$users->name."<br>
																Selamat ".$timemessage."<br>

																Data Prospect yang anda kirimkan salah :<br>
																".$message."<br><br>
																Dengan Error sebagai berikut : <b>".$return."</b><br><br>
																Pastikan format yang anda gunakan Benar.<br>
																Format benar :<br>
																NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
																Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
																dd-mm-yyyy hh:mm<br><br>
																Terimakasih,<br>
																Best regards,<br>
																Admin
																";
											$errormail->message = $messages;
											$errormail->save();
										}
										// exit();
									}else{
										$return .= "Format jam dan tanggal tidak ada spasi atau ada spasi setelah hashtag (#) ";
										echo "Format jam dan tanggal tidak ada spasi atau ada spasi setelah hashtag (#) ";
										$errormail->reason = $return;
										$messages = "Dear ".$users->name."<br>
															Selamat ".$timemessage."<br>

															Data Prospect yang anda kirimkan salah :<br>
															".$message."<br><br>
															Dengan Error sebagai berikut : <b>".$return."</b><br><br>
															Pastikan format yang anda gunakan Benar.<br>
															Format benar :<br>
															NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
															Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
															dd-mm-yyyy hh:mm<br><br>
															Terimakasih,<br>
															Best regards,<br>
															Admin
															";
										$errormail->message = $messages;
										$errormail->save();
										// exit();
									}
								}else{
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
									$return .= "Jumlah hashtag '#' kurang atau lebih dari 11 ";
									echo  "Jumlah hashtag '#' kurang atau lebih dari 11 ";
									$errormail = new ErrorGrabMail;
									$criteria = new CDbCriteria;  
									$criteria->addCondition("email = '".$from."' and password = '".$password."'");
									$user = User::model()->find($criteria);
									if ($user) {
										$messages = "Dear ".$user->name."<br>
													Selamat ".$timemessage."<br>

													Data Prospect yang anda kirimkan salah :<br>
													".$message."<br><br>
													Dengan Error sebagai berikut : <b>".$return."</b><br><br>
													Pastikan format yang anda gunakan Benar.<br>
													Format benar :<br>
													NIK#Nama Prospect#Alamat#Tempat, tanggal lahir#No Telepon#Tipe Motor#DP yang disetujui# Tanggal & Jam survey#Keterangan#Region#Status Konsumen#Nama Salesman<br>
													Pastikan tidak menggunakan enter di setiap hastag (#) dan format dalam penulisan jam survey tidak salah, yaitu :<br>
													dd-mm-yyyy hh:mm<br><br>
													Terimakasih,<br>
													Best regards,<br>
													Admin
													";
										$errormail->message = $messages;
										$errormail->email = $from;
										$errormail->created_by = 'SYSTEM';
										$errormail->created_at = new CDbExpression('NOW()');
										$errormail->cc_email = 'ebenk.rzq2@gmail.com';
										$errormail->reason = 'error no 11 #';
										$errormail->save();
										}
								}
							}
								$status = imap_setflag_full($inbox, $email_number, "\\Seen", ST_UID);
								echo gettype($status) . "\n";
								echo $status . "\n";
								if($count++ >= $email_number) break;
						}//foreach

						/* close the connection */
						imap_close($inbox);
					}//if emails
					else{
						echo 'not ok';
					}
				// }else{
				// 		echo '<br>tidak masuk time = '.date('H:i:s');exit();
				// }
			// }
		}
    }
    public function validateDate($date, $format = 'd-m-Y H:i')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
    }