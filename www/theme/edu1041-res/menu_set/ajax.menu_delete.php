<?php
include_once('../../../common.php');

$ca_no = $_POST['ca_no'];
$ca_id = $_POST['ca_id'];
$deaso = $_POST['deaso'];


if(!$_POST['ca_no']) {die("{\"sh_alert\":\"정상적으로 접근해주세요.\"}");}
if($is_admin!='super'){die("{\"sh_alert\":\"정상적으로 접근해주세요.\"}");}

// 대분분류 검색 후 대분류면 소분류 체크 
if($deaso=='2'){
	$sql = " select count(*) as cnt from sh_category where ca_id like '$ca_id%' and LENGTH(ca_id) = '4' ";
	$row = sql_fetch($sql);
	if ($row['cnt']){die("{\"sh_alert\":\"소분류 삭제 후 대분류 삭제 가능합니다.\"}");}
}

// 페이지 및 게시판 삭제 시작
$sql = " select * from sh_category where ca_no = '$ca_no' ";
$ca = sql_fetch($sql);
if($ca['ca_type']=='php'){
	$date = time();
	@unlink(G5_PATH.'/page/page'.$ca_no.'.php');
}
// 페이지 삭제 끝

// 게시판 삭제 시작
$bo_table = 'table'.$ca_no;
$sql = " select * from g5_board where bo_table = '$bo_table' ";
$bo = sql_fetch($sql);
	
if($bo['bo_table']){
	$tmp_bo_table = $bo['bo_table'];
	include_once(G5_ADMIN_PATH.'/admin.lib.php');
	if (!$tmp_bo_table) { return; }

	// 게시판 설정 삭제
	sql_query(" delete from {$g5['board_table']} where bo_table = '{$tmp_bo_table}' ");

	// 최신글 삭제
	sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$tmp_bo_table}' ");

	// 스크랩 삭제
	sql_query(" delete from {$g5['scrap_table']} where bo_table = '{$tmp_bo_table}' ");

	// 파일 삭제
	sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$tmp_bo_table}' ");

	// 게시판 테이블 DROP
	sql_query(" drop table {$g5['write_prefix']}{$tmp_bo_table} ", FALSE);

	delete_cache_latest($tmp_bo_table);

	// 게시판 폴더 전체 삭제
	rm_rf(G5_DATA_PATH.'/file/'.$tmp_bo_table);
}
// 게시판 삭제 끝

$sql = " delete from sh_category where ca_no = '{$ca_no}' ";
sql_query($sql);
die("{\"sh_alert\":\"정상적으로 삭제 되었습니다.\"}");
?>