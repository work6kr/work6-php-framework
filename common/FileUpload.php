<?
namespace common;
class FileUpload{

    private $exception_ext = array('inc','ini','php');

    function __construct(){

        global $tpl,$db,$lib,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->lib = $lib;
        $this->dev = $dev;

        $ini[] = ini_get('upload_max_filesize');
		$ini[] = ini_get('post_max_size');

		rsort($ini);

		$this->upload_max_filesize = $ini[0];

		umask(0);

    }

    function uploadMaxFilesize(){
		return $upload_max_filesize;
	}

	function makeFilenm($origin_name){

		$filenm = str_replace('.','',array_sum(explode(' ',microtime()))).'_'.$origin_name;

		return $filenm;
	}

	function upload($user_file,$upload_path,$filenm=''){

        $upload_path_arr = explode('/',$upload_path);

        foreach($upload_path_arr as $k=>$v){
            if($k==0){
                $tmp_path =$v;
            }else{
                $tmp_path .='/'.$v;
            }

            if(!is_dir($tmp_path)){
                mkdir($tmp_path,0777);
            }else{
                if(!is_writable($tmp_path)){
                    chmod($tmp_path,0777);
                }
            }
        }



		if($filenm=='') $filenm = $this->makeFilenm($user_file['name']);

		if($user_file['tmp_name']){

			$file_ext = explode('.',$user_file['name']);
			$file_ext = $file_ext[1];
			if(in_array($file_ext,$this->exception_ext)){ $this->lib->alert('허가된 파일 형식이 아닙니다.'); exit;}

			if(move_uploaded_file($user_file['tmp_name'],$upload_path.'/'.$filenm)){
				$result=$upload_path.$filenm;
				@chmod($result,0777);
			}else{
                $this->lib->alert('파일 업로드를 실패하였습니다.');
                exit;
            }
		}

		$result = $filenm;

		return $result;
	}

}
