<?php
include_once('./_common.php');
// 종속파일은 단독으로 실행할 수 없다
if(!$is_admin){
    alert_close("권한이 없습니다. 로그인해주세요");
}
$sql2 = " update g5_board set 
bo_list_level= '$bo_list_level',
bo_read_level= '$bo_read_level',
bo_write_level= '$bo_write_level',
bo_reply_level= '$bo_reply_level',
bo_comment_level= '$bo_comment_level',
bo_use_secret= '$bo_use_secret',
bo_use_dhtml_editor= '$bo_use_dhtml_editor',
bo_category_list = '$bo_category_list',
bo_upload_count = '$bo_upload_count',
bo_use_email = '$bo_use_email',
bo_use_category = '$bo_use_category',
bo_gallery_width = '{$bo_gallery_width}',
bo_gallery_height = '{$bo_gallery_height}', 
bo_gallery_cols = '{$bo_gallery_cols}',
bo_1 = '$bo_1',
bo_2 = '$bo_2',
bo_3 = '$bo_3',
bo_4 = '$bo_4',
bo_5 = '$bo_5'
where bo_table = '$bo_table'";
sql_query($sql2);

alert("게시판 정보가 정상적으로 입력되었습니다.");
?>