<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/designkits.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
$ex_sh_caption=explode("!@!",$view['sh_caption']);//설명

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

	<p class="tit">
		<?php if ($category_name) { ?><span class="cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span><?php } ?>
        <?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?>
	</p>

    <div class="info">
    	<p><b>작성자</b><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></p>
        <ul>
            <li><b>등록일</b> <?php echo date("y-m-d", strtotime($view['wr_datetime'])) ?></li>		
            <li><b>조회</b><?php echo number_format($view['wr_hit']) ?>회</li>
        </ul>
    </div>
    <!-- 옵션/설명 [s] -->
    <div class="option_area">
        <div id="bo_v_img" class="img">
        <?php if($view['file'][0]['view']) {
                 echo get_view_thumbnail($view['file'][0]['view'],500);
                 @get_view_thumbnail($view['file'][0]['view']);
               } else {
                 echo "<div class='no_image'>이미지 준비중입니다.</div>";					   
        }?> 
        </div>        
        <div class="desc">            
        <?php 
        for($i=0;$i<6;$i++){//for문 i값($i<6) 수정하면 칸 수 조절 가능합니다. write 수정시 view, list도 수정해주세요 (최대 10)
			if ($ex_sh_caption[$i]) {?>
            <dl>
            	<dt><?php echo $ex_sh_caption[$i]?></dt>
                <dd><?php echo $ex_sh_caption[$i+1]?></dd>
            </dl>
        <?php 
			}
		$i++;
		}?>
        </div>    
    </div> 
    <!-- 옵션/설명 [e] -->
    
	<ul class="bo_ul">
        <?php if($view['mb_id']!='admin' && $view['mb_id']!='adm'){?>
        <li><span>이름</span><?php echo $view['wr_name'] ?></li>
        <?php }?>
        <?php if($board['bo_1'] == '1' and $view['sh_phone']){?>
        <li><span>연락처</span><?php echo phoneNum($view['sh_phone']) ?></li>
		<?php }?>
        <?php if($board['bo_2'] == '1' and $view['sh_zip']){?>
        <li><span>주소</span>[<?php echo $view['sh_zip']?>] <?php echo $view['sh_addr1']?>, <?php echo $view['sh_addr2']?> <?php echo $view['sh_addr3']?></li>
        <?php }?>
        <?php if($board['bo_3'] == '1' and $view['wr_email']){?>
        <li><span>이메일</span><?php echo $view['wr_email'] ?></li>
        <?php } ?> 
        <?php if($board['bo_4'] == '1' and $view['wr_homepage']){?>
		<li><span>홈페이지</span><?php echo $view['wr_homepage'] ?></li>
        <?php } ?>
	</ul>

    <div id="bo_v_atc" class="bo_cont">
        <p class="sound_only">본문</p>
        <?php if($view['sh_video']){?>
        	<?php echo $view['sh_video']?>
		<?php }?>
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