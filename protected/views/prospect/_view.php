<?php
/* @var $this ProspectController */
/* @var $data Prospect */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama')); ?>:</b>
	<?php echo CHtml::encode($data->nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat')); ?>:</b>
	<?php echo CHtml::encode($data->alamat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ttl')); ?>:</b>
	<?php echo CHtml::encode($data->ttl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan')); ?>:</b>
	<?php echo CHtml::encode($data->pekerjaan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('case_number')); ?>:</b>
	<?php echo CHtml::encode($data->case_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region_id')); ?>:</b>
	<?php echo CHtml::encode($data->region_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_email')); ?>:</b>
	<?php echo CHtml::encode($data->from_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('udate')); ?>:</b>
	<?php echo CHtml::encode($data->udate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bid_from_time')); ?>:</b>
	<?php echo CHtml::encode($data->bid_from_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('has_winner')); ?>:</b>
	<?php echo CHtml::encode($data->has_winner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foto_1')); ?>:</b>
	<?php echo CHtml::encode($data->foto_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foto_2')); ?>:</b>
	<?php echo CHtml::encode($data->foto_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foto_3')); ?>:</b>
	<?php echo CHtml::encode($data->foto_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted_at')); ?>:</b>
	<?php echo CHtml::encode($data->deleted_at); ?>
	<br />

	*/ ?>

</div>