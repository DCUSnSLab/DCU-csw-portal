<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/hd/top_menu/style.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_THEME_URL.'/hd/top_menu/script.js?ver='.G5_JS_VER.'"></script>', 0); 
?>

<nav id="shGnb">	
    
	<!-- 로고 -->
	<div class="sh_logo">
		<a href="/"><img src="<?php echo G5_THEME_URL; ?>/hd/top_menu/logo.png" alt="<?php echo $config['cf_title'] ?>" /></a>
	</div>

	<!-- 상단메뉴 -->
    <ul class="sh_nav">
		<?php
		$result_len2 = sql_query($sql_len2); 
		for ($i_len2=1; $row_len2=sql_fetch_array($result_len2); $i_len2++) { // 대분류
		if(!$row_len2['ca_link']){ //대분류 링크 없으면 소분류 첫번째로 ㄱㄱ
			$row_2 = sql_fetch(" select * from sh_category where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row_len2['ca_id']}' order by ca_id asc ");
			$row_len2['ca_link'] = $row_2['ca_link'];
		} ?>
		<li>
			<a href="<?php echo $row_len2['ca_link']?>"<?= $row_len2['ca_link_target']=='_blank' ? ' target="_blank"' :'' ?>><?php echo $row_len2['ca_name']?></a>
			<ul class="sh_lnb_s">
				<?php // 소분류 시작
				$sql_len4 = " select * {$sql_common_len} {$sql_search_len} and LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row_len2['ca_id']}' {$sql_order_len} ";
				$result_len4 = sql_query($sql_len4);
				for ($i_len4=0; $row_len4=sql_fetch_array($result_len4); $i_len4++) {?>
				<li><a href="<?php echo $row_len4['ca_link']?>"<?= $row_len4['ca_link_target']=='_blank' ? ' target="_blank"' :'' ?>><?php echo $row_len4['ca_name']?></a></li>
				<?php } // 소분류 끝?>
			</ul>
		</li>
		<?php } // 대분류?>
    </ul>
    
	<ul class="sh_tip">
        <?php if($member['mb_level']=='10'){?><li><a href="/admin" class="admli">관리자</a></li><?php }?>
        <?php if(!$member['mb_id']){?>	
        <li><a href="/bbs/login.php">로그인</a></li>
        <li><a href="/bbs/register.php">회원가입</a></li>
        <?php }else{?>
        <li><a href="/bbs/member_confirm.php?url=register_form.php">정보수정</a></li>
        <li><a href="/bbs/logout.php">로그아웃</a></li>
        <?php }?>
    </ul>

</nav>

<!-- 반응형메뉴 [s] -->
<div id="topmenuM">
	<div id="m_logo"><a href="/"><img src="<?php echo G5_THEME_URL; ?>/hd/top_menu/logo.png" alt="<?php echo $config['cf_title'] ?>" /></a></div>
    <!-- 메뉴 버튼 -->
    <div id="m_navBtn"><span></span></div>
    <!-- 오픈 메뉴 -->
    <div id="navWrap">
        <div class="inner">
 			<!-- 회원가입 사용시 주석 해제 -->       
        	<?php ?><ul class="user_tip">
				<?php if(!$member['mb_id']){?>	
                <li><a href="/bbs/register.php" class="small_tip">회원가입</a></li>
                <li><a href="/bbs/login.php" class="small_tip">로그인</a></li>
                <?php }else{?>
                <li><a href="/bbs/member_confirm.php?url=register_form.php" class="small_tip">정보수정</a></li>
                <li><a href="/bbs/logout.php" class="small_tip">로그아웃</a></li>
                <?php }?>
            </ul><?php ?>
            <ul class="m_lnb">
				<?php
                $result_len2 = sql_query($sql_len2); 
                for ($i_len2=1; $row_len2=sql_fetch_array($result_len2); $i_len2++) {// 대분류
                if(!$row_len2['ca_link']){//대분류 링크 없으면 소분류 첫번째로 ㄱㄱ
                    $row_2 = sql_fetch(" select * from sh_category where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row_len2['ca_id']}' order by ca_id asc ");
                    $row_len2['ca_link'] = $row_2['ca_link'];
                }
				?>
                <li>
                    <button class="m_bmenu" type="button"><?php echo $row_len2['ca_name'] ?></button>
                    <ul class="m_smenu">
                        <?php // 소분류 시작
                        $sql_len4 = " select * {$sql_common_len} {$sql_search_len} and LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row_len2['ca_id']}' {$sql_order_len} ";
                        $result_len4 = sql_query($sql_len4);
                        for ($i_len4=0; $row_len4=sql_fetch_array($result_len4); $i_len4++) {?>
						<li><a href="<?php echo $row_len4['ca_link']?>"<?= $row_len4['ca_link_target']=='_blank' ? ' target="_blank"' :'' ?>><?php echo $row_len4['ca_name']?></a> </li>
						<?php }//sub menu for End?>
                    </ul>
                </li>
				<?php }//main menu for End?>
            </ul>   
            <p class="mo_hd_copy">ⓒ <?php echo $config['cf_title'] ?></p>         
        </div>
    </div>
</div>
<!-- 반응형메뉴 [e] -->