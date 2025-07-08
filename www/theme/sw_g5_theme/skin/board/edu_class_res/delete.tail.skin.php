<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if($board['bo_1']){
    $in_sql = sql_query("select wr_id from {$g5['write_prefix']}{$board['bo_1']} where sh_class = '{$write['wr_id']}'");
    for($i=0;$in_row=sql_fetch_array($in_sql);$i++){
        // 게시글 삭제
        sql_query(" delete from {$g5['write_prefix']}{$board['bo_1']} where wr_id = '{$in_row['wr_id']}' ");
    
        // 최근게시물 삭제
        sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$board['bo_1']}' and wr_parent = '{$in_row['wr_id']}' ");
    
        // 스크랩 삭제
        sql_query(" delete from {$g5['scrap_table']} where bo_table = '{$board['bo_1']}' and wr_id = '{$in_row['wr_id']}' ");
    }

    sql_query(" update {$g5['board_table']} set bo_count_write = bo_count_write - ($i-1) where bo_table = '{$board['bo_1']}' ");
}
?>