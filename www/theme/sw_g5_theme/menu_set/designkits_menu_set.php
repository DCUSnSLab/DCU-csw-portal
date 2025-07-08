<?php include_once('../../../common.php');
include_once(G5_PATH.'/adm/admin.lib.php');
if($is_admin!='super'){
    alert('홈페이지 관리자만 접근 가능합니다.');
}
//메뉴관리 테이블생성
$table_chk = sql_fetch("SELECT COUNT(*) cnt FROM information_schema.tables WHERE table_name = 'sh_category'");
if($table_chk['cnt']<1){
    sql_query("CREATE TABLE sh_category(
        ca_no INT(11) NOT NULL AUTO_INCREMENT,
        ca_id VARCHAR(11) NOT NULL,
        ca_name VARCHAR(255) NOT NULL,
        ca_type VARCHAR(11) NOT NULL,
        ca_link VARCHAR(255) NOT NULL,
        ca_link_target VARCHAR(11) NOT NULL,
        bo_skin VARCHAR(25) NOT NULL,
        ca_mobile_use TINYINT(1) NOT NULL,
        PRIMARY KEY(ca_no),
        key ca_id(ca_id)
    )",true);
}

include_once(G5_THEME_PATH.'/head.sub.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/menu_set/sh_cate_list.css">', 0);
add_javascript('<script src="'.G5_THEME_URL.'/js/jquery-ui.js"></script>', 0);?>

<style>
tbody td {border:0px !important;}
.btn_s {
    display: inline-block;
    padding: 4px 7px;
    background: #676c74;
    border-radius: 4px;
    color: #fff !important;
    font-size: 0.9em;
    margin: 1px;
    cursor: pointer;
}
</style>

