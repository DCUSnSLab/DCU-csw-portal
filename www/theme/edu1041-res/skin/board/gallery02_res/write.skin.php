<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
if($board['bo_2'] == '1'){
    echo G5_POSTCODE_JS;
}
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
$ex_sh_caption=explode("!@!",$write['sh_caption']);//설명
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
        <?php if($board['bo_4'] == '1' and $w == 'r'){?>
        <input type="hidden" name="sh_rank" value="<?php echo $write['sh_rank'] ?>">
        <?php } ?>
        <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option = '';
            if ($is_notice) {
                $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
            }

            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">HTML</label>';
                }
            }

            if ($is_secret) {
                if ($is_admin || $is_secret==1) {
                    $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
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
                    <?php if ($is_name) { ?>
                    <tr>
                        <th><label for="wr_name">이름</label></th>
                        <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="sh_input required" placeholder="이름"></td>
                    </tr>
                    <?php } ?>
                    <?php if ($is_password) { ?>
                    <tr>
                        <th>비밀번호</th>
                        <td>
                            <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
                            <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="sh_input <?php echo $password_required ?>">
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($board['bo_1'] == '1'){?>    
                    <tr>
                        <th><label for="sh_phone">연락처</label></th>
                        <td><input type="text" class="sh_input" name="sh_phone" id="sh_phone" maxlength="12" value="<?php echo $write['sh_phone']?>" onkeyup='Num_ck(this);'></td>
                    </tr>
                    <?php }?>
                
                    <?php if($board['bo_2'] == '1'){?>
                    <tr>
                        <th>주 소</th>
                        <td>
                            <label for="sh_zip" class="sound_only">우편번호</label>
                            <input type="text" name="sh_zip" value="<?php echo $write['sh_zip']; ?>" id="sh_zip" class="sh_input read" size="5" maxlength="6" readonly>
                            <button type="button" class="zip_btn" onclick="win_zip('fwrite', 'sh_zip', 'sh_addr1', 'sh_addr2', 'sh_addr3', 'sh_addr_jibeon');">주소 검색</button><br />
                            <label for="sh_addr1" class="sound_only">기본주소</label>
                            <input type="text" name="sh_addr1" value="<?php echo $write['sh_addr1'] ?>" id="sh_addr1" class="sh_input read frm_address" placeholder="주소를 검색해주세요." size="40%" readonly><br />
                            <label for="reg_mb_addr2" class="sound_only">상세주소</label>
                            <input type="text" name="sh_addr2" value="<?php echo $write['sh_addr2'] ?>" id="reg_mb_addr2" class="sh_input frm_address" placeholder="상세주소" size="40%" ><br />
                            <label for="reg_mb_addr3" class="sound_only">참고항목</label>
                            <input type="text" name="sh_addr3" value="<?php echo $write['sh_addr3'] ?>" id="reg_mb_addr3" class="sh_input frm_address read" placeholder="참고항목" readonly size="40%" >
                            <input type="hidden" name="sh_addr_jibeon" value="<?php echo $member['sh_addr_jibeon']; ?>">
                        </td>
                    </tr>
                    <?php }?>

                    <?php if($board['bo_3'] == '1'){?>
                    <tr>
                        <th><label for="wr_email">이메일</label></th>
                        <td><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="sh_input email" size="50" maxlength="100"></td>
                    </tr>
                    <?php } ?>
                    
                    <?php if($board['bo_4'] == '1' and $is_admin){?>
                    <tr>
                        <th><label for="sh_rank">출력순서</label></th>
                        <td><input type="text" name="sh_rank" value="<?php echo $write['sh_rank'] ?>" id="sh_rank" class="sh_input" onkeyup='Num_ck(this);'><span class="ps">※ 높은 숫자일수록 상위에 노출됩니다.</span></td>
                    </tr>
                    <?php } ?>
                    <?php if ($option) { ?>
                    <tr>
                        <th>옵션</th>
                        <td>
                        <div class="write_div">
                            <span class="sound_only">옵션</span>
                            <?php echo $option ?>
                            <?php if($is_admin){?><span class="ps">※ 공지 체크시 게시판 최상단에 고정됩니다.</span><?php }?>
                        </div> 
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th>옵션 예시 : 장소</th>
                        <td>설명 예시 : 부천시청</td>
                    </tr>
                    <?php
                        $i2='0';
                        for($i=0;$i<6;$i++){//for문 i값($i<6) 수정하면 칸 수 조절 가능합니다. write 수정시 view, list도 수정해주세요 (최대 10)
                        ?>
                        <tr>
                            <th><p class="th_option"><input type="text" name="ex_sh_caption[<?php echo $i?>]" value="<?php echo $ex_sh_caption[$i]?>" class="sh_input" placeholder="옵션<?php echo $i2+1?>"/></p></th>
                            <td>
                                <input name="ex_sh_caption[<?php echo $i+1?>]" value="<?php echo $ex_sh_caption[$i+1]?>"  class="sh_input" placeholder="설명<?php echo $i2+1?>" rows="3" size="50" >
                                
                            </td>     
                        </tr>
                    <?php $i++; $i2++;}?>
                    <tr>
                        <th><label for="wr_subject">제목<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="sh_input full_input required" maxlength="255"></td>
                    </tr>
                    <tr>
                        <th><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
                        <td class="wr_content"><?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?></td>
                    </tr>
                    <?php if($board['bo_5'] == '1'){?>
                    <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
                    <tr>
                        <th><label for="wr_link<?php echo $i ?>">링크  #<?php echo $i ?></label></th>
                        <td><input type="text" name="wr_link<?php echo $i ?>" value="<?php echo $write['wr_link'.$i]; ?>" id="wr_link<?php echo $i ?>" class="sh_input full_input"></td>
                    </tr>
                    <?php }}?>
                    <tr>
                        <th scope="row">리스트 출력이미지</th>
                        <td>
                        <input type="file" name="bf_file[0]" class="frm_file sh_input">
                            <?php if ($is_file_content) { ?>
                            <input type="text" name="bf_content[0]" value="<?php echo ($w == 'u') ? $file[0]['bf_content'] : ''; ?>" class="frm_file sh_input" size="50">
                            <?php } ?>
                            <?php if($w == 'u' && $file[0]['file']) { ?>
                            <input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="1"> <label for="bf_file_del0"><?php echo $file[0]['source'].'('.$file[0]['size'].')';  ?> 파일 삭제</label>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php for ($i=1; $is_file && $i<$file_count; $i++) { ?>
                    <tr>
                        <th scope="row">파일 #<?php echo $i ?></th>
                        <td>
                            <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file sh_input">
                            <?php if ($is_file_content) { ?>
                            <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file sh_input" size="50">
                            <?php } ?>
                            <?php if($w == 'u' && $file[$i]['file']) { ?>
                            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }?>
                    <?php if ($is_guest) { //자동등록방지  ?>
                    <tr>
                        <th>자동등록방지</th>
                        <td>
                            <?php echo $captcha_html ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($is_guest and ($board['bo_1'] == '1' or $board['bo_2'] == '1' or $board['bo_3'] == '1')){?>
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
            <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_type01 comp_btn">
            <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="cancel_btn">취소</a>
        </div>
    </form>
</section>

<script>
function Num_ck(obj) { 
    var val = obj.value; 
    if(isNaN(val)) { 
        alert("숫자만 입력해 주세요"); 
        obj.value = val.replace(/[^0-9]/gi, ''); 
    }  
}

function fwrite_submit(f){
    <?php if($is_guest and ($board['bo_1'] == '1' or $board['bo_2'] == '1' or $board['bo_3'] == '1')){?>
    
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