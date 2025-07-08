<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$sql2 = " update {$write_table} set  
			sh_rank = '$sh_rank',
			sh_phone = '$sh_phone',
			sh_zip = '$sh_zip',
			sh_addr1 = '$sh_addr1',
			sh_addr2 = '$sh_addr2',
			sh_addr3 = '$sh_addr3'
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);
?>