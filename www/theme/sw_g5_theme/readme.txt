Theme Name: sw_g5_theme
Theme URI: https://www.designkits.co.kr/design_view/gaxiRd
Maker: 디자인키트
Maker URI: https://www.designkits.co.kr
Detail: 디자인키트에서 판매중인 디자인 입니다. 디자인 저작권은 (주)샤이닝에 있습니다. 무단으로 디자인 수정/배포/판매 시 법적 책임을 물을 수 있습니다.


[프로그램 제작 환경]
언어 : PHP 7.3.5
DB : Mysql 10.3.15-MariaDB
그누보드버전 : 5.5.8.3

[기본 세팅방법] 
1. https://sir.kr/manual/yc5/67 로 접속 후 내용 확인하며 그누보드(영카트)를 설치합니다.

2. /www/theme 경로에 다운로드한 파일 중 edu1041-res 폴더를 업로드합니다.

3. 그누보드를 설치한 사이트에 관리자 로그인 후 관리자 페이지(/adm)에 접근합니다.

4. 관리자 페이지 좌측 메뉴에서 '테마설정'에 접근하여 업로드한 edu1041-res 적용합니다.

5. /www/config.php에서 define('G5_USE_MOBILE', true); -> define('G5_USE_MOBILE', false); 로 수정해 주세요.

6. 기본 세팅이 완료되었습니다. 사이트에 맞게 코드 수정 진행해 주시면 됩니다.
※ 코드 설명과 기능 추가/유지 보수 문의는 받지 않습니다.


[메뉴세팅]
1. 관리자 로그인 후 최하단에 보면 MENU 버튼이 있습니다. 해당 버튼을 클릭하여 메뉴세팅 페이지로 이동합니다.

2. 홈페이지에 알맞게 대분류추가/소분류 추가를 이용해 메뉴를 추가합니다.

3. 메뉴명 입력 후 타입을 선택해 줍니다.
3-1. 일반게시판을 선택하면 링크가 자동으로 입력 되며 해당 bo_table 값으로 게시판이 자동 생성 됩니다.
3-2. PHP를 선택하면 링크가 자동 입력 되며 /www/page/ 경로로 파일이 자동 생성 됩니다.
※ /www/page 폴더를 권한 707 or 777로 먼저 생성을 해줘야 합니다.
※ 자동 입력된 파일명을 변경 시 네비게이터가 정상 작동 안될 수 있습니다.
3-3. 직접 입력은 외부 경로를 입력할 때 사용해 주시면 됩니다.

4. 링크방식, 스킨, 모바일 출력을 알맞게 선택 후 저장 누르면 메뉴가 생성 됩니다.


[파일생성]
파일 생성 위치를 /www/theme/edu1041-res/페이지.php 기준으로 안내드리겠습니다.
(위치 변경 시 _common.php include 경로를 수정해 줘야 합니다.)

<?php 
include_once('./_common.php');//파일 위치에 따라 경로 수정 필요
include_once(G5_THEME_PATH.'/head.php');
?>
-- 내용 --
<?php include_once(G5_THEME_PATH.'/tail.php'); ?> 

디자인에 맞는 상·하단(header, footer)를 호출하고 그 안에 내용을 넣습니다.