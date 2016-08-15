<?php

class SendwinnerCommand extends CConsoleCommand
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
					
					$criteria3 = new CDbCriteria;  
					$criteria3->addCondition("status = 0");
					$criteria3->limit = 20;
					$sendwinner = Winner::model()->findAll($criteria3);
					$count = count($sendwinner);
					if($count > 0)
					{// echo 'masuk if';exit();
						foreach ($sendwinner as $row) {
							$id = $row->id;
							$prospect_id = $row->prospect_id;
							$to_email = $row->email;
							$email = "no-reply@nadyne.com";
							$cc = $row->cc_email;
							$message = $row->message;
							
							$_modelpros = Winner::model()->findByPk($id);
							$_modelpros->status = 1;
							$_modelpros->updated_by = 'SYSTEM';
							$_modelpros->updated_at = new CDbExpression('NOW()');
							$_modelpros->update();
					
							$_modelprosnew = Prospect::model()->findByPk($prospect_id);
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

							if(!empty($_modelprosnew->last_case_id)){
								$mail2->Subject = 'Bidding Program '.$prospect_id.' (RE:'.$_modelprosnew->last_case_id.')';
							}else{
								$mail2->Subject = 'Bidding Program '.$prospect_id;
							}
							$mail2->Body    = $message;
							$mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

							if(!$mail2->send()) {
								echo 'Message could not be sent.';
								echo 'Mailer Error: ' . $mail2->ErrorInfo;
							} else {
								echo 'Message has been sent';
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