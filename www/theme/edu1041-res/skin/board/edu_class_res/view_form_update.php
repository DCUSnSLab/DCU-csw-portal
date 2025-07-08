<?php
include_once('./_common.php');

if(!$inquiry_table || !$class_table){
	alert('잘못된 접근입니다.');
}

$class_row = sql_fetch(" select sh_restartday, sh_reendday, wr_id from {$g5['write_prefix']}{$class_table} where wr_id = '$sh_class' ");
if(!$class_row['wr_id']){
	alert('잘못된 접근입니다.');
}else if($class_row['sh_reendday']<G5_TIME_YMD){
    alert('해당 교육과정은 신청기간이 마감되었습니다.\n다른 교육과정을 선택해주세요');
}else if($class_row['sh_restartday']>G5_TIME_YMD){
    alert('해당 교육과정은 신청기간이 아닙니다.\n다른 교육과정을 선택해주세요');
}

if(!$wr_name){ alert("이름은 필수항목입니다."); } 
if(!is_numeric($sh_phone)){ alert("전화번호는 숫자만 입력 가능합니다."); } 

$sh_ss_name = $_SERVER['PHP_SELF'];
if (isset($_SESSION[$sh_ss_name])) {
	if ($_SESSION[$sh_ss_name] >= (G5_SERVER_TIME - 30)){
		alert('너무 빠른 시간내에 상담 신청을 연속해서 신청할 수 없습니다.');
	}
} 
set_session($sh_ss_name, G5_SERVER_TIME);

///////////////////////////////////////////////////////////////////////////////////////////
/********************************* 해당게시판에 내용 저장 *********************************/
$wr_subject = "[상담문의]".$wr_name."님의 수강료조회 입니다."; //제목

/******************************** sms 문자 기본 설정 내용 ********************************/
$use_sms = 'yes'; // 사용안하면 no
$adm_number = '01000000000';//관리자번호(발신등록번호) (번호,번호 배열로 하시면 다중 전송 가능.)
$guest_number = $sh_phone;//고객번호
$adm_contents = $wr_name."님의 수강료조회 입니다.\n".$guest_number;//관리자 문자내용
$guest_contents = $wr_name."님의 수강료조회가 접수되었습니다. 감사합니다.";//신청자 문자내용
////////////////////////////////////////////////////////////////////////////////////////////

$write_table = "{$g5['write_prefix']}{$inquiry_table}";
$wr_password = sprintf('%06d',rand(000000,999999));
$wr_password = get_encrypt_string($wr_password);

$wr_num = get_next_num($write_table);
$wr_reply = '';
    
sql_query("insert into {$write_table} set wr_num = '$wr_num', ca_name = '$ca_name', wr_subject = '$wr_subject', wr_datetime = '".G5_TIME_YMDHIS."', wr_name = '$wr_name', wr_password = '$wr_password', wr_email = '$wr_email', wr_content = '$wr_content', wr_ip = '{$_SERVER[REMOTE_ADDR]}', wr_option = 'secret', sh_phone = '$sh_phone', sh_class = '$sh_class'   ");

$wr_id = sql_insert_id();

// 부모 아이디에 UPDATE
sql_query(" update {$write_table} set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

// 새글 INSERT
if(!$member['mb_id']){$member['mb_id']='guest';}
sql_query(" insert into g5_board_new ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$inquiry_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");
	
// 게시글 1 증가
sql_query("update g5_board set bo_count_write = bo_count_write + 1 where bo_table = '{$inquiry_table}'");

if($member['mb_level'] != '10' and $use_sms == 'yes'){
	$adm_number = explode(',', $adm_number);
    for ($i=0; $i<count($adm_number); $i++){
		//sh_sms('수신번호','발신번호','문자내용');
    	sh_sms($adm_number[$i],$adm_number[0],$adm_contents);//관리자용
	}
	sh_sms($guest_number,$adm_number[0],$guest_contents);//고객용
}

if($_POST['form_url']){$go_url = $_POST['form_url'];}else{$go_url = G5_URL;}

alert("수강료조회가 정상 접수되었습니다.\\n빠른 시간 내로 연락드리겠습니다.", $go_url);
?>
