<?
namespace common;
class DevLibrary{


    #디버그
    function debug($data=''){
    	echo "<xmp style='background:black; color:#43db20; font-size:11px; line-height:16px; text-align:left; position:relative; z-index:1000;'>";
    	print_r($data);
    	echo "</xmp>";
    }



}
