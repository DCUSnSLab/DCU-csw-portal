<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sql2 = " update {$write_table} set  
sh_rank = '$sh_rank'
where wr_id = '$wr_id' ";			

sql_query($sql2);
goto_url("/bbs/board.php?bo_table={$bo_table}");
?>