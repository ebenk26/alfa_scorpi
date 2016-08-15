<?php

/**
 * This is the model class for table "inbox".
 *
 * The followings are the available columns in table 'inbox':
 * @property integer $id
 * @property string $nik
 * @property string $nama
 * @property string $alamat
 * @property string $ttl
 * @property string $no_hp
 * @property string $tipe
 * @property string $dp
 * @property string $jam_survey
 * @property string $keterangan
 * @property string $case_number
 * @property integer $region_id
 * @property integer $user_id
 * @property string $from_email
 * @property string $udate
 * @property integer $status
 * @property string $bid_from_time
 * @property integer $has_winner
 * @property string $foto_1
 * @property string $foto_2
 * @property string $foto_3
 * @property string $note
 * @property string $dp_approve
 * @property string $cicil_approve
 * @property string $tenor
 * @property string $ganti_jam_survey
 * @property string $status_telepon
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Inbox extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_id, user_id, status, has_winner', 'numerical', 'integerOnly'=>true),
			array('nik, nama, alamat, ttl, no_hp, tipe, dp, jam_survey, keterangan, case_number, from_email, udate, dp_approve, cicil_approve, tenor, ganti_jam_survey, status_telepon, created_by, updated_by', 'length', 'max'=>255),
			array('bid_from_time, foto_1, foto_2, foto_3, note, created_at, updated_at, deleted_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nik, nama, alamat, ttl, no_hp, tipe, dp, jam_survey, keterangan, case_number, region_id, message, user_id, from_email, udate, status, bid_from_time, has_winner, foto_1, foto_2, foto_3, note, dp_approve, cicil_approve, tenor, ganti_jam_survey, status_telepon, created_by, updated_by, created_at, updated_at, deleted_at', 'safe', 'on'=>'search'),
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
			'nik' => 'Nik',
			'nama' => 'Nama',
			'alamat' => 'Alamat',
			'ttl' => 'Ttl',
			'no_hp' => 'No Hp',
			'tipe' => 'Tipe',
			'dp' => 'Dp',
			'jam_survey' => 'Jam Survey',
			'keterangan' => 'Keterangan',
			'case_number' => 'Case Number',
			'region_id' => 'Region',
			'user_id' => 'User',
			'from_email' => 'From Email',
			'udate' => 'Udate',
			'status' => 'Status',
			'bid_from_time' => 'Bid From Time',
			'has_winner' => 'Has Winner',
			'foto_1' => 'Foto 1',
			'foto_2' => 'Foto 2',
			'foto_3' => 'Foto 3',
			'note' => 'Note',
			'dp_approve' => 'Dp Approve',
			'cicil_approve' => 'Cicil Approve',
			'tenor' => 'Tenor',
			'ganti_jam_survey' => 'Ganti Jam Survey',
			'status_telepon' => 'Status Telepon',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
			'message' => 'Message',
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
		$criteria->compare('nik',$this->nik,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('ttl',$this->ttl,true);
		$criteria->compare('no_hp',$this->no_hp,true);
		$criteria->compare('tipe',$this->tipe,true);
		$criteria->compare('dp',$this->dp,true);
		$criteria->compare('jam_survey',$this->jam_survey,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('case_number',$this->case_number,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from_email',$this->from_email,true);
		$criteria->compare('udate',$this->udate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('bid_from_time',$this->bid_from_time,true);
		$criteria->compare('has_winner',$this->has_winner);
		$criteria->compare('foto_1',$this->foto_1,true);
		$criteria->compare('foto_2',$this->foto_2,true);
		$criteria->compare('foto_3',$this->foto_3,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('dp_approve',$this->dp_approve,true);
		$criteria->compare('cicil_approve',$this->cicil_approve,true);
		$criteria->compare('tenor',$this->tenor,true);
		$criteria->compare('ganti_jam_survey',$this->ganti_jam_survey,true);
		$criteria->compare('status_telepon',$this->status_telepon,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('deleted_at',$this->deleted_at,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inbox the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
