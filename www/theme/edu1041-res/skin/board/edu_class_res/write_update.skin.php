<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sh_week = '';
if(!empty($ex_sh_week)){
	for($i=0;$i<count($ex_sh_week);$i++){
		if($sh_week){
			$sh_week .= ",";
		}
		$sh_week .= $ex_sh_week[$i];
	}
}else{
	$sh_week = '일,월,화,수,목,금,토';
}
$sql2 = " update {$write_table} set  
			sh_rank = '$sh_rank',
			sh_startday = '$sh_startday',
			sh_endday = '$sh_endday',
			sh_restartday = '$sh_restartday',
			sh_reendday = '$sh_reendday',
			sh_starttime = '$sh_starttime',
			sh_endtime = '$sh_endtime',
			sh_week = '$sh_week',
			sh_alltime = '$sh_alltime',
			sh_class = '$sh_class',
			sh_info = '$sh_info'
	     where wr_id = '$wr_id' ";			
         
sql_query($sql2);
?>