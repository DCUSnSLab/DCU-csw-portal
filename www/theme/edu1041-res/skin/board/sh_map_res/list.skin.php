<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
?>

<div id="sh_bo_list">
    <?php
    for ($i=0; $i<count($list); $i++) {
        $link = " /bbs/board.php?bo_table=".$bo_table."&wr_id=".$list[$i]['wr_id'];
        goto_url($link);
    }?>
    <div style="width:100%; height:300px; text-align:center; padding-top:100px;">
        <?php echo $board['bo_subject']; ?></strong>는(은) 준비중입니다. 
    </div>

    <div class="btn_area">
    	<ul class="adm_btns">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="sh_adm_btn">관리자</a></li><?php } ?>
        </ul>
		<?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_type01 w_btn">글쓰기</a><?php } ?>
    </div>

</div>