<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
        <?php if(!defined('_INDEX_')) { // index가 아닐때만 실행 ?>
        </div><!-- sh_content -->
    <?php }?>   
	</div><!-- sh_container_wrapper --> 
</main><!-- sh_container -->
<!-- } 콘텐츠 끝 -->

<div id="sh_ft_btns">
    <div class="btns">
        <a class="tel" href="tel:00000000"><i class="fa fa-phone"></i>0000-0000</a>
    </div>
</div>
<a id="fix_tel" href="tel:00000000"><i class="fa fa-phone"></i></a>

<!-- 하단 시작 { -->
<footer id="sh_ft">
    <div class="inner">
        <div class="top_area">
            <a href="/" class="ft_logo"><div ><img src="<?= G5_THEME_URL ?>/hd/top_menu/logo.png" alt="<?php echo $config['cf_title'] ?>" /></div></a>
            <ul>
                <li><a onclick="window.open('/', 'window', 'width=600; height=900; left=150; top=0; scrollbars=no')">개인정보취급방침</a></li>
                <li><a href="/">대학안내</a></li>
                <li><a href="/">오시는 길</a></li>
                <li><a href="/">투어신청하기</a></li>
            </ul>
        </div>

        고객사 주소, 사업자번호, 전화번호 등 하단 정보가 들어가는 곳입니다.<br />
        
        <div class="btm_area">
            ⓒ <?php echo $config['cf_title'] ?>
            <div class="links">
                <?php if($is_admin=='super'){?>  
                <a href="<?= G5_THEME_URL ?>/menu_set/designkits_menu_set.php">MENU</a>
                <?php }?>
            </div>
        </div>
    </div>
    
</footer> 

</div>
<!-- sh_wrapper[e] -->

<script>
$(window).on("scroll",function(){
    if($(window).scrollTop() > 100) { 
        $('#fix_tel').addClass('active');}
    else{
        $('#fix_tel').removeClass('active');}
    return false;
});
feather.replace()
AOS.init();
</script>

<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->
<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");