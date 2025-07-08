<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/sql_add.php");
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);

if(!$is_admin){
    alert('해당 게시판은 관리자만 입력 가능합니다.');
}
?>

<section id="sh_bo_w">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 [s] -->
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
        <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                }
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
                        <th>분류</th>
                        <td>
                            <div class="cate_wrap">
                            <label for="ca_name"  class="sound_only">분류<strong>필수</strong></label>
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
                        <th scope="row"><label for="sh_rank">출력순서</label></th>
                        <td><input type="text" name="sh_rank" value="<?php echo $write['sh_rank'] ?>" id="sh_rank" class="sh_input" onkeyup='Num_ck(this);'><span class="ps">※ 높은 숫자일수록 상위에 노출됩니다.</span></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="wr_subject">제목<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="sh_input full_input required" size="50" maxlength="255"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
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
function fwrite_submit(f)
{	
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
    return true;
}
</script>