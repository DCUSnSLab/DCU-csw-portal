<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
    <li>
        <?php echo "<a href=\"".$list[$i]['href']."\">"; ?> 
        <p class="lt_tit"> <?= $bo_subject ?></p>
        <span class="subj">
            <?php echo cut_str($list[$i]['subject'],"100",".."); ?>
        </span>
        <p class="date"><?php echo date("y.m.d", strtotime($list[$i]['wr_datetime'])) ?></p>
        <?php echo "</a>"; ?>
    </li>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty">게시물이 없습니다.</li>
    <?php }  ?>
