<?php

/* PREFILTER EXAMPLE */

function parseMySyntax($source, $tpl)
{
	$map=array(
		'{include '=>'{#',
		'{loop '=>'{@',
		'{switch '=>'{?',
		'{case '=>'{:',
		'{if '=>'{?',
		'{elseIf '=>'{:',
		'{else '=>'{:',
		'{loopelse '=>'{:',
		'{endloop '=>'{/',
		'{endswitch '=>'{/',
		'{endif '=>'{/',
	);
	return strtr($source, $map);
	/*
	$map=array(
		'/<!BeginLoop:([\w\x80-\xff]+)>/ie'=>'"{@".strtolower("$1")."}"',
		'/<!LoopElse>/i'  =>'{:}',
		'/<!EndLoop>/i'   =>'{/}',
		'/<!Else>/i'      =>'{:}',
		'/<!EndIf>/i'     =>'{/}',
		'/{url_self}/i'   =>'{_SERVER.PHP_SELF}',
		'/<!If:OddRow>/i' =>'{?.index_ % 2}',
	);
	switch (basename($tpl->tpl_path)) {
	case 'bbslist.htm':
		$map=array_merge($map, array(
			'/{Num}/i'        =>'{start-.list}',
			'/{Title(:?)}/i'  =>'{.rec.title}',
			'/{Title:(\d+)}/i'=>'{=getSting(.rec.title,$1)}',
			'/{Date}/i'       =>'{=substr(.rec.date, 3, 8)}',
			'/{Hit}/i'        =>'{.rec.hit}',
			'/{Name(:?)}/i'   =>'{.rec.name}',
			'/{Name:(\d+)}/i' =>'{=getSting({.rec.name}, $1)}',
		));
		break;
	case 'bbsread.htm':
		$map=array_merge($map, array(
			'/{Title(:?)}/i'  =>'{data.title}',
			'/{Title:(\d+)}/i'=>'{=getSting(.data.title, $1)}',
			'/{Name(:?)}/i'   =>'{data.name}',
			'/{Name:(\d+)}/i' =>'{=getSting(.data.name, $1)}',
			'/{Email}/i'      =>'{=encrypt(.data.email)}',
			'/{Tname(:?)}/'   =>'{.trec.name}',
			'/{Tname:(\d+)}/i'=>'{=getSting(.trec.name, $1)}',
			'/{Tdate}/i'      =>'{=substr(.trec.date, 3, 8)}',
			'/{Tcontent}/i'   =>'{=htmlspecialchars(.trec.text)}',
		));
		break;
	}
	$search=array_keys($map);
	$replace=array_values($map);
	return preg_replace($search, $replace, $source);
	*/
}
?>