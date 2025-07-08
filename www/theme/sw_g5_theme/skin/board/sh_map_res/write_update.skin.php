<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sql2 = " update {$write_table} set  
			sh_map_type = '$sh_map_type',
			sh_google_eng = '$sh_google_eng',
			sh_latitude = '$sh_latitude',
			sh_longitude = '$sh_longitude',
			sh_map_level = '$sh_map_level',
			sh_company = '$sh_company',
			sh_cs = '$sh_cs' 
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);

?>