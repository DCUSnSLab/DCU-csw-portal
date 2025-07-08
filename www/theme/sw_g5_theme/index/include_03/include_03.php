<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sh_inc_url = G5_THEME_URL.'/index/include_03';
add_stylesheet('<link rel="stylesheet" href="'.$sh_inc_url.'/style.css?ver='.G5_CSS_VER.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/skin/board/sh_video_gallery_res/sh_style.css?ver='.G5_CSS_VER.'">', 0);
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
?>

<article id="atc03" data-aos="fade-up">
    <div class="inner">
        <div class="l_cont">
            <div class="top_cont" >
                <div class="atc_tit">
                    <h2><b>DCU</b> NOTICE</h2>
                    <!--<span>한눈에 보는 주요 소식 </span>-->
                </div>
                <ul class="type">
                    <li class="tab-link on" data-tab="tab1">학부 공지사항</li>
                    <li class="tab-link" data-tab="tab2">대학원 공지사항</li>
                    <li class="tab-link" data-tab="tab3">진로/채용정보</li>
                </ul>
            </div>
            <div class="cont">
                <div class="tabs">
                    <div id="tab1" class="tab-content on">
                        <div class="info">
                            <?=latest("theme/notice_lastest","ugd_announcements", 5, 100);?>
                        </div>
                    </div>
                    <div id="tab2" class="tab-content">
                        <div class="info">
                            <?=latest("theme/notice_lastest","gd_announcements", 5, 100);?>
                        </div>
                    </div>
                    <div id="tab3" class="tab-content">
                        <div class="info">
                            <?=latest("theme/notice_lastest","cr_jobinfo", 5, 100);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="r_cont">
            <div class="lk_txt">
                주요 소식을 빠르게 확인하세요.
                <a href="/bbs/board.php?bo_table=pr_news">
                    <p>바로가기</p>
                    <span class="material-symbols-outlined">
                    trending_flat
                    </span>
                </a>
            </div>

            <ul class="video_area">
                <?php
                $vi_table='pr_gallery';
                $sql = " select * from {$g5['write_prefix']}{$vi_table} where wr_is_comment = 0 order by wr_num limit 0, 1 ";
                $result = sql_query($sql);
                for ($i=0; $row2 = sql_fetch_array($result); $i++) {
                $youtube_link = mb_substr($row2['sh_video'],-11,NULL,'utf-8');
                ?>			
                <li>
                    <button type="button" onclick="video_view(<?php echo $row2['wr_id']?>,'<?= $vi_table?>')">
                        <p class="video_txt">
                            <span class="subj"><?php echo $row2['wr_subject'] ?></span>
                            <img src="<?= $sh_inc_url ?>/img/arrow_btn.png" alt="더보기" />
                        </p>
                        <img class="youtube_img" src="https://img.youtube.com/vi/<?= $youtube_link ?>/hqdefault.jpg" alt="<?php echo $row2['wr_subject'] ?>">
                    </button>
                </li>
                <?php }?>
                <?php if ($i == 0) { //게시물이 없을 때  ?>
                    <li class="empty">게시물이 없습니다.</li>
                <?php }  ?>                     
            </ul>            
        </div>
    </div>
</article>

<script>
 $(document).ready(function() {

      // 탭 클릭 이벤트 핸들러
      $(".tab-link").on("click", function() {
        var tabId = $(this).attr("data-tab");

        // 활성 탭 스타일 변경
        $(".tab-link").removeClass("on");
        $(this).addClass("on");

        // 활성 탭 콘텐츠 표시
        $(".tab-content").removeClass("on");
        $("#" + tabId).addClass("on");
      });
      
    });

    function video_view(id, table) {
        $.ajax({
            url: g5_theme_url+"/skin/board/sh_video_gallery_res/view.ajax.php",
            type: "POST",
            data: {
                id: id,
                table: table
            },
            dataType: "html",
            success: function (data) {
                $("#video_view").remove();
                $("body").append(data);
            }
        });
    }
</script>