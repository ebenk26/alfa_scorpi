<?php
/* @var $this ProspectController */
/* @var $model Prospect */

/* $this->breadcrumbs=array(
	'Prospects'=>array('index'),
	$model->id,
); */

$this->menu=array(
	array('label'=>'List Prospect', 'url'=>array('index')),
	array('label'=>'Create Prospect', 'url'=>array('create')),
	array('label'=>'Update Prospect', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Prospect', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Prospect', 'url'=>array('admin')),
);
?>
<style type="text/css">
	#logo,#mainmenu,#footer{
		display:none;
	}
</style>
<h1>View Prospect : <?php echo $model->nama; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama',
		'alamat',
		'ttl',
		'pekerjaan',
		// 'case_number',
		array(
			'label'=>'Case Number',
			'value'=>$model->id,
		),
		'no_ro',
		array(
			'label'=>'Foto RO',
			'type'=>'image',
			'value'=>'data:image/jpg;base64,'.$model->foto_ro,
		),
		'region_id',
		'dp_approve',
		'cicil_approve',
		'tenor',
		'nama_stnk',
		'nama_surveyor',
		'tipe_approve',
		'keterangan_approve',
		// 'user_id',
		// 'from_email',
		// 'udate',
		// 'status',
		// 'bid_from_time',
		// 'has_winner',
		// 'foto_1',
		// 'foto_2',
		// 'foto_3',
		array(
			'label'=>'Foto',
			'type'=>'image',
			'value'=>'data:image/jpg;base64,'.$model->foto_1,
		),
		array(
			'label'=>'Foto',
			'type'=>'image',
			'value'=>'data:image/jpg;base64,'.$model->foto_2,
		),
		array(
			'label'=>'Foto',
			'type'=>'image',
			'value'=>'data:image/jpg;base64,'.$model->foto_3,
		),
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		// 'deleted_at',
	),
)); ?>
