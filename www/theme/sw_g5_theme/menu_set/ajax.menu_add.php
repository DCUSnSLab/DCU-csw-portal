<?php
include_once('../../../common.php');
include_once(G5_PATH.'/adm/admin.lib.php');

$ca_id_type_N = $_POST['ca_id_type_N'];
$ca_id = $_POST['ca_id'];


if($ca_id_type_N=='len2'){
	$ca_name = '대분류';$ca_id_type++;$ca_name_strong1="<strong>";$ca_name_strong2="</strong>";$ca_id_NN='11';
	
	$sql_no = " select max(ca_id) as max_ca_id from sh_category where length(ca_id) = '2' ";
	$row_no = sql_fetch($sql_no);
	$next_ca_id = $row_no['max_ca_id']+1;
	
	$sql = " insert into sh_category set ca_id = '{$next_ca_id}', ca_name = '대분류' ";
	sql_query($sql);
	$ca_no = sql_insert_id();
	
}else{
	$ca_name = '소분류';$ca_id_type=$ca_name_strong1=$ca_name_strong2='';$ca_id_NN='1111';
	
	$sql_no = " select max(ca_id) as max_ca_id from sh_category where length(ca_id) = '4' and ca_id like '{$ca_id}%' ";
	$row_no = sql_fetch($sql_no);
	$next_ca_id = $row_no['max_ca_id']+1;
	
	if($next_ca_id==1){$next_ca_id = $ca_id.'01';}
	
	$sql = " insert into sh_category set ca_id = '{$next_ca_id}', ca_name = '소분류' ";
	sql_query($sql);
	$ca_no = sql_insert_id();
}
?>

<?php if($ca_id_type_N=='len2'){?>
<ul id="sortable<?php echo $ca_no?>" class="connectedSortable" style="background-color:transparent !important; z-index:999 !important; padding:10px; margin:10px;border: 1px solid #EBEBEB;">
<?php }?>
<!-- class ui-state-disabled 면 고정 -->
          <li id="ca_name<?php echo $ca_no?>" type="dea" class="dea ui-widget" <?php echo $ca_li_bg;?> style="<?php if($ca_id_type_N=='len2'){?>background: #f6f6f6 !important;<?php }else{?>border: 1px solid #d3d3d3;<?php }?>opacity: 1 !important;border-radius: 4px !important;">
<input type="hidden" name="ca_no[]" value="<?php echo $ca_no?>">                
<input type="hidden" name="ca_id_old[]">
<input type="hidden" name="ca_id_len[]" value="<?php if($ca_id_type_N=='len2'){echo '2';}else{echo '4';}?>">

                
                
<input type="hidden" name="ca_id_del[<?php echo $ca_no?>]" id="ca_id_del<?php echo $ca_no?>">
<input type="hidden" name="ca_id_N[]">
<input type="hidden" name="ca_name_N[]" id="ca_name_sN<?php echo $ca_no?>">
<input type="hidden" name="ca_type_N[]" id="ca_type_sN<?php echo $ca_no?>">
<input type="hidden" name="ca_type_d_N[]" id="ca_type_d_sN<?php echo $ca_no?>">
<input type="hidden" name="ca_id_type[]" value="<?php echo $ca_id_type?>">
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
    <td><?php echo $next_ca_id?></td>
    <td><input type="text" name="ca_name[<?php echo $ca_no?>]" id="ca_name_<?php echo $ca_no?>" value="<?php echo $ca_name?>" class="frm_input required"/></td>
    <td>
	<select name="ca_type[<?php echo $ca_no?>]" id="ca_type_<?php echo $ca_no?>" onChange="sh_auto_setting(this.value, '<?php echo $ca_no?>')">
    	<option value="">선택</option>
        <option value="php">PHP</option>
        <option value="board">일반게시판</option>
        <option value="self">직접입력</option>
    </select>
    </td>
    <td>
	<input type="text" name="ca_link[<?php echo $ca_no?>]" id="ca_link_<?php echo $ca_no?>" style="width:100%" class="frm_input">
    </td>
    <td>
	<select name="ca_link_target[<?php echo $ca_no?>]" id="ca_link_target_<?php echo $ca_no?>">
        <option value="self">일반</option>
        <option value="_blank">새창</option>
    </select>
    </td>
    <td><?php echo get_skin_select('board', 'bo_skin_'.$ca_no, 'bo_skin['.$ca_no.']', '', ''); ?></td>
    <td>모바일 출력 [<input type="checkbox" name="ca_mobile_use[<?php echo $ca_no?>]" value="1">]</td>
    <td>
    <a onclick="sh_cate_list_modify('<?php echo $ca_no?>');" class="btn_s">수정</a>
    <?php if($ca_id_type_N=='len2'){?>
    <a onclick="sh_cate_list_delete('<?php echo $ca_no?>','<?php echo $next_ca_id?>','sortable<?php echo $i?>','2');" class="btn_s">삭제</a>
    <a onclick="add_cate('len4','sortable<?php echo $ca_no?>','<?php echo $next_ca_id?>')" class="btn_s">소분류추가</a> 
    <?php }else{?>
    <a onclick="sh_cate_list_delete('<?php echo $ca_no?>','<?php echo $next_ca_id?>','ca_name<?php echo $ca_no?>','4');" class="btn_s">삭제</a> 
    <?php }?>
    </td>
</tr>
</table>
<?php if($ca_id_type_N=='len2'){?></ul><?php }?>