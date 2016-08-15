<?php
/* @var $this ProspectController */
/* @var $model Prospect */

$this->breadcrumbs=array(
	'Prospects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Prospect', 'url'=>array('index')),
	array('label'=>'Manage Prospect', 'url'=>array('admin')),
);
?>

<h1>Create Prospect</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>