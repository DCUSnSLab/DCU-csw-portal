<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
$field_chk = sql_fetch(" SELECT 1 FROM Information_schema.columns WHERE table_schema = '".G5_MYSQL_DB."' AND table_name = '{$g5['write_prefix']}{$board['bo_1']}' AND column_name = 'sh_class' ");

if(!$field_chk){
    sql_query(" ALTER TABLE `{$g5['write_prefix']}{$board['bo_1']}` ADD `sh_class` int(11) NOT NULL DEFAULT '0' AFTER `wr_10` ",true);
}
?>

<div id="view_form">
	<div class="inner">
    	<div class="tit">수강료조회</div>
        <form method="post" action="<?= $board_skin_url ?>/view_form_update.php" autocomplete="off" onsubmit="return view_submit();">
            <input type="hidden" name="form_url" value="<?php echo $_SERVER['REQUEST_URI']?>" />
            <input type="hidden" name="sh_class" value="<?= $view['wr_id'] ?>" />
            <input type="hidden" name="class_table" value="<?= $bo_table ?>" />
            <input type="hidden" name="inquiry_table" value="<?= $board['bo_1'] ?>" />
            <div class="flex">
                <ul class="form">
                    <li>
                        <label for="vf_name">이름</label>
                        <input name="wr_name" type="text" id="vf_name" class="sh_input" placeholder="이름" required>
                    </li>
                    <li>
                        <label for="sh_phone">연락처</label>
                        <input name="sh_phone" type="text" id="sh_phone" class="sh_input" placeholder="연락처" required oninput='Num_ck(this);' maxlength="12">
                    </li>
                    <li class="full">
                        <label for="vf_content">문의사항</label>
                        <textarea name="wr_content" id="vf_content" placeholder="문의사항"></textarea>
                    </li>
                </ul>
                <div class="agree_area">
                    <p><input type="checkbox" id="ckall" class="all_ck" onclick="checkAll();"><label for="ckall">모두 동의합니다</label></p>
                    <ul>
                        <li>
                            <input type="checkbox" class="vf_ck" id="vf_agree"><label for="vf_agree">이용약관 동의</label>
                            <button type="button" onclick="window.open('<?= $board_skin_url ?>/sh_stipulation.php', 'stipulation', 'width=600; height=800; left=150; top=0; scrollbars=no');" >약관보기</button>
                        </li>
                        <li>
                            <input type="checkbox" class="vf_ck" id="vf_agree2"><label for="vf_agree2">개인정보 취급방침 동의</label>
                            <button type="button" onclick="window.open('<?= $board_skin_url ?>/sh_privacy.php', 'privacy', 'width=600; height=800; left=150; top=0; scrollbars=no');" >약관보기</button>
                        </li>
                    </ul>
	                <button type="submit" class="sbm_btn">문의하기</button>    
                </div>      
            </div>
        </form>
    </div>
</div>

<script>
function Num_ck(obj) { 
	var val = obj.value; 
	if(isNaN(val)) { 
		alert("숫자만 입력해 주세요"); 
		obj.value = val.replace(/[^0-9]/gi, ''); 
	}  
}
function checkAll(){
    if($("#ckall").is(':checked')){
        $("input.vf_ck").prop("checked",true);
    }else{
        $("input.vf_ck").prop("checked",false);
    }
}
function view_submit(){
	if($("#vf_agree").is(":checked") != true){
		alert("이용약관에 동의 해주세요.");
		$("#vf_agree").focus();
		return false;
	}
	if($("#vf_agree2").is(":checked") != true){
		alert("개인정보취급방침에 동의 해주세요.");
		$("#vf_agree2").focus();
		return false;
	}
}
</script>