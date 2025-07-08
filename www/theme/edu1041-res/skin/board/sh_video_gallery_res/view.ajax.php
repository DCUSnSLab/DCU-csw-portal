<?php include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail_sh.lib.php');
if(!$_POST['id'] || !$_POST['table']){
    die();
}
$view = sql_fetch("select * from {$g5['write_prefix']}{$table} where wr_id = '{$id}'");
if(!$view){
    die('no');
}
$youtube_link = mb_substr($view['sh_video'],-11,NULL,'utf-8');
?>
<div id="video_view">
    <div class="inner">
        <button class="close" onclick="$('#video_view').remove()" type="button"><span class="sound_only">닫기</span></button>
    	<div class="tit_area">
            <p><?php echo $view['wr_subject'] ?></p>
            <span><?php echo $view['wr_name'] ?></span><span><?php echo date('Y-m-d',strtotime($view['wr_datetime'])) ?></span>
        </div>
    	<div class="scr_area">
            <iframe width="800" height="450" src="https://www.youtube.com/embed/<?php echo $youtube_link ?>" title="YouTube video player" frameborder="0" allow="accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>
            <div class="cont"><?php echo get_view_thumbnail($view['wr_content']); ?></div>
        </div>
    </div>
</div>

<script>
setTimeout(function() {
	$('#video_view').fadeIn(200).addClass("on");
},0);

$(document).mouseup(function (e){
  var LayerPopup = $("#video_view .inner");
  if(LayerPopup.has(e.target).length === 0){
    $('#video_view').remove();
  }
});
</script>
