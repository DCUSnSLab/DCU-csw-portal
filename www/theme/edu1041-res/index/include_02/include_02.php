<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sh_inc_url = G5_THEME_URL.'/index/include_02';
add_stylesheet('<link rel="stylesheet" href="'.$sh_inc_url.'/style.css?ver='.G5_CSS_VER.'">', 0);
include_once(G5_PATH.'/lib/thumbnail.lib.php');
?>

<article id="atc02">
    <div class="inner">
        <div class="atc_tit" data-aos="fade-up">
            <h2>TODAY <b>SU</b></h2>
            <p>연구성과 및 대학소식</p>
        </div>

        <div class="lt_area">
            <div class="swiper inc02_slide" data-aos="fade-up">
                <ul class="swiper-wrapper">
                    <?php
                    $pf_table='테이블명';
                    $pf_width='445';
                    $sql = " select * from {$g5['write_prefix']}{$pf_table} where wr_is_comment = 0 order by wr_num limit 0, 4";
                    $result = sql_query($sql);
                    for ($i=0; $row = sql_fetch_array($result); $i++) {
                    $thumb = get_list_thumbnail($pf_table, $row['wr_id'], $pf_width, '');
                    ?>	
                    <li class="swiper-slide">
                        <a href="/bbs/board.php?bo_table=<?php echo $pf_table?>&wr_id=<?php echo $row['wr_id']?>">
                            <div class="txt">
                                <div class="tab"><?= $row['ca_name'] ?></div>
                                <div class="tit">
                                    <h4><?php echo $row['wr_subject']?></h4>
                                    <div><?php echo $row['wr_content']?></div>
                                </div>
                                <i data-feather="arrow-up-right"></i>
                            </div>
                            <div class="img <?= $thumb['src'] ? "":"none" ?>" >
                                <div style="background-image:url(<?php echo $thumb['src']?>)"></div>
                            </div>
                        </a>
                    </li>	
                    <?php }?>
                    <?php if ($i== 0) { echo '<li class="empty">게시물이 없습니다.</li>'; } ?>
                </ul>
                <div class="pager"></div>
            </div>
        </div>

</article>

<script>
    var incSwiper = new Swiper("#atc02 .inc02_slide", {
    loop: true,
    speed:1500,
    slidesPerView: "1",
    spaceBetween : 20,
    autoplay: {
        delay: 3500,
        disableOnInteraction:false,
    },
    pagination: {
        el: '#atc02 .pager',
        bulletActiveClass: 'on',
        clickable: true
    },
    breakpoints: {
        481: {
        slidesPerView: 2,
        spaceBetween: 20,
        },
        769: {
        slidesPerView: 3,
        spaceBetween: 20,
        },
        1025: {
        slidesPerView: 3,
        spaceBetween: 25,
        },
    },
    });
</script>