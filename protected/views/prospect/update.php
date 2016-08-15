<?php
/* @var $this ProspectController */
/* @var $model Prospect */

/* $this->breadcrumbs=array(
	'Prospects'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
); */

$this->menu=array(
	array('label'=>'List Prospect', 'url'=>array('index')),
	array('label'=>'Create Prospect', 'url'=>array('create')),
	array('label'=>'View Prospect', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Prospect', 'url'=>array('admin')),
);

$criteria2 = new CDbCriteria;  
$criteria2->addCondition("prospect_id = '".$_GET['id']."'");
$criteria2->addCondition("winner_confirm = 2 or winner_confirm = 1");
$winner = Winner::model()->find($criteria2);

$leasing = Leasing::model()->findByPk($winner->leasing_id);
?>
<style type="text/css">
	#mainmenu,#footer{
		display:none;
	}
	.container {
		width: auto;
	}
</style>
<div class="profile_name">Welcome <?php echo $leasing->nama; ?></div>
<h1>Update Prospect : <?php echo $model->nama; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>