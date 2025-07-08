<?php
if (!defined('_GNUBOARD_')) exit;
function phoneNum($number){
    $number = str_replace('-','',$number);
    $number = str_replace(' ','',$number);
    $number = preg_replace('/[^0-9]/','',$number);
    switch(strlen($number)){
     case 7:;
     case 8:;
      $pattern = '/^(.{4})(.*)$/';
      $replace = '$1-$2';
     break;
     case 9:;
     case 10:;
     case 11:;
     case 12:
      $pattern = '/^(02|0.{2}|.{4})(.*)(.{4})$/';
      $replace = '$1-$2-$3';
     break;
    }
    if(!isset($pattern)){ return false; }
    return preg_replace($pattern,$replace,$number);
}

function sh_get_thumbnail($bo_table, $wr_id, $bf_no=0, $thumb_width, $thumb_height, $is_create=false, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3'){
    global $g5, $config;
    $filename = $alt = "";
    $edt = false;

    $sql = " select bf_file, bf_content from {$g5['board_file_table']}
                where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_type between '1' and '3' and bf_no = '$bf_no' order by bf_no ";
    $row = sql_fetch($sql);

	$filename = $row['bf_file'];
	$filepath = G5_DATA_PATH.'/file/'.$bo_table;
	$alt = get_text($row['bf_content']);

    if(!$filename)
        return false;

    $tname = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

    if($tname) {
        if($edt) {
            // 오리지날 이미지
            $ori = G5_URL.$data_path;
            // 썸네일 이미지
            $src = G5_URL.str_replace($filename, $tname, $data_path);
        } else {
            $ori = G5_DATA_URL.'/file/'.$bo_table.'/'.$filename;
            $src = G5_DATA_URL.'/file/'.$bo_table.'/'.$tname;
        }
    } else {
        return false;
    }

    $thumb = array("src"=>$src, "ori"=>$ori, "alt"=>$alt);

    return $thumb;
}
?>