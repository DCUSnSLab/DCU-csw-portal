<?php
// common.php 경로는 설치 구조에 따라 ../ 또는 ./ 등으로 맞춰주세요.
include_once('../common.php'); 

// 페이지 제목
$g5['title'] = '샘플 페이지 16';
include_once(G5_PATH.'/head.php');
?>

<div style="padding: 30px; text-align: center;">
    <h1 style="font-size: 2rem; color: #333;">🎉 샘플 페이지 16 🎉</h1>
    <p>이 페이지는 <strong>/page/page16.php</strong>로 직접 만든 페이지입니다.</p>
    <p>헤더와 푸터가 정상적으로 출력되면 연동이 잘 된 것입니다.</p>
    <p style="margin-top: 20px;">
        <a href="<?php echo G5_URL ?>" style="color: blue; text-decoration: underline;">홈으로 가기</a>
    </p>
</div>

<?php
include_once(G5_PATH.'/tail.php');
?>
