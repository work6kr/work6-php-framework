<?
namespace common;
use common;
class AdminLibrary extends common\Template{


    function __construct(){

        global $tpl,$db,$lib,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->lib = $lib;
        $this->dev = $dev;

        $this->lib->cfg['front_skin'] = $this->lib->cfg['skin'];
        $this->lib->cfg['skin'] = 'admin';
        $this->lib->cfg['super_admin'] = 9999;

        $this->define('header', $this->lib->cfg['skin'].'/_header.htm');
		$this->define('footer', $this->lib->cfg['skin'].'/_footer.htm');
        $this->define('popup_header', $this->lib->cfg['skin'].'/_header_popup.htm');
		$this->define('popup_footer', $this->lib->cfg['skin'].'/_footer_popup.htm');



        if(!$this->lib->sess){
            $this->lib->go('/admin/login');
        }else{

            $query = "select count(*) from ".$this->db->tables['member']." as a left join ".$this->db->tables['level']." as b on a.level=b.level where a.uid='".$this->lib->sess['uid']."' and admin_permision='y'";

            list($cnt) = $this->db->fetch($query);

            if($cnt==1){
                $this->admin_menu = $this->getAdminMenu();
            }else{
                $this->lib->alert("접근 권한이 없습니다.");
                $this->lib->parentGo("/");
            }
            
        }


    }



    function allAdminMenu(){

        $admin_menu[0][0] = array('설정','<i class="fas fa-cog"></i>');
        $admin_menu[1][0] = array('직원','<i class="fa fa-user"></i>');
        $admin_menu[9][0] = array('도움말','<i class="fa fa-info"></i>');

        $admin_menu[0][1] = array('일반','/admin/conf/general');
        $admin_menu[0][3] = array('메일서버','/admin/conf/mailServer');
        $admin_menu[0][2] = array('공지','/admin/notice/notices');

        $admin_menu[1][1] = array('직원등급','/admin/member/groups');
        $admin_menu[1][2] = array('직원리스트','/admin/member/users');

        $admin_menu[9][1] = array('프로그램 정보','/admin/help/info');


        $custom = 'custom/conf/menu.php';
        if(file_exists($custom)){
            include $custom;
        }

        ksort($admin_menu);

        return $admin_menu;
    }



    function getAdminMenu(){

        $admin_menu = $this->allAdminMenu();


        if($this->lib->sess['level']<$this->lib->cfg['super_admin']){

            $query = "select admin_menu_permit from ".$this->db->tables['level']." where level='".$this->lib->sess['level']."' and admin_permision='y'";
            list($admin_menu_permit) = $this->db->fetch($query);

            $admin_menu_permit = explode(',',$admin_menu_permit);



            foreach($admin_menu as $k=>$v){
                foreach($v as $k2 => $v2){

                    if(in_array($v2[1],$admin_menu_permit)){
                        if(!$redefinition[$k][0]) $redefinition[$k][0] = $admin_menu[$k][0];
                        $redefinition[$k][$k2] = $v2;
                    }

                }
            }

            return $redefinition;

        }else{

            return $admin_menu;


        }



    }


}
