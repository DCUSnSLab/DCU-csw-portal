<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);

if($board['bo_sort_field'] != 'sh_rank desc, wr_num, wr_reply' and $board['bo_4'] == '1'){ //출력순서 사용
	sql_query(" update g5_board set bo_sort_field = 'sh_rank desc, wr_num, wr_reply' where bo_table = '{$board['bo_table']}' ");
}else if($board['bo_sort_field'] == 'sh_rank desc, wr_num, wr_reply' and $board['bo_4'] != '1'){//출력순서 사용 안함
	sql_query(" update g5_board set bo_sort_field = '' where bo_table = '{$board['bo_table']}' ");
}
?>

<!-- 게시판 목록 시작 [s] -->
<div id="sh_bo_gall">

    <!-- 게시판 분류 [s] { -->
    <?php if ($is_category) {//박스 형식의 스타일을 사용한다고 하면 bo_cate_ul_box로 아이디 바꿔주세요 ?>
    <ul id="bo_cate_ul_line">
        <?php echo $category_option ?>
    </ul>
    <?php } ?>
    <!-- 게시판 분류 [e] -->        

    <!-- rss / 검색 [s] -->
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
	<!-- rss / 검색 [e] -->

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">

        <?php if ($is_checkbox) { ?>
        <div id="gall_allchk">
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            <label for="chkall">전체선택</label>
        </div>
        <?php } ?>
        
        <ul id="sh_gall_ul" class="gall_row">
            <?php for ($i=0; $i<count($list); $i++) {
            $update_href = $delete_href = '';
            if (($member['mb_id'] && ($member['mb_id'] === $list[$i]['mb_id'])) || $is_admin) {
                $update_href = './write.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;page='.$page.$qstr;
                set_session('ss_delete_token', $token = uniqid(time()));
                $delete_href ='./delete.php?bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
            }else if(!$list[$i]['mb_id']) { // 회원이 쓴 글이 아니라면
                $update_href = './password.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;page='.$page.$qstr;
                $delete_href = './password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;page='.$page.$qstr;
            }
            $youtube_link = mb_substr($list[$i]['sh_video'],-11,NULL,'utf-8');?>
            <li class="gall_li col-gn-<?= $bo_gallery_cols ?>">
                <div class="gall_chk">
                    <?php if ($is_checkbox) { ?>
                    <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                    <?php } ?>
                    <span class="sound_only">
                        <?php
                        if ($wr_id == $list[$i]['wr_id'])
                            echo "<span class=\"bo_current\">열람중</span>";
                        else
                            echo $list[$i]['num'];
                        ?>
                    </span>
                </div>
                <div class="gall_img">
                    <button type="button" onclick="video_view(<?php echo $list[$i]['wr_id'] ?>)"><img src="https://img.youtube.com/vi/<?= $youtube_link ?>/hqdefault.jpg" alt="<?php echo $list[$i]['wr_subject'] ?>"></button>
                </div>
                <div class="gall_txt">
                    <?php if ($is_category && $list[$i]['ca_name']) {?>
                    <span class="cate_link"><?php echo $list[$i]['ca_name'] ?></span>
                    <?php } ?>
                    <button class="tit" type="button" onclick="video_view(<?php echo $list[$i]['wr_id'] ?>)">
                        <?php echo $list[$i]['subject'] ?>
                        <?php if ($list[$i]['icon_new']) echo "<span class='new'>N</span>"; ?>
                    </button>
                    <?php if($is_admin){?>
                    <div class="set">
						<?php if($update_href){?><a href="<?php echo $update_href ?>">수정</a><?php }?>
                        <?php if($delete_href){?><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제</a><?php }?>
                    </div>
                    <?php }?>
                </div>
            </li>
            <?php } ?>
            <?php if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>
        </ul>
        
        <?php echo $write_pages; //페이지 ?>
        
        <!-- 버튼 [s] -->
        <div class="btn_area">
            <!-- 관리자 버튼 [s] -->
            <ul class="adm_btns">
                <?php if($is_checkbox){ ?><li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="sh_adm_btn"><i class="fa fa-check-square-o" aria-hidden="true"></i> 선택삭제</button></li><?php } ?>
                <?php if($admin_href){ ?><li><a href="<?php echo $admin_href ?>" class="sh_adm_btn">관리자</a></li><?php } ?>
                <?php if($is_admin){?><li><button type="button" class="sh_adm_btn" onclick="window.open('<?= $board_skin_url ?>/sh_setup.php?bo_table=<?php echo $bo_table?>', 'cs_call', 'width=800px; height=620px; left=150; top=30px; scrollbars=yes');">게시판관리</button></li><?php } ?>
            </ul>
            <!-- 관리자 버튼 [e] -->
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_type01 w_btn">글쓰기</a><?php } ?>
        </div>
        <!-- 버튼 [e] -->
    </form>
</div>
<!-- 게시판 목록 [e] -->

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<script>
function video_view(id){
    $.ajax({
        url: "<?php echo $board_skin_url ?>/view.ajax.php",
        type: "POST",
        data: {
            id:id,
            table:g5_bo_table
        },
        dataType: "html",
        success: function(data) {
            $("#video_view").remove();
            $("body").append(data);
        }
    });
}
<?php if ($is_checkbox) { ?>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

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
