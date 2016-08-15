<?php
/* @var $this ProspectController */
/* @var $model Prospect */

$this->breadcrumbs=array(
	'Prospects'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Prospect', 'url'=>array('index')),
	array('label'=>'Create Prospect', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#prospect-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Prospects</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'prospect-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nama',
		'alamat',
		'ttl',
		'pekerjaan',
		'case_number',
		/*
		'region_id',
		'user_id',
		'from_email',
		'udate',
		'status',
		'bid_from_time',
		'has_winner',
		'foto_1',
		'foto_2',
		'foto_3',
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
