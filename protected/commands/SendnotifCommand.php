<?php

class SendnotifCommand extends CConsoleCommand
{
	public function run($args)
    {
		require 'PHPMailer/PHPMailerAutoload.php';
		
		$criteria2 = new CDbCriteria;  
		$criteria2->addCondition("status = 0");
		$sendmail = SendNotifProspect::model()->findAll($criteria2);
		$count = count($sendmail);
		if($count > 0)
		{
			foreach ($sendmail as $row) {
				$from_mail = FromEmail::model()->findByPk(1);
				// $email = "smsincoming@nadyne.com";
				$email = $from_mail->email;
				$to_email = $row->email;
				$message = $row->message;
				
				$_modelsend = SendNotifProspect::model()->findByPk($row->id);
				$_modelsend->status = 1;
				$_modelsend->updated_by = 'SYSTEM';
				$_modelsend->updated_at = new CDbExpression('NOW()');
		
				//PHPMailer Object
				$mail = new PHPMailer;

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'ginger.gotnotice.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'smsincoming@nadyne.com';                 // SMTP username
				$mail->Password = 'iniSmsYamaha889';                           // SMTP password
				// $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 10025;                                    // TCP port to connect to

				$mail->setFrom($email, 'No Reply');
				// $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
				$mail->addAddress($to_email);               // Name is optional
				// $mail->addReplyTo('info@example.com', 'Information');
				// $mail->addCC($cc);
				// $mail->addBCC('bcc@example.com');

				// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Bidding Program '.date('m').'-'.$prospect_id;
				$mail->Body    = $message;
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					echo 'Message has been sent';
					$_modelsend->update();
				}
					}
		}else
		{
			echo 'No row Prospect';
		}
	}
	
}