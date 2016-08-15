<?php

class BlastwinnerController extends Controller
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

					require 'PHPMailer/PHPMailerAutoload.php';
					
					$criteria2 = new CDbCriteria;  
					$criteria2->addCondition("status = 0");
					$criteria2->limit = 20;
					$sendmail = SendMailWinner::model()->findAll($criteria2);
					$count = count($sendmail);
					if($count > 0)
					{
						foreach ($sendmail as $row) {
							$prospect_id = $row->prospect_id;
							$id = $row->id;
							$to_email = $row->email;
							$email = "no-reply@nadyne.com";
							$cc = $row->cc_email;
							$message = $row->message;
							
							$_modelsend = SendMailWinner::model()->findByPk($id);
							$_modelsend->status = 1;
							$_modelsend->updated_by = 'SYSTEM';
							$_modelsend->updated_at = new CDbExpression('NOW()');
							$_modelsend->update();
							
							$_modelpros = Prospect::model()->findByPk($prospect_id);
							$_modelpros->status = 1;
							$_modelpros->updated_by = 'SYSTEM';
							$_modelpros->bid_from_time = new CDbExpression('NOW()');
							$_modelpros->updated_at = new CDbExpression('NOW()');
							$_modelpros->update();
					
							//PHPMailer Object
							$mail = new PHPMailer;

							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'ginger.gotnotice.com';  // Specify main and backup SMTP servers
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = 'smsincoming@nadyne.com';                 // SMTP username
							$mail->Password = 'iniSmsYamaha889';                   // SMTP password
							// $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 10025;                                    // TCP port to connect to

							$mail->setFrom($email, 'No Reply');
							// $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
							$mail->addAddress($to_email);               // Name is optional
							// $mail->addReplyTo('info@example.com', 'Information');
							$mail->addCC($cc);
							// $mail->addBCC('bcc@example.com');

							// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
							// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
							$mail->isHTML(true);                                  // Set email format to HTML

							if(!empty($_modelpros->last_case_id)){
								// $mail->Subject = 'Bidding Program '.date('m').'-'.$prospect_id.' (RE:'.$_modelpros->last_case_id.')';
								$mail->Subject = 'Bidding Program '.$prospect_id.' (RE:'.$_modelpros->last_case_id.')';
							}else{
								// $mail->Subject = 'Bidding Program '.date('m').'-'.$prospect_id;
								$mail->Subject = 'Bidding Program '.$prospect_id;
							}
							$mail->Body    = $message;
							$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

							if(!$mail->send()) {
								echo 'Message could not be sent.';
								echo 'Mailer Error: ' . $mail->ErrorInfo;
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