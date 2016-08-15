<?php
/* @var $this WinnerController */

// $this->breadcrumbs=array(
	// 'Winner',
// );
?>
<style type="text/css">
	#logo,#mainmenu,#footer{
		display:none;
	}
	#status_telepon{
		float:right;
	}
</style>

<script>
<?php if($return != ''){?>
alert('<?php echo $return ?>');

<?php } ?>
</script>

<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		// 'action'=>'/alfa_scorpi/index.php/biddingprograminsert/',
		'method'=>'get',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
		'id' => 'reject',
	)); 
	?>
<div style="font-size:large;font-weight:bold">Nama Prospect : <?php echo $prospect_name?></div><br><br>
<div style="width: 32%;">
	<div class="row">
		<label for="nama_surveyor">Nama Surveyor (CMO)</label>
		<input style="float:right;" type="text" class="nama_surveyor" name="nama_surveyor" placeholder="">
	</div><br><br>
	<div class="row">
		<label for="reason_reject">Alasan Reject</label>
		<!--<input style="float:right;" type="text" class="reason_reject" name="reason_reject" placeholder="">-->
		<?php 
		echo CHtml::textArea('reason_reject', '', 
					array('id'=>'reason_reject', 
				   'cols'=>35, 
				   'rows'=>10)); 
		?>
	</div><br>
	
	<input type="text" class="id" name="id" value="<?php echo $prospect_id?>" style="display:none">
	<input type="text" class="secretkey" name="secretkey" value="<?php echo $secretkey?>" style="display:none">
	
	<button class="" type="submit">Submit</button>
</div>
<?php 
	$this->endWidget(); 
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js"></script>
<script>
	$(function() {
		// $("#status_telepon").attr('required','required');
	});
</script>