<?php
include_once("../../../common.php");

if($is_admin!='super'){
    alert('홈페이지 관리자만 접근 가능합니다.');
}

for ($i=0; $i<count($_POST['ca_no']); $i++) {
	if($i==0){$ca_id_set1 = $ca_id_set2 = 10;}	
	
	if($ca_id_len[$i]=='2' and $i!=0){$ca_id_set1++;}
	
	if($ca_id_len[$i]=='2'){
		$ca_id_new = $ca_id_set1;
		$ca_id_set2 = 10;
	}else{
		$ca_id_new = $ca_id_set1.$ca_id_set2;
		$ca_id_set2++;
	}

	$sql =" update sh_category set ca_id = '{$ca_id_new}' where ca_no = '{$ca_no[$i]}' ";
	sql_query($sql);
}

for ($i=0; $i<count($_POST['ca_name']); $i++) {
	$sql =" update sh_category set 
			ca_name = '{$ca_name[$ca_no[$i]]}',
			ca_type = '{$ca_type[$ca_no[$i]]}',
			ca_link = '{$ca_link[$ca_no[$i]]}',
			ca_link_target = '{$ca_link_target[$ca_no[$i]]}',
			bo_skin = '{$bo_skin[$ca_no[$i]]}',
			ca_mobile_use = '{$ca_mobile_use[$ca_no[$i]]}' 
			where ca_no = '{$ca_no[$i]}' ";
	sql_query($sql);	

	if($ca_type[$ca_no[$i]] == 'php'){
		$ca_no_file = G5_PATH.'/page/page'.$ca_no[$i].'.php';
		// 페이지가 없을때만 실행
		if (!file_exists($ca_no_file)) {
			@copy(G5_THEME_PATH.'/menu_set/page_sample.php', G5_PATH.'/page/page'.$ca_no[$i].'.php');
			@chmod(G5_PATH.'/page/page'.$ca_no[$i].'.php', 0707);
		}
	}

	if($bo_skin[$ca_no[$i]] && $ca_type[$ca_no[$i]]=='board'){
		$bo_table = 'table'.$ca_no[$i];
		
		$ex_ca_link = explode("bo_table=",$ca_link[$ca_no[$i]]);
		$ex_ca_link = explode("&",$ex_ca_link[1]);
		if($ex_ca_link[0]){$bo_table = $ex_ca_link[0];}
		
		$sql_bo = " select * from g5_board where bo_table = '$bo_table' ";
		$bo = sql_fetch($sql_bo);
		
		if($bo['bo_table']){
			$sql =" update g5_board set bo_subject = '{$ca_name[$ca_no[$i]]}', bo_mobile_skin = '{$bo_skin[$ca_no[$i]]}', bo_skin = '{$bo_skin[$ca_no[$i]]}' where bo_table = '{$bo['bo_table']}' ";
			sql_query($sql);
		}else{ 
			$bo_list_level = $bo_read_level = $bo_write_level = $bo_reply_level = $bo_comment_level = '1';
		
			$sql = " insert into {$g5['board_table']}
				set bo_table = '{$bo_table}',
					gr_id = 'board',
					bo_count_write = '0',
					bo_count_comment = '0',
					bo_subject = '{$ca_name[$ca_no[$i]]}', 
					bo_mobile_skin = '{$bo_skin[$ca_no[$i]]}', 
					bo_skin = '{$bo_skin[$ca_no[$i]]}',
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
}

alert("메뉴 수정이 완료 되었습니다.");
?>