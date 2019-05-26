<?
namespace controller\admin;
use common;
use common\FileUpload as FileUpload;
use model\admin\Member as MemberModel;
class Member extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

        $this->model = new MemberModel;
        $this->fileupload = new FileUpload();

    }


    function allLevel(){
        return $this->model->getAllLevel();
    }


    function sendNewPassword(){

        list($email,$name) = $this->model->getId($_POST['idx']);

        $new_password = $this->lib->getRandomString(8,'09azAZ');

        $this->model->updatePassword($_POST['idx'],$new_password);


        $subject = "[".$this->lib->cfg['site_name']."] 패스워드가 변경되었습니다.";
        $content = "안녕하세요. ".$this->lib->cfg['site_name']."입니다.<br/>".$name." 님의 패스워드가 변경되었습니다.<br/>임시패스워드 : ".$new_password;

        $res = $this->lib->sendEmail($name,$email,$subject,$content);

        echo $res;
    }



    function groups(){


        #선택 삭제
        if($this->lib->segment[5]=='delete'){

            if(!$_POST){
                $this->lib->error404();
                exit;
            }

            //잔여직원이 있는지 체크
            foreach($_POST as $v){


                list($level,$level_name) = $this->model->getGroupName($v['idx']);

                list($cnt) = $this->model->getGroupCount($level);


                if($cnt>0){
                    $this->lib->alert($level_name.' 등급에 직원이 있어서 삭제할 수 없습니다.');
                    exit;
                }
            }


            foreach($_POST['idx'] as $v){
                $this->model->deleteGroup($v);
            }

            $this->lib->parentReload();

            exit;
        }




        #select
        $tpl = $this->lib->cfg['skin'].'/groups.htm';

        $data['selected']['skey'][$_GET['skey']] = 'selected';
        $data['selected']['row'][$_GET['row']] = 'selected';


        $data['list'] = $this->model->getGroupList($_GET);


		$this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess,'page'=>$page));
		$this->print_('tpl');

    }



    function group(){

        $tpl = $this->lib->cfg['skin'].'/group.htm';

        $idx = $this->lib->segment[5];


        #register form
        if(!$idx){

            $this->lib->segment[5] = 'post';

            $data['admin_menu'] = $this->allAdminMenu();


            $this->define('tpl', $tpl);
    		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
    		$this->print_('tpl');

            exit;
        }





        #update && insert
        if($_POST){

            if(!$_POST['name']){
                $this->lib->alert('등급명을 입력해주세요.');
                exit;
            }


            if(!$_POST['level']){
                $this->lib->alert('등급을 입력해주세요.');
                exit;
            }

            if($_POST['level']>$this->lib->cfg['super_admin']){
                $this->lib->alert('등급은 '.($this->lib->cfg['super_admin']-1).' 이하 숫자를 입력해주세요.');
                exit;
            }
            $_POST['admin_permision'] = (!$_POST['admin_permision'])?'n':'y';




            #겹치는 등급이 있는지 검사
            if($idx=='post'){ //insert
                list($cnt) = $this->model->chkInsertGroupOverlap($_POST['level']);
            }else{ //update
                list($cnt) = $this->model->chkUpdateGroupOverlap($_POST['level'],$idx);
            }


            if($cnt>0){
                $this->lib->alert($_POST['level'].'는 이미 사용중인 등급 입니다.');
                exit;
            }




            if($idx=='post'){ //insert
                $this->model->insertGroup($_POST);
            }else{ //update
                $this->model->updateGroup($_POST,$idx);
            }



            $this->lib->parentGo('/admin/member/groups');


            exit;
        }




        #select
        $data = $this->model->getGroupData($idx);


        $data['admin_menu_permit'] = explode(',',$data['admin_menu_permit']);

        $data['admin_menu'] = $this->allAdminMenu();

        foreach($data['admin_menu'] as $k=>$v){
            foreach($v as $k2=>$v2){
                if(in_array($v2[1],$data['admin_menu_permit'])){
                    $data['admin_menu'][$k][$k2][2] = 'checked';
                }
            }
        }



        if($data['admin_permision']=='y'){
            $data['checked']['admin_permision']['y'] = 'checked';
        }


        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');

    }


    function profile(){

        $upload_path = './data/skin/'.$this->lib->cfg['skin'].'/img/admin_photo';

        if($this->lib->sess['idx']!=$this->lib->segment[5]){
            $this->lib->err404();
        }



        if($_POST){

            if($_POST['name']=='' || !$_POST['name']){
                $this->lib->alert('이름을 입력해 주세요.');
                exit;
            }

            if($_POST['password_change']=='y'){
                if($_POST['new_upw'][0]!=$_POST['new_upw'][1]){
                    $this->lib->alert('새 비밀번호와 새 비밀번호 확인이 다릅니다.');
                    exit;
                }

                if(!$_POST['new_upw'][0]){
                    $this->lib->alert('새 비밀번호를 작성해 주세요.');
                    exit;
                }

                if(!$_POST['new_upw'][1]){
                    $this->lib->alert('새 비밀번호 확인을 작성해 주세요.');
                    exit;
                }
            }




            $photo = $_POST['ori_photo'];

            if($_POST['photo_del']=='y'){
                unlink($upload_path.'/'.$photo);
                $photo = '';
            }

            if($_FILES['photo']['tmp_name']){
                $photo = $this->fileupload->upload($_FILES['photo'],$upload_path);
            }


            $this->model->updateProfile($_POST['name'],$photo,$this->lib->sess['idx']);


            if($_POST['password_change']=='y'){
                $this->model->updatePassword($this->lib->sess['idx'],$_POST['new_upw'][0]);
            }

            $this->lib->alert('다시 로그인해 주세요.');
            $this->lib->parentGo('/admin/login/out');


        }


        $tpl = $this->lib->cfg['skin'].'/profile.htm';

        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');


    }





    function users(){

        $tpl = $this->lib->cfg['skin'].'/users.htm';
        $idx = $this->lib->segment[5];

        #선택 삭제
        if($idx=='delete'){

            if(!$_POST){
                $this->lib->error404();
                exit;
            }

            foreach($_POST['idx'] as $v){
                $this->model->deleteUser($v);
            }

            $this->lib->parentReload();

            exit;
        }


        #select
        $data['selected']['skey'][$_GET['skey']] = 'selected';
        $data['selected']['row'][$_GET['row']] = 'selected';


        $data['list'] = $this->model->getUserList($_GET);

        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');

    }




    function user(){

        $tpl = $this->lib->cfg['skin'].'/user.htm';

        $idx = $this->lib->segment[5];


        $data['level_list'] = $this->allLevel();


        #register form
        if(!$idx){

            $data['idx'] = 'post';

            $this->define('tpl', $tpl);
    		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
    		$this->print_('tpl');

            exit;
        }


        #update && insert
        if($_POST){

            if($idx=='post'){ //insert

                #유효성체크
                if(!$_POST['uid']){
                    $this->lib->alert('이메일을 입력해 주세요.');
                    exit;
                }

                if(!$this->lib->emailCheck($_POST['uid'])){
                    $this->lib->alert($_POST['uid'].' 은 정상적인 이메일 주소가 아닙니다.');
                    exit;
                }

                if(!$_POST['name']){
                    $this->lib->alert('이름을 입력해 주세요.');
                    exit;
                }


                if(!($_POST['upw'][0] && $_POST['upw'][1])){
                    $this->lib->alert('패스워드를 입력해 주세요.');
                    exit;
                }


                #중복이메일체크
                list($cnt) = $this->model->chkEmailOverlap($_POST['uid']);

                if($cnt>0){
                    $this->lib->alert($_POST['uid'].' 은 이미 등록된 이메일 입니다.');
                    exit;
                }


                #패스워드체크
                if($_POST['upw'][0] != $_POST['upw'][1]){
                    $this->lib->alert('패스워드와 패스워드 확인이 다릅니다.\n다시 입력해 주세요.');
                    exit;
                }

                $query = $this->model->insertUser($_POST);


            }else{ //update
                $query = $this->model->updateUser($_POST,$idx);


            }


            $this->lib->parentGo('/admin/member/users');


            exit;
        }




        #select
        $tmp['level_list'] = $data['level_list'];
        $data = $this->model->getUserData($idx);

        $data['level_list'] = $tmp['level_list'];


        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');
    }


}