<form name="fcateform" id="fcateform" action="./designkits_menu_set_update.php" method="POST" autocomplete="off" id="menu_form">
  <div id="cate_box" class="ui-widget-content">
    <div class="tree">
        <div>
            <ul  class="connectedSortable ui-sortable-handle ui-sortable" style="background-color:transparent !important; z-index:999 !important; padding:10px; margin:10px;border: 1px solid #EBEBEB; font-weight:bold;">
                <li class="dea ui-widget" style="background: #f6f6f6 !important;opacity:1 !important; border-radius: 4px !important;">
                    <table>
                        <colgroup>
                            <col width="180px">
                            <col width="200px">
                            <col width="180px">
                            <col width="">
                            <col width="180px">
                            <col width="180px">
                            <col width="120px">
                            <col width="180px">
                        </colgroup>
                        <tbody>
                            <tr style="text-align:center;">
                                <td>코드</td>
                                <td>메뉴명</td>
                                <td>타입</td>
                                <td>링크</td>
                                <td>링크방식</td>
                                <td>스킨(게시판만 선택)</td>
                                <td>모바일 출력 [<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">]</td>
                                <td><a onclick="add_cate('len2')" class="btn_s">대분류추가</a></td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>     
        <div id="sortable">
            <?php
            $sql_common = " from sh_category ";
            $sql_search = " where length(ca_id) = '2' ";
            if (!$sst) {
                $sst = "ca_id";
                $sod = "asc";
            }
            $sql_order = " order by {$sst} {$sod} ";

            $sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
            $result = sql_query($sql);

            $result = sql_query($sql); 
            $sortable_no = '';
            for ($i=1; $row=sql_fetch_array($result); $i++) {// 대분류
                if($row['ca_link'] && strpos($row['ca_link'],"bo_table") !== false && $row['bo_skin']){
                    $ex_ca_link = explode("bo_table=",$row['ca_link']);
                    $ex_ca_link = explode("&",$ex_ca_link[1]);
                    $board = sql_fetch("select bo_skin from g5_board where bo_table = '{$ex_ca_link[0]}'");
                    if($board['bo_skin']){
                        $row['bo_skin'] = $board['bo_skin'];
                    }
                }
                $ca_name = $row['ca_name'];
                $ca_name_strong1="<strong style='color:#333'>";
                $ca_name_strong2="</strong>";
                $ca_li_bg = "style='background: #f6f6f6 !important;opacity:1 !important; border-radius: 4px !important;'";
                if($i!='1'){$sortable_no .= ", ";}
                $sortable_no .= "#sortable{$i}";
            ?>
            <ul id="sortable<?php echo $i?>" class="connectedSortable" style="background-color:transparent !important; z-index:999 !important; padding:10px; margin:10px;border: 1px solid #EBEBEB;">
                <li id="ca_name<?php echo $row['ca_no']?>" type="dea" class="dea ui-widget" <?php echo $ca_li_bg?>>
                    <input type="hidden" name="ca_no[]" value="<?php echo $row['ca_no']?>">                
                    <input type="hidden" name="ca_id_old[]" value="<?php echo $row['ca_id']?>">
                    <input type="hidden" name="ca_id_len[]" value="2">
                    <table>
                        <col width="180px">
                        <col width="200px">
                        <col width="180px">
                        <col width="">
                        <col width="180px">
                        <col width="180px">
                        <col width="120px">
                        <col width="180px">
                        <tr style="text-align:center;">
                            <td><?php echo $row['ca_id']?></td>
                            <td><input type="text" name="ca_name[<?php echo $row['ca_no']?>]" id="ca_name_<?php echo $row['ca_no']?>" value="<?php echo $row['ca_name']?>" class="frm_input required"/></td>
                            <td>
                                <select name="ca_type[<?php echo $row['ca_no']?>]" id="ca_type_<?php echo $row['ca_no']?>" onChange="sh_auto_setting(this.value, '<?php echo $row['ca_no']?>')">
                                    <option value="" <?php if(!$row['ca_type']){echo 'selected';}?>>선택</option>
                                    <option value="php" <?php if($row['ca_type']=='php'){echo 'selected';}?>>PHP</option>
                                    <option value="board" <?php if($row['ca_type']=='board'){echo 'selected';}?>>일반게시판</option>
                                    <option value="self" <?php if($row['ca_type']=='self'){echo 'selected';}?>>직접입력</option>
                                </select>
                            </td>
                            <td><input type="text" name="ca_link[<?php echo $row['ca_no']?>]" id="ca_link_<?php echo $row['ca_no']?>" value="<?php echo $row['ca_link']?>" style="width:100%" class="frm_input"></td>
                            <td>
                                <select name="ca_link_target[<?php echo $row['ca_no']?>]" id="ca_link_target_<?php echo $row['ca_no']?>">
                                    <option value="self" <?php if($row['ca_link_target']=='self'){echo 'selected';}?>>일반</option>
                                    <option value="_blank" <?php if($row['ca_link_target']=='_blank'){echo 'selected';}?>>새창</option>
                                </select>
                            </td>
                            <td><?php echo get_skin_select('board', 'bo_skin_'.$row['ca_no'], 'bo_skin['.$row['ca_no'].']', $row['bo_skin'], ''); ?></td>
                            <td>모바일 출력 [<input type="checkbox" name="ca_mobile_use[<?php echo $row['ca_no']?>]" id="ca_mobile_use_<?php echo $row['ca_no']?>" value="1" <?php if($row['ca_mobile_use']){echo 'checked';}?>>]</td>
                            <td>
                                <a onclick="sh_cate_list_modify('<?php echo $row['ca_no']?>');" class="btn_s">수정</a>
                                <a onclick="sh_cate_list_delete('<?php echo $row['ca_no']?>','<?php echo $row['ca_id']?>','sortable<?php echo $i?>','2');" class="btn_s">삭제</a> 
                                <a onclick="add_cate('len4','sortable<?php echo $i?>','<?php echo $row['ca_id']?>')" class="btn_s">소분류추가</a> 
                            </td>
                        </tr>
                    </table>
                </li>
                <?php
                $sql2 = " select * from sh_category where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' order by ca_id asc ";
                $result2 = sql_query($sql2);
                for ($i2=0; $row2=sql_fetch_array($result2); $i2++) {
                $ca_name = $row2['ca_name'];
                $ca_name_strong1=$ca_name_strong2='';
                $ca_li_bg = "";
                if($row2['ca_link'] && strpos($row2['ca_link'],"bo_table") !== false && $row2['bo_skin']){
                    $ex_ca_link = explode("bo_table=",$row2['ca_link']);
                    $ex_ca_link = explode("&",$ex_ca_link[1]);
                    $board = sql_fetch("select bo_skin from g5_board where bo_table = '{$ex_ca_link[0]}'");
                    if($board['bo_skin']){
                        $row2['bo_skin'] = $board['bo_skin'];
                    }
                }
                ?>
                <li id="li_id_<?php echo $row2['ca_no']?>" class="ui-state-default" <?php echo $ca_li_bg?>>
                    <input type="hidden" name="ca_no[]" value="<?php echo $row2['ca_no']?>">
                    <input type="hidden" name="ca_id_old[]" value="<?php echo $row2['ca_id']?>">
                    <input type="hidden" name="ca_id_len[]" value="4">
                    <table>
                        <col width="180px">
                        <col width="200px">
                        <col width="180px">
                        <col width="">
                        <col width="180px">
                        <col width="180px">
                        <col width="120px">
                        <col width="180px">
                        <tr style="text-align:center;">
                            <td><?php echo $row2['ca_id']?></td>
                            <td><input type="text" name="ca_name[<?php echo $row2['ca_no']?>]" id="ca_name_<?php echo $row2['ca_no']?>" value="<?php echo $row2['ca_name']?>" class="frm_input required" /></td>
                            <td>
                                <select name="ca_type[<?php echo $row2['ca_no']?>]" id="ca_type_<?php echo $row2['ca_no']?>" onChange="sh_auto_setting(this.value, '<?php echo $row2['ca_no']?>')">
                                    <option value="" <?php if(!$row2['ca_type']){echo 'selected';}?>>선택</option>
                                    <option value="php" <?php if($row2['ca_type']=='php'){echo 'selected';}?>>PHP</option>
                                    <option value="board" <?php if($row2['ca_type']=='board'){echo 'selected';}?>>일반게시판</option>
                                    <option value="self" <?php if($row2['ca_type']=='self'){echo 'selected';}?>>직접입력</option>
                                </select>
                            </td>
                            <td><input type="text" name="ca_link[<?php echo $row2['ca_no']?>]" id="ca_link_<?php echo $row2['ca_no']?>" value="<?php echo $row2['ca_link']?>" style="width:100%" class="frm_input"></td>
                            <td>
                                <select name="ca_link_target[<?php echo $row2['ca_no']?>]" id="ca_link_target_<?php echo $row2['ca_no']?>">
                                    <option value="self" <?php if($row2['ca_link_target']=='self'){echo 'selected';}?>>일반</option>
                                    <option value="_blank" <?php if($row2['ca_link_target']=='_blank'){echo 'selected';}?>>새창</option>
                                </select>
                            </td>
                            <td><?php echo get_skin_select('board', 'bo_skin_'.$row2['ca_no'], 'bo_skin['.$row2['ca_no'].']', $row2['bo_skin'], ''); ?></td>
                            <td>모바일 출력 [<input type="checkbox" name="ca_mobile_use[<?php echo $row2['ca_no']?>]" id="ca_mobile_use_<?php echo $row2['ca_no']?>" value="1" <?php if($row2['ca_mobile_use']){echo 'checked';}?>>]</td>
                            <td>
                                <a onclick="sh_cate_list_modify('<?php echo $row2['ca_no']?>');" class="btn_s">수정</a>
                                <a onclick="sh_cate_list_delete('<?php echo $row2['ca_no']?>','<?php echo $row['ca_id']?>','li_id_<?php echo $row2['ca_no']?>','4');" class="btn_s">삭제</a> 
                            </td>
                        </tr>
                    </table>
                </li>
                <?php 
                }// 소분류 for
                ?>
            </ul>
            <?php
            }// 대분류 for?>
        </div>            
    </div>
         
    </div>
    <div class="confirm_area">
        <input type="submit" value=" 저 장 " id="btn_submit">
  </div>
</form>
<script>
function all_checked(sw) {
    var f = document.fcateform;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name.substring(0,14) == "ca_mobile_use[")
            f.elements[i].checked = sw;
    }
}

