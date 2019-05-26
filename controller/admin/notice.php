<?
namespace controller\admin;
use common;
use common\FileUpload as FileUpload;
use model\admin\Notice as NoticeModel;
class Notice extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

        $this->model = new NoticeModel;
        $this->fileupload = new FileUpload();

    }

    function notices(){

        $tpl = $this->lib->cfg['skin'].'/notices.htm';
        $idx = $this->lib->segment[5];

        #선택 삭제
        if($idx=='delete'){

            if(!$_POST){
                $this->lib->error404();
                exit;
            }

            foreach($_POST['idx'] as $v){

                $file = $this->model->getFile($v);

                if($file){
                    unlink('./data/skin/'.$this->lib->cfg['skin'].'/file/'.$file);
                }

                $file = $this->model->delete($v);

            }

            $this->lib->parentReload();

            exit;
        }


        #select
        $data['idx'] = $idx;

        $data['selected']['skey'][$_GET['skey']] = 'selected';
        $data['selected']['row'][$_GET['row']] = 'selected';


        $data['list'] = $this->model->getList($_GET);


        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');
    }




    function notice(){


        $tpl = $this->lib->cfg['skin'].'/notice.htm';

        $idx = $this->lib->segment[5];



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

            $file = $_POST['ori_file'];
            $upload_path = './data/skin/'.$this->lib->cfg['skin'].'/file';

            if($_POST['file_del']=='y'){
                unlink('./data/skin/'.$this->lib->cfg['skin'].'/file/'.$_POST['ori_file']);
                $file='';
            }


            if($_FILES['file']['tmp_name']){
                $file = $this->fileupload->upload($_FILES['file'],$upload_path);
            }



            if($idx=='post'){ //insert

                #유효성체크
                if(!$_POST['subject']){
                    $this->lib->alert('제목을 입력해 주세요.');
                    exit;
                }

                if(!$_POST['contents']){
                    $this->lib->alert('내용을 입력해 주세요.');
                    exit;
                }

                $query = $this->model->insertQuery($_POST,$file);

            }else{ //update

                $query = $this->model->updateQuery($_POST,$file,$idx);

            }


            $this->db->query($query);
            $this->lib->parentGo('/admin/notice/notices');


            exit;
        }


        #select
        $data = $this->model->getData($idx);



        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');
    }


}
