<?
namespace common;
use \common\PHPMailer\PHPMailer;
use \common\PHPMailer\Exception;
class Library{


    function __construct(){

        global $tpl,$db,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->dev = $dev;
        $this->cfg = $this->getConfig();
        $this->segment = explode('/',$_SERVER['PHP_SELF']);
        $this->sess = $_SESSION['sess'];

    }


    #클래스 구하기
    function getClass($controller,$custom){

        $controller_file = str_replace('\\','/',$controller).".php";
        $custom_file = str_replace('\\','/',$custom).".php";

        if(file_exists($custom_file)){
            $class = new $custom;
        }elseif($controller_file){
            $class = new $controller;
        }else{
            $this->err404($custom." 또는 ".$controller." 클래스를 찾을 수 없습니다.");
        }


        return $class;
    }


    #에러404
    function err404($msg){
        require_once 'data/skin/error/error404.htm';
        exit;
    }


    # 설정가져오기
    function getConfig(){

        $query = "select * from ".$this->db->tables['config']." where 1";
        $res = $this->db->query($query);
        while($row = $this->db->fetch($res)){
            $data[$row['code']] = $row['data'];
        }

        if(file_exists('favicon.ico')){
            $data['favicon'] = 'y';
        }

        return $data;

    }



    #이동
    function go($url){
        echo "<script>location.href='".$url."';</script>";
    }


    #부모창이동
    function parentGo($url){
        echo "<script>top.location.href='".$url."';</script>";
    }

    #부모창이동
    function parentReload(){
        echo "<script>top.location.reload();</script>";
    }

    #알림
    function alert($text){
        echo "<script>alert('".$text."');</script>";
    }


    #이메일체크
    function emailCheck($temp_email) {
    	return preg_match("/^[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)*@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)+$/", $temp_email);
    }

    #xml to array
    function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

        return $out;
    }




    #라이센스
    function license(){

        if(!$_COOKIE['work6license']){

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

                setcookie('work6license',$post['host'],time()+(60*60*24));
            }

        }

    }



    #datetime to date
    function datetimeToDate($datetime){
        return substr($datetime,0,10);
    }


    #send email
    function sendEmail($to_name,$to_email,$subject,$content,$file=null){

        $mail = new PHPMailer(true);

    	$from_name = $this->cfg['site_name'];
    	$from_email = $this->cfg['site_email'];

    	switch($this->cfg['email_server']){
    		case 'stmp':
                //Server settings
                //$mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host = $this->cfg['site_stmp_server'];
                $mail->SMTPAuth = true;
                $mail->Username = $this->cfg['site_stmp_id'];
                $mail->Password = base64_decode($this->cfg['site_stmp_pw']);
                $mail->SMTPSecure = $this->cfg['email_secure'];
                $mail->Port = $this->cfg['site_stmp_port'];

                //Recipients
                $mail->setFrom($from_email, $from_name);
                $mail->addAddress($to_email, $to_name);

    			break;
    		case 'server':
    			$mail->isMail();
    			break;
    	}

    	//첨부파일 세팅
    	if($file['tmp_name']!=''){
            $mail->addAttachment($file['tmp_name'],$file['name']);         // Add attachments
    	}




        try {

            //Content
            $mail->CharSet    = 'UTF-8';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;


            $mail->send();

            return true;
        } catch (Exception $e) {
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            return false;
        }


    }



    #무작위문자(랜덤문자)
    function getRandomString($len = 10, $type = '') {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeric = '0123456789';
        $special = '~!@#$%^&*()-_=+\\|[{]}:\,<.>/?';
        $key = '';
        $token = '';
        if ($type == '') {
            $key = $lowercase.$uppercase.$numeric;
        } else {
            if (strpos($type,'09') > -1) $key .= $numeric;
            if (strpos($type,'az') > -1) $key .= $lowercase;
            if (strpos($type,'AZ') > -1) $key .= $uppercase;
            if (strpos($type,'$') > -1) $key .= $special;
        }
        for ($i = 0; $i < $len; $i++) {
            $token .= $key[mt_rand(0, strlen($key) - 1)];
        }
        return $token;
    }




    #date ago (max:week)
    function dateAgo($data){

        $ori_data = $data;
        $data = strtotime($data);
        $today = time();
        $hour = 60*60;
        $day = $hour*24;

        $diff = abs($today-$data);



        if($diff<$day && $diff>$hour){
            $res = floor($diff/$hour).' 시간 전';
        }elseif($diff<$hour){
            $res = floor($diff/60).' 분 전';
        }else{
            $res = $ori_data;
        }


        return $res;

    }



    # https로 전환
    function chk_https(){
        if($_SERVER['HTTP_X_FORWARDED_PROTO']=='http'){
            header("location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
    }


    # http로 전환
    function chk_http(){
        if($_SERVER['HTTP_X_FORWARDED_PROTO']!='http'){
            header("location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
    }



    # 날짜 사이 기간 구하기
    function datePeriod($start_day,$end_day){

        $begin = new \DateTime($start_day);
        $end = new \DateTime($end_day);
        $end = $end->modify( '+1 day' );

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$end);

        foreach($daterange as $date){
            $result['day'][] = $date->format("Y-m-d");
            $result['week'][] = date('w',strtotime($date->format("Y-m-d")));
            $result['month'][] = substr($date->format("Y-m-d"),0,7);
        }

        if($result['month']) $result['month'] = array_unique($result['month']);

        return $result;
    }

}
