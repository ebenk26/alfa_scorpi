<?php
$getdataprospectid = $_GET["id"];// echo $id;
$connection=Yii::app()->db;
		$command2= $connection->createCommand("
				select b.leasing_name as leasing_terlibat,c.name as region,a.bidding_token,a.bidding_token_time 
				from send_mail a
				left join leasing b on a.leasing_id = b.id
				left join region c on b.region_id = c.id
				where prospect_id = '".$getdataprospectid."'
				order by a.bidding_token_time asc
		");
		$rows2 = $command2->queryAll();
		$totalData = count($rows2);
		$sql = "
				select a.id as id, b.leasing_name as leasing_terlibat,c.name as region,a.bidding_token,a.bidding_token_time 
				from send_mail a
				left join leasing b on a.leasing_id = b.id
				left join region c on b.region_id = c.id
				where prospect_id = '".$getdataprospectid."'
				order by a.bidding_token_time asc
				";
		// echo $sql;
		$dataProvider = new CSqlDataProvider($sql, array(
			'totalItemCount' => $totalData,
			'sort' => array(
					'defaultOrder' => 'a.created_at DESC ',
				),
			'pagination' => array(
					'pageSize' => 20,
				),
		));
	$prospect = Prospect::model()->findByPk($getdataprospectid);
	$prosname = $prospect->nama;
	echo 'Nama Prospect : <b>'.$prosname.'<b><br><br>';
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'marketing-officer-grid',
		'dataProvider'=>$dataProvider,
		'columns'=>array(
				array(
					'header'=> 'No.',
					'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'htmlOptions'=>array('style'=>'text-align: center;'),
				),
				'region' => array(
							'name' => 'region',
							'header' => 'Region',
							'value' => '$data["region"]',
							'type' => 'raw',
							'headerHtmlOptions' => array(
									'style' => 'vertical-align:middle;',
								),	
						),
			'leasing_terlibat' => array(
							'name' => 'leasing_terlibat',
							'header' => 'Leasing Terlibat',
							'value' => '$data["leasing_terlibat"]',
							'type' => 'raw',
							'headerHtmlOptions' => array(
									'style' => 'vertical-align:middle;',
								),	
						),
			'bidding_token' => array(
							'name' => 'bidding_token',
							'header' => 'Bidding Token',
							'value' => '$data["bidding_token"]',
							'type' => 'raw',
							'headerHtmlOptions' => array(
									'style' => 'vertical-align:middle;',
								),	
						),
			'bidding_token_time' => array(
							'name' => 'bidding_token_time',
							'header' => 'Bidding Token Time',
							'value' => '$data["bidding_token_time"]',
							'type' => 'raw',
							'headerHtmlOptions' => array(
									'style' => 'vertical-align:middle;',
								),	
						),
			),
		)
	);

?>