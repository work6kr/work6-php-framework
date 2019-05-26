<?php

/* POSTFILTER EXAMPLE */

function arrangeSpace($source, $tpl)
{
	$split=preg_split('@(<pre.*?</pre)@is', $source, -1, PREG_SPLIT_DELIM_CAPTURE);
	for ($i=0,$s=count($split); $i<$s; $i+=2) $split[$i] = preg_replace('/[ \t]*(\r\n|\n|\r)\s*/', '$1', $split[$i]);
	return trim(implode('', $split));
}
?>