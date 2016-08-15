<?php
/* @var $this DatabiddingController */

$this->breadcrumbs=array(
	'Databidding',
);

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Detail Data Bidding',
        'autoOpen'=>false,
		'width'=> '50%',
		'height' => '600',
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog2',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Detail Data Prospect',
        'autoOpen'=>false,
		'width'=> '50%',
		'height' => '600',
    ),
));
   // echo 'dialog content here';

$this->endWidget('zii.widgets.jui.CJuiDialog');
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog3',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Comment',
        'autoOpen'=>false,
		'width'=> '50%',
		'height' => '600',
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');

// the link that may open the dialog
/* echo CHtml::link('open dialog', '#', array(
   'onclick'=>'$("#mydialog").dialog("open"); return false;',
)); */
?>
<?php echo CHtml::link('Excell',array("downloadmonbrand"),array('class'=>'btn btn-success btn-excell',)); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-bidding-grid',
	'dataProvider'=>$dataProvider,
	/* 'afterAjaxUpdate'=>"function() {  
        jQuery('.rating-block input').rating({'readOnly':true});  
    }", */
	// 'filter'=>$model,
	'ajaxUpdate' => true,
	'columns'=>array(
		array(
			'header'=> 'No.',
			'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
			'htmlOptions'=>array('style'=>'text-align: center;'),
		),
		'id' => array(
        			'name' => 'id',
        			'header' => 'Case ID',
        			'value' => 'substr($data["time_sent_order"], 5, 2)."-".$data["id"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'last_case_id' => array(
        			'name' => 'last_case_id',
        			'header' => 'Last Case ID',
        			'value' => '$data["last_case_id"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'prospect' => array(
        			'name' => 'prospect',
        			// 'header' => 'Prospect',
        			// 'value' => '$data["prospect"]',
        			// 'type' => 'raw',
					// 'headerHtmlOptions' => array(
							// 'style' => 'vertical-align:middle;',
						// ),	
					'value' => '
						CHtml::link("$data[prospect]","#", array("onClick"=>"$.ajax({
							type: `POST`,
							url: `/alfa_scorpi/index.php/viewprospect/viewDataprospect?id=`+`$data[id]`,
							success: function(html){ var obj = jQuery.parseJSON( html );jQuery(`#mydialog2`).dialog(`open`).html(obj.content);return false; },
						})"))
						',
					'type' => 'raw',
					'htmlOptions' => array(
							'style' => 'padding-left: 12px;',
						),
					'header' => 'Prospect',
					'headerHtmlOptions' => array(
								'style' => 'vertical-align:middle;',
							),
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
        			// 'value' => '$data["leasing_terlibat"]',
					'value'  => 'Common::model()->Getleasingterlibat($data["leasing_terlibat"])',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						'class' => 'visible',
						),	
					'htmlOptions' => array(
							'class' => 'visible',
						),
        		),
		'sumber_order' => array(
        			'name' => 'sumber_order',
        			'header' => 'Sumber Order',
        			'value' => '$data["sumber_order"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
							'class' => 'visible',
						),	
					'htmlOptions' => array(
							'class' => 'visible',
						),
        		),
		'nama_salesman' => array(
        			'name' => 'nama_salesman',
        			'header' => 'Nama Salesman',
        			'value' => '$data["nama_salesman"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
							'class' => 'visible2',
						),	
					'htmlOptions' => array(
							'class' => 'visible2',
						),
        		),
		'time_sent_order' => array(
        			'name' => 'time_sent_order',
        			'header' => 'Time Sent Order',
        			'value' => '$data["time_sent_order"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'pemenang' => array(
        			'name' => 'pemenang',
        			'header' => 'Pemenang',
        			'value' => '$data["pemenang"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
							'class' => 'visible',
						),	
					'htmlOptions' => array(
							'class' => 'visible',
						),
        		),
		/* 'time' => array(
        			'name' => 'time',
        			'header' => 'Time',
        			'value' => '$data["time"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		), */
		'time_confirm' => array(
        			'name' => 'time_confirm',
        			'header' => 'Time Confirm',
        			'value' => '$data["time_confirm"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'time_approve' => array(
        			'name' => 'time_approve',
        			'header' => 'Time Approve / Reject',
        			'value' => '$data["time_approve"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'durasi' => array(
        			'name' => 'durasi',
        			'header' => 'Durasi',
        			'value' => '$data["durasi"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'winner_confirm' => array(
        			'name' => 'winner_confirm',
        			'header' => 'Winner Confirm',
        			'value' => '$data["winner_confirm"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'role_name' => array(
        			'name' => 'role_name',
        			'header' => 'Last Comment By',
        			'value' => '$data["role_name"]',
        			'type' => 'raw',
					'headerHtmlOptions' => array(
							'style' => 'vertical-align:middle;',
						),	
        		),
		'action' => array(
					// 'name' => 'b',
					'value' => '
								CHtml::link(CHtml::image("/alfa_scorpi/images/icon-view.png"),"#", array("onClick"=>"$.ajax({
							type: `POST`,
							url: `/alfa_scorpi/index.php/databidding/viewDatabidding?id=`+`$data[id]`,
							success: function(html){ var obj = jQuery.parseJSON( html );jQuery(`#mydialog`).dialog(`open`).html(obj.content);return false; },
						})"))
							',
					'type' => 'raw',
					'header' => '<table height="100%" width="100%" style="margin-bottom:0px;" border="0">
						Action
					</table>',
					// 'type' => 'number',
					'htmlOptions' => array(
							'width' => '20',
							'style' => 'text-align:right;vertical-align:middle;',
							'class' => 'visible',
						),
					'headerHtmlOptions' => array(
							'colspan' => 2,
							//'rowspan' => 2,
							'style' => 'padding:0px;',
							'class' => 'visible',
						),	

				),
		'comment' => array(
					'value' => '
								CHtml::link(CHtml::image("/alfa_scorpi/images/update.png"),"#", array("onClick"=>"$.ajax({
							type: `POST`,
							url: `/alfa_scorpi/index.php/databidding/viewComment?id=`+`$data[id]`,
							success: function(html){ var obj = jQuery.parseJSON( html );jQuery(`#mydialog3`).dialog(`open`).html(obj.content);return false; },
						})"))
								',
					'header' => false,
					'type' => 'raw',
					'htmlOptions' => array(
							'width' => '20',
							'style' => 'text-align:right;vertical-align:middle;',
							'class' => 'visible3',
						),
					'headerHtmlOptions' => array(
							'style' => "display:none;",
							'class' => 'visible3',
						),	
				),
	),
	)
);
?>
<?php if (Yii::app()->session['roleid'] == 3) { ?>
<script>
	$('.visible').css('display','none');
</script>
<?php }else{ ?>
	<script>
		$('.visible2').css('display','none');
	</script>
<?php	} 
?>
<?php if (Yii::app()->session['roleid'] == 4 || Yii::app()->session['roleid'] == 1) { ?>
<script>
	$('.visible3').css('display','none');
</script>
<?php }
?>
<?php if (Yii::app()->session['roleid'] == 4) { ?>
<script>
	$('.btn-excell').css('display','none');
</script>
<?php }
?>