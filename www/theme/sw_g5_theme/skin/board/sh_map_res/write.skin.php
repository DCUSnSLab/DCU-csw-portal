<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
?>
<section id="sh_bo_w">
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
        
        <div id="sh_write_tbl" class="sh_tbl_common">
            <table cellpadding="0" cellspacing="0" summary="<?php echo $board['bo_subject'] ?> 글쓰기">
                <caption class="sound_only"><?php echo $board['bo_subject'] ?> 글쓰기</caption>
                <tbody>
                    <tr>
                        <th>지도 선택<span class="star">*</span></th>
                        <td><input type="radio" name="sh_map_type" id="sh_map_type_1" value="Naver" <?php echo $write['sh_map_type']=='Naver' || $write['sh_map_type']==''?'checked':''?> onclick="viewegock(this.value);" />
                        <label for="sh_map_type_1">네이버</label> &nbsp;
                        <input type="radio" name="sh_map_type" id="sh_map_type_2" value="Daum" <?php echo $write['sh_map_type']=='Daum'?'checked':''?> onclick="viewegock(this.value);" />
                        <label for="sh_map_type_2">다음</label> &nbsp;
                        <input type="radio" name="sh_map_type" id="sh_map_type_3" value="Google" <?php echo $write['sh_map_type']=='Google'?'checked':''?> onclick="viewegock(this.value);" />
                        <label for="sh_map_type_3">구글</label>
                        <span id="google_en_ck" style="display:none">
                        <input type="checkbox" name="sh_google_eng" id="sh_google_eng" value="en" <?php echo $write['sh_google_eng']=='en'?'checked':''?> />
                        <label for="sh_google_eng">영문</label></span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wr_subject">주 소</label><span class="star">*</span></th>
                        <td><input type="text" class="sh_input full_input" name="wr_subject" id="wr_subject" required value="<?php echo $subject?>"></td>
                    </tr>     
                    <tr>
                        <th>좌 표<span class="star">*</span></th>
                        <td>
                            <label for="sh_latitude" class="sound_only">X좌표</label>
                            <input id="sh_latitude" type="text" placeholder="X좌표" class="sh_input" required name="sh_latitude"  value="<?php echo $write['sh_latitude']?>">
                            <label for="sh_longitude" class="sound_only">Y좌표</label>
                            <input id="sh_longitude" type="text" placeholder="Y좌표"class="sh_input" required name="sh_longitude"  value="<?php echo $write['sh_longitude']?>">
                            <a class="map_btn" href="https://www.google.com/maps/place/" target="_blank">좌표찾기</a>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sh_map_level">지도 확대 레벨</label></th>
                        <td><input id="sh_map_level" type="text" class="sh_input" size="6" name="sh_map_level" value="<?php echo $write['sh_map_level']?>" onkeyup='Num_ck(this);'> <span class="ps">[기본값] 네이버 : 11 / 다음 : 3 / 구글 : 17</span></td>
                    </tr>
                    <tr>
                        <th><label for="sh_company">업체명</label><span class="star">*</span></th>
                        <td><input type="text" class="sh_input" style="width:100%" name="sh_company" id="sh_company" required value="<?php echo $write['sh_company']?>"></td>
                    </tr>
                    <tr>
                        <th><label for="sh_cs">고객센터</label></th>
                        <td><textarea class="sh_input txtarea" name="sh_cs" id="sh_cs"><?php echo $write['sh_cs']?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="wr_content">내용</label></th>
                        <td class="wr_content"><?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?></td>
                    </tr>
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
var map_type = '<?php echo $write['sh_map_type']?>';
function viewegock(val){
	if(val == 'Google'){
		$('#google_en_ck').css('display','inline');
	}else{
		$('#google_en_ck').css('display','none');
	}
}
if(map_type == 'Google'){
	viewegock(map_type);
}

function Num_ck(obj) { 
    var val = obj.value; 
    if(isNaN(val)) { 
        alert("숫자만 입력해 주세요"); 
        obj.value = val.replace(/[^0-9]/gi, ''); 
    }  
}

function fwrite_submit(f)
{
	<?php echo get_editor_js('wr_content');?>
    if(!f.wr_content.value ){
    f.wr_content.value = '&nbsp;';
    }
    return true;
}
</script> 