<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$sql2 = " update {$write_table} set  
			sh_rank = '$sh_rank',
			sh_video = '$sh_video'
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);

alert("글이 정상적으로 작성 되었습니다.", "/bbs/board.php?bo_table=$bo_table");
?>