<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sh_caption = '';
for($i=0;$i<10;$i++){
	$sh_caption .= $ex_sh_caption[$i].'!@!';
}

$sql2 = " update {$write_table} set  
			sh_rank = '$sh_rank',
			sh_phone = '$sh_phone',
			sh_zip = '$sh_zip',
			sh_addr1 = '$sh_addr1',
			sh_addr2 = '$sh_addr2',
			sh_addr3 = '$sh_addr3',
			sh_caption = '$sh_caption',
			sh_video = '$sh_video'
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);
?>