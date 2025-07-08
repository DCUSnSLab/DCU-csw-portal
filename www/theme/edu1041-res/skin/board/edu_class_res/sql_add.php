<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_rank'])) {//출력순서
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_rank` int(11) NOT NULL DEFAULT '0' AFTER `wr_10` ", false);
}
if (!isset($write['sh_startday'])) {//교육기간 시작일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_startday` DATE NOT NULL DEFAULT '0000-00-00' AFTER `sh_rank` ", false);
}
if (!isset($write['sh_endday'])) {//교육기간 마지막일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_endday` DATE NOT NULL DEFAULT '0000-00-00' AFTER `sh_startday` ", false);
}
if (!isset($write['sh_starttime'])) {//교육시작 시간 
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_starttime` VARCHAR(20) NOT NULL DEFAULT '' AFTER `sh_endday` ", false);
}
if (!isset($write['sh_endtime'])) {//교육끝 시간 
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_endtime` VARCHAR(20) NOT NULL DEFAULT '' AFTER `sh_starttime` ", false);
}
if (!isset($write['sh_week'])) {//교육요일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_week` VARCHAR(20) NOT NULL DEFAULT '' AFTER `sh_endtime` ", false);
}
if (!isset($write['sh_alltime'])) {//교육요일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_alltime` int(11) NOT NULL DEFAULT '0' AFTER `sh_week` ", false);
}
if (!isset($write['sh_class'])) {//교육과목
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_class` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_alltime` ", false);
}
if (!isset($write['sh_info'])) {//교육내용
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_info` TEXT NOT NULL DEFAULT '' AFTER `sh_class` ", false);
}
if (!isset($write['sh_restartday'])) {//교육모집기간 시작일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_restartday` DATE NOT NULL DEFAULT '0000-00-00' AFTER `sh_info` ", false);
}
if (!isset($write['sh_reendday'])) {//교육모집기간 마지막일
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_reendday` DATE NOT NULL DEFAULT '0000-00-00' AFTER `sh_restartday` ", false);
}
?>