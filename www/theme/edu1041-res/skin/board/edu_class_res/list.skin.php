<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/designkits.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);

$sql_common = " from g5_write_{$bo_table} ";
$sql_search = " where wr_is_comment = 0 ";
$qstr = '';
if($time){
    switch($time){
        case 'wait':
            $sql_search .= " and sh_restartday > '".G5_TIME_YMD."'";
            break;
        case 'recruit':
            $sql_search .= " and sh_restartday <= '".G5_TIME_YMD."' and sh_reendday >= '".G5_TIME_YMD."'";
            break;
        case 'going':
            $sql_search .= " and sh_startday <= '".G5_TIME_YMD."' and sh_endday >= '".G5_TIME_YMD."'";
            break;
        case 'finish':
            $sql_search .= " and sh_endday < '".G5_TIME_YMD."'";
            break;
    }
    $qstr .= "&time={$time}";
}
if($sfl && $stx){
    $sql_search .= " and {$sfl} like '%{$stx}%' ";
    $qstr .= "&sfl={$sfl}&stx={$stx}";
}
if($page){
    $qstr .= "&page={$page}";
}

$sql_orderby = " order by sh_rank desc, wr_num asc, wr_reply asc";// 출력 순서 정의 desc or asc

$list_page_rows = $rows = $board['bo_page_rows'];
		
$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
		
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();
$sql = " select * {$sql_common} {$sql_search} {$sql_orderby} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
$k = 0;
for ($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = get_list($row, $board, $board_skin_url, G5_IS_MOBILE ? $board['bo_mobile_subject_len'] : $board['bo_subject_len']);
	$list_num = $total_count - ($page - 1) * $list_page_rows;
	$list[$i]['num'] = $list_num - $k;
	$k++;
	
}
$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr);
?>

