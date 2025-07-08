<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
if(!$is_admin){
    alert('관리자만 작성가능합니다.');
}
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
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
        <?php if($board['bo_6'] == '1' and $w == 'r'){?>
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
                    <?php if($board['bo_6'] == '1'){?>
                    <tr>
                        <th><label for="sh_rank">출력순서</label></th>
                        <td><input type="text" name="sh_rank" value="<?php echo $write['sh_rank'] ?>" id="sh_rank" class="sh_input" oninput='Num_ck(this);'><span class="ps">※ 높은 숫자일수록 상위에 노출됩니다.</span></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th><label for="wr_subject">교육명<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="sh_input full_input required" maxlength="255"></td>
                    </tr>
                    <tr>
                        <th><label for="sh_class">교육과목</label></th>
                        <td><input type="text" name="sh_class" value="<?php echo $write['sh_class'] ?>" id="sh_class" required class="sh_input full_input required"></td>
                    </tr>
                    <tr>
                        <th>교육생 모집 기간</th>
                        <td>
                            <input type="text" name="sh_restartday" value="<?php echo $write['sh_restartday'] ?>" id="sh_restartday" class="sh_input" placeholder="0000-00-00" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="sh_date_input(this);" title="교육생 모집 시작일">
                            ~
                            <input type="text" name="sh_reendday" value="<?php echo $write['sh_reendday'] ?>" id="sh_reendday" class="sh_input" placeholder="0000-00-00" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="sh_date_input(this);" title="교육생 모집 마지막일">
                        </td>
                    </tr>
                    <tr>
                        <th>교육기간</th>
                        <td>
                            <input type="text" name="sh_startday" value="<?php echo $write['sh_startday'] ?>" id="sh_startday" required class="sh_input required" placeholder="0000-00-00" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="sh_date_input(this);" title="교육기간 시작일">
                            ~
                            <input type="text" name="sh_endday" value="<?php echo $write['sh_endday'] ?>" id="sh_endday" required class="sh_input required" placeholder="0000-00-00" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="sh_date_input(this);" title="교육기간 마지막일">
                        </td>
                    </tr>
                    <tr>
                        <th>교육시간</th>
                        <td>
                            <input type="text" name="sh_starttime" value="<?php echo $write['sh_starttime'] ?>" required id="sh_starttime" class="sh_input required" placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}" oninput="sh_time_input(this);" title="교육시간 시작">
                            ~
                            <input type="text" name="sh_endtime" value="<?php echo $write['sh_endtime'] ?>" required id="sh_endtime" class="sh_input required" placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}" oninput="sh_time_input(this);" title="교육시간 끝">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sh_week">교육요일</label></th>
                        <td>
                            <?php 
                            $sh_week_arr = array('일','월','화','수','목','금','토');
                            $ex_sh_week = explode(',',$write['sh_week']);
                            for($i=0;$i<count($sh_week_arr);$i++){?>
                            <input type="checkbox" name="ex_sh_week[]" value="<?= $sh_week_arr[$i]?>" id="sh_week_arr_<?= $i?>" <?= in_array($sh_week_arr[$i],$ex_sh_week) ? 'checked' : '' ?>>
                            <label for="sh_week_arr_<?= $i?>"><?= $sh_week_arr[$i]?></label>&nbsp;&nbsp;
                            <?php }?>
                            <span class="ps">※ 요일은 체크하지 않으시면 자동으로 전체요일이 선택됩니다.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sh_alltime">총 교육시간</label></th>
                        <td><input type="text" name="sh_alltime" value="<?php echo $write['sh_alltime'] ?>" id="sh_alltime" class="sh_input" oninput='Num_ck(this);'> 시간</td>
                    </tr>
                    <tr>
                        <th><label for="sh_info">교육내용</label></th>
                        <td>
                            <input type="text" name="sh_info" value="<?php echo $write['sh_info'] ?>" id="sh_info" class="sh_input full_input"><br>
                            <span class="ps">※ 한 줄로 요약하여 입력해 주세요.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wr_content">상세 내용<strong class="sound_only">필수</strong></label></th>
                        <td class="wr_content"><?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?></td>
                    </tr>
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
$(function(){
    $('#sh_restartday,#sh_reendday,#sh_startday,#sh_endday').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: "yy-mm-dd",
        yearRange: "c-1:c+1",
        maxDate: "+365d",
        minDate: "-365d"
    });
});
function sh_date_input(obj){
	var value = $(obj).val();
	var RegNotNum = /[^0-9]/g;
	
	value = value.replace(RegNotNum, '');

    if (value.length > 8) {
        value = value.slice(0, 8);
    }
	
    if (value.length>6) {
        value = `${value.slice(0, 4)}-${value.slice(4, 6)}-${value.slice(6, 8)}`;
    } else if (value.length>4) {
        value = `${value.slice(0, 4)}-${value.slice(4, 6)}`;
    } else if (value.length>2) {
        value = `${value.slice(0, 4)}`;
    }

    $(obj).val(value);
}
function sh_time_input(obj){
	var value = $(obj).val();
	var RegNotNum = /[^0-9]/g;
	
	value = value.replace(RegNotNum, '');

    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    if (value.length>2) {
        value = `${value.slice(0, 2)}:${value.slice(2, 4)}`;
    }else if (value.length>2) {
        value = `${value.slice(0, 2)}`;
    }

    $(obj).val(value);
}
function Num_ck(obj) { 
    var val = obj.value; 
    if(isNaN(val)) { 
        alert("숫자만 입력해 주세요"); 
        obj.value = val.replace(/[^0-9]/gi, ''); 
    }  
}

function fwrite_submit(f){    
    <?php echo get_editor_js('wr_content');?>
    if(!f.wr_content.value ){
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
    
    if(f.sh_startday.value=='0000-00-00'){
        alert('교육 시작일을 입력해 주시기 바랍니다.');
        f.sh_startday.focus();
        return false
    }
    if(f.sh_endday.value=='0000-00-00'){
        alert('교육 종료일을 입력해 주시기 바랍니다.');
        f.sh_endday.focus();
        return false
    }
    if(f.sh_startday.value > f.sh_endday.value){
        alert('교육 시작일은 교육 종료일 보다 작아야 합니다.');
        f.sh_startday.focus();
        return false
    }
    
    var stime = f.sh_starttime.value;
    var etime = f.sh_endtime.value;
    var sdatetime = new Date(f.sh_startday.value + ' ' + stime);
    var edatetime = new Date(f.sh_startday.value + ' ' + etime);

    if(etime=='00:00'){
        alert('교육 종료시간을 입력해 주시기 바랍니다.');
        f.sh_endtime.focus();
        return false
    }
    if(sdatetime > edatetime){
        alert('교육 시작시간은 교육 종료시간 보다 작아야 합니다.');
        f.sh_starttime.focus();
        return false
    }

    return true;
}
</script>