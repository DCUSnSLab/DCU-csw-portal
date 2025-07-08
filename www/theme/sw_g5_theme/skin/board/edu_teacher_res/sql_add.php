<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_phone'])) {//연락처
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_phone` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_10` ", false);
}
if (!isset($write['sh_rank'])) {//출력순서
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_rank` int(11) NOT NULL DEFAULT '0' AFTER `wr_10` ", false);
}
if (!isset($write['sh_class'])) { //담당과목
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_class` VARCHAR(255) NOT NULL DEFAULT '' AFTER `sh_rank` ", false);
}
if (!isset($write['sh_career'])) { //경력
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_career` TEXT NOT NULL DEFAULT '' AFTER `sh_class` ", false);
}
if (!isset($write['sh_schoolcareer'])) { //학력
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_schoolcareer` TEXT NOT NULL DEFAULT '' AFTER `sh_career` ", false);
}
?>