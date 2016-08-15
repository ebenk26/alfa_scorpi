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
		/*float:right;*/
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
		'id' => 'biddingprogram',
	)); 
	?>
<div style="font-size:large;font-weight:bold">Nama Prospect : <?php echo $prospect_name?></div><br><br>
<div style="width: 32%;">
	<div class="row">
		<label for="status_telepon">Status Telepon</label>
		<?php
		$criteria = new CDbCriteria;
		$criteria->condition='group_id = 1';
		echo CHtml::dropDownList("status_telepon","status_telepon", CHtml::listData(DropdownData::model()->findAll($criteria), 'id', 'data'), array('empty'=>'--Status Telepon--'));
		?>
	</div><br>
	<!-- <div class="row">
		<label for="ganti_tanggal_survey">Ganti Tanggal Survey</label>
		<input style="" type="text" class="ganti_tanggal_survey" name="ganti_tanggal_survey" placeholder="">
	</div><br> -->
	<div class="row">
		<label for="ganti_jam_survey">Ganti Jam Survey</label>
		<input style="" type="text" class="ganti_jam_survey" name="ganti_jam_survey" placeholder="">
	</div><br>
	<div class="row">
		<label for="keterangan_confirm">Keterangan</label>
		<!--<input style="float:right;" type="text" class="keterangan_confirm" name="keterangan_confirm" placeholder="">-->
		<?php
		echo CHtml::textArea('keterangan_confirm', '', 
					array('id'=>'keterangan_confirm', 
				   'cols'=>35, 
				   'rows'=>10,
				   'style'=>'')); 
		
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