<?
namespace common;
class DBLibrary extends \mysqli{

    function __construct() {

        if(!file_exists($_SERVER[DOCUMENT_ROOT]."/common/db.php")){
            Library::debug('Not find DB configuration file.');
            exit;
        }else{

            include $_SERVER[DOCUMENT_ROOT]."/common/db.php";

            parent::__construct($dbinfo['host'],$dbinfo['dbid'],base64_decode($dbinfo['dbpw']),$dbinfo['dbnm']);


            if ($this->connect_error) {
                Library::debug($this->connect_error);
                exit;
            }


            $table['config']    ='w_config';
            $table['member']    ='w_member';
            $table['level']     ='w_level';
            $table['log_login'] ='w_log_login';
            $table['notice'] ='w_notice';

            $custom = 'custom/conf/tables.php';
            if(file_exists($custom)){
                include $custom;
            }

            $this->tables = $table;

        }

    }


	function query($query){
		return @parent::query($query);
	}

	function fetch($res){
		if(is_string($res)) $res = $this->query($res);
		if($res) return @$res->fetch_array();
	}


	function rows($res){
		if(is_string($res)) $res = $this->query($res);
		return @$res->num_rows;
	}

	function last(){
		return @$this->insert_id;
	}


	function escape($data){
		$data = $this->stripslashes_deep($data);
		$data = $this->mysql_real_escape_string_deep($data);

		return $data;
	}

	function stripslashes_deep($var){
		$var = is_array($var)?array_map(array($this,'stripslashes_deep'), $var) :stripslashes($var);
		return $var;
	}

	function mysql_real_escape_string_deep($var){
		$var = is_array($var)?array_map(array($this,'mysql_real_escape_string_deep'), $var):$this->real_escape_string($var);
		return $var;
	}
}
