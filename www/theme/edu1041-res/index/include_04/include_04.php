<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$sh_inc_url = G5_THEME_URL.'/index/include_04';
add_stylesheet('<link rel="stylesheet" href="'.$sh_inc_url.'/style.css?ver='.G5_CSS_VER.'">', 0);
?>

<article id="atc04">
    <div class="l_cont" data-aos="fade-right">
        <div class="atc_tit">
            <h2><b>SU</b> College</h2>
            <span>창의 인재를 양성하는 학과 소개</span>
        </div>

        <div class="tabs_area">
            <ul class="tabs">
                <li class="on">인문대학</li>
                <li>사회과학대학</li>
                <li>자연과학대학</li>
                <li>공과대학</li>
                <li>의과대학 / 간호대학</li>
            </ul>
        </div>
    </div>

    <div class="cir_link">
        <a href="/">
            학과소개 <br>자세히보기
        </a>
    </div>

    <div class="tab_page" data-aos="fade-left">
        <div class="tab_cont1 tab_cont">
            <div class="clg_cont">
                <span class="e_txt">College of Humanities</span>
                <p class="k_txt">인문대학</p>
                <div class="info">
                    <p>사유의 깊이, 인간을 이해하는 힘</p>
                    <div>
                        인문대학은 인간과 세상을 깊이 이해하며, 삶의 의미와 가치를 탐구하는 공간입니다. <br>
                        다양한 사상과 지혜를 배우고, 세상을 보는 넓은 시각을 키울 수 있습니다.
                    </div>
                </div>
            </div>
        </div>    
        <div class="tab_cont2 tab_cont">
            <div class="clg_cont">
                <span class="e_txt">College of Social Sciences</span>
                <p class="k_txt">사회과학대학</p>
                <div class="info">
                    <p>세상을 읽는 눈, 사회를 움직이는 힘</p>
                    <div>
                    사회과학대학은 세상의 변화를 이해하고, 사람들의 삶을 개선할 방법을 찾는 곳입니다. <br>
                    경제, 정치, 심리 등 다양한 분야를 배워 사회에 긍정적인 영향을 미칠 수 있습니다.
                    </div>
                </div>
            </div>
        </div>    
        <div class="tab_cont3 tab_cont">
            <div class="clg_cont">
                <span class="e_txt">College of Natural Sciences</span>
                <p class="k_txt">자연과학대학</p>
                <div class="info">
                    <p>자연을 탐구하고, 원리를 밝히다</p>
                    <div>
                    자연과학대학은 세상의 기본 원리를 탐구하며, 과학적 사고를 통해 세상을 명확하게 이해하는 힘을 키웁니다. <br>
                    과학적 발견의 시작은 여러분의 손끝에 있습니다.
                    </div>
                </div>
            </div>
        </div>
        <div class="tab_cont4 tab_cont">
            <div class="clg_cont">
                <span class="e_txt">College of Engineering</span>
                <p class="k_txt">공과대학</p>
                <div class="info">
                    <p>기술로 세상을 설계하다</p>
                    <div>
                    공과대학은 기술로 세상을 변화시키는 방법을 배웁니다. <br>
                    기계, 전자, 컴퓨터 등 다양한 분야에서 실용적인 지식과 기술을 익혀, 미래를 설계하는 능력을 기를 수 있습니다.
                    </div>
                </div>
            </div>
        </div>  
        <div class="tab_cont5 tab_cont">
            <div class="clg_cont">
                <span class="e_txt">College of Medicine / College of Nursing</span>
                <p class="k_txt">의과대학 / 간호대학</p>
                <div class="info">
                    <p>생명을 위한 지식, 사람을 위한 기술</p>
                    <div>
                    의료 분야에서 사람의 생명과 건강을 지키는 기술과 인성을 배웁니다. <br>
                    전문적인 기술뿐만 아니라, 사람에 대한 깊은 이해와 배려를 배워 진정한 의료인이 될 수 있습니다.
                    </div>
                </div>
            </div>
        </div>  
    </div>

</article>

<script>
	$(function() { 
		$(".tab_page .tab_cont1").show();
		$(".tabs_area .tabs li").click(function() {
			$(".tabs_area .tabs li").removeClass("on"); 
			$(this).addClass("on");
			var num = $(this).index()+1;
			$(".tab_page .tab_cont").hide();
			$(".tab_page .tab_cont"+num).show() 
		});
	});
</script>