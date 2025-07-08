<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$wr_subject = $_POST['wr_name']."님의 수강료조회 입니다.";
$sql2 = " update {$write_table} set  
            wr_subject = '$wr_subject',
            wr_name = '{$_POST['wr_name']}',
            sh_phone = '$sh_phone',
			sh_class = '$sh_class'
	     where wr_id = '$wr_id' ";			
			
sql_query($sql2);

if($member['mb_level'] != '10' and !$w){
	//고객번호
    $guest_number = $sh_phone;
	
	//관리자번호(발신등록번호)
    $adm_number = '01000000000';
  
	//관리자 문자내용
	$adm_contents = '['.$config['cf_title'].']'.$wr_name."님의 수강료조회 입니다.\n".$guest_number;
	//신청자 문자내용
	$guest_contents = '['.$config['cf_title'].']'.$wr_name."님의 수강료조회 접수되었습니다. 감사합니다.";
  
	//sh_sms('수신번호','발신번호','문자내용');
    sh_sms($adm_number,$adm_number,$adm_contents);//관리자용
    sh_sms($guest_number,$adm_number,$guest_contents);//고객용
}

if(!$is_admin){
    alert("고객님의 글이 정상적으로 작성 되었습니다.", "/bbs/write.php?bo_table=$bo_table".$qstr);
}
?>