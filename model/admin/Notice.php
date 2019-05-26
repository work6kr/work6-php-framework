<?
namespace model\admin;
use common;
class Notice extends common\Library{

    function __construct(){

        parent::__construct();


    }

    function getFile($idx){
        $query = "select file from ".$this->db->tables['notice']." where idx='".$idx."'";
        list($file) = $this->db->fetch($query);
        return $file;
    }


    function delete($idx){
        $query = "delete from ".$this->db->tables['notice']." where idx='".$idx."'";
        return $this->db->query($query);
    }


    function getList($get){

        if($get['skey'] && $get['stxt']!=''){
            if($get['skey']=='name'){
                $where[] = "b.".$get['skey']." like '%".$get['stxt']."%'";
            }else{
                $where[] = "a.".$get['skey']." like '%".$get['stxt']."%'";
            }

        }

        $page = new common\Page($get['page'],$get['row']);
        $page->setQuery($this->db->tables['notice']." as a left join ".$this->db->tables['member']." as b on a.member_idx = b.idx",'a.*, b.name',$where,'order by a.idx desc');
        $res = $this->db->query($page->query);
        while($row = $this->db->fetch($res)){
            $row['insdt'] = $this->datetimeToDate($row['insdt']);
            $row['moddt'] = $this->datetimeToDate($row['moddt']);
            $result[] = $row;
        }

        return $result;

    }


    function getData($idx){
        $query = "select * from ".$this->db->tables['notice']." where idx='".$idx."'";
        return $this->db->fetch($query);
    }


    function insertQuery($post,$file){
        $query = "insert into ".$this->db->tables['notice']." set member_idx='".$post['member_idx']."', subject='".addslashes($post['subject'])."', contents='".addslashes($post['contents'])."', file='".$file."', insdt=now()";
        return $query;
    }


    function updateQuery($post,$file,$idx){
        $query = "update ".$this->db->tables['notice']." set member_idx='".$post['member_idx']."', subject='".addslashes($post['subject'])."', contents='".addslashes($post['contents'])."', file='".$file."',moddt=now() where idx='".$idx."'";
        return $query;
    }


}