$( function() {
	/* 대분류 */
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
	$( "#draggable" ).draggable();
	/* 소분류 */
	$( "<?php echo $sortable_no?>" ).sortable({
      connectWith: ".connectedSortable",items: "li:not(.dea)"
    })
	$( "<?php echo $sortable_no?>" ).disableSelection();
} );

$(function() {
$(".ui-state-default")
.button()
});

function sh_cate_list_modify(ca_no){ 
	var ca_name = $('#ca_name_'+ca_no).val();
	var ca_link = $('#ca_link_'+ca_no).val();
	if($('#ca_mobile_use_'+ca_no).is(':checked')){	var ca_mobile_use = 1;}
	var bo_skin = $('#bo_skin_'+ca_no).val();
	var ca_type = $('#ca_type_'+ca_no).val();
	var ca_link_target = $('#ca_link_target_'+ca_no).val();
	
	$.ajax({
        url: g5_theme_url+"/menu_set/ajax.menu_modify.php",
        type: "POST",
        data: {
            "ca_no": ca_no,
            "ca_name": ca_name,
            "ca_link":ca_link,
            "ca_mobile_use": ca_mobile_use,
            "bo_skin":bo_skin,
            "ca_type":ca_type,
            "ca_link_target":ca_link_target
        },
        async: false,
        success: function(data) {
            alert('수정되었습니다.');
            var thisbackgroundColor = $("#li_id_"+ca_no).css("backgroundColor");// 원래 색 저장 후 적용
            $("#li_id_"+ca_no).animate({'background-color':'#f6f6f6'},500);
            $("#li_id_"+ca_no).animate({'background-color':thisbackgroundColor},500);
            $('#ca_name_'+ca_no).blur();
        }
	});
}

