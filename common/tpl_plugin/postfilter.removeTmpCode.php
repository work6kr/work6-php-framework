<?php

/* POSTFILTER EXAMPLE */

function removeTmpCode($source, $tpl)
{
	return preg_replace('@<!BeginTmp>.*?<!EndTmp>[ \t]*(\r\n|\n|\r)?\s*@s', '', $source);
}
?>