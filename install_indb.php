<?


function debug($data=''){
    echo "<xmp style='background:black; color:#43db20; font-size:11px; line-height:16px; text-align:left; position:relative; z-index:1000;'>";
    print_r($data);
    echo "</xmp>";
}

#이메일체크
function emailCheck($temp_email) {
    return preg_match("/^[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)*@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)+$/", $temp_email);
}


#알림
function alert($text){
    echo "<script>alert('".$text."');</script>";
}


if(file_exists('common/db.php')){
    alert('프로그램이 이미 설치되어 있습니다.');
    exit;
}



if(!$_POST[uid]){
    alert('이메일을 입력해 주세요.');
    exit;
}



if($_POST[upw]!=$_POST[upw2]){
    alert('최고관리자 패스워드가 일치하지 않습니다.');
    exit;
}


if(!$_POST[db_host]){
    alert('호스트를 입력해 주세요.');
    exit;
}

if(!$_POST[db_name]){
    alert('데이터베이스 이름을 입력해 주세요.');
    exit;
}

if(!$_POST[db_id]){
    alert('데이터베이스 아이디를 입력해 주세요.');
    exit;
}

if(!$_POST[db_pw]){
    alert('데이터베이스 패스워드를 입력해 주세요.');
    exit;
}



if(!emailCheck($_POST[uid])){
    alert('정상적인 이메일을 입력해 주세요.');
    exit;
}


if(strlen($_POST[upw])<6){
    alert('최고관리자 패스워드를 6자 이상 입력해 주세요.');
    exit;
}


if(!$fp = fopen($_SERVER[DOCUMENT_ROOT]."/common/db.php","w")){
    alert('파일 권한 문제로 설치할수 없습니다.\n개발자에게 문의 바랍니다.');
    exit;
}

fwrite($fp,"<?");
fwrite($fp,"\$dbinfo = array('host'=>'".$_POST[db_host]."','dbid'=>'".$_POST[db_id]."','dbpw'=>'".base64_encode($_POST[db_pw])."','dbnm'=>'".$_POST[db_name]."');");
fwrite($fp,"?>");

fclose($fp);


include 'common/db.php';


$mysqli = new mysqli($dbinfo['host'],$dbinfo['dbid'],base64_decode($dbinfo['dbpw']),$dbinfo['dbnm']);

if (mysqli_connect_errno()){
    alert('데이터베이스에 연결할 수 없습니다.\n계정을 재확인 해주세요.');
    unlink('common/db.php');
    exit;
}



$url = 'http://work6.kr/solution/license/framework';
$post['host'] = $_SERVER['HOST'];
if(!$post['host']) $post['host'] = $_SERVER['HTTP_HOST'];
if(!$post['host']) $post['host'] = $_SERVER['SERVER_NAME'];

$ch = @curl_init();

if($ch){

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);  // Tell cURL you want to post something
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Define what you want to post
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the output in string format
    $res = curl_exec ($ch); // Execute

    curl_close ($ch); // Close cURL handle

}




//데이터베이스 테이블 생성
$query = "
CREATE TABLE `w_config` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT NULL COMMENT '코드명',
  `data` text COMMENT '값',
  PRIMARY KEY (idx)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='설정테이블';

INSERT INTO `w_config` (`idx`, `code`, `data`) VALUES
(1, 'site_name', ''),
(2, 'site_description', ''),
(3, 'site_email', ''),
(4, 'email_server', 'server'),
(5, 'site_stmp_id', ''),
(6, 'site_stmp_pw', ''),
(11, 'company_name', ''),
(12, 'company_addr', ''),
(13, 'company_tel', ''),
(14, 'company_ceo', ''),
(15, 'company_number', ''),
(16, 'site_keywords', ''),
(17, 'google_webmaster_code', ''),
(19, 'site_name_en', ''),
(20, 'security_exception_ip', ''),
(21, 'naver_webmaster_code', ''),
(22, 'company_sales_number', ''),
(23, 'company_webmaster', ''),
(26, 'site_stmp_server', ''),
(27, 'site_stmp_port', ''),
(28, 'sms_id', ''),
(29, 'sms_key', ''),
(30, 'skin', 'front'),
(31, 'email_secure', 'ssl'),
(32, 'super_admin', '9999');