function sh_cate_list_delete(ca_no, ca_id, sortable_no, deaso){ 
	if(!confirm("선택한 메뉴를 정말 삭제하시겠습니까?\n※페이지 php파일과 게시판이 같이 삭제 됩니다.")) {
		return false;
	}
	var sh_alert = '';
	
	$.ajax({
            url: g5_theme_url+"/menu_set/ajax.menu_delete.php",
            type: "POST",
            data: {
                "ca_no": ca_no,
				"ca_id": ca_id,
				"deaso": deaso
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                window.location.reload();
                alert(data.sh_alert);
			},
			error : function(data, textStatus) {$("#"+sortable_no).remove();}
	});

}

function add_cate(obj,sortable_no,ca_id) {
	var ca_id_type_N = obj;
	var sortable_no = sortable_no;
	$.ajax({
		url: g5_theme_url+"/menu_set/ajax.menu_add.php",
		type: 'POST', 
		data: {
			"ca_id_type_N": ca_id_type_N,
			"ca_id": ca_id
			},
		success: function(data){ 
			if(obj=='len2'){
				$("#sortable").prepend(data); 
			}else{
				$("#"+sortable_no).append(data); 
			}
		},
		dataType: 'html' 
	}); 
}

function sh_auto_setting(value, ca_no) { 
	if (value == '') {
		ca_link_value = "";
		bo_skin_value_value = "";
	}
	
	var ca_link_value = "";
	var bo_skin_value_value = "";
	if (value == 'php') {
		ca_link_value = "/page/page"+ca_no+".php";
	}
	if (value == 'board') {
		ca_link_value = "/bbs/board.php?bo_table=table"+ca_no;
	}
	$("#ca_link_"+ca_no).attr('value',ca_link_value);
	$("#bo_skin_"+ca_no).val(bo_skin_value_value).attr("selected", "selected");
	
	
}
</script>
<?php include_once(G5_THEME_PATH.'/tail.sub.php'); ?>