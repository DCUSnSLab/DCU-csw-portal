<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/hd/sub_main_banner/style.css?ver='.G5_CSS_VER.'">', 0);
?>

<div id="shSubBnr">
    <div class="sub_nav" >
        <p class="crumb" data-aos="fade-up" data-aos-delay="300"><a href="/"><i data-feather="home"></i></a><?php echo $gr['ca_name']?> <i data-feather="chevron-right"></i><?php echo $pa['ca_name']?></p>
        <p class="tit" data-aos="fade-up" data-aos-delay="600"><?php echo $pa['ca_name']?></p>
    </div>
    <div id="mainImg" data-aos="fade-up" style="background-image:url(<?= G5_THEME_URL ?>/hd/sub_main_banner/bg_<?php echo $gr['ca_id']?>.jpg);"></div>
</div>