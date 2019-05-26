<?
namespace model\admin;
use common;
class Login extends common\Library{

    function __construct(){

        parent::__construct();


    }

    function chkUser($escapedata){
        
        $query = "select a.idx,a.uid,a.level,a.name,a.photo,b.name as level_name from ".$this->db->tables['member']." as a left join ".$this->db->tables['level']." as b on a.level=b.level where a.uid='".$escapedata['uid']."' and a.upw=PASSWORD('".$escapedata['upw']."') and admin_permision='y'";
        $result = $this->db->fetch($query);

        return $result;
    }


    function insertLog($idx,$ip){
        $query = "insert into ".$this->db->tables['log_login']." set member_idx='".$idx."', logindt=now(), ip='".$ip."'";
        $this->db->query($query);
    }


    function updateLoginDate($idx,$ip){
        $this->db->query("update ".$this->db->tables['member']." set logindt=now(),ip='".$ip."' where idx='".$idx."'");
    }

}
