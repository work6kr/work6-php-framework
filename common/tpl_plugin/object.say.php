<?php

/* TEMPLATE PLUGIN OBJECT EXAMPLE */

class tpl_object_say
{

	function tpl_object_say($user='guest')
	{
		$this->user= $user;
	}
	function hello()
	{
		return 'Hello! '.$this->user;
	}
	function goodbye()
	{
		return 'Good Bye! '.$this->user;
	}
}