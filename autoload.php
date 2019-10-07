<?

if(!file_exists('./.htaccess')){
    die('.htaccess 파일이 누락되었습니다.');
    exit;
}


if(!file_exists('./common/db.php')){
    //header('Location:install.php');
    die('프로그램이 설치되어 있지 않습니다.<br><a href="/install.php">프로그램 설치하기</a>');
    exit;
}


function autoload($param){
    $param = str_replace('\\','/',$param).".php";

    if(file_exists($param)){
        require_once $param;
    }else{

        $msg = $param." 파일을 찾을 수 없습니다.";

        require_once 'data/skin/error/error404.htm';
        exit;
    }


}

spl_autoload_register('autoload');
