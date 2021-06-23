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
	<title>
		Government Polytechnic Amravati: Admin Links
	</title>	
	<!-- to clear browser cache -->
	<meta http-equiv="cache-control" content="no-cache">
	<link href="styles/admin_links.css" rel="stylesheet"/>
</head>
<body>
	<table>
		<tr>
		<td><img src="images/admin.jpg" width="230px" height="240px"/></td>
		</tr>		
	</table>
	<hr color="orange" size="1px"/>
	<table>		
		<tr>
			<td>
				<a href="add_subjects.php" target="frame2">
					Add Subjects
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="add_syllabus.php" target="frame2">
					Add Syllabus
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="admin_home.php" target="frame2">
					View Subjects
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="clear_session.php" target="_top">
					Logout
				</a>
			</td>
		</tr>
	</table>
	<hr color="orange" size="1px"/>
</body>
</html>