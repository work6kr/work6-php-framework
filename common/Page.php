<?
namespace common;
class Page{

    public $query,$totalquery,$totalrow,$totalpage,$totalpagerow,$pagerow=5,$nowpage,$row,$firstpage,$lastpage,$page,$page_front,$number;

    function __construct($nowpage=1,$row = 10){

        global $tpl,$db,$lib,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->lib = $lib;
        $this->dev = $dev;

        $this->nowpage = (!$nowpage)?1:$nowpage;
		$this->row = (!$row)?10:$row;

    }


	function setQuery($table,$feild,$where=array(),$etc=''){

        if(!$feild)$feild='*';

		$query = "select ".$feild." from ".$table;
		if(count($where)>0) $query .= " where ".implode(' and ',$where);
		if($etc!='') $query .= " ".$etc;

		$this->totalrow = $this->db->rows($query);

		$this->totalpage = ceil($this->totalrow/$this->row);

		$this->totalpagerow = ceil($this->totalpage/$this->pagerow);


		$this->lastpage = $this->nowpage*$this->row;

		$this->firstpage = $this->lastpage-($this->row-1);


		if($this->totalpage<$this->lastpage){
			$this->lastpage = $this->totalpage;
		}

		$this->totalquery = $query;

		$this->query .= $query." limit ".($this->firstpage-1).",".$this->row;

		$this->number = $this->totalrow-(($this->nowpage-1)*$this->row);

		$this->makehref();
		$this->makehrefFront();
	}


	function makehref(){

		$grp = ceil($this->nowpage/$this->pagerow);
		$last = $grp*$this->pagerow;
		$fist = $last-$this->pagerow+1;
		$get = '';
		$getdata = $_GET;
		$php_self = str_replace('/index.php','',$_SERVER['PHP_SELF']);

		unset($getdata['page']);

        foreach($getdata as $k=>$v){
			if($v!=''){
                if(is_array($v)){
                    foreach($v as $v2){
                        $get .= '&'.$k.'[]='.$v2;
                    }
                }else{
                    $get .= '&'.$k.'='.$v;
                }
            }
		}


		if($this->totalpage<$last){
			$last = $this->totalpage;
		}


		if($grp!=1 && $grp<=$this->totalpagerow){
            $html[] = "<li class='paginate_button previous'><a href='".$php_self."?page=".($fist-1).$get."'>이전</a></li>";
		}

		for($i=$fist; $i<($last+1); $i++){
			if($this->nowpage==$i){
                $html[] = "<li class='paginate_button active'><a>".$i."</a></li>";
			}else{
                $html[] = "<li class='paginate_button'><a href='".$php_self."?page=".$i.$get."'>".$i."</a></li>";
			}
		}


		if($grp<$this->totalpagerow){
            $html[] = "<li class='paginate_button next'><a href='".$php_self."?page=".($last+1).$get."'>다음</a></li>";
		}

		if($html){
			$this->page = implode('',$html);
		}
	}


	function makehrefFront(){

        $grp = ceil($this->nowpage/$this->pagerow);
		$last = $grp*$this->pagerow;
		$fist = $last-$this->pagerow+1;
		$get = '';
		$getdata = $_GET;
		$php_self = str_replace('/index.php','',$_SERVER['PHP_SELF']);

		unset($getdata['page']);

        foreach($getdata as $k=>$v){
			if($v!=''){
                if(is_array($v)){
                    foreach($v as $v2){
                        $get .= '&'.$k.'[]='.$v2;
                    }
                }else{
                    $get .= '&'.$k.'='.$v;
                }
            }
		}


		if($this->totalpage<$last){
			$last = $this->totalpage;
		}


		if($grp!=1 && $grp<=$this->totalpagerow){
            $html[] = "<li class='paginate_button previous'><a href='".$php_self."?page=".($fist-1).$get."'>이전</a></li>";
		}

		for($i=$fist; $i<($last+1); $i++){
			if($this->nowpage==$i){
                $html[] = "<li class='paginate_button active'><a>".$i."</a></li>";
			}else{
                $html[] = "<li class='paginate_button'><a href='".$php_self."?page=".$i.$get."'>".$i."</a></li>";
			}
		}


		if($grp<$this->totalpagerow){
            $html[] = "<li class='paginate_button next'><a href='".$php_self."?page=".($last+1).$get."'>다음</a></li>";
		}

		if($html){
			$this->page = implode('',$html);
		}

	}

}
