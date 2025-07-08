<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sql2 = " update {$write_table} set  
			wr_name = '{$_POST['wr_name']}',
			wr_subject = '{$_POST['wr_name']}',
			wr_email = '{$_POST['wr_email']}',
			sh_rank = '$sh_rank',
			sh_phone = '$sh_phone',
			sh_class = '$sh_class',
			sh_career = '$sh_career',
			sh_schoolcareer = '$sh_schoolcareer'
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);
?>