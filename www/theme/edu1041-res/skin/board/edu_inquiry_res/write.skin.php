<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
$class_list = sql_query(" select wr_subject, wr_id from {$g5['write_prefix']}{$board['bo_1']} where wr_is_comment = 0  and sh_restartday <= '".G5_TIME_YMD."' and sh_reendday >= '".G5_TIME_YMD."' order by sh_restartday asc ");
if($class && !$w){
    $sh_class = $class;
    $class_row = sql_fetch(" select sh_restartday, sh_reendday, wr_id from {$g5['write_prefix']}{$board['bo_1']} where wr_id = '$sh_class' ");
    if(!$class_row['wr_id']){
        alert('잘못된 접근입니다.');
    }else if($class_row['sh_reendday']<G5_TIME_YMD){
        alert('해당 교육과정은 신청기간이 마감되었습니다.\n다른 교육과정을 선택해주세요');
    }else if($class_row['sh_restartday']>G5_TIME_YMD){
        alert('해당 교육과정은 신청기간이 아닙니다.\n다른 교육과정을 선택해주세요');
    }
}else{
    $sh_class = $write['sh_class'];
}
?>

<section id="sh_bo_w">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="secret" value="secret">
        <input type="hidden" name="wr_subject" value=".">
        <input type="hidden" name="c_change" value="">
        <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option = '';
            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">HTML</label>';
                }
            }

            if ($is_mail) {
                $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
            }
        }

        echo $option_hidden;
        ?>
        <div id="sh_write_tbl" class="sh_tbl_common">
            <table cellpadding="0" cellspacing="0" summary="<?php echo $board['bo_subject'] ?> 글쓰기">
                <caption class="sound_only"><?php echo $board['bo_subject'] ?> 글쓰기</caption>
                <tbody>
                    <tr>
                        <th><label for="sh_class">교육과정</label></th>
                        <td>
                            <div class="cate_wrap">
                            <select name="sh_class" id="sh_class" class="sh_select" required <?php if($w){?>onchange="class_change()"<?php }?>>
                                <option value="">분류를 선택하세요</option>
                                <?php for ($i=0; $row=sql_fetch_array($class_list); $i++) {?>
                                    <option value="<?= $row['wr_id'];?>" <?=get_selected($sh_class,$row['wr_id']);?>><?= $row['wr_subject'];?></option>
                                <?php }?>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <?php if ($is_category) { ?>
                    <tr>
                        <th><label for="ca_name">분류</label></th>
                        <td>
                            <div class="cate_wrap">
                            <select name="ca_name" id="ca_name" class="sh_select" required>
                                <option value="">분류를 선택하세요</option>
                                <?php $category_option = str_replace('<option value="공지">공지</option>','',$category_option);
                                echo $category_option ?>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th><label for="wr_name">이름</label></th>
                        <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="sh_input required" placeholder="이름"></td>
                    </tr>
                    <?php if ($is_password) { ?>
                    <tr>
                        <th>비밀번호</th>
                        <td>
                            <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
                            <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="sh_input <?php echo $password_required ?>">
                        </td>
                    </tr>
                    <?php } ?> 
                    <tr>
                        <th><label for="sh_phone">연락처</label></th>
                        <td><input type="text" class="sh_input" name="sh_phone" id="sh_phone" maxlength="12" value="<?php echo $write['sh_phone']?>" oninput='Num_ck(this);'></td>
                    </tr>
                    <tr>
                        <th><label for="wr_content">문의 내용<strong class="sound_only">필수</strong></label></th>
                        <td class="wr_content"><?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?></td>
                    </tr>
                    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
                    <tr>
                        <th>파일 #<?php echo $i+1 ?></th>
                        <td>
                            <label for="sh_file<?php echo $i+1 ?>" class="sound_only">파일 #<?php echo $i+1 ?></label>
                            <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file sh_input" id="sh_file<?php echo $i+1 ?>">
                            <?php if($w == 'u' && $file[$i]['file']) { ?>
                            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if ($is_guest) { //자동등록방지  ?>
                    <tr>
                        <th>자동등록방지</th>
                        <td>
                            <?php echo $captcha_html ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="privacy" class="sound_only">개인정보취급방침</label>
                            <textarea readonly class="sh_input txtarea privacy" id="privacy"><?php echo get_text($config['cf_privacy']) ?></textarea>
                            <div class="agr_area">
                                <p><span class="ps">(필수)</span> 개인정보취급방침 내용에 동의합니다. </p>
                                <input type=radio value=1 name="agreess" id="agree" <?php if($w=='u'){echo "checked";}?>>&nbsp;<label for="agree">동의함</label>
                                <input type=radio value=1 name="agreess" id="no_agree">&nbsp;<label for="no_agree">동의안함</label>
                            </div>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>    

        <div class="btn_area">
            <input type="submit" value="작성완료" id="btn_submit" class="btn_type01 comp_btn">
            <?php if($is_admin){?>
            <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="cancel_btn">목록</a>
            <?php }?>
        </div>
    </form>
</section>

<script>
<?php if($w){?>
function class_change() {
    var sh_class = "<?= $write['sh_class']?>";
    var c_change = $('input[name=c_change]').val();
    var sh_class_change = $('select[name=sh_class]').val();
    if(!c_change){
        if(!confirm('기존에 신청 하셨던 교육과정이 모집마감이 된상태라면 재신청이 어려울수 있습니다.\n교육과정을 정말 변경하시겠습니까?')){
            $("#sh_class").val(sh_class).prop("selected", true);
            return false
        }else{
            $('input[name=c_change]').val('change');
        }
    }else{
        if(sh_class_change==sh_class){
            $('input[name=c_change]').val('');
        }
    }
}
<?php } ?>
function Num_ck(obj) { 
    var val = obj.value; 
    if(isNaN(val)) { 
        alert("숫자만 입력해 주세요"); 
        obj.value = val.replace(/[^0-9]/gi, ''); 
    }  
}

function fwrite_submit(f){
    <?php if($is_guest){?>
    if (!$("#agree").is(":checked")) {
        alert("개인정보취급방침의 내용에 동의하셔야 작성가능 합니다.");
        return false;
    }
    <?php }?>
    
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    return true;
}
</script>