<?
namespace common;
class Download
{

	#생성자
	function __construct()
	{

	}

	function file_download($filepath,$filename){


		$filesize = filesize($filepath);
		$path_parts = pathinfo($filepath);
		$extension = $path_parts['extension'];
		$filename .= '.'.$extension;


		header("Pragma: public");
		header("Expires: 0");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $filesize");

		ob_clean();
		flush();
		readfile($filepath);

	}


}
?>
