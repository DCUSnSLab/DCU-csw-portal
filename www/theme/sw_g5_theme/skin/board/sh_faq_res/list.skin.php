<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css">', 0);
if($board['bo_sort_field'] != 'sh_rank desc, wr_num asc'){ //출력순서 사용
	sql_query(" update g5_board set bo_sort_field = 'sh_rank desc, wr_num asc' where bo_table = '{$board['bo_table']}' ");
}
?>

<div id="sh_faq"> 
    
    <?php if ($is_category) {//박스 형식의 스타일을 사용한다고 하면 bo_cate_ul_box로 아이디 바꿔주세요?>
    <ul id="bo_cate_ul_line">
        <?php echo $category_option ?>
    </ul>
    <?php } ?>
    
    <div class="list_top">
		<?php if ($rss_href || $write_href) { ?><?php if ($rss_href) { ?><a href="<?php echo $rss_href ?>"><i class="fa fa-rss" aria-hidden="true"></i>RSS</a><?php } ?><?php } ?>
        <fieldset id="sh_bo_sch">
            <legend>게시물 검색</legend>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>아이디</option>
                <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20">
            <input type="image" src="<?= G5_THEME_URL ?>/img/search.png" alt="검색" name="submit" value="submit" />
            </form>
        </fieldset>        
    </div>
        
    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">
            
        <div class="faq_wrap">
            <?php
            for ($i=0; $i<count($list); $i++) {?>
            <div class="cont_faq">
                <?php if ($is_checkbox) { ?>
                    <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                <?php } ?>
                <button class="cont_q <?= $i==0 ? 'open' : '' ?>" type="button">
                    <span class="num">Q
                    </span>
                    <p><?php echo $list[$i]['wr_subject'] ?></p>
                </button>    
            
                <div class="cont_a">
                    <?php if ($is_admin) { ?><p class="ps">※ 아래 본문 내용 클릭시 수정 가능합니다.</p><? } ?>				            
                    <?php if ($is_admin) { ?><a href="/bbs/write.php?bo_table=<?= $bo_table ?>&wr_id=<?= $list[$i]['wr_id'] ?>&w=u"><? } ?><?php echo $list[$i]['wr_content'] ?><?php if ($is_admin) { ?></a><? } ?>
                </div>
            </div>
            <?php } ?>
            <?php if (count($list) == 0) { echo '<div class="empty_table">게시물이 없습니다.</div>'; } ?>
        </div>
            
        <?php echo $write_pages; //페이지 ?>
        
        <div class="btn_area">
            <ul class="adm_btns">
                <?php if ($is_checkbox) { ?><li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="sh_adm_btn"><i class="fa fa-check-square-o" aria-hidden="true"></i> 선택삭제</button></li><?php } ?>
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="sh_adm_btn">관리자</a></li><?php } ?>
            </ul>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_type01 w_btn">글쓰기</a><?php } ?>
        </div>
    </form>
</div>

<script>
$('.cont_q').click(function(){
    $(this).toggleClass('open');
    $(this).siblings('.cont_a').slideToggle(200);
});

<?php if ($is_checkbox) { ?>
function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}
<?php } ?>
</script>