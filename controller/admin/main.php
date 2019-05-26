<?
namespace controller\admin;
use common;
use model\admin\Main as MainrModel;
class Main extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

        $this->model = new MainrModel;

	    if(!$this->lib->segment[4]) $this->index_();
    }


    function index_(){

        $this->lib->license();

        $tpl = $this->lib->cfg['skin'].'/main.htm';


        #공지
        $data['notice'] = $this->model->getNoticeList();



        #최근접속
        $data['log_login'] = $this->model->getLoginLogList();
        



		$this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');


    }


}
