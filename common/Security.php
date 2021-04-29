<?
namespace common;
class Security{

    function __construct(){

        global $tpl,$db,$lib,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->lib = $lib;
        $this->dev = $dev;

        $this->exception_tag = '<br><p>';

    }

    //xss shild
    function xss($data){

        if(is_array($data)){
            foreach($data as $k=>$v){

                if(is_array($v)){
                    $data[$k] = $this->xss_deep($v);
                }else{
                    $data[$k] = strip_tags($v,$this->exception_tag);
                }
            }
        }else{
            $data = strip_tags($data,$this->exception_tag);
        }

        return $data;
    }



    function xss_deep($var){
		$var = is_array($var)?array_map(array($this,'xss_deep'), $var) :strip_tags($var,$this->exception_tag);
		return $var;
	}


    function csrf(){

        $parse = parse_url($_SERVER['HTTP_REFERER']);
        if($parse['host']!=$_SERVER['HOST']){
            if($parse['host']!=$_SERVER['HTTP_HOST']){
                $this->lib->alert('잘못된 접근 입니다.');
                echo "<script>history.go(-1);</script>";
                exit;
            }
        }

    }

}
