<?php

class DatabiddingController extends Controller
{
	public function actionIndex()
	{
		if(Yii::app()->user->isGuest){
			$this->redirect(array('/site/login'));
		}else{
			if(Yii::app()->session['roleid'] == 2){
				$where = " where a.id is not null and a.region_id is not null and g.leasing_id in (".Yii::app()->session['emailleasingid'].") and g.bidding_time is not null and c.leasing_id = ".Yii::app()->session['emailleasingid']."";
			}else if(Yii::app()->session['roleid'] == 3){
				$where = " where a.id is not null and a.region_id is not null and f.dealer_id in ('".Yii::app()->session['dealerid']."')";
			}else{
				$where = " where a.id is not null and a.region_id is not null ";
			}
			
			$connection=Yii::app()->db;
			$command2= $connection->createCommand("
					select a.id as id,a.nama as prospect,UCASE(e.name) as region,a.region_id as leasing_terlibat,c.created_at as time,
					a.time_confirm,a.time_approve,c.time_reject,timediff(a.time_approve,a.time_confirm)as durasi,a.last_case_id,a.profil_konsumen,a.nama_salesman,i.name as role_name,
					CASE 
						WHEN c.winner_confirm =1 THEN 'Confirmed'
						WHEN c.winner_confirm =2 THEN 'Approved'
						WHEN c.winner_confirm is null THEN 'No Feedback'
						WHEN c.winner_confirm =98 THEN 'No Feedback'
						WHEN c.winner_confirm =3 THEN 'Cancel'
						ELSE 'Rejected'
					END as winner_confirm,
					CASE 
						WHEN d.leasing_name is null THEN d.nama
						ELSE d.leasing_name
					END as pemenang
					from prospect a
					left join send_mail g on a.id = g.prospect_id
					left join leasing b on a.region_id = b.region_id
					left join winner c on a.id = c.prospect_id
					left join leasing d on c.leasing_id = d.id
					left join region e on a.region_id = e.id
					left join user f on a.from_email = f.email
					left join user h on a.last_comment_user = h.id
					left join role i on h.role_id = i.id
					".$where."
					group by a.id
			");
			$rows2 = $command2->queryAll();
			// $model=$command2->query();
			// print_r($rows2);exit();
			// $model->unsetAttributes();
			$totalData = count($rows2);
			$sql = "
					select a.id as id,a.nama as prospect,UCASE(e.name) as region,a.region_id as leasing_terlibat,f.dealer_name as sumber_order,a.created_at as time_sent_order,c.created_at as time,
					a.time_confirm,a.time_approve,c.time_reject,timediff(a.time_approve,a.time_confirm)as durasi,a.last_case_id,a.profil_konsumen,a.nama_salesman,i.name as role_name,
					CASE 
						WHEN c.winner_confirm =1 THEN 'Confirmed'
						WHEN c.winner_confirm =2 THEN 'Approved'
						WHEN c.winner_confirm is null THEN 'No Feedback'
						WHEN c.winner_confirm =98 THEN 'No Feedback'
						WHEN c.winner_confirm =3 THEN 'Cancel'
						ELSE 'Rejected'
					END as winner_confirm,
					CASE 
						WHEN d.leasing_name is null THEN d.nama
						ELSE d.leasing_name
					END as pemenang
					from prospect a
					left join send_mail g on a.id = g.prospect_id
					left join leasing b on a.region_id = b.region_id
					left join winner c on a.id = c.prospect_id
					left join leasing d on c.leasing_id = d.id
					left join region e on a.region_id = e.id
					left join user f on a.from_email = f.email
					left join user h on a.last_comment_user = h.id
					left join role i on h.role_id = i.id
					".$where."
					group by a.id
					";
			// if (isset($_GET["DownloadExcel_x"])){
			
				// $this->downloadWebSurvey($sql);
			// }
			// echo $sql;
			$dataProvider = new CSqlDataProvider($sql, array(
				'totalItemCount' => $totalData,
				'sort' => array(
						'defaultOrder' => 'a.id DESC ',
					),
				'pagination' => array(
						// 'pageSize' => intval(Yii::app()->params["defaultPageSize"]),
						'pageSize' => 20,
					),
			));
			$this->render('index',array(
				'dataProvider' => $dataProvider,
			));
			// $this->render('index');
		}
	}
	
	public function allowedActions()
	{
		return 'viewDatabidding';
		return 'viewComment';
	}
	
	public function actions(){
		return array(
			'viewDatabidding' => array(
		    		'class' => 'application.actions.ViewAction',
		    		'ajaxView' => '_view_databidding',
		    	),
			'viewComment' => array(
		    		'class' => 'application.actions.ViewAction',
		    		'ajaxView' => '_view_comment',
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
				  'actions'=>array('update','delete','downloadmonbrand'),
				  'users'=>array('@'),
			 ),
			 array('deny',  // deny all users
				   'users'=>array('*'),
			),
		 );
	}
	
	public function actionDownloadmonbrand(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Alfa Scorpii")
		->setLastModifiedBy("Alfa Scorpii")
		->setTitle("Download Data Bidding")
		->setSubject("Download Data Bidding")
		->setDescription("Download Data Bidding")
		->setKeywords("download,Download Data Bidding")
		->setCategory("Download");
		
		$objPHPExcel->getActiveSheet()->setTitle('DATA BIDDING');
		$worksheet = $objPHPExcel->getActiveSheet();
		
		$where = 'a.deleted_at is null';
		if(Yii::app()->session['roleid'] == 2){
			$where = " where a.id is not null and a.region_id is not null and g.leasing_id in (".Yii::app()->session['emailleasingid'].") and g.bidding_time is not null and c.leasing_id = ".Yii::app()->session['emailleasingid']."";
		}else if(Yii::app()->session['roleid'] == 3){
			$where = " where a.id is not null and a.region_id is not null and f.dealer_id in ('".Yii::app()->session['dealerid']."')";
		}else{
			$where = " where a.id is not null and a.region_id is not null ";
		}
		$query = "
					select a.id as id,a.nama as prospect,UCASE(e.name) as region,a.region_id as leasing_terlibat,f.dealer_name as sumber_order,a.created_at as time_sent_order,c.created_at as time,
					a.time_confirm,a.time_approve,c.time_reject,timediff(a.time_approve,a.time_confirm)as durasi,a.last_case_id,a.profil_konsumen,a.nama_salesman,i.name as role_name,
					CASE 
						WHEN c.winner_confirm =1 THEN 'Confirmed'
						WHEN c.winner_confirm =2 THEN 'Approved'
						WHEN c.winner_confirm is null THEN 'No Feedback'
						WHEN c.winner_confirm =98 THEN 'No Feedback'
						WHEN c.winner_confirm =3 THEN 'Cancel'
						ELSE 'Rejected'
					END as winner_confirm,
					CASE 
						WHEN d.leasing_name is null THEN d.nama
						ELSE d.leasing_name
					END as pemenang,
					a.nik,a.alamat,a.ttl,a.no_hp,a.keterangan,a.jam_survey,a.tipe,a.dp_approve,a.cicil_approve,a.profil_konsumen
					from prospect a
					left join send_mail g on a.id = g.prospect_id
					left join leasing b on a.region_id = b.region_id
					left join winner c on a.id = c.prospect_id
					left join leasing d on c.leasing_id = d.id
					left join region e on a.region_id = e.id
					left join user f on a.from_email = f.email
					left join user h on a.last_comment_user = h.id
					left join role i on h.role_id = i.id
					".$where."
					group by a.id
				";

		$data = Yii::app()->db->createCommand($query)->queryAll();
		$xlFieldName = array(
				'NO',
				'Case ID',
				'Last Case ID',
				'Prospect',
				//start detail prospect
				'NIK',
				'Alamat',
				'Tempat, Tanggal Lahir',
				'No. HP',
				'Keterangan',
				'Jam Survey',
				'Tipe Motor',
				'DP',
				'Cicilan',
				'Profil Konsumen',
				//start detail prospect
				'Region',
				'Leasing Terlibat',
				'Sumber Order',
				'Time Sent Order',
				'Pemenang',
				'Time Confirm',
				'Time Approve/Reject',
				'Durasi',
				'Winner Confirm',
				'Last Comment By',
		);
		
		$colId = 0;
		$rowId = 1;
		foreach ($xlFieldName as $key => $value) {
			$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value);
		}
		
		$urutan = 0;
		if (is_array($data)){
		
			foreach ($data as $value) {
		
				$colId = 0;
				$urutan++;
				$rowId++;
		
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $urutan );
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['id']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['last_case_id']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['prospect']);
				//start detail prospect
				if(isset($value['nik'])){
					$colIdnik = $colId++;
					$rowId = $rowId;
					$worksheet->setCellValueByColumnAndRow($colIdnik, $rowId, $value['nik']);
					$worksheet->getStyleByColumnAndRow($colIdnik, $rowId)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				}
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['alamat']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['ttl']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['no_hp']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['keterangan']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['jam_survey']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['tipe']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['dp_approve']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['cicil_approve']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['profil_konsumen']);
				//start detail prospect
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['region']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['leasing_terlibat']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['sumber_order']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['time_sent_order']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['pemenang']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['time_confirm']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['time_approve']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['durasi']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['winner_confirm']);
				$worksheet->setCellValueByColumnAndRow($colId++, $rowId, $value['role_name']);
		
			}
		
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
		$filename = 'Databidding'.date("Ymdhis");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		Yii::app()->end();
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