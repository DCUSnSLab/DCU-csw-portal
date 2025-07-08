<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/designkits.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_JS_URL.'/viewimageresize.js?ver='.G5_JS_VER.'"></script>', 0);
$qstr = '';

if($class){
    $qstr .= "&class={$class}";
}


$class_row = sql_fetch(" select wr_subject from {$g5['write_prefix']}{$board['bo_1']} where wr_id = '{$view['sh_class']}' ");
?>

<section id="sh_bo_v">
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
    
	<ul class="bo_ul">
        <?php if($class_row){?>
		<li><span>교육과정</span><?php echo $class_row['wr_subject'] ?></li>
        <?php } ?>
        <li><span>이름</span><?php echo $view['wr_name'] ?></li>
        <?php if($view['sh_phone']){?>
        <li><span>연락처</span><?php echo phoneNum($view['sh_phone']) ?></li>
		<?php }?>
	</ul>
    
    <div id="bo_v_atc" class="bo_cont">
        <p class="sound_only">본문</p>
		<?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }
            echo "</div>\n";
        }?>
		<?php echo get_view_thumbnail($view['content']); ?>
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
    <div class="file">
        <p>첨부파일</p>
        <ul>
            <?php
            // 가변 파일
            for ($i=0; $i<count($view['file']); $i++) {
                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {?>
            <li>
                <i class="fa fa-download" aria-hidden="true"></i>
                <a href="<?php echo $view['file'][$i]['href']; ?>" class="view_file_download">
                    <?php echo $view['file'][$i]['source'] ?>
                </a>
                <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
            </li>
            <?php
                }
            }?>
        </ul>
    </div>
    <?php } ?>
    
    <?php //include_once(G5_BBS_PATH.'/view_comment.php'); // 코멘트 입출력 ?>

	<?php if ($prev_href || $next_href) { ?>
    <ul class="v_page">
        <?php if ($prev_href) { ?><li><span><i class="fa fa-angle-up"></i></span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a></li><?php } ?>
        <?php if ($next_href) { ?><li><span><i class="fa fa-angle-down"></i></span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a></li><?php } ?>
    </ul>
    <?php } ?>

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
    
</section>

<script>
$(function() {
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
