<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/hd/aside/style.css?ver='.G5_CSS_VER.'">', 0);
?>

<ul id="shSnb">
    <?php
    $sql_len4 = " select * {$sql_common_len} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$gr['ca_id']}' {$sql_order_len} ";
    $result_len4 = sql_query($sql_len4);
    for ($i_len4=1; $row_len4=sql_fetch_array($result_len4); $i_len4++) { ?>
    <li <?php if ($pageNum == $i_len4){ echo "class='on'";}?>>
        <a href="<?php echo $row_len4['ca_link']?>"<?= $row_len4['ca_link_target']=='_blank' ? ' target="_blank"' :'' ?>><?php echo $row_len4['ca_name']?></a>
    </li>
    <?php }?>
</ul>
