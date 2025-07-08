<?php 
include_once('./_common.php');
include_once(G5_THEME_PATH.'/head.sub.php');
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/sh_style.css?ver='.G5_CSS_VER.'">', 0);
if(!$is_admin){
  alert_close("권한이 없습니다. 로그인해주세요");
}?>

    <!-- 게시물 작성/수정 시작 { -->

<form name="fwrite" id="fwrite" action="<?php echo $board_skin_url?>/sh_setup_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
  <input type="hidden" name="bo_table" value="<?php echo $bo_table?>" />
  <p class="basicset_title">게시판 기본설정</p>
  <table class="basicset">
    <tr>
      <th colspan="4">게시판공통설정</th>
    </tr>
    <tr>
      <th>출력순서</th>
      <td><input type="checkbox" name="bo_4" value="1" <?= get_checked($board['bo_4'],'1') ?> id="bo_4"/> <label for="bo_4">체크시 사용</label></td>
      <th>에디터사용</th>
      <td><input type="checkbox" name="bo_use_dhtml_editor" value="1" <?php echo $board['bo_use_dhtml_editor']?'checked':''; ?> id="bo_use_dhtml_editor"> 체크시 사용</td>
    </tr>
    <tr>
      <th>분류 ( 구분자| )</th>
      <td colspan="3">
        <input type="text" name="bo_category_list" value="<?php echo get_text($board['bo_category_list']) ?>" id="bo_category_list" class="frm_input" style="width:80%">
        <input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" <?php echo $board['bo_use_category']?'checked':''; ?>>
        <label for="bo_use_category">사용</label>
      </td>
    </tr>

    <tr>
      <th>글쓰기 권한</th>
      <td>
        <input type="radio" name="bo_write_level" value="1" <?= get_checked($board['bo_write_level'],'1') ?> id="bo_write_level1"> <label for="bo_write_level1">모두</label>
        <input type="radio" name="bo_write_level" value="2" <?= get_checked($board['bo_write_level'],'2') ?> id="bo_write_level2"> <label for="bo_write_level2">회원</label>
        <input type="radio" name="bo_write_level" value="10" <?= get_checked($board['bo_write_level'],'10') ?> id="bo_write_level3"> <label for="bo_write_level3">관리자만</label>
      </td>
      <th>읽기 권한</th>
      <td>
        <input type="radio" name="bo_read_level" value="1" <?= get_checked($board['bo_read_level'],'1') ?> id="bo_read_level1"> <label for="bo_read_level1">모두</label>
        <input type="radio" name="bo_read_level" value="2" <?= get_checked($board['bo_read_level'],'2') ?> id="bo_read_level2"> <label for="bo_read_level2">회원</label>
        <input type="radio" name="bo_read_level" value="10" <?= get_checked($board['bo_read_level'],'10') ?> id="bo_read_level3"> <label for="bo_read_level3">관리자만</label>
      </td>
    </tr>
    
    <tr>
      <th>목록보기 권한</th>
      <td>
        <input type="radio" name="bo_list_level" value="1" <?= get_checked($board['bo_list_level'],'1') ?> id="bo_list_level1"> <label for="bo_list_level1">모두</label>
        <input type="radio" name="bo_list_level" value="2" <?= get_checked($board['bo_list_level'],'2') ?> id="bo_list_level2"> <label for="bo_list_level2">회원</label>
        <input type="radio" name="bo_list_level" value="10" <?= get_checked($board['bo_list_level'],'10') ?> id="bo_list_level3"> <label for="bo_list_level3">관리자만</label>
      </td>
      <th>댓글 권한</th>
      <td>
        <input type="radio" name="bo_comment_level" value="1" <?= get_checked($board['bo_comment_level'],'1') ?> id="bo_comment_level1"> <label for="bo_comment_level1">모두</label>
        <input type="radio" name="bo_comment_level" value="2" <?= get_checked($board['bo_comment_level'],'2') ?> id="bo_comment_level2"> <label for="bo_comment_level2">회원</label>
        <input type="radio" name="bo_comment_level" value="10" <?= get_checked($board['bo_comment_level'],'10') ?> id="bo_comment_level3"> <label for="bo_comment_level3">관리자만</label>
      </td>
    </tr>
    
    <tr>
      <th>글답변 권한</th>
      <td>
        <input type="radio" name="bo_reply_level" value="1" <?= get_checked($board['bo_reply_level'],'1') ?> id="bo_reply_level1"> <label for="bo_reply_level1">모두</label>
        <input type="radio" name="bo_reply_level" value="2" <?= get_checked($board['bo_reply_level'],'2') ?> id="bo_reply_level2"> <label for="bo_reply_level2">회원</label>
        <input type="radio" name="bo_reply_level" value="10" <?= get_checked($board['bo_reply_level'],'10') ?> id="bo_reply_level3"> <label for="bo_reply_level3">관리자만</label>
      </td>
      <th>비밀글설정</th>
      <td>
        <input type="radio" name="bo_use_secret" value="0" <?= get_checked($board['bo_use_secret'],'0') ?> id="bo_use_secret1"> <label for="bo_use_secret1">사용하지 않음</label>
        <input type="radio" name="bo_use_secret" value="1" <?= get_checked($board['bo_use_secret'],'1') ?> id="bo_use_secret2"> <label for="bo_use_secret2">체크박스</label>
        <input type="radio" name="bo_use_secret" value="2" <?= get_checked($board['bo_use_secret'],'2') ?> id="bo_use_secret3"> <label for="bo_use_secret3">무조건</label>
      </td>
    </tr>
  </table> 
  <div class="btn_confirm" style="margin:10px 0;">
    <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit btn">
    <a href="#" onclick="window.close();"  class="btn_cancel btn">닫기</a>
  </div>
</form>

<?php include_once(G5_THEME_PATH.'/tail.sub.php');?>