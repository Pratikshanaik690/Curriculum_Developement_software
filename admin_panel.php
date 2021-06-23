<?php
	session_start();
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
?>
<html>
<head>
	<title>Government Polytechnic Amravati: Admin Panel</title>
	<!-- to clear browser cache -->
	<meta http-equiv="cache-control" content="no-cache">
</head>
<frameset cols="260px, *" border="1">
	<frame name="frame1" src="admin_links.php"/>		
	<frame name="frame2" src="admin_home.php"/>
</frameset>
</html>
