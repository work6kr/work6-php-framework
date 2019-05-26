<?php
function adjustPath($source, $tpl, $indicator='', $type='absolute')
{

	$default_indicator = 'css,js,gif,jpg,jpeg,png,swf';
	$path_filter = array();

//
	#$document_root = $_SERVER['DOCUMENT_ROOT']; 

	if (!$indicator || $indicator==='default') $indicator=$default_indicator;
	if (!$indicator=str_replace(',', '|', preg_replace('/^,\s*|\s*,$/', '', $indicator))) return $source;

	$on_ms   =$tpl->on_ms;

	// (1) get template path info

	$tpl_path =$tpl->tpl_path;
	if ($on_ms) $tpl_path=preg_replace('@\\\\+@', '/', $tpl_path);
	
	$tpl_dirs	=explode('/', preg_replace('@/[^/]+$@', '', $tpl_path));
	$tpl_dir_cnt=count($tpl_dirs);

	// (2) get web path		e.g) $web_path='/forum'
	
	if (!empty($_SERVER['SCRIPT_NAME'])) {
		// need not check friendly url
		$web_path=$_SERVER['SCRIPT_NAME'];
		if ($on_ms) $web_path=preg_replace('@\\\\+@', '/', $web_path);
		$web_dirs=explode('/', $web_path);
		array_pop($web_dirs);
	} else if (!empty($_SERVER['PHP_SELF'])) {
		$web_path=$_SERVER['PHP_SELF'];
		if ($on_ms) $web_path=preg_replace('@\\\\+@', '/', $web_path);
		$web_dirs=explode('/', $web_path);
		if (!empty($_SERVER['SCRIPT_FILENAME'])) {
			$script_filename=$_SERVER['SCRIPT_FILENAME'];
			if ($on_ms) $script_filename=preg_replace('@\\\\+@', '/', $script_filename);
			$filename = array_pop(explode('/', $script_filename));
			while ($web_dirs && array_pop($web_dirs) != $filename);
		} else {
			array_pop($web_dirs);
		}
	} else {
		$tpl->report('Error #34', 'prefilter "adjustPath" cannot find web address', true);
	}
	$web_dir_cnt=count($web_dirs);

	// (3) get OS absolute path of current directory
	//	   e.g) $abs_web_path ='/home/user/wwwroot/forum'
	$abs_web_path=realpath('.');
	if (empty($abs_web_path)) {
		if (!empty($_SERVER['SCRIPT_FILENAME'])) {
			$abs_web_path=$_SERVER['SCRIPT_FILENAME'];
			$real_abs_web_path=realpath($abs_web_path);	// for symbolic linked document root 
			if ($real_abs_web_path) $abs_web_path = $real_abs_web_path;
			if ($on_ms) $abs_web_path=preg_replace('@\\\\+@', '/', $abs_web_path);
			$abs_web_path=preg_replace('@/[^/]+$@', '', $abs_web_path);
		} else {
			$tpl->report('Error #33', 'prefilter "adjustPath" cannot find absolute path of <b>'.$_SERVER['PHP_SELF'].' on OS</b>', true);	
		}
	} else {
		if ($on_ms) $abs_web_path=preg_replace('@\\\\+@', '/', $abs_web_path);
	}
	$abs_web_dirs=explode('/', $abs_web_path);
	$abs_web_dir_cnt=count($abs_web_dirs);

	// (4) set pattern to identify path

	$Dot='(?<=url\()\\\\*\./(?:(?:[^)/]+/)*[^)/]+)?(?=\))'.
		'|(?<=")\\\\*\./(?:(?:[^"/]+/)*[^"/]+)?(?=")'.
		"|(?<=')\\\\*\./(?:(?:[^'/]+/)*[^'/]+)?(?=')".
		'|(?<=\\\\")\\\\*\./(?:(?:[^"/]+/)*[^"/]+)?(?=\\\\")'.
		"|(?<=\\\\')\\\\*\./(?:(?:[^'/]+/)*[^'/]+)?(?=\\\\')";
	$Ext= $indicator[0]==='.' ? substr($indicator,2) : $indicator;
	$Ext='(?<=url\()(?:[^"\')/]+/)*[^"\')/]+\.(?:'.$Ext.')(?=\))'.
		'|(?<=")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=")'.
		"|(?<=')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=')".
		'|(?<=\\\\")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=\\\\")'.
		"|(?<=\\\\')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=\\\\')";
	if ($indicator==='.') $pattern=$Dot;
	else $pattern= $indicator[0]==='.' ? $Ext.'|'.$Dot : $Ext;
	$pattern='@('.$pattern.')@ixU';
	$split=preg_split($pattern, $source, -1, PREG_SPLIT_DELIM_CAPTURE);

	$m=array();

// convert to relative path :: for peculiar usage requested by some user.

	if ($type==='relative') {
		$less_cnt=$abs_web_dir_cnt<$tpl_dir_cnt ? $abs_web_dir_cnt : $tpl_dir_cnt;
		for ($i=0; $i<$less_cnt; $i++) {
			if ($abs_web_dirs[$i]!=$tpl_dirs[$i]) break;
		}
		$rel_path_pfx = $abs_web_dir_cnt>$i ? str_repeat('../',$abs_web_dir_cnt-$i) : '';
		if ($tpl_dir_cnt>$i) {
			$reducible = $tpl_dir_cnt - $i;
			$rel_path_pfx.=implode('/',array_slice($tpl_dirs, $i)).'/';
		} else {
			$reducible = 0;
		}
		for ($i=1,$s=count($split); $i<$s; $i+=2) {
			if (substr($split[$i], 0, 1)==='\\') {
				$split[$i]=substr($split[$i],1);
				continue;
			}
			$split[$i] = preg_replace('@^(\./)+@','',$split[$i]);
			if ($reducible && preg_match('@^((?:\.{2}/)+)@', $split[$i], $m)) {
				$reduce = substr_count($m[1], '../');
				if ($reduce > $reducible) $reduce = $reducible;
				$split[$i] = preg_replace('@(?:[^/]+/){'.$reduce.'}$@', '', $rel_path_pfx) . preg_replace('@^(\.{2}/){'.$reduce.'}@','',$split[$i]);
			} else {
				$split[$i] = $rel_path_pfx . $split[$i];
			}
		}
		return implode('', $split);
	}

// convert to absolute path

	$path_search =array_keys($path_filter);
	$path_replace=array_values($path_filter);
	
	// (5) get $base_path (=DOCUMENT_ROOT)
	if (empty($document_root)) {
		if ($web_dir_cnt===1) {
			// $web_path == '/'

			$base_path=implode('/', $abs_web_dirs);
		} else {
			//  /home/abc/wwwroot/forum/index.php
			//  $web_path == '/forum' $web_dir_cnt == 2
			//  $abs_web_path == '/home/abc/wwwroot/forum'  $abs_web_dir_cnt==5

			$less_cnt=($web_dir_cnt < $abs_web_dir_cnt ? $web_dir_cnt : $abs_web_dir_cnt)-1;
			// if $web_path contains virtual directories, $abs_web_dir_cnt can be lesser than $web_dir_cnt.
				
			$web_test=array_reverse($web_dirs);
			$abs_test=array_reverse($abs_web_dirs);

			if ($on_ms) {
				for ($i=0; $i<$less_cnt; $i++) {
					if (strtolower($web_test[$i])!=strtolower($abs_test[$i])) break;
				}
			} else {
				for ($i=0; $i<$less_cnt; $i++) {
					if ($web_test[$i]!=$abs_test[$i]) break;
				}
			}
			
			//  removing $web_path from $abs_web_path gets $document_root(=$base_path).
			$base_path=implode('/', $i ? array_slice($abs_web_dirs, 0, -$i) : $abs_web_dirs);

			//  in case of virtual directory e.g) $web_path == '/~user/forum'
			//  catch '/~user' and prepened to adjusted path.
			if ($i<$web_dir_cnt-1) {					
				array_unshift($path_search, '/^/');
				array_unshift($path_replace, implode('/', $i ? array_slice($web_dirs, 0, -$i) : $web_dirs));
			}
		}
	} else {
		if ($on_ms) $document_root=preg_replace('@\\\\+@', '/', $document_root);
		$base_path = preg_replace('@/$@','',$document_root);
	}

	$tpl_path_prefix=preg_replace('@[^/]+$@', '', $tpl_path);
	// if template path '/home/abc/wwwroot/tpl/index.html', $tpl_path_prefix is '/home/abc/wwwroot/tpl'.
	for ($i=1,$s=count($split); $i<$s; $i+=2) {
		if (substr($split[$i], 0, 1)==='\\') {
			$split[$i]=substr($split[$i],1);
			continue;
		}
		// (6) get $src which is absolute path of file to adjust
		if (!$src=realpath($tpl_path_prefix.$split[$i])) {
			// simplify path. e.g) /a/b/c/../../d/e --> /a/d/e
			
			if (preg_match('@^((?:\.{1,2}/)+)@', $split[$i], $m)) {
				$src=preg_replace('@(?:[^/]+/){'.substr_count($m[1],'../').'}$@', '', $tpl_path_prefix)
					.preg_replace('@^(\.{1,2}/)+@','',$split[$i]);
			} else {
				$src=$tpl_path_prefix . $split[$i];
			}
		}
		if ($on_ms) $src = preg_replace('@\\\\+@', '/', $src);

		// (7) now get web absolute file path from relative path.
		// for access to files outside document root, cut abs path not by charater length but by number of directory.
		// this with $path_filter enables multi-domain adjustment.
		$base_cnt = count(explode('/', $base_path));
		$split[$i]='/'.implode('/',array_slice(explode('/', $src),$base_cnt));

		if ($path_search) $split[$i]=preg_replace($path_search, $path_replace, $split[$i]);
	}
	return implode('', $split);
}
?>