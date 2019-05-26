<?
namespace controller\admin;
use common;
class Help extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

        //고정
        $this->lib->cfg['skin']='admin';

    }


    function info(){

        $tpl = $this->lib->cfg['skin'].'/info.htm';

        $data['core_version'] = '3.5';
        $data['solution_version'] = '1.1';
        $data['maker'] = '워크식스';
        $data['homepage'] = 'https://work6.kr';
        $data['dev_guide'] = 'https://work6.kr/framework';

        $this->define('tpl', $tpl);
		$this->assign(array('data'=>$data,'cfg'=>$this->lib->cfg,'sess'=>$this->lib->sess));
		$this->print_('tpl');
    }



}
