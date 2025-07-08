<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_JS_URL.'/viewimageresize.js?ver='.G5_JS_VER.'"></script>', 0);

if($board['bo_6'] == '1'){ //출력순서 사용
	
    $view_rank = sql_fetch(" select rank from (SELECT @rownum := @rownum + 1 AS rank, t.* FROM {$write_table} t, (SELECT @rownum := 0) r order by sh_rank desc, wr_num, wr_reply )b where wr_id ='{$view['wr_id']}' ");
	if($view_rank['rank']>1){$SH_limit_s = $view_rank['rank']-2;$SH_limit = $SH_limit_s.', 3';}
	if($view_rank['rank']==1){$SH_limit = ' 0, 2 ';}

	$sql_rank = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 order by sh_rank desc, wr_num, wr_reply limit {$SH_limit} ";
    $result_rank = sql_query($sql_rank);
    
	$prev=$next='';
	for ($r=0; $row_rank=sql_fetch_array($result_rank); $r++) {
		if($view_rank['rank']==1){
			if($r==1){$next = $row_rank;}
		}else{
			if($r==0){$prev = $row_rank;}
			if($r==2){$next = $row_rank;}
		}
    }
    
    // 이전글 링크
    $prev_href = '';
    if (isset($prev['wr_id']) && $prev['wr_id']) {
        $prev_wr_subject = get_text(cut_str($prev['wr_subject'], 255));
        $prev_href = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$prev['wr_id'].$qstr;
        $prev_wr_date = $prev['wr_datetime'];
    }
    
    // 다음글 링크
    $next_href = '';
    if (isset($next['wr_id']) && $next['wr_id']) {
        $next_wr_subject = get_text(cut_str($next['wr_subject'], 255));
        $next_href = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$next['wr_id'].$qstr;
        $next_wr_date = $next['wr_datetime'];
    }

}
// 사용 요일 빈값 제거
$sh_week = $view['sh_week'];
$sh_week_arr = array_filter(explode(',', $sh_week));
$sh_week = implode(',', $sh_week_arr);

$qstr = '';

if($time){
    $qstr .= "&time={$time}";
}
?>

<article id="sh_bo_v">

    <!-- 옵션/설명 [s] -->
    <div class="option_area">
        <div id="bo_v_img" class="img">
            <?php if($view['file'][0]['view']) {
                echo get_view_thumbnail($view['file'][0]['view'],500);
            } else {
                echo "<div class='no_image'>이미지 준비중입니다.</div>";					   
            }?> 
        </div>         
        <div class="desc">  
        	<div class="tit">
				<?php if ($category_name) { ?><span><?php echo $view['ca_name']; // 분류 출력 끝 ?></span><?php } ?>
                <p><?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?></p>
            </div>                  
            <dl>
                <?php if($view['sh_restartday']!='0000-00-00' && $view['sh_reendday']!='0000-00-00'){?>
                <dt>모집기간</dt>
                <dd><?= $view['sh_restartday']?> ~ <?= $view['sh_reendday']?></dd>
                <?php }?>
                <dt>교육기간</dt>
                <dd><?= $view['sh_startday']?> ~ <?= $view['sh_endday']?></dd>
                <dt>교육시간</dt>
                <dd class="time">
					<span><?= $view['sh_starttime']?> ~ <?= $view['sh_endtime']?></span>
                    <span> 주 <?= count($sh_week_arr)?>일 ( <?= $sh_week?> )</span>
					<?= $view['sh_endtime']?' <span>총 '.$view['sh_alltime'].'시간</span>':''?>
                </dd>
                <dt>교육과목</dt>
                <dd><?= $view['sh_class']?></dd>
                <dt>교육내용</dt>
                <dd><?= $view['sh_info']?></dd>
            </dl>
			<?php if($is_admin){?>
            <a class="ck_btn" href="/bbs/board.php?bo_table=<?= $board['bo_1'] ?>&class=<?= $view['wr_id']?>">수강료조회 내역</a>
            <?php }else if($view['sh_restartday'] <= G5_TIME_YMD and $view['sh_reendday'] >= G5_TIME_YMD && $board['bo_1']){?>
            <a class="ck_btn" href="/bbs/write.php?bo_table=<?= $board['bo_1'] ?>&class=<?= $view['wr_id']?>">수강료조회</a>
            <?php }?>  
        </div>    
     </div> 
    <!-- 옵션/설명 [e] -->


    <div id="bo_v_atc" class="bo_cont">
        <p class="sound_only">본문</p>
		<?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=1; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }
            echo "</div>\n";
        }
		?>
		<?php echo get_view_thumbnail($view['content']); ?>
            
        <?php if($view['sh_restartday'] <= G5_TIME_YMD and $view['sh_reendday'] >= G5_TIME_YMD && $board['bo_1']){?>
        <!-- 빠른상담폼 [s] -->
        <?php include_once($board_skin_path."/view_form.php");?>
        <!-- 빠른상담폼 [e] -->
        <?php }?>
    </div>   
    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
	?>
    <?php if($cnt) { ?>
    <!-- 첨부파일 [s] -->
    <div class="file">
        <p>첨부파일</p>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <i class="fa fa-download" aria-hidden="true"></i>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <?php echo $view['file'][$i]['source'] ?>
                </a>
                <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </div>
    <!--  첨부파일 [e] -->
    <?php } ?>    


    <?php //include_once(G5_BBS_PATH.'/view_comment.php'); // 코멘트 입출력 ?>

	<!-- 이전/다음 글 [s] -->
	<?php if ($prev_href || $next_href) { ?>
    <ul class="v_page">
        <?php if ($prev_href) { ?><li><span><i class="fa fa-angle-up"></i></span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a></li><?php } ?>
        <?php if ($next_href) { ?><li><span><i class="fa fa-angle-down"></i></span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a></li><?php } ?>
    </ul>
    <?php } ?>
    <!-- 이전/다음 글 [e] -->

    <!-- 버튼 [s] -->
    <div class="btn_area">
        <?php
        ob_start();
        ?>
        <ul class="left">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_normal">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_normal" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
        </ul>
        <ul class="right">
            <li><a href="<?php echo ($search_href ? $search_href : $list_href).$qstr ?>" class="btn_line"> 목록</a></li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_type01 w_btn"> 글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
		?>
    </div>
    <!-- 버튼 [e] -->

</article>
<!-- } 게시판 읽기 끝 -->
<script>
$(function() {
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
<!-- } 게시글 읽기 끝 -->