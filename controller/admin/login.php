<?
namespace controller\admin;
use common;
use model\admin\Login as LoginModel;
use common\Security as Security;
class Login extends common\Template{

    function __construct(){

        global $lib,$cfg,$dev,$segment,$db;

        $this->lib = $lib;
        $this->db = $db;
        $this->cfg = $cfg;
        $this->dev = $dev;
        $this->segment = $segment;

        $this->model = new LoginModel;
        $this->security = new Security;



        if(!$this->lib->segment[4]){


            if($this->lib->sess['level']>=9000){
                $this->lib->alert('로그인 중 입니다.');
                $this->lib->go('/admin/main');
                exit;
            }

            if($_COOKIE['svi']){
                $data['uid'] = base64_decode($_COOKIE['svi']);
                $data['checked']['saveid']='checked';
            }


            $this->cfg['skin'] = 'admin';


            $tpl = $this->cfg['skin'].'/login.htm';


            $this->define('header', $this->cfg['skin'].'/_header_popup.htm');
    		$this->define('footer', $this->cfg['skin'].'/_footer_popup.htm');


            $this->define('tpl', $tpl);
    		$this->assign(array('data'=>$data,'cfg'=>$this->cfg));
    		$this->print_('tpl');

        }


    }


    #로그인 검증
    function chk(){

        $this->security->csrf();

        if($this->lib->sess['level']>=9000){
            $this->lib->alert('로그인 중 입니다.');
            exit;
        }



        if(!$_POST['uid']){
            $this->lib->alert('이메일을 입력해 주세요.');
            $this->lib->go('/blank.php');
            exit;
        }

        if(!$_POST['upw']){
            $this->lib->alert('패스워드를 입력해 주세요.');
            $this->lib->go('/blank.php');
            exit;
        }

        if($_POST['saveid']=='y'){
            setcookie('svi', base64_encode($_POST['uid']), time() + 86400 * 30);
        }else{
            setcookie('svi', '', time());
        }



        if($_POST['uid'] && $_POST['upw']){

            $escapedata = $this->db->escape($_POST);
            $data = $this->model->chkUser($escapedata);

            if($data['idx']!=''){

                $this->model->updateLoginDate($data['idx'],$_SERVER['REMOTE_ADDR']);

                $_SESSION['sess'] = $data;

                $this->model->insertLog($data['idx'],$_SERVER['REMOTE_ADDR']);

                if($_POST['return_url']!=""){
                    $this->lib->parentGo($_POST['return_url']);
                }else{
                    $this->lib->parentGo('/admin/main');
                }

            }else{
                $this->lib->alert("존재하지 않는 계정입니다.");
                $this->lib->go('/blank.php');
            }

        }


    }



    #logout
    function out(){

        session_destroy();

        if($_GET['return']) $this->lib->go($_GET['return']);
        $this->lib->go('/');

    }


}