<!-- 게시판 목록 시작 [s] -->
<div id="sh_bo_gall">
    <!-- 모집별 분류 [s] -->
    <ul id="bo_cate_ul_line">
        <li><a href="/bbs/board.php?bo_table=<?= $bo_table ?>" <?= !$time?'id="bo_cate_on"':'' ?>>전체</a></li>
        <li><a href="/bbs/board.php?bo_table=<?= $bo_table ?>&time=wait" <?= $time=='wait'?'id="bo_cate_on"':'' ?>>교육 모집대기중</a></li>
        <li><a href="/bbs/board.php?bo_table=<?= $bo_table ?>&time=recruit" <?= $time=='recruit'?'id="bo_cate_on"':'' ?>>교육 모집중</a></li>
        <li><a href="/bbs/board.php?bo_table=<?= $bo_table ?>&time=going" <?= $time=='going'?'id="bo_cate_on"':'' ?>>교육 진행중</a></li>
        <li><a href="/bbs/board.php?bo_table=<?= $bo_table ?>&time=finish" <?= $time=='finish'?'id="bo_cate_on"':'' ?>>교육 완료</a></li>
    </ul>
    <!-- 모집별 분류 [e] -->

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
                <input type="hidden" name="time" value="<?php echo $time ?>">
                <label for="sfl" class="sound_only">검색대상</label>
                <select name="sfl" id="sfl">
                    <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                    <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                </select>
                <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20">
                <input type="image" src="<?= G5_THEME_URL?>/img/search.png" alt="검색" value="submit" />
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
    <input type="hidden" name="time" value="<?php echo $time ?>">
    <input type="hidden" name="sw" value="">

    <?php if ($is_checkbox) { ?>
    <div id="gall_allchk">
        <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
    </div>
    <?php } ?>

    <ul id="sh_gall_ul" class="gall_row">

		<?php for ($i=0; $i<count($list); $i++) {
        // 사용 요일 빈값 제거
        $sh_week = $list[$i]['sh_week'];
        $sh_week_arr = array_filter(explode(',', $sh_week));
        $sh_week = implode(',', $sh_week_arr);
        ?>
        <li class="gall_li">
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
            
            <!-- gall_con [s] -->
            <div class="gall_con">
                <div class="gall_img">
                    <a href="<?php echo $list[$i]['href'] ?>">
                    <?php
                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
                    if($thumb['src']) {
                        $img_content = '<img src="'.$thumb['src'].'" alt="'.$list[$i]['wr_subject'].'" >';
                    } else {
						$img_content = '<div class="no_image" style="width:'.$board['bo_gallery_width'].'px; line-height:'.$board['bo_gallery_height'].'px">이미지 준비중입니다.</div>';
                    }
                    echo $img_content;
                    ?>
                    </a>
                </div>
                <div class="gall_txt">
                    <div class="subject">
						<?php if ($is_category && $list[$i]['ca_name']) {?>
                        <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="cate_link"><span><?php echo $list[$i]['ca_name'] ?></span></a>
                        <?php } ?>
                        <a href="<?php echo $list[$i]['href'] ?>" class="tit">
                            <?php echo $list[$i]['subject'] ?>
                            <?php if ($list[$i]['icon_new']) echo "<span class='new'>N</span>"; ?>
                        </a>
                    </div>
                    <div class="desc">   
                        <?php if($list[$i]['sh_restartday']!='0000-00-00' && $list[$i]['sh_reendday']!='0000-00-00'){?>         
                        <dl>
                            <dt>모집기간</dt>
                            <dd><?= $list[$i]['sh_restartday']?> ~ <?= $list[$i]['sh_reendday'] ?></dd>
                        </dl>
                        <?php }?>
                        <dl>
                            <dt>교육기간</dt>
                            <dd><?= $list[$i]['sh_startday']?> ~ <?= $list[$i]['sh_endday'] ?></dd>
                        </dl>
                        <dl>
                            <dt>교육시간</dt>
                            <dd class="time">
								<span><?= $list[$i]['sh_starttime']?> ~ <?= $list[$i]['sh_endtime'] ?></span>
                                <span>주 <?= count($sh_week_arr) ?>일 ( <?= $sh_week ?> )</span>
								<?= $list[$i]['sh_endtime'] ? '<span>총 '.$list[$i]['sh_alltime'].'시간</span>' : '' ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>교육과목</dt>
                            <dd><?= $list[$i]['sh_class'] ?></dd>
                        </dl>
                        <dl>
                            <dt>교육내용</dt>
                            <dd><?= $list[$i]['sh_info'] ?></dd>
                        </dl>
                    </div>  
                    <div class="link_area">
                        <a href="<?= $list[$i]['href'] ?>">상세보기</a>
                        <?php if($list[$i]['sh_restartday'] <= G5_TIME_YMD and $list[$i]['sh_reendday'] >= G5_TIME_YMD && $board['bo_1']){?>
                        <a href="/bbs/write.php?bo_table=<?= $board['bo_1'] ?>&class=<?= $list[$i]['wr_id']?>">수강료조회</a>
                        <?php }?>
                    </div>                             
                </div>                
            </div>
            <!-- gall_con [e] -->
            
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
            <?php if($is_admin){?>
            <li><button type="button" class="sh_adm_btn" onclick="window.open('<?php echo $board_skin_url ?>/sh_setup.php?bo_table=<?php echo $bo_table?>', 'cs_call', 'width=800px; height=<?php echo $member['mb_id'] == 'admin' ? '620' : '280'?>px; left=150; top=30px; scrollbars=yes');">게시판관리</button></li>
            <?php if($board['bo_1']){?>
            <li><a href="/bbs/board.php?bo_table=<?= $board['bo_1'] ?>" class="sh_adm_btn">수강료조회 내역</a></li>
            <?php }?>
            <?php } ?>
        </ul>
		<!-- 관리자 버튼 [e] -->
		<?php if($write_href){ ?><a href="<?php echo $write_href ?>" class="btn_type01 w_btn">글쓰기</a><?php } ?>
    </div>
    <!-- 버튼 [e] -->
    </form>
</div>
<!-- 게시판 목록 끝 [e] -->


<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<script>
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
