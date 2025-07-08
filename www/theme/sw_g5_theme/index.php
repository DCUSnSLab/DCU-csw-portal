<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
$sh_inc_path = G5_THEME_PATH.'/index';
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/swiper/swiper.min.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_JS_URL.'/swiper/swiper.min.js?ver='.G5_JS_VER.'"></script>', 0); 
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<!-- 메인 비주얼모션 -->
<?php include_once($sh_inc_path.'/main_banner/main_banner.php');?>

<!--인덱스 영역-->
<section id="sh_section">
    <?php include_once($sh_inc_path.'/include_03/include_03.php');?>
    <br><br><br>
</section>

<?php
include_once(G5_THEME_PATH.'/tail.php');