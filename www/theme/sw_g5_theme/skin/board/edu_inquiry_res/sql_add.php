<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_phone'])) {//연락처
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_phone` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_10` ", false);
}
if (!isset($write['sh_class'])) {//교육과정
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_class` INT(11) NOT NULL DEFAULT '0' AFTER `sh_phone` ", false);
}
?>