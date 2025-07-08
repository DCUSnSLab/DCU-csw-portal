<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($c_change or !$w){
    $class_row = sql_fetch(" select sh_restartday, sh_reendday, wr_id from {$g5['write_prefix']}{$board['bo_1']} where wr_id = '$sh_class' ");
    if(!$class_row['wr_id']){
        alert('잘못된 접근입니다.');
    }else if($class_row['sh_reendday']<G5_TIME_YMD){
        alert('해당 교육과정은 신청기간이 마감되었습니다.\n다른 교육과정을 선택해주세요');
    }else if($class_row['sh_restartday']>G5_TIME_YMD){
        alert('해당 교육과정은 신청기간이 아닙니다.\n다른 교육과정을 선택해주세요');
    }
}
?>