CREATE TABLE `w_level` (
  `idx` int(10) NOT NULL AUTO_INCREMENT COMMENT '고유값',
  `name` varchar(30) DEFAULT NULL COMMENT '회원등급명',
  `admin_permision` varchar(1) DEFAULT NULL COMMENT '관리자접속혀용여부',
  `admin_menu_permit` text COMMENT '관리자접근허용메뉴',
  `level` int(4) DEFAULT NULL COMMENT '회원레벨',
  `insdt` datetime DEFAULT NULL COMMENT '가입날짜',
  `moddt` datetime DEFAULT NULL COMMENT '수정날짜',
  PRIMARY KEY (idx)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회원등급' ROW_FORMAT=COMPACT;

INSERT INTO `w_level` (`idx`, `name`, `admin_permision`, `admin_menu_permit`, `level`, `insdt`, `moddt`) VALUES
(1, '최고관리자', 'y', NULL, 9999, now(), NULL);



CREATE TABLE `w_member` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL COMMENT '아이디',
  `upw` text COMMENT '패스워드',
  `team` varchar(255) NOT NULL COMMENT '소속',
  `name` varchar(100) DEFAULT NULL COMMENT '이름',
  `mobile` varchar(15) DEFAULT NULL COMMENT '휴대폰번호',
  `level` int(4) DEFAULT NULL COMMENT '레벨',
  `insdt` datetime DEFAULT NULL COMMENT '가입날짜',
  `moddt` datetime DEFAULT NULL COMMENT '수정날짜',
  `logindt` datetime DEFAULT NULL COMMENT '최근접속날짜',
  `ip` varchar(45) DEFAULT NULL COMMENT '최근접속아이피',
  `photo` text NOT NULL COMMENT '관리자 사진',
  PRIMARY KEY (idx)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회원테이블' ROW_FORMAT=COMPACT;


INSERT INTO `w_member` (`idx`, `uid`, `upw`, `team`, `name`, `mobile`, `level`, `insdt`, `moddt`, `logindt`, `ip`, `photo`) VALUES
(1, '".$_POST['uid']."', PASSWORD('".$_POST['upw']."'), '', '최고관리자', NULL, 9999, NOW(), '', '', '', '');


CREATE TABLE `w_log_login` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `member_idx` int(10) DEFAULT NULL COMMENT '회원 idx',
  `logindt` datetime DEFAULT NULL COMMENT '최근접속일',
  `ip` varchar(45) DEFAULT NULL COMMENT '접속아이피',
  PRIMARY KEY (idx)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='접속로그';


CREATE TABLE `w_notice` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `member_idx` int(10) DEFAULT NULL COMMENT '회원 idx',
  `subject` varchar(255) DEFAULT NULL COMMENT '제목',
  `contents` text COMMENT '내용',
  `file` text NOT NULL COMMENT '다운로드파일',
  `insdt` datetime DEFAULT NULL COMMENT '작성일',
  `moddt` datetime DEFAULT NULL COMMENT '수정일',
  PRIMARY KEY (idx)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='공지';


INSERT INTO `w_notice` (`idx`, `member_idx`, `subject`, `contents`, `file`, `insdt`, `moddt`) VALUES
(1, 1, '반갑습니다.', '워크식스의 관리 프로그램을 이용해 주셔서 감사합니다. 성원에 힘입어 더욱 발전된 모습으로 찾아뵙겠습니다.', '', NOW(), '');

";
if(!$mysqli->multi_query($query)){
    alert('데이터베이스 설치중 오류가 발생 했습니다.');
    unlink('common/db.php');
    exit;
}

header("Location:remove.php");


?>
