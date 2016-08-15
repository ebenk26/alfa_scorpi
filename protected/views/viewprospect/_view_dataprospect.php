<?php
// echo $_GET["id"];exit();
$getdataprospectid = $_GET["id"];// echo $id;
$prospect = Prospect::model()->findByPk($getdataprospectid);
$region = Region::model()->findByPk($prospect->region_id);
$criteria = new CDbCriteria;  
$criteria->addCondition("prospect_id = '".$getdataprospectid."'");
$winner = Winner::model()->find($criteria);
echo 'NIK : '.$prospect->nik.'<br><br><br>';
echo 'Nama Prospect : '.$prospect->nama.'<br><br>';
echo 'Alamat : '.$prospect->alamat.'<br><br>';
echo 'TTL : '.$prospect->ttl.'<br><br>';
echo 'No. HP : '.$prospect->no_hp.'<br><br>';
echo 'No. RO : '.$prospect->no_ro.'<br><br>';
if(!empty($prospect->foto_ro) && $prospect->foto_ro != "-"){
	echo 'Foto RO : <img src="data:image/jpg;base64,'.$prospect->foto_ro.'"><br><br>';
}else{
	echo 'Foto RO :<br><br>';
}
echo 'Keterangan : '.$prospect->keterangan.'<br><br>';
echo 'Region : '.$region->name.'<br><br>';
echo 'Profil Konsumen : '.$prospect->profil_konsumen.'<br><br>';
if ($prospect->status_telepon == 1) {
	echo 'Status Telepon : Tidak Aktif<br><br>';
}else if ($prospect->status_telepon == 2) {
	echo 'Status Telepon : Tidak Diangkat<br><br>';
}else if ($prospect->status_telepon == 2){
	echo 'Status Telepon : Konsumen Batal<br><br>';
}else{
	echo 'Status Telepon : <br><br>';
}
echo 'Tanggal Survey : '.$prospect->ganti_tanggal_survey.'<br><br>';
if(empty($prospect->ganti_jam_survey)){
echo 'Jam Survey : '.$prospect->jam_survey.'<br><br>';
}else{
echo 'Jam Survey : '.$prospect->ganti_jam_survey.'<br><br>';
}
echo 'Keterangan Konfirm : '.$prospect->keterangan_confirm.'<br><br>';
echo 'DP yang disetujui : '.$prospect->dp_approve.'<br><br>';
echo 'Cicilan yang disetujui : '.$prospect->cicil_approve.'<br><br>';
echo 'Tenor : '.$prospect->tenor.'<br><br>';
echo 'Nama STNK : '.$prospect->nama_stnk.'<br><br>';
echo 'Nama Surveyor (CMO) : '.$prospect->nama_surveyor.'<br><br>';
if(empty($prospect->tipe_approve)){
echo 'Tipe Motor : '.$prospect->tipe.'<br><br>';
}else{
echo 'Tipe Motor : '.$prospect->tipe_approve.'<br><br>';
}
echo 'Keterangan Approve : '.$prospect->keterangan_approve.'<br><br>';
if($winner){
	echo 'Alasan Reject : '.$winner->reason_reject.'<br><br>';
}else{
	echo 'Alasan Reject : kosong<br><br>';
}
if(!empty($prospect->foto_1)){
echo 'Foto 1 : <img src="data:image/jpg;base64,'.$prospect->foto_1.'"><br><br>';
}else{
echo 'Foto 1 :<br><br>';
}
if(!empty($prospect->foto_2)){
echo 'Foto 2 : <img src="data:image/jpg;base64,'.$prospect->foto_2.'"><br><br>';
}else{
echo 'Foto 2 :<br><br>';
}
if(!empty($prospect->foto_3)){
echo 'Foto 3 : <img src="data:image/jpg;base64,'.$prospect->foto_3.'"><br><br>';
}else{
echo 'Foto 3 :<br><br>';
}
if(!empty($prospect->last_case_id)){
	$explode = explode('-', $prospect->last_case_id);
	$explode2 = $explode[1];
	$criteria2 = new CDbCriteria;  
	$criteria2->addCondition("prospect_id = '".$explode2."'");
	$winner2 = Winner::model()->find($criteria2);
	$leasing = Leasing::model()->findByPk($winner2->leasing_id);
	$status = Status::model()->findByPk($winner2->winner_confirm);
	echo 'History Reblast : Case ID '.$prospect->last_case_id.', '.$status->name.' By '.$leasing->nama.'<br><br>';
}
//view table comment prospect
echo 'Komentar : <br>';
	$connection=Yii::app()->db;
	$command2= $connection->createCommand("
			select d.name,a.comment,a.created_at
			from comment_prospect a
			join prospect b on a.prospect_id = b.id
			join user c on a.user_id = c.id
			join role d on c.role_id = d.id
			where prospect_id = '".$getdataprospectid."'
			order by a.created_at desc
	");
	$rows2 = $command2->queryAll();
	echo "<div style='height: 300px !important;overflow-y: auto;margin-bottom: 20px;'>";
	foreach ($rows2 as $row) {
	$time = strtotime($row['created_at']);
	$myFormatForView = date("F d,Y g:i A", $time);
				echo "	
						<div style='border-top: 1px solid black;
    margin-left: 10px;
    margin-right: 10px;
    margin-top: 10px;'>
						<div style='width:50%'>
						<div style='float:left'>  ".$row['name']." </div>
						<div style='float:right;color: grey;'>  ".$myFormatForView." </div>
						</div><br>
						<div>
							".$row['comment']."
						</div>
						</div>
				";
			}
	echo "</div>";
?>