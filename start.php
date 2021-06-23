
<!DOCTYPE html>
<html>
<head>
	<title>Government Polytechnic Amravati</title>
	<link href="styles/start.css" rel="stylesheet"/>
	<script lang="javascript">
		function checkdata()
		{
			var msg = "";
			if(document.f1.TxtUserId.value.trim().length == 0)
				msg = msg + "Userid is required\n";
			if(document.f1.TxtPassword.value.trim().length == 0)
				msg = msg + "Password is required\n";

			if(msg != "")
			{
				alert(msg);
				return;
			}
			else
			document.f1.submit();
		}
	</script>
</head>
<body style="background-image:url(images/img1.jpg);">
<form action="check_admin_login.php" method="post" name="f1">
<!-- <form action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1"> -->
	<hr size="1px" color="brossred"/>
	<table style="font-family: calibri;font-size: 17px; width:100%">		
			<tr>
				<td style="font-family: Calibri;font-size: xx-large;text-align: center;color: #660033;">Government Polytechnic, Amravati, MH.</td>
			</tr>
			<tr>
				<td style="font-family: Calibri;font-size: x-large;text-align: center;color: white;"><b><u>Curriculum Development Cell</u></b></td>
			</tr>
			<tr>
				<td><a href="see_syllabus.php">Syllabus</a></td>
			</tr>		
	</table>	
	<hr size="1px" color="brossred"/>
	<table>
		<tr>
			<td colspan="3">
				<font face="Calibri" size="5pt" color="green">
					Administrative Login
				</font>
			</td>			
		</tr>
		<tr>
			<td>Userid:</td>
			<td><input type="text" name="TxtUserId"></td>
			<td>
				<font face="calibri" size="10px" color="red">
				<?php
					//echo $userid_err;
				?>
				</font>
			</td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="TxtPassword"></td>
			<td>
				<font face="calibri" size="10px" color="red">
				<?php
					//echo $upassword_err;
				?>
				</font>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<!-- <input type="submit" name="b1" value="Login"> -->
				<input type="button" name="b1" value="Login" onclick="checkdata()">
			</td>
			<td></td>
		</tr>
	</table>
</form>
</body>
</html>