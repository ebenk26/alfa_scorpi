<?php

class ViewprospectController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function allowedActions()
	{
		return 'viewDataprospect';
	}
	
	public function actions(){
		return array(
			'viewDataprospect' => array(
		    		'class' => 'application.actions.ViewAction',
		    		'ajaxView' => '_view_dataprospect',
		    	),
		);
		// $this->render('_view_list_location_survey',array(
			// 'condition'=>'testparam',
		// ));
	}
	
	public function loadModel()
	{
	  
	}
	
	public function accessRules()
	{
		 return array(
			 array('allow',  // allow all users to perform 'index' and 'contact' actions
				  'actions'=>array('index','contact'),
				  'users'=>array('@'),
			 ),
			 array('allow', // allow authenticated user to perform 'delete' and 'update' actions
				  'actions'=>array('update','delete'),
				  'users'=>array('@'),
			 ),
			 array('deny',  // deny all users
				   'users'=>array('*'),
			),
		 );
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