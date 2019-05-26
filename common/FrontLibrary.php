<?
namespace common;
use common;
class FrontLibrary extends common\Template{


    function __construct(){

        global $tpl,$db,$lib,$dev;

        $this->tpl = $tpl;
        $this->db = $db;
        $this->lib = $lib;
        $this->dev = $dev;


        $this->define('header', $this->lib->cfg['skin'].'/_header.htm');
		$this->define('footer', $this->lib->cfg['skin'].'/_footer.htm');
        $this->define('popup_header', $this->lib->cfg['skin'].'/_header_popup.htm');
		$this->define('popup_footer', $this->lib->cfg['skin'].'/_footer_popup.htm');


    }


}
