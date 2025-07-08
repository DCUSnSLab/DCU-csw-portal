<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
?>
<?php
// add_stylesheet('css 구문', 출력순서);숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<style>
#prvLayer .tit{padding:15px 20px;border-bottom:1px solid #e1e1e1;font-size:15px;color:#222;background:#f5f5f5;font-family:'notokr-medium'}
#prvLayer .inner{padding:30px;}
#prvLayer textarea{width:100%;height:500px;margin-bottom:30px;border:none;font-size:13px;color:#777;font-family:'notokr-regular'}
#prvLayer textarea:focus, #prvLayer textarea:active{box-shadow:none;border:none!important;outline:none}
#prvLayer button{display:block;width:130px;height:45px;margin:0 auto;border:none;border-radius:3px;font-size:14px;color:#fff;background-color:#333;font-family:'notokr-medium'}
</style>

<div id="prvLayer">
	<p class="tit">이용약관</p>
    <div class="inner">
    <form name="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
        <textarea><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <button onclick="window.close();">확인</button>
    </form>
    </div>
</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>