<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
// 공통부분
$sql_common_len = " from sh_category ";
$sql_search_len = " where (1) ";
$sst_len = "ca_id";
$sod_len = "asc";
$sql_order_len = " order by {$sst_len} {$sod_len} ";

$sql_len2 = " select * {$sql_common_len} {$sql_search_len} and length(ca_id) = '2' {$sql_order_len} ";

$ex_PHP_SELF=explode("/",$_SERVER['PHP_SELF']);
$ex_PHP_SELF=explode(".",$ex_PHP_SELF[2]);
$ex_PHP_SELF=explode("page",$ex_PHP_SELF[0]);

if($bo_table){$ex_PHP_SELF=explode("table",$bo_table);} 

$pa = sql_fetch(" select * from sh_category where ca_no = '{$ex_PHP_SELF[1]}' ");

if(!$pa['ca_id']){
	$new_PHP_SELF = G5_URL.$_SERVER['REQUEST_URI'];
	$pa = sql_fetch(" select * from sh_category where ca_link = '{$new_PHP_SELF}' ");

	if(!$pa['ca_id']){
		$new_PHP_SELF = $_SERVER['REQUEST_URI']; 
		$pa = sql_fetch(" select * from sh_category where ca_link = '{$new_PHP_SELF}' ");
	}
	
	if(!$pa['ca_id'] and $_GET['bo_table'] and !$_GET['sca']){ 
		$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link not like '%wr_id=%' and ca_link not like '%sca={$GET_sca}%' ");
	}
	
	if(!$pa['ca_id'] and $_GET['bo_table'] and $_GET['sca']){ 
		$encode = array('UTF-8', 'EUC-KR');
		$mb_GET_sca = mb_detect_ENCODING($_GET['sca'], $encode);
		
		if(strtoupper($mb_GET_sca) == 'UTF-8'){
			$GET_sca = $_GET['sca'];
		}
		if(strtoupper($mb_GET_sca) == 'EUC-KR'){
			if(preg_match("/[\xA1-\xFE\xA1-\xFE]/",$_GET['sca'])){
				$GET_sca = iconv("euc-kr", "utf-8", $_GET['sca']);
				$_GET['sca'] = $sca = $GET_sca;
			}
		}

		$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link like '%wr_id=%' and ca_link like '%sca={$GET_sca}%' ");
		if(!$pa['ca_id']){
			$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link like '%sca={$GET_sca}%' and ca_link not like '%wr_id=%' ");
		}
	}
	
	if(!$pa['ca_id'] and $_GET['bo_table'] and $_GET['wr_id']){
		$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link like '%wr_id={$_GET['wr_id']}%' ");
		if(!$pa['ca_id']){
			$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link not like '%wr_id=%' ");
		}
	}
	if(!$pa['ca_id'] and $_GET['bo_table'] and !$_GET['wr_id']){
		$pa = sql_fetch(" select * from sh_category where ca_link like '%bo_table={$_GET['bo_table']}%' and ca_link not like '%wr_id=%' ");
	}
}

if(isset($pa['ca_id']) && $pa['ca_id']){
	$gr = sql_fetch(" select * from sh_category where ca_id = SUBSTRING({$pa['ca_id']},1,2) ");

	$sql_pa = " select * from sh_category where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$gr['ca_id']}' order by ca_id asc ";
	$result_pa = sql_query($sql_pa);
			
	for ($i_pa=1; $row_pa=sql_fetch_array($result_pa); $i_pa++) {
		if($row_pa['ca_id']==$pa['ca_id']){$pageNum = $i_pa;}
	}
	$i_pa--;
	if(!substr($i_pa,1,1)){$i_pa = '0'.$i_pa;}
}
?>