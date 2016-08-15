<?php

class ProspectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Prospect;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Prospect']))
		{
			$model->attributes=$_POST['Prospect'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_GET['secretkey']))
		{
			$criteria = new CDbCriteria;  
			$criteria->addCondition("secret_key = '".$_GET['secretkey']."'");
			$criteria->addCondition("prospect_id = '".$_GET['id']."'");
			$secretkey = SecretKey::model()->find($criteria);
			if($secretkey)
			{
				if(isset($_POST['Prospect']))
				{
					// $model->attributes=$_POST['Prospect'];
					$model->dp_approve = $_POST['Prospect']['dp_approve'];
					$model->cicil_approve = $_POST['Prospect']['cicil_approve'];
					$model->tenor = $_POST['Prospect']['tenor'];
					// $model->ganti_jam_survey = $_POST['Prospect']['ganti_jam_survey'];
					// $model->status_telepon = $_POST['Prospect']['status_telepon'];
					$model->nama_stnk = $_POST['Prospect']['nama_stnk'];
					$model->nama_surveyor = $_POST['Prospect']['nama_surveyor'];
					$model->tipe_approve = $_POST['Prospect']['tipe_approve'];
					$model->keterangan_approve = $_POST['Prospect']['keterangan_approve'];
					// $model->no_ro = $_POST['Prospect']['no_ro'];
					$model->updated_by = 'SYSTEM';
					$model->updated_at = new CDbExpression('NOW()');
					$model->time_approve = new CDbExpression('NOW()');
					
					$criteria2 = new CDbCriteria;  
					$criteria2->addCondition("prospect_id = '".$_GET['id']."'");
					$criteria2->addCondition("winner_confirm = 2 or winner_confirm = 1");
					$winner = Winner::model()->find($criteria2);
					if($winner){
						$winner->winner_confirm = 2;
						$winner->updated_by = 'SYSTEM';
						$winner->updated_at = new CDbExpression('NOW()');
						$winner->update();

						if(!empty($_FILES['Prospect']['tmp_name']['foto_ro'])){
							$foto_ro = base64_encode(file_get_contents($_FILES['Prospect']['tmp_name']['foto_ro']));
							$model->foto_ro = $foto_ro;
						}
						if(!empty($_FILES['Prospect']['tmp_name']['foto_1'])){
							$foto_1 = base64_encode(file_get_contents($_FILES['Prospect']['tmp_name']['foto_1']));
							$model->foto_1 = $foto_1;
						}
						if(!empty($_FILES['Prospect']['tmp_name']['foto_2'])){
							$foto_2 = base64_encode(file_get_contents($_FILES['Prospect']['tmp_name']['foto_2']));
							$model->foto_2 = $foto_2;
						}
						if(!empty($_FILES['Prospect']['tmp_name']['foto_3'])){
							$foto_3 = base64_encode(file_get_contents($_FILES['Prospect']['tmp_name']['foto_3']));
							$model->foto_3 = $foto_3;
						}
						if(isset($_POST['Prospect']['no_ro'])){
							$model->no_ro = $_POST['Prospect']['no_ro'];
						}else{
							$model->no_ro = "-";
							$model->foto_ro = "-";
						}
						if($model->save())
							$this->redirect(array('view','id'=>$model->id));
					}else{
						echo 'Not Allowed';
						exit();
					}
				}
				$this->render('update',array(
					'model'=>$model,
				));
			}else{
				echo 'Not Allowed';
			}
		
		}else{
			echo 'Not Allowed';
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Prospect');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Prospect('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prospect']))
			$model->attributes=$_GET['Prospect'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Prospect the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Prospect::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Prospect $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='prospect-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
