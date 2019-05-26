<?
namespace model\admin;
use common;
class Member extends common\Library{

    function __construct(){

        parent::__construct();


    }


    function getAllLevel(){

        $query = "select * from ".$this->db->tables['level']." where level!='".$this->cfg['super_admin']."' order by level asc";
        $res = $this->db->query($query);
        while($row = $this->db->fetch($res)){
            $data[] = $row;
        }

        return $data;
    }



    function getGroupList($get){

        $where[] = "level!='".$this->cfg['super_admin']."'";

        if($get['skey'] && $get['stxt']!=''){
            $where[] = $get['skey']." like '%".$get['stxt']."%'";
        }


        $page = new common\Page($get['page'],$get['row']);
        $page->setQuery($this->db->tables['level'],'*',$where,'order by level desc');
        $res = $this->db->query($page->query);
        while($row = $this->db->fetch($res)){
            $row['admin_permision'] = ($row['admin_permision']=='y')?'Y':'N';
            $row['insdt'] = $this->datetimeToDate($row['insdt']);
            $row['moddt'] = $this->datetimeToDate($row['moddt']);
            $result[] = $row;
        }

        return $result;
    }


    function deleteGroup($idx){
        $query = "delete from ".$this->db->tables['level']." where idx='".$idx."'";
        return $this->db->query($query);
    }


    function getGroupName($idx){
        $query = "select level,name from ".$this->db->tables['level']." where idx='".$idx."'";
        return $this->db->fetch($query);
    }


    function getGroupCount($level){
        $query = "select count(*) from ".$this->db->tables['member']." where level='".$level."'";
        return $this->db->fetch($query);
    }



    function getId($idx){
        $query = "select uid,name from ".$this->db->tables['member']." where idx='".$idx."'";
        return $this->db->fetch($query);
    }


    function updatePassword($idx,$new_password){
        $query = "update ".$this->db->tables['member']." set upw=password('".$new_password."'), moddt=now() where idx='".$idx."'";
        return $this->db->query($query);
    }


    function getGroupData($idx){
        $query = "select * from ".$this->db->tables['level']." where idx='".$idx."'";
        return $this->db->fetch($query);
    }



    function chkInsertGroupOverlap($level){
        $query =  "select count(*) from ".$this->db->tables['level']." where level='".$level."'";
        return $this->db->fetch($query);
    }


    function chkUpdateGroupOverlap($level,$idx){
        $query = "select count(*) from ".$this->db->tables['level']." where level='".$level."' and idx!='".$idx."'";
        return $this->db->fetch($query);
    }



    function insertGroup($post){
        $query = "insert into ".$this->db->tables['level']." set level='".$post['level']."', name='".$post['name']."',  admin_permision='".$post['admin_permision']."', admin_menu_permit='".implode(',',$post['admin_menu_permit'])."', insdt=now()";
        return $this->db->query($query);
    }


    function updateGroup($post,$idx){
        $query = "update ".$this->db->tables['level']." set level='".$post['level']."', name='".$post['name']."',  admin_permision='".$post['admin_permision']."', admin_menu_permit='".implode(',',$post['admin_menu_permit'])."', moddt=now() where idx='".$idx."'";
        return $this->db->query($query);
    }


    function updateProfile($name,$photo,$idx){
        $query = "update ".$this->db->tables['member']." set name='".$name."',photo='".$photo."',moddt=now() where idx='".$idx."'";
        return $this->db->query($query);
    }


    function deleteUser($idx){
        $query = "delete from ".$this->db->tables['member']." where idx='".$idx."'";
        return $this->db->query($query);
    }


    function getUserList($get){
        $where[] = "a.level!='".$this->cfg['super_admin']."'";

        if($get['skey'] && $get['stxt']!=''){
            $where[] = "a.".$get['skey']." like '%".$get['stxt']."%'";
        }


        $page = new common\Page($get['page'],$get['row']);
        $page->setQuery($this->db->tables['member']." as a left join ".$this->db->tables['level']." as b on a.level = b.level",'a.*, b.name as level_name',$where,'order by a.idx desc');
        $res = $this->db->query($page->query);
        while($row = $this->db->fetch($res)){
            $row['insdt'] = $this->datetimeToDate($row['insdt']);
            $row['moddt'] = $this->datetimeToDate($row['moddt']);
            $result[] = $row;
        }

        return $result;
    }



    function chkEmailOverlap($uid){
        $query = "select count(*) from ".$this->db->tables['member']." where uid='".$uid."'";
        return $this->db->fetch($query);
    }


    function insertUser($post){
        $query = "insert into ".$this->db->tables['member']." set uid='".$post['uid']."', level='".$post['level']."', name='".$post['name']."', mobile='".$post['mobile']."', upw=password('".$post['upw'][0]."'), team='".$post['team']."', insdt=now()";
        return $this->db->query($query);
    }


    function updateUser($post,$idx){
        $query = "update ".$this->db->tables['member']." set level='".$post['level']."', name='".$post['name']."', mobile='".$post['mobile']."', team='".$post['team']."', moddt=now() where idx='".$idx."'";
        return $this->db->query($query);
    }


    function getUserData($idx){
        $query = "select * from ".$this->db->tables['member']." where idx='".$idx."'";
        return $this->db->fetch($query);
    }


    

}
