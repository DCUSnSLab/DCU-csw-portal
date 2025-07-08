<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_phone'])) {//연락처
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_phone` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_10` ", false);
}
if (!isset($write['sh_rank'])) {//출력순서
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_rank` int(11) NOT NULL DEFAULT '0' AFTER `wr_10` ", false);
}
// 주소 시작
if (!isset($write['sh_zip'])) {
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_zip` char(5) NOT NULL DEFAULT '' AFTER `sh_phone` ", false);
}
if (!isset($write['sh_addr1'])) {
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_addr1` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_zip` ", false);
}
if (!isset($write['sh_addr2'])) {
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_addr2` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_addr1` ", false);
}
if (!isset($write['sh_addr3'])) {
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_addr3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_addr2` ", false);
}
// 주소 끝
?>