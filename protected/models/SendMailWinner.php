<?php

/**
 * This is the model class for table "send_mail_winner".
 *
 * The followings are the available columns in table 'send_mail_winner':
 * @property integer $id
 * @property string $uid_email
 * @property integer $leasing_id
 * @property integer $prospect_id
 * @property string $email
 * @property string $cc_email
 * @property integer $status
 * @property integer $bidding_token
 * @property string $bidding_token_time
 * @property string $bidding_time
 * @property string $message
 * @property integer $time_up
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class SendMailWinner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'send_mail_winner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leasing_id, status, bidding_token, time_up', 'numerical', 'integerOnly'=>true),
			array('uid_email, email, cc_email, created_by, updated_by', 'length', 'max'=>255),
			array('bidding_token_time, bidding_time, message, created_at, updated_at, deleted_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid_email, leasing_id, prospect_id, email, cc_email, status, bidding_token, bidding_token_time, bidding_time, message, time_up, created_by, updated_by, created_at, updated_at, deleted_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'uid_email' => 'Uid Email',
			'leasing_id' => 'Leasing',
			'prospect_id' => 'Prospect',
			'email' => 'Email',
			'cc_email' => 'Cc Email',
			'status' => 'Status',
			'bidding_token' => 'Bidding Token',
			'bidding_token_time' => 'Bidding Token Time',
			'bidding_time' => 'Bidding Time',
			'message' => 'Message',
			'time_up' => 'Time Up',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('uid_email',$this->uid_email,true);
		$criteria->compare('leasing_id',$this->leasing_id);
		$criteria->compare('prospect_id',$this->prospect_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cc_email',$this->cc_email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('bidding_token',$this->bidding_token);
		$criteria->compare('bidding_token_time',$this->bidding_token_time,true);
		$criteria->compare('bidding_time',$this->bidding_time,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('time_up',$this->time_up);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('deleted_at',$this->deleted_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SendMailWinner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
