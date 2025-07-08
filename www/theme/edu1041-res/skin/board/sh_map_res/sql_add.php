<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_map_type'])) {//지도 선택
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_map_type` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_10` ", false);
}
if (!isset($write['sh_google_eng'])) {//구글 영문
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_google_eng` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_map_type` ", false);
}
if (!isset($write['sh_latitude'])) {//좌표(X)
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_latitude` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_google_eng` ", false);
}
if (!isset($write['sh_longitude'])) {//좌표(Y)
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_longitude` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_latitude` ", false);
}
if (!isset($write['sh_map_level'])) {//지도 확대 레벨
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_map_level` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_longitude` ", false);
}
if (!isset($write['sh_company'])) {//업체
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_company` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_map_level` ", false);
}
if (!isset($write['sh_cs'])) {//업체
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_cs` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_company` ", false);
}
?>