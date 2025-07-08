<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
if(!$is_admin){
    alert('관리자만 작성가능합니다.');
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
        <input type="hidden" name="wr_subject" value=".">
        <?php if($board['bo_6'] == '1' and $w == 'r'){?>
        <input type="hidden" name="sh_rank" value="<?php echo $write['sh_rank'] ?>">
        <?php } ?>
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
                    
                    <?php if($board['bo_6'] == '1' and $is_admin){?>
                    <tr>
                        <th><label for="sh_rank">출력순서</label></th>
                        <td><input type="text" name="sh_rank" value="<?php echo $write['sh_rank'] ?>" id="sh_rank" class="sh_input" oninput='Num_ck(this);'><span class="ps">※ 높은 숫자일수록 상위에 노출됩니다.</span></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th><label for="wr_name">강사명</label></th>
                        <td><input type="text" name="wr_name" value="<?php echo $write['wr_name'] ?>" id="wr_name" required class="sh_input required"></td>
                    </tr>
                    <tr>
                        <th><label for="wr_email">이메일</label></th>
                        <td><input type="text" name="wr_email" value="<?php echo $write['wr_email'] ?>" id="wr_email" class="sh_input email" maxlength="100"></td>
                    </tr>
                    <tr>
                        <th><label for="sh_phone">연락처</label></th>
                        <td><input type="text" class="sh_input" name="sh_phone" id="sh_phone" maxlength="12" value="<?php echo $write['sh_phone']?>" oninput='Num_ck(this);'></td>
                    </tr>
                    <tr>
                        <th><label for="sh_class">담당과목</label></th>
                        <td><input type="text" class="sh_input" name="sh_class" id="sh_class" value="<?php echo $write['sh_class']?>"></td>
                    </tr>
                    <tr>
                        <th><label for="sh_schoolcareer">학력</label></th>
                        <td><textarea name="sh_schoolcareer" class="sh_input" id="sh_schoolcareer"><?php echo $write['sh_schoolcareer']?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="sh_career">경력</label></th>
                        <td><textarea name="sh_career" class="sh_input" id="sh_career"><?php echo $write['sh_career']?></textarea></td>
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
                </tbody>
            </table>
        </div>    

        <div class="btn_area">
            <input type="submit" value="작성완료" id="btn_submit" class="btn_type01 comp_btn">
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
    <?php echo get_editor_js('wr_content');?>
    if(!f.wr_content.value){
        f.wr_content.value = '&nbsp;';
    }
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