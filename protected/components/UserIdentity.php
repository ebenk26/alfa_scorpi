<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/* $users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		); */
		$username = $this->username;
		$password = $this->password;
		$users = User::model()->find(array('condition'=>"username = '$username'"));
		/* if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE; */
		if(!empty($users))
			{
				if($users->role_id == 1 || $users->role_id == 2 || $users->role_id == 3|| $users->role_id == 4)
				{
					$emailuser = $users->email;
					$emailleasing = Leasing::model()->find(array('condition'=>"email = '$emailuser'"));
					$dealer = Dealer::model()->find(array('condition'=>"id = '$users->dealer_id'"));
					Yii::app()->session['userlogin'] = $username; //session user
					Yii::app()->session['roleid'] = $users->role_id; //session role_id
					Yii::app()->session['emailuser'] = $emailuser; 
					Yii::app()->session['emailleasingid'] = $emailleasing->id; 
					Yii::app()->session['dealerid'] = $dealer->id; 
					Yii::app()->session['userid'] = $users->id; 
					$hashedPassword = md5($password);
					if($hashedPassword == $users->password)
					{
						$this->errorCode=self::ERROR_NONE;
					}else
					{
						$this->errorCode=self::ERROR_PASSWORD_INVALID;
					}
				}else
				{
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
				}
			}else
			{
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		return !$this->errorCode;
	}
}