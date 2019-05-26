<?
namespace controller\admin;
use common;
use common\FileUpload as FileUpload;
use model\admin\Conf as ConfModel;
class Conf extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

        $this->model = new ConfModel;
        $this->fileupload = new FileUpload();

    }


    function general(){

        $tpl = $this->lib->cfg['skin'].'/general.htm';


        #favicon
        if(file_exists('favicon.ico')){
            $data['favicon'] = 'y';
        }


        #or:image
        if(file_exists('ogimage.jpg')){
            $data['ogimage'] = 'y';
        }


        #robots.txt 파일 읽어오기
        if(file_exists('robots.txt')){
            $fp = fopen('robots.txt', "r");
            while(!feof($fp)){
               $buffer .= fgets($fp);
            }
            fclose($fp);
        }

        $data['robots'] = $buffer;


        $this->lib->cfg['ori_site_name'] = str_replace(' 관리','',$this->lib->cfg['site_name']);


		$this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');

    }


    #설정 업데이트
    function put(){

        $exception = array('favicon_del','ogimage_del','robots');
        $upload_path = '.';

        foreach($_POST as $k=>$v){
            if(!in_array($k,$exception)){
                $this->model->update($v,$k);
            }
        }


        if($_POST['favicon_del']=='y'){
            unlink('favicon.ico');
        }

        if($_POST['ogimage_del']=='y'){
            unlink('ogimage.jpg');
        }


        if($_FILES['favicon']['tmp_name']){
            $this->fileupload->upload($_FILES['favicon'],$upload_path,'favicon.ico');
        }

        if($_FILES['ogimage']['tmp_name']){
            $this->fileupload->upload($_FILES['ogimage'],$upload_path,'ogimage.jpg');
        }





        if (!is_writable('robots.txt')) {
            $this->lib->alert('파일 권한 문제로 robots.txt를 수정할 수 없습니다.\n개발자에게 문의 바랍니다.');
        }else{
            $fp = fopen('robots.txt', "w");
            $data = str_replace(array("\r\n","\r"),"\n",$_POST["robots"]);
            fwrite($fp, $data);
            fclose($fp);
        }




        $this->lib->alert('저장되었습니다.');
        $this->lib->parentGo('/admin/conf/general');
    }



    function notice(){

        $tpl = $this->lib->cfg['skin'].'/notice.htm';




		$this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');

    }



    function mailServer(){

        $tpl = $this->lib->cfg['skin'].'/mailserver.htm';


        if($_POST){

            foreach($_POST as $k=>$v){
                if($k=='site_stmp_pw'){
                    $v = base64_encode($v);
                }
                $this->model->update($v,$k);
                $this->db->query($query);
            }


            $this->lib->parentReload();
            exit;
        }


        $this->lib->cfg['site_stmp_pw'] = base64_decode($this->lib->cfg['site_stmp_pw']);


        $data['selected']['email_server'][$this->lib->cfg['email_server']]="selected";
        $data['selected']['email_secure'][$this->lib->cfg['email_secure']]="selected";


		$this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');

    }





}
