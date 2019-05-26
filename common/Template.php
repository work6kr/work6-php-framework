<?php
// Template_ 2.2.7 2012-07-20 http://www.xtac.net Freeware - LGPL
namespace common;
class Template
{
	var $compile_check = true;
	var $compile_dir   = '_compile';
	var $compile_ext   = 'php';
	var $skin          = '';
	var $notice        = false;
	var $path_digest   = false;

	var $template_dir  = 'data/skin';
	var $prefilter     = '';
	var $postfilter    = '';
	var $permission    = 0777;
	var $safe_mode     = false;
	var $auto_constant = false;

	var $caching       = false;
	var $cache_dir     = '_cache';
	var $cache_expire  = 3600;

	var $scp_='';
	var $var_=array(''=>array());
	var $obj_=array();

	function define($arg, $path='')
	{
		if ($path) $this->_define($arg, $path);
		else foreach ($arg as $fid => $path) $this->_define($fid, $path);
	}
	function _define($fid, $path)
	{
		switch ($fid[0]) {
		case '!': $this->tpl_[substr($fid,1)]=array('txt', $path); break;
		case '>': $this->tpl_[substr($fid,1)]=array('php', $path); break;
		default : $this->tpl_[$fid]=array('tpl', $path);
		}
	}
	function assign($arg)
	{
		if (is_array($arg)) $var = array_merge($var=&$this->var_[$this->scp_], $arg);
		else $this->var_[$this->scp_][$arg] = func_get_arg(1);
	}
	function fetch($fid)
	{
		ob_start();
		$this->print_($fid);
		$fetch = ob_get_contents();
		ob_end_clean();
		return $fetch;
	}
	function print_($fid, $scope='', $sub=0)
	{
		if ($scope) $fid = $scope.'.'.$fid;
		if (!isset($this->tpl_[$fid])) $this->exit_('Error #2', 'template id <b>'.$fid.'</b> is not defined');
		$tpl=&$this->tpl_[$fid];
		if ($tpl[0]==='txt') {
			$this->_print_txt($this->_get_compile_path($tpl[1]));
			return;
		}
		if ($this->caching) {
			if ($this->isCached($fid)) {
				echo $this->_cache_info[$fid]['cont'];
				return;
			}
			if (isset($this->_is_cached[$fid])) {
				$cache=&$this->_cache_info[$fid];
				ob_start();
			}
		}
		if ($tpl[0]==='tpl') {
			$cpl_path=$this->_get_compile_path($tpl[1]);
			$tid = ($D=strrpos($fid,'.')) ? substr($fid, $D+1) : $fid;
			if (isset($this->var_[$fid])) $scope=$fid;
			if ($sub) {
				$this->_include_tpl($cpl_path, $tid, $scope);
			} else {
				$this->ebase=error_reporting();
				if ($this->notice) {
					error_reporting($this->ebase|E_NOTICE);
					set_error_handler('_template_notice_handler');
					$this->_include_tpl($cpl_path, $tid, $scope);
					restore_error_handler();
				} else {
					error_reporting($this->ebase&~E_NOTICE);
					$this->_include_tpl($cpl_path, $tid, $scope);
				}
				error_reporting($this->ebase);
			}
		} else {
			$this->_php_source=$tpl[1];
			if ($sub) {
				$this->etpl=error_reporting();
				error_reporting($this->ebase);
				if ($this->notice) {
					restore_error_handler();
					$this->_include_php();
					set_error_handler('_template_notice_handler');
				} else {
					$this->_include_php();
				}
				error_reporting($this->etpl);
			} else {
				$this->_include_php();
			}
		}
		if (isset($cache)) {
			$text=ob_get_contents();
			ob_end_flush();
			$this->_make_dir($cache['path']);
			$fp=fopen($cache['path'], 'wb');
			fwrite($fp, strlen($text).'-'.$cache['cid'].'*'.$text);
			fclose($fp);
			chmod($cache['path'], $this->permission&~0111);
			if ($cache['rid']) {
				$R1=$this->cache_dir.'/%clear/';
				$R2=$this->_get_clear_path($cache['cid']);
				if (is_array($cache['rid'])) foreach ($cache['rid'] as $R) $this->_touch_clear_id($R1.$R.$R2);
				else $this->_touch_clear_id($R1.$cache['rid'].$R2);
			}
		} elseif ($this->compile_check==='dev' && $this->caching && @is_dir($this->cache_dir)) {
			$path = $this->cache_dir.'/%cache'.$_SERVER['PHP_SELF'];
			$this->_rmdir($path, ini_get('safe_mode'));
		}
	}
	function new_($obj)
	{
		$class = 'tpl_object_'.strtolower($obj);
		if (!isset($this->obj_[$class])) {
			if (!class_exists($class, false)) include dirname(__file__).'/tpl_plugin/object.'.$obj.'.php';
			$n = func_num_args();
			if ($n>1) {
				for ($i=1; $i<$n; $i++) {
					$arg[$i]=func_get_arg($i);
					$args[]='$arg['.$i.']';
				}
				eval('$this->obj_[$class]=new $class('.implode(',',$args).');');
			} else {
				$this->obj_[$class]=new $class;
			}
		}
		return $this->obj_[$class];
	}
	function include_()
	{
		foreach (func_get_args() as $f) function_exists($f) or include dirname(__file__).'/tpl_plugin/function.'.$f.'.php';
	}
	function _include_tpl($TPL_CPL, $TPL_TPL, $TPL_SCP)
	{
		$TPL_VAR = &$this->var_[$TPL_SCP];
		if (false===include $TPL_CPL) exit;
	}
	function _include_php()
	{
		if (false===include $this->_php_source) exit;
	}
	function _print_txt($path)
	{
		$fp=fopen($path, 'rb');
		echo preg_replace('/^<\?.*?\?>(\r\n|\n|\r)?/s', '', fread($fp, filesize($path)));
		fclose($fp);
	}
	function _get_compile_path($rpath)
	{
        global $template_dir;

		$cpl_ext=$this->compile_ext;

		if ($R=strpos($rpath, '?')) {
			$cpl_ext=substr($rpath, $R+1).'.'.$cpl_ext;
			$rpath=substr($rpath, 0, $R);
		}

		if (!$this->compile_dir) $this->compile_dir = '.';

		$cpl_base = $this->compile_dir.'/'.($this->skin?$this->skin.'/':'').$rpath;

		if ($this->path_digest) {
			$cpl_base = $this->compile_dir.'/@digest/'.basename($rpath).'_'.md5($cpl_base);
		}

		$cpl_path = $cpl_base.'.'.$cpl_ext;

		if (!$this->compile_check) {
			return $cpl_path;
		}

        if($template_dir && $template_dir!=""){
            $this->template_dir = $template_dir ;
        }

		$tpl_path = $this->template_dir.'/'.($this->skin?$this->skin.'/':'').$rpath;

		if (@!is_file($tpl_path)) {
			$this->exit_('Error #1', 'cannot find defined template <b>'.$tpl_path.'</b>');
		}

		$tpl_path = realpath($tpl_path);

		$cpl_head = '<?php /* Template_ 2.2.7 '.date('Y/m/d H:i:s', filemtime($tpl_path)).' '.$tpl_path.' ';

		if ($this->compile_check!=='dev' && @is_file($cpl_path)) {

			$fp=fopen($cpl_path, 'rb');
			$head = fread($fp, strlen($cpl_head)+9);
			fclose($fp);

			if (strlen($head)>9
				&& $cpl_head == substr($head,0,-9)
				&& filesize($cpl_path) == (int)substr($head,-9) ) {

				return $cpl_path;
			}
		}

		include_once dirname(__file__).'/Template_.compiler.php';
		$compiler=new Template_Compiler_;
		$compiler->_compile_template($this, $tpl_path, $cpl_base, $cpl_head);

		return $cpl_path;
	}
	function setScope($scope='')
	{
		if (!isset($this->var_[$scope])) $this->var_[$scope]=array();
		$this->scp_=$scope;
	}
	function setCache($fid, $time=1, $rid='', $cid='')
	{
		if (empty($this->tpl_[$fid])||$this->tpl_[$fid][0]==='txt') {
			$this->exit_('Error #3', 'file id <b>'.$fid.'</b> passed to setCached() is not properly defined');
		}
		if ($time<0) unset($this->tpl_[$fid][2]);
		else $this->tpl_[$fid][2]=array($time, $rid, $cid);
	}
	function isCached($fid)
	{
		if (!$this->caching || !isset($this->tpl_[$fid][2]) || $this->compile_check==='dev') return 0;
		if (isset($this->_is_cached[$fid])) return $this->_is_cached[$fid];
		$info =&$this->tpl_[$fid][2];
		$rid  =$info[1];
		$cid  =$fid.'/'.$this->skin.'/'.$this->tpl_[$fid][1].($info[2]?'/?'.base64_encode(serialize($info[2])):'');
		$path =$this->cache_dir.'/%cache'.$_SERVER['PHP_SELF'].'/'.md5($cid);
		$this->_cache_info[$fid]=array('rid'=>$rid, 'cid'=>$cid, 'path'=>$path);
		if ($info[0]===1) $info[0] = $this->cache_expire;
		if (@!is_file($path) or $info[0] && filemtime($path)+$info[0]<time()) return $this->_is_cached[$fid]=0;
		if ($rid) {
			$rdir1=$this->cache_dir.'/%clear/';
			$rdir2=$this->_get_clear_path($cid);
			if (is_array($rid)) {
				foreach ($rid as $r) if (@!is_file($rdir1.$r.$rdir2)) return $this->_is_cached[$fid]=0;
			} elseif (@!is_file($rdir1.$rid.$rdir2)) {
				return $this->_is_cached[$fid]=0;
			}
		}
		$fp=fopen($path, 'rb');
		$text=fread($fp, filesize($path));
		fclose($fp);
		if (!$B=strpos($text,'-') or !$H=strpos($text,'*')) return $this->_is_cached[$fid]=0;
		$byte=substr($text, 0, $B);
		$head=substr($text, $B+1, $H-$B-1);
		$text=substr($text, $H+1);
		if ($head!=$cid || strlen($text)!=$byte) return $this->_is_cached[$fid]=0;
		$this->_cache_info[$fid]['cont'] =$text;
		return $this->_is_cached[$fid]=1;
	}
	function clearCache()
	{
		if (!($this->caching && $this->cache_dir && @is_dir($this->cache_dir))) return;
		$safe_mode=ini_get('safe_mode');
		if (!func_num_args()) $this->_rmdir($this->cache_dir, $safe_mode);
		else foreach (func_get_args() as $dir) $this->_rmdir($this->cache_dir.'/%clear/'.$dir, $safe_mode);
	}
	function _rmdir($path, $php_safe_mode)
	{
		if (!$php_safe_mode) {
			substr(__file__,0,1)==='/'
				? @shell_exec('rm -rf "'.$path.'/"*')
				: @shell_exec('del "'.str_replace('/','\\',$path).'\\*" /s/q');
			return;
		}
		if (!$d = @dir($path)) return;
		while ($f = @$d->read()) {
			switch ($f) {
			case '.': case '..': break;
			default : @is_dir($f=$path.'/'.$f) ? $this->_rmdir($f, 1) : @unlink($f);
			}
		}
	}
	function _get_clear_path($cid)
	{
		$path=urlencode($_SERVER['PHP_SELF'].'?'.$cid);
		strlen($path)%80 or $path.='@ff';
		return '/%'.substr(chunk_split($path, 80, '/'), 3, -1);
	}
	function _touch_clear_id($path)
	{
		if (@is_file($path)) return;
		$this->_make_dir($path);
		@touch($path);
		@chmod($path, $this->permission&~0111);
	}
	function _make_dir($path)
	{
		if (@is_dir(dirname($path))) return;
		$dir=$this->cache_dir;
		if (substr(__file__,0,1)!=='/') {
			$dir =preg_replace('/\\\\+/', '/', $dir);
			$path=preg_replace('/\\\\+/', '/', $path);
		}
		$dirs=explode('/', substr($path, strlen($dir)+1));
		for ($nodir=0,$i=0,$s=count($dirs)-1; $i<$s; $i++) {
			$dir.='/'.$dirs[$i];
			if ($nodir or !@is_dir($dir) and $nodir=1) {
				@mkdir($dir, $this->permission);
				@chmod($dir, $this->permission);
			}
		}
	}
	function exit_($type, $msg)
	{
		exit("<br />\n".'<span style="font:12px tahoma,arial;color:#DA0000;background:white">Template_ '.$type.': '.$msg."</span><br />\n");
	}

// About xprint() and xfetch(), refer http://www.xtac.net/bbs/?prc=read&idx=1091
	function xprint($file, $type='tpl')
	{
		$this->define(($type=='txt' ? '!*' : '*'), $file);
		$this->print_('*');
	}
	function xfetch($file, $type='tpl')
	{
		$this->define(($type=='txt' ? '!*' : '*'), $file);
		return $this->fetch('*');
	}

// Below methods are deprecated.
	function loopLoad($id, $n=1)
	{
		if ($n===1) $this->b1= &$this->var_[$this->scp_][$id];
		else $this->{'b'.$n}=&$this->{'b'.--$n}[count($this->{'b'.$n})-1][$id];
	}
	function loopPushAssign($arg, $n=1)
	{
		$this->{'b'.$n}[]=$arg;
	}
	function loopPushLoad($id, $n=2)
	{
		$this->{'b'.$n}=&$this->{'b'.--$n}[][$id];
	}
	function loopAssign($arg, $n=1)
	{
		$section = array_merge($section=&$this->{'b'.$n}[count($this->{'b'.$n})-1], $arg);
	}
	function setLoop($id, $arg, $n=1)
	{
		if ($n===1) $this->var_[$this->scp_][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
		else $this->{'b'.--$n}[count($this->{'b'.$n})-1][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
	}
	function pushSetLoop($id, $arg, $n=2)
	{
		$this->{'b'.--$n}[][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
	}
}
function _template_notice_handler($type, $msg, $file, $line)
{
	$msg.=" in <b>$file</b> on line <b>$line</b>";
	switch ($type) {
	case E_NOTICE      :$msg='<span style="font:12px tahoma,arial;color:green;background:white">Template_ Notice #1: '.$msg.'</span>';break;
	case E_WARNING     :
	case E_USER_WARNING:$msg='<b>Warning</b>: '.$msg; break;
	case E_USER_NOTICE :$msg='<b>Notice</b>: ' .$msg; break;
	case E_USER_ERROR  :$msg='<b>Fatal</b>: '  .$msg; break;
	default            :$msg='<b>Unknown</b>: '.$msg; break;
	}
	echo "<br />\n".$msg."<br />\n";
}

include './common/TplLibrary.php';
?>
