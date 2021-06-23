<?php
	session_start();
	unset($_SESSION["userid"]);
          	unset($_SESSION["sem"]);
          	unset($_SESSION["dept"]);
	if(!array_key_exists("userid", $_SESSION))
	{
		clearstatcache();		
		header("location:pagenotfound.php");
	} 
	elseif(empty($_SESSION["userid"]))
	{
		clearstatcache();
		header("location:pagenotfound.php");
	}
	clearstatcache();
	session_destroy();
	$_SESSION = array();
          	header("location:start.php");
?>

