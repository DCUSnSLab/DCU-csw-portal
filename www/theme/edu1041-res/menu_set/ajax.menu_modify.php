<?php
include_once('../../../common.php');

$ca_no = $_POST['ca_no'];
$ca_name = $_POST['ca_name'];
$ca_link = $_POST['ca_link'];
$ca_mobile_use = $_POST['ca_mobile_use'];
$bo_skin = $_POST['bo_skin'];
$ca_type = $_POST['ca_type'];
$ca_link_target = $_POST['ca_link_target'];

$sql =" update sh_category set ca_name = '{$ca_name}', ca_link = '{$ca_link}', ca_mobile_use = '{$ca_mobile_use}', bo_skin = '{$bo_skin}', ca_type = '{$ca_type}', ca_link_target = '{$ca_link_target}' where ca_no = '{$ca_no}' ";
sql_query($sql);

// php 생성 시작
if($ca_type == 'php'){
	$ca_no_file = G5_PATH.'/sh_page/page'.$ca_no.'.php';
		// 페이지가 없을때만 실행
	if (!file_exists($ca_no_file)) {
		@copy(G5_PATH.'/sh_system/page_sample.php', G5_PATH.'/sh_page/page'.$ca_no.'.php');
		@chmod(G5_PATH.'/sh_page/page'.$ca_no.'.php', 0707);
	}
}
// php 생성 끝

// bo_tabe 생성 시작
if($bo_skin){
	$bo_table = 'table'.$ca_no;
	$sql = " select * from g5_board where bo_table = '$bo_table' ";
	$bo = sql_fetch($sql);
	
	if($bo['bo_table']){// 게시판이 있을때 스킨, 테이블명 만 수정
		$sql =" update g5_board set bo_subject = '{$ca_name}', bo_mobile_skin = '{$bo_skin}', bo_skin = '{$bo_skin}' where bo_table = '{$bo['bo_table']}' ";
		sql_query($sql);
	}else{// 게시판이 없을때 생성 시작
		// 권한 세팅
		if($ca_type=='board' or $ca_type== 'write'){$bo_list_level = $bo_read_level = $bo_write_level = $bo_reply_level = $bo_comment_level = '1';}
		if($ca_type=='map' or $ca_type=='faq' or $ca_type=='page'){$bo_list_level = $bo_write_level = $bo_reply_level = $bo_comment_level = '10';$bo_read_level = '1';}

	
		$sql = " insert into {$g5['board_table']}
            set bo_table = '{$bo_table}',
                gr_id = 'homepage',
                bo_count_write = '0',
                bo_count_comment = '0',
                bo_subject = '{$ca_name}', 
                bo_mobile_skin = '{$bo_skin}', 
                bo_skin = '{$bo_skin}',
                bo_device           = 'both',
                bo_admin            = 'adm',
                bo_list_level       = '{$bo_list_level}',
                bo_read_level       = '{$bo_read_level}',
                bo_write_level      = '{$bo_write_level}',
                bo_reply_level      = '{$bo_reply_level}',
                bo_comment_level    = '{$bo_comment_level}',
                bo_html_level       = '1',
                bo_link_level       = '1',
                bo_count_modify     = '1',
                bo_count_delete     = '1',
                bo_upload_level     = '1',
                bo_download_level   = '1',
                bo_use_dhtml_editor = '1',
                bo_table_width      = '100',
                bo_subject_len      = '60',
                bo_mobile_subject_len      = '30',
                bo_page_rows        = '15',
                bo_mobile_page_rows = '15',
                bo_new              = '24',
                bo_hot              = '100',
                bo_image_width      = '820',
                bo_include_head     = '_head.php',
                bo_include_tail     = '_tail.php',
                bo_gallery_cols     = '4',
                bo_gallery_width    = '174',
                bo_gallery_height   = '124',
                bo_mobile_gallery_width = '125',
                bo_mobile_gallery_height= '100',
                bo_upload_count     = '2',
                bo_upload_size      = '1048576',
                bo_reply_order      = '1' ";
		sql_query($sql);

		// 게시판 테이블 생성
        $file = file(G5_PATH.'/adm/sql_write.sql');
        $file = get_db_create_replace($file);

        $sql = implode("\n", $file);

        $create_table = $g5['write_prefix'] . $bo_table;

        // sql_board.sql 파일의 테이블명을 변환
        $source = array('/__TABLE_NAME__/', '/;/');
        $target = array($create_table, '');
        $sql = preg_replace($source, $target, $sql);
        sql_query($sql, false);
	}//게시판 없을때 생성 끝
	
}
// bo_tabe 생성 끝
?>