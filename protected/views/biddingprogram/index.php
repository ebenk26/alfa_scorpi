<?php
/* @var $this BiddingprogramController */

/* $this->breadcrumbs=array(
	'Biddingprogram',
); */
?>
<style type="text/css">
	#mainmenu,#footer{
		display:none;
	}
	.container {
		width: auto;
	}
</style>
<?php
if($return != '')
{
?>
<script>
	alert('<?php echo $return?>');
</script>
<?php
}
?>
<div class="profile_name">Welcome <?php echo $nama; ?></div>
<div class="bidding_left_content">
	<div class="left_content_1">Dapatkan data prospect ini dengan mengikuti program BID</div>
	<div class="left_content_2">SISA TOKEN ANDA</div>
	<div class="left_content_3"><?php echo $token ?></div>
	<div class="left_content_4">   1 Token = 1 Menit</div>
	<div class="left_content_5"><img src="/alfa_scorpi/images/syarat-dan-ketentuan.png"></div>
</div>
<div class="bidding_right_content">
	<img class="img_bidding_right_content" src="/alfa_scorpi/images/data-Prospect-Block.png">
	<div class="right_content_1"><br>
	&nbsp;&nbsp;&nbsp;&nbsp;Profil Konsumen : <?php echo $prospect_profil ?><br><br>
	<!--&nbsp;&nbsp;&nbsp;&nbsp;Alamat Sesuai KTP : <?php // echo $prospect_alamat ?><br><br>-->
	&nbsp;&nbsp;&nbsp;&nbsp;Tempat,Tanggal Lahir : <?php echo $prospect_ttl ?><br><br>
	<!--&nbsp;&nbsp;&nbsp;&nbsp;Nomor Hand Phone : <?php // echo $prospect_nohp ?><br><br>-->
	<!--&nbsp;&nbsp;&nbsp;&nbsp;Tipe Motor : <?php // echo $prospect_tipe ?><br><br>-->
	<!--&nbsp;&nbsp;&nbsp;&nbsp;Down Payment (DP) : <?php // echo $prospect_dp ?><br><br>-->
	&nbsp;&nbsp;&nbsp;&nbsp;Waktu Survey : <?php echo $prospect_jamsurvey ?><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;RO/Kolektif/Kredit : <?php echo $prospect_keterangan ?><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;Region : <?php echo $prospect_region ?><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;NIK : <?php echo $prospect_nik ?><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;Nama Konsumen : <?php echo $prospect_name ?>
	</div>
	<?php 
	$form=$this->beginWidget('CActiveForm', array(
		// 'action'=>Yii::app()->createUrl($this->route),
		'action'=>'/alfa_scorpi/index.php/biddingprograminsert/',
		// 'method'=>'get',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
		'id' => 'biddingprogram',
	)); 
	?>
	<form action="/" id="searchForm">
	<input type="text" class="id" name="id" value="<?php echo $id ?>" style="display:none">
	<input type="text" class="idm" name="idm" value="<?php echo $idm ?>" style="display:none">
	<input type="text" class="secretkey" name="secretkey" value="<?php echo $secretkey ?>" style="display:none"><br>

	<?php
	if($return == 'Anda sudah melakukan bidding' || $return == 'Token berhasil di input' || $return == 'Time Up')
	{
	}else
	{
	?>
	<div class="div_ro">
		&nbsp;&nbsp;&nbsp;&nbsp;RO : &nbsp;&nbsp;
		<input type="text" class="input_ro" name="input_ro" placeholder="input RO"><br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;Upload RO : &nbsp;&nbsp;
		<?php echo CHtml::FileField('foto_bid', ''); ?>
	</div>
		<div class="label_insert_token">&nbsp;&nbsp;&nbsp;&nbsp;INSERT TOKEN</div><br><br>
		<!-- <input type="number" class="input_token" name="input_token" placeholder="input token" min="1"><br>-->
		&nbsp;&nbsp;&nbsp;&nbsp;<?php
		$criteria = new CDbCriteria;
		$criteria->condition='group_id = 2';
		echo CHtml::dropDownList("input_token","input_token", CHtml::listData(DropdownData::model()->findAll($criteria), 'data', 'data'), array('empty'=>'--Insert Token--'));
		?>
	<button class="submit_btn" type="submit"></button>
	<?php
	}
	?>
	<?php 
	$this->endWidget(); 
	?>
	
	</form>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js"></script>
<script>
	$(function() {
		$(".div_ro").css('display','none');
		// $("#input_token").change(function(){
		// 	if($("#input_token").val() == 4)
		// 	{
		// 		$(".div_ro").css('display','block');
		// 		$(".input_ro").attr('required','required');
		// 		$("#foto_bid").attr('required','required');
		// 	}else{
		// 		$(".div_ro").css('display','none');
		// 		$(".input_ro").removeAttr('required');
		// 		$("#foto_bid").removeAttr('required');
		// 	}
		// });
		
		/* $("#biddingprogram").submit(function({
			$.ajax({
				type: "POST",
				cache: false, 
				data: {
					new_pass: $('#foto_bid').val()
				},
				url: "/alfa_scorpi/index.php/biddingprogram/",  
				success: function(msg){
					// if(msg == 1){
						// alert('Your password has been changed, please login again !');
						similar behavior as an HTTP redirect
						// window.location.replace(GLOBAL_MAIN_VARS["BASE_URL"]+"user_login/logout");
					// }
					// else {
						// alert('Incorrect Old Password!');
					// }
				}
			});
		})) */
	});
</script>