<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/designkits.lib.php');
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
?>

<article id="sh_bo_v">

	<div class="profile">
        <div class="img">
            <?php if($view['file'][0]['view']) {
                echo get_view_thumbnail($view['file'][0]['view'],500);
            } else {
                echo "<div class='no_image'>이미지 준비중입니다.</div>";					   
            }?> 
        </div>
        <div class="info">
        	<div class="tit">
				<?php if ($category_name) { ?><span><?php echo $view['ca_name']; // 분류 출력 끝 ?></span><?php } ?>
                <p><?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?></p>
            </div>
            <dl>
                <?php if($view['wr_name']){?>
                <dt>강사명</dt>
                <dd><?php echo $view['wr_name'] ?></dd>
                <?php }?>
				<?php if($view['sh_phone']){?>
                <dt>연락처</dt>
                <dd><?php echo phoneNum($view['sh_phone']) ?></dd>
                <?php }?>
				<?php if($view['wr_email']){?>
                <dt>이메일</dt>
				<dd><?php echo $view['wr_email'] ?></dd>
                <?php } ?> 
				<?php if($view['sh_class']){?>
                <dt>담당과목</dt>
				<dd><?php echo $view['sh_class'] ?></dd>
                <?php } ?> 
				<?php if($view['sh_schoolcareer']){?>
                <dt>학력</dt>
				<dd><?php echo nl2br($view['sh_schoolcareer'])?></dd>
                <?php } ?> 
				<?php if($view['sh_career']){?>
                <dt>경력</dt>
				<dd><?php echo nl2br($view['sh_career']) ?></dd>
                <?php } ?> 
            </dl>
    
        </div>
    </div>

    <div id="bo_v_atc" class="bo_cont">
        <p class="sound_only">본문</p>

		<?php echo get_view_thumbnail($view['content']); ?>
    </div>   

    <?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
    <div class="link">
        <p>관련링크</p>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
            ?>
            <li>
                <i class="fa fa-link" aria-hidden="true"></i> 
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <?php echo $link ?>
                </a>
                <span>(<?php echo $view['link_hit'][$i] ?>회 연결)</span>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </div>
    <?php } ?>
    
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
            <li><a href="<?php echo $list_href ?>" class="btn_line"> 목록</a></li>
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