<?php
/* @var $this ProspectController */
/* @var $model Prospect */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prospect-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php // echo $form->labelEx($model,'nama'); ?>
		<?php // echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'nama'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'alamat'); ?>
		<?php // echo $form->textField($model,'alamat',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'alamat'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'ttl'); ?>
		<?php // echo $form->textField($model,'ttl',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'ttl'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'pekerjaan'); ?>
		<?php // echo $form->textField($model,'pekerjaan',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'pekerjaan'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'case_number'); ?>
		<?php // echo $form->textField($model,'case_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'case_number'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'region_id'); ?>
		<?php // echo $form->textField($model,'region_id'); ?>
		<?php // echo $form->error($model,'region_id'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'user_id'); ?>
		<?php // echo $form->textField($model,'user_id'); ?>
		<?php // echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'from_email'); ?>
		<?php // echo $form->textField($model,'from_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'from_email'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'udate'); ?>
		<?php // echo $form->textField($model,'udate',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'udate'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'status'); ?>
		<?php // echo $form->textField($model,'status'); ?>
		<?php // echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'bid_from_time'); ?>
		<?php // echo $form->textField($model,'bid_from_time'); ?>
		<?php // echo $form->error($model,'bid_from_time'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'has_winner'); ?>
		<?php // echo $form->textField($model,'has_winner'); ?>
		<?php // echo $form->error($model,'has_winner'); ?>
	</div>
	<?php
	$criteria3 = new CDbCriteria;  
	$criteria3->addCondition("prospect_id = '".$_GET['id']."'");
	$criteria3->addCondition("bidding_token = 'RO'");
	$sendmail = SendMail::model()->find($criteria3);
	if($sendmail)
	{
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'no_ro'); ?>
		<?php echo $form->textField($model,'no_ro'); ?>
		<?php echo $form->error($model,'no_ro'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'foto_ro'); ?>
		<?php echo $form->fileField($model,'foto_ro'); ?>
		<?php echo $form->error($model,'foto_ro'); ?>
	</div>
	<?php
	}
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'dp_approve'); ?>
		<?php echo $form->textField($model,'dp_approve'); ?>
		<?php echo $form->error($model,'dp_approve'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'cicil_approve'); ?>
		<?php echo $form->textField($model,'cicil_approve'); ?>
		<?php echo $form->error($model,'cicil_approve'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tenor'); ?>
		<?php echo $form->textField($model,'tenor'); ?>
		<?php echo $form->error($model,'tenor'); ?>
	</div>
	
	<div class="row">
		<?php // echo $form->labelEx($model,'ganti_jam_survey'); ?>
		<?php // echo $form->textField($model,'ganti_jam_survey'); ?>
		<?php // echo $form->error($model,'ganti_jam_survey'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nama_stnk'); ?>
		<?php echo $form->textField($model,'nama_stnk'); ?>
		<?php echo $form->error($model,'nama_stnk'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nama_surveyor'); ?>
		<?php echo $form->textField($model,'nama_surveyor'); ?>
		<?php echo $form->error($model,'nama_surveyor'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tipe_approve'); ?>
		<?php echo $form->textField($model,'tipe_approve'); ?>
		<?php echo $form->error($model,'tipe_approve'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'keterangan_approve'); ?>
		<?php echo $form->textField($model,'keterangan_approve'); ?>
		<?php echo $form->error($model,'keterangan_approve'); ?>
	</div>
	
	<div class="row">
		<?php // echo $form->labelEx($model,'status_telepon'); ?>
		<?php
		// $criteria = new CDbCriteria;
		// $criteria->condition='group_id = 1';
		// echo $form->dropDownList($model,"status_telepon", CHtml::listData(DropdownData::model()->findAll($criteria), 'id', 'data'), array('empty'=>'--Select status--'));
		?>
		<?php // echo $form->textField($model,'status_telepon'); ?>
		<?php // echo $form->error($model,'status_telepon'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'foto_1'); ?>
		<?php echo $form->fileField($model, 'foto_1'); ?>
		<?php echo $form->error($model,'foto_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'foto_2'); ?>
		<?php echo $form->fileField($model, 'foto_2'); ?>
		<?php echo $form->error($model,'foto_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'foto_3'); ?>
		<?php echo $form->fileField($model, 'foto_3'); ?>
		<?php echo $form->error($model,'foto_3'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'created_by'); ?>
		<?php // echo $form->textField($model,'created_by',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'updated_by'); ?>
		<?php // echo $form->textField($model,'updated_by',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'created_at'); ?>
		<?php // echo $form->textField($model,'created_at'); ?>
		<?php // echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'updated_at'); ?>
		<?php // echo $form->textField($model,'updated_at'); ?>
		<?php // echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'deleted_at'); ?>
		<?php // echo $form->textField($model,'deleted_at'); ?>
		<?php // echo $form->error($model,'deleted_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->