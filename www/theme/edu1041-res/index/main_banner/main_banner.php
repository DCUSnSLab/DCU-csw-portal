<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/index/main_banner/style.css?ver='.G5_CSS_VER.'">', 0);
$sh_inc_url = G5_THEME_URL.'/index/main_banner/';
add_javascript('<script src="'.G5_THEME_URL.'/js/ScrollTrigger.min.js?ver='.G5_JS_VER.'"></script>', 1); 
add_javascript('<script src="'.G5_THEME_URL.'/js/gsap.min.js?ver='.G5_JS_VER.'"></script>', 2); 
?>

<div id="mainVisual">
    <div class="main_view">
        <ul>
            <li>
                <!--
                <video autoplay muted loop>
                    <source src="<?= $sh_inc_url ?>/img/main_vid.mp4" trpe="video/mp4">
                    브라우저가 비디오를 지원하지 않습니다.
                </video>     
                -->
                <img src="<?= $sh_inc_url ?>/img/main_banner.png" alt="background-image">
            </li>
        </ul>
    </div>
    <div class="abs_txt">
        <div class="main_tit" data-aos="fade-up">
            <h1>컴퓨터소프트웨어학부</h1>
            <p>School of Computer Software</p>
            <div class="arrow"><i data-feather="chevron-down"></i></div>
        </div>

        <div class="sec_page" data-aos="fade-up">
            <h2>소프트웨어가 세상을 움직인다.</h2>
            <div class="count">
                <dl>
                    <dt>설립연도</dt>
                    <dd><span class="num" data-count="1996">1996</span>년</dd>
                </dl>
                <dl>
                    <dt>학생 수</dt>
                    <dd><span class="num" data-count="949">949</span>명</dd>
                </dl>
                <dl>
                    <dt>교원 수</dt>
                    <dd><span class="num" data-count="22">22</span>명</dd>
                </dl>
            </div>

            <div class="link_box">
                <div class="quick">
                    <p>Quick Menu</p>
                    <ul>
                        <li>
                            <a href="">증명발급 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                        <li>
                            <a href="">학생증발급 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                        <li>
                            <a href="">편의서비스 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                        <li>
                            <a href="">캠퍼스 투어 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                        <li>
                            <a href="">새내기 가이드 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                        <li>
                            <a href="">편입학 <span class="material-symbols-outlined">trending_flat</span></a>
                        </li>
                    </ul>
                </div>
                <div class="collge">
                    <ul>
                        <li>
                            <a href="">
                                <img src="<?= $sh_inc_url ?>/img/collge_icon01.png" alt="수시모집">
                                <p>수시모집</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?= $sh_inc_url ?>/img/collge_icon02.png" alt="정시모집">
                                <p>정시모집</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?= $sh_inc_url ?>/img/collge_icon03.png" alt="대학원모집">
                                <p>대학원모집</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
// 카운트
$(document).ready(function() {
    function animateCounts() {
        $('.count .num').each(function() {
            var $this = $(this),
                countTo = parseInt($this.attr('data-count').replace(/,/g, '')); // data-count 값을 숫자로 변환
            $({ countNum: 0 }).animate({
                countNum: countTo
            },
            {
                duration: 1500,
                easing: 'linear',
                step: function(now) {
                    // now는 현재 애니메이션 중의 숫자 값
                    $this.text(Math.floor(now).toLocaleString()); // 콤마 추가
                },
                complete: function() {
                    // 애니메이션이 끝나면 최종 값 설정 (콤마 포함)
                    $this.text(countTo.toLocaleString());
                }
            });
        });
    }

    function checkIfInView() {
        var $count = $('.count');
        var windowHeight = $(window).height();
        var scrollTop = $(window).scrollTop();
        var elementOffset = $count.offset().top;
        var distance = elementOffset - scrollTop;

        // 요소가 뷰포트 내에 있는지 확인
        if (distance <= windowHeight && distance >= 0) {
            // 요소가 뷰포트에 들어오면 애니메이션 실행
            animateCounts();
            // 애니메이션이 시작된 후 스크롤 이벤트 바인딩 해제
            $(window).off('scroll', checkIfInView);
        }
    }

    // 스크롤 이벤트로 checkIfInView 실행
    $(window).on('scroll', checkIfInView);
    // 페이지 로드 시 이미 뷰포트 내에 있는지 확인
    checkIfInView();
});

gsap.registerPlugin(ScrollTrigger);

gsap.to(".main_view", {
    ease: "none",
    scrollTrigger: {
      trigger: ".main_view",
      start: "top top",
      end: "+=800",
      scrub: .7,
      pin: true,
      onUpdate: self => {
    document.querySelector("#mainVisual")
    .classList.toggle("on", self.progress >= 0.5);
    }
    }
  });
</script>