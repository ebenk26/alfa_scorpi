<?php
$getdataprospectid = intval($_GET["id"]);// echo $id;
$prospect_id = intval($_GET["id"]);// echo $id;
$user_id = Yii::app()->session['userid'];// echo $id;
$prospect = Prospect::model()->findByPk($getdataprospectid);
$region = Region::model()->findByPk($prospect->region_id);
$criteria = new CDbCriteria;  
$criteria->addCondition("prospect_id = '".$getdataprospectid."'");
$winner = Winner::model()->find($criteria);
echo 'NIK : '.$prospect->nik.'<br><br>';
echo 'Nama Prospect : '.$prospect->nama.'<br><br>';
?>
<?php 
	$form=$this->beginWidget('CActiveForm', array(
		// 'action'=>Yii::app()->createUrl($this->route),
		'action'=>'/alfa_scorpi/index.php/comment/',
		'method'=>'get',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
		'id' => 'comment',
	)); 
	?>
<div style="width: 32%;margin-left: 20px;">
	<div class="row">
		<label for="comment">Comment :</label>
		<!--<input style="float:right;" type="text" class="keterangan_confirm" name="keterangan_confirm" placeholder="">-->
		<?php
		echo CHtml::textArea('comment', '', 
					array('id'=>'comment', 
				   'cols'=>100, 
				   'rows'=>10,
				   'style'=>'width: 500px;')); 
		
		?>
	</div><br>
	<input type="text" class="id" name="id" value="<?php echo $prospect_id?>" style="display:none">
	<input type="text" class="id" name="user_id" value="<?php echo $user_id?>" style="display:none">
	<button class="" type="submit">Submit</button>
</div>
<?php 
	$this->endWidget(); 
?>