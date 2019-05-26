<?
@unlink('./install.php');
@unlink('./install_indb.php');

session_destroy();

echo "<script>top.location.href='/';</script>";

?>
