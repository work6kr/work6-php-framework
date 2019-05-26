<?
namespace model\admin;
use common;
class Conf extends common\Library{

    function __construct(){

        parent::__construct();


    }



    function update($data,$code){
        $query = "update ".$this->db->tables['config']." set data='".$data."' where code='".$code."'";
        return $this->db->query($query);
    }


}
