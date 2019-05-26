<?
namespace model\admin;
use common;
class Main extends common\Library{

    function __construct(){

        parent::__construct();


    }

    function getNoticeList(){
        $query = "select a.*,b.name from ".$this->db->tables['notice']." as a left join ".$this->db->tables['member']." as b on a.member_idx=b.idx where 1 order by a.idx desc limit 3";
        $res = $this->db->query($query);
        while($row = $this->db->fetch($res)){
            $row['contents'] = nl2br($row['contents']);
            $row['insdt'] = $this->dateAgo($row['insdt']);
            $result[] = $row;
        }

        return $result;
    }


    function getLoginLogList(){
        $query = "select a.*,b.name as member_name from ".$this->db->tables['log_login']." as a left join ".$this->db->tables['member']." as b on a.member_idx=b.idx where 1 order by a.idx desc limit 6";
        $res = $this->db->query($query);
        while($row = $this->db->fetch($res)){
            $row['logindt'] = $this->dateAgo($row['logindt']);
            $result[] = $row;
        }

        return $result;
    }

}
