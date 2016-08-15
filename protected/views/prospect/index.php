<?php
/* @var $this ProspectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Prospects',
);

$this->menu=array(
	array('label'=>'Create Prospect', 'url'=>array('create')),
	array('label'=>'Manage Prospect', 'url'=>array('admin')),
);
?>

<h1>Prospects</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
