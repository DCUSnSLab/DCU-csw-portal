<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

add_javascript('<script src="'.G5_THEME_URL.'/js/feather.min.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_THEME_URL.'/js/aos.js?ver='.G5_JS_VER.'""></script>', 1); 
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/js/aos.css?ver='.G5_CSS_VER.'">', 0);
?>

<!-- 100% 배경이미지 때문에 사용 -->
<div id="sh_wrapper">
	<!-- 상단 시작 { -->
	<header id="sh_hd">	
		<div id="skip_to_container"><a href="#sh_container">본문 바로가기</a></div>
		<?php
		if(defined('_INDEX_')) { // index에서만 실행
		include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
		} ?>

		<div id="sh_hd_wrapper">
			<div class="sh_lnb_bg"></div>
			<?php include_once(G5_THEME_PATH.'/hd/top_menu/top_menu.php'); // 상단메뉴 ?>	
		</div>
	</header>
	<!-- } 상단 끝 -->

	<!-- 콘텐츠 시작 { -->
    <main id="sh_container">
		<div id="sh_container_wrapper">
			<?php if(!defined('_INDEX_')) { // index가 아닐때만 실행 ?>
			<?php include_once(G5_THEME_PATH.'/hd/sub_main_banner/sub_main_banner.php'); ?>
			<?php include_once(G5_THEME_PATH.'/hd/aside/aside.php'); ?>
			<div id="sh_content">
			<?php }?>