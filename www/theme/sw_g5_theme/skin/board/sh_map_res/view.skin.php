<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
if(!$view['sh_map_type']){$view['sh_map_type'] = 'Naver';}
$sh_company = urlencode($view['sh_company']);?>

<div id="sh_map_v">

    <div class="tit_area">
        <span>ADDRESS</span>
        <p><?php echo $view['wr_subject'] ?></p>
    </div>

    <div id="sh_iframe_wrap">
        <iframe id="sh_iframe" frameborder='0' border='0' marginwidth='0' marginheight='0' scrolling='no' title="<?= $view['sh_company'] ?> 오시는길"></iframe>
    </div>

    <?php if($view['wr_content'] != ' ' and $view['wr_content'] != '&nbsp;'){?>
    <div id="bo_v_con" class="bo_cont"><?php echo get_view_thumbnail($view['wr_content']); ?></div>
    <?php }?>

    <?php /* 필요시 주석풀고 사용하세요. 
    <dl class="info">
    	<dt><img src="<?= $board_skin_url ?>/img/icon01.png" alt="버스" /></dt>
        <dd>
        	<p>버스</p>
            <span>신성성결교회 하차 시 (25M)</span>
            11번, 20번, 34번, 37번, 46번, 531번, 1601번, 790번
            <span>모래내시장역(2번출구) 하차 시 (140M)</span>
            8번, 8A번, 46번, 9100번
            <span>올림픽생활기념관 하차 시 (150M)</span>
            20번, 34번, 37번, 1601번            
        </dd>
    </dl>
    <dl class="info">
    	<dt><img src="<?= $board_skin_url ?>/img/icon02.png" alt="지하철" /></dt>
        <dd>
        	<p>지하철</p>
            부천시청역 2번 출구에서 도보 3분
        </dd>
    </dl>    
    */ ?>
    <?php if($view['sh_cs']){?>
    <dl class="info">
    	<dt><img src="<?= $board_skin_url ?>/img/icon03.png" alt="고객센터" /></dt>
        <dd>
        	<p>고객센터</p>
            <div><?= nl2br($view['sh_cs']) ?></div>
        </dd>
    </dl>    
    <?php }?>
    
    <?php if ($update_href) { ?>
    <div class="btn_area">
        <ul class="left">
            <li><a href="<?php echo $update_href ?>" class="btn_normal">수정</a></li>
        </ul>
    </div>
    <?php } ?>
</div>


<script>
//기본 공통 자료.
var sh_map_name = '<?php echo $view['sh_map_type']?>';
var sh_width = $("#sh_iframe").width();
var sh_height =  (sh_width * 0.5) * 1.1;
$('#sh_iframe').css("width",sh_width+'px');
$('#sh_iframe').css("height",sh_height+'px');

var sh_subj = '<?php echo $sh_company?>'; //업체명
var sh_x = '<?php echo $view['sh_latitude']?>';    //x좌표
var sh_y = '<?php echo $view['sh_longitude']?>';    //y좌표
var sh_zoom = '<?php echo $view['sh_map_level']?>';	//지도 확대 정도

if(sh_map_name == 'Naver'){
	//끌어오는 API원본 경로
	var exist_map_url = '<?= $board_skin_url ?>/naver.php'; 
	//전달하는 추가 URL정보
	var exist_map_add_url = 'sh_x='+sh_x+'&sh_y='+sh_y+'&sh_name='+sh_subj+'&sh_set=utf8&sh_height='+sh_height+'&sh_width='+sh_width+"&sh_zoom="+sh_zoom;
}

if(sh_map_name == 'Daum'){
	//끌어오는 API원본 경로
	var exist_map_url = '<?= $board_skin_url ?>/daum.php'; 
	//전달하는 추가 URL정보
	var exist_map_add_url = "sh_name="+sh_subj+"&lat="+sh_x+"&lng="+sh_y+"&sh_height="+sh_height+"&sh_width="+sh_width+"&sh_zoom="+sh_zoom;
}

if(sh_map_name == 'Google'){
	//영문버전 or 한글버전
	var sh_language = '<?php echo $view['sh_google_eng']?>';
	//끌어오는 API원본 경로
	var exist_map_url = '<?= $board_skin_url ?>/google.php'; 
	//전달하는 추가 URL정보
	var exist_map_add_url = "sh_name="+sh_subj+"&lat="+sh_x+"&lng="+sh_y+"&sh_zoom="+sh_zoom+"&sh_language="+sh_language;
}
//iframe에 src값 전달.
document.getElementById("sh_iframe").src = exist_map_url+"?"+exist_map_add_url;

</script>