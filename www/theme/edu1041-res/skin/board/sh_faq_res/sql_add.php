<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!isset($write['sh_rank'])) {//출력순서
    sql_query(" ALTER TABLE `{$write_table}` ADD `sh_rank` int(11) NOT NULL DEFAULT '0' AFTER `wr_10` ", false);
}
?